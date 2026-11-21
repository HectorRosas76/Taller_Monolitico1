<?php

namespace app\models\repositories;

use app\models\database\VehiclesDBInterface;
use app\models\entities\Vehicles;
use app\models\mappers\VehiclesMappers;
use Exception;

class VehiclesRepository implements VehiclesRepositoryInterface
{
    private VehiclesDBInterface $vehicles_db;

    public function __construct(VehiclesDBInterface $vehicles_db)
    {
        $this->vehicles_db = $vehicles_db;
    }

    public function get_vehicles_all(): array
    {
        $sql = "select * from vehiculos";
        $rows_db = $this->vehicles_db->exc_select($sql);
        $vehicles = [];
        foreach ($rows_db as $item) {
            array_push($vehicles, VehiclesMappers::to_entity($item));
        }
        return $vehicles;
    }

    public function save_new_vehicles(Vehicles $vehicles): bool
    {
        $sql = "insert into vehiculos(marca,modelo,anio, categoria, estado)values";
        $sql .= "('" . $vehicles->get_marca() . "','" . $vehicles->get_model() . "','" . $vehicles->get_anio() . "','" . $vehicles->get_categoria() . "','" . $vehicles->get_estado() . "')";
        $result = $this->vehicles_db->exc_query($sql);
        return $result;
    }

    public function find_vehicles_by_id(int $id): Vehicles|null
    {
        $sql = "select * from vehiculos where id=$id";
        $rows_db = $this->vehicles_db->exc_select($sql);
        foreach ($rows_db as $item) {
            return VehiclesMappers::to_entity($item);
        }
        return null;
    }

    public function save_vehicles(Vehicles $vehicles): bool
    {
        $sql = "update vehiculos set ";
        $sql .= " marca='" . $vehicles->get_marca() . "', ";
        $sql .= " modelo='" . $vehicles->get_model() . "', ";
        $sql .= " anio='" . $vehicles->get_anio() . "', ";
        $sql .= " categoria='" . $vehicles->get_categoria() . "', ";
        $sql .= " estado='" . $vehicles->get_estado() . "' ";
        $sql .= " where id=" . $vehicles->get_id();
        return $this->vehicles_db->exc_query($sql);
    }
         public function delete_vehicles(int $id): bool
    {
        $sql = "delete from vehiculos where id=$id";
        return $this->vehicles_db->exc_query($sql);
    }

    // Vehículos que se pueden reservar entre $start y $end (formato Y-m-d):
    public function get_available_vehicles(string $start, string $end): array
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $start) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $end)) {
            return [];
        }
        $sql = "select v.* from vehiculos v";
        $sql .= " where v.estado <> 'mantenimiento'";
        $sql .= " and not (v.estado = 'alquilado' and curdate() between '$start' and '$end')";
        $sql .= " and v.id not in (select r.vehiculo_id from reservas r";
        $sql .= "   where r.estado = 'activa' and r.fecha_inicio <= '$end' and r.fecha_fin >= '$start')";
        $sql .= " order by v.marca, v.modelo";
        $rows_db = $this->vehicles_db->exc_select($sql);
        $vehicles = [];
        foreach ($rows_db as $item) {
            array_push($vehicles, VehiclesMappers::to_entity($item));
        }
        return $vehicles;
    }

    public function set_vehicle_status(int $id, string $status): bool
    {
        if (!in_array($status, ['disponible', 'alquilado', 'mantenimiento'], true)) {
            return false;
        }
        $sql = "update vehiculos set estado='$status' where id=$id";
        return $this->vehicles_db->exc_query($sql);
    }
}
