<?php

namespace app\models\mappers;

use app\models\entities\Reservations;

class ReservationsMappers
{
    public static function to_entity(array $row_db): Reservations
    {
        return new Reservations(
            $row_db["id"],
            $row_db["cliente_id"],
            $row_db["vehiculo_id"],
            $row_db["fecha_inicio"],
            $row_db["fecha_fin"],
            $row_db["estado"],
        );
    }
}
