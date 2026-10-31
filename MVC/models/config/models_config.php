<?php

namespace app\models\config;

use app\models\database\VehiclesDBInterface;
use app\models\database\Vehicles_DB;
use app\models\repositories\VehiclesRepositoryInterface;
use app\models\repositories\VehiclesRepository;

class ModelsConfig
{
    public static function get_vehicles_db(): VehiclesDBInterface
    {
        return new Vehicles_DB();
    }

    public  static function get_vehicles_repository(): VehiclesRepositoryInterface
    {
        return new VehiclesRepository(ModelsConfig::get_Vehicles_db());
    }
}
