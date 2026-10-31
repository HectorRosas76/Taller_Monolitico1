<?php

namespace app\models\mappers;

use app\models\entities\Vehicles;

class VehiclesMappers
{
    public static function to_entity(array $row_db): Vehicles
    {
        return new Vehicles(
            $row_db["id"],
            $row_db["marca"],
            $row_db["modelo"],
            $row_db["anio"],
            $row_db["categoria"],
            $row_db["estado"],
            $row_db["fecha_inicio"],
            $row_db["fecha_fin"]
        );
    }
}
