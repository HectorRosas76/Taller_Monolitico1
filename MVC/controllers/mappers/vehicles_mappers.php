<?php

namespace app\controllers\mappers;

use app\models\entities\Vehicles;

class VehiclesControllerMappers
{
    public static function to_entity(array $request): Vehicles
    {
        return new Vehicles(
            empty($request["id"]) ? 0 : $request["id"],
            $request["marca"],
            $request["modelo"],
            $request["anio"],
            $request["categoria"],
            $request["estado"]
        );
    }
}
