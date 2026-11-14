<?php

namespace app\controllers\mappers;

use app\models\entities\Reservations;

class ReservationsControllerMappers
{
    public static function to_entity(array $request): Reservations
    {
        return new Reservations(
            empty($request["id"]) ? 0 : $request["id"],
            $request["cliente_id"],
            $request["vehiculo_id"],
            $request["fecha_inicio"],
            $request["fecha_fin"],
            $request["estado"]
        );
    }
}
