<?php

namespace app\models\config;

use app\models\database\Vehicles_DBInterface;
use app\models\database\VehiclessDB;
use app\models\repositories\VehiclesRepositoryInterface;
use app\models\repositories\VehiclesRepository;

class ModelsConfig
{
    public static function get_vehicles_db(): VehiclesDBInterface
    {
        return new VehiclesDB();
    }

    public  static function get_vehicles_repository(): StudentsRepositoryInterface
    {
        return new VehiclesRepository(ModelsConfig::get_Vehicles_db());
    }
}
