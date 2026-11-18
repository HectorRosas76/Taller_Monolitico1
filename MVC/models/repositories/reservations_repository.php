<?php

namespace app\models\repositories;

use app\models\database\ReservationsDBInterface;
use app\models\entities\Reservations;
use app\models\mappers\ReservationsMappers;
use Exception;

class ReservationsRepository implements ReservationsRepositoryInterface
{
    private ReservationsDBInterface $reservations_db;

    public function __construct(ReservationsDBInterface $reservations_db)
    {
        $this->reservations_db = $reservations_db;
    }

    public function get_reservations_all(): array
    {
        $sql = "select * from reservas";
        $rows_db = $this->reservations_db->exc_select($sql);
        $reservations = [];
        foreach ($rows_db as $item) {
            array_push($reservations, ReservationsMappers::to_entity($item));
        }
        return $reservations;
    }

    public function save_new_reservations(Reservations $reservations): bool
    {
        $sql = "insert into reservas(cliente_id,vehiculo_id,fecha_inicio,fecha_fin,estado)values";
        $sql .= "('" . $reservations->get_client_id() . "','" . $reservations->get_vehicle_id() . "','" . $reservations->get_start_date() . "','" . $reservations->get_end_date() . "','" . $reservations->get_status() . "')";
        $result = $this->reservations_db->exc_query($sql);
        return $result;
    }

    public function find_reservations_by_id(int $id): Reservations|null
    {
        $sql = "select * from reservas where id=$id";
        $rows_db = $this->reservations_db->exc_select($sql);
        foreach ($rows_db as $item) {
            return ReservationsMappers::to_entity($item);
        }
        return null;
    }

    public function save_reservations(Reservations $reservations): bool
    {
        $sql = "update reservas set ";
        $sql .= " cliente_id='" . $reservations->get_client_id() . "', ";
        $sql .= " vehiculo_id='" . $reservations->get_vehicle_id() . "', ";
        $sql .= " fecha_inicio='" . $reservations->get_start_date() . "', ";
        $sql .= " fecha_fin='" . $reservations->get_end_date() . "', ";
        $sql .= " estado='" . $reservations->get_status() . "' ";
        $sql .= " where id=" . $reservations->get_id();
        return $this->reservations_db->exc_query($sql);
    }
     public function delete_reservations(int $id): bool
    {
        $sql = "delete from reservas where id=$id";
        return $this->reservations_db->exc_query($sql);
    }
}
