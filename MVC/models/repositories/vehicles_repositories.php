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
        $sql = "insert into vehiculos(marca,modelo,anio, categoria, estado, fecha_inicio, fecha_fin)values";
        $sql .= "('" . $vehicles->get_marca() . "','" . $vehicles->get_model() . "','" . $vehicles->get_anio() . "','" . $vehicles->get_categoria() . "','" . $vehicles->get_estado() . "','" . $vehicles->get_start_date() . "','" . $vehicles->get_end_date() ."')";
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

    public function save_student(Vehicles $vehicles): bool
    {
        $sql = "update vehiculos set ";
        $sql .= " marca='" . $vehicles->get_marca() . "', ";
        $sql .= " modelo='" . $vehicles->get_model() . "', ";
        $sql .= " anio='" . $vehicles->get_anio() . "' ";
            $sql .= " categoria='" . $vehicles->get_categoria() . "', ";
        $sql .= " estado='" . $vehicles->get_estado() . "', ";
        $sql .= " fecha_inicio='" . $vehicles->get_start_date() . "' ";
        $sql .= " fecha_fin='" . $vehicles->get_end_date() . "' ";
        $sql .= " where id=" . $vehicles->get_id();
        return $this->vehicles_db->exc_query($sql);
    }
}
