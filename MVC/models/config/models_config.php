<?php

namespace app\models\config;

use app\models\database\VehiclesDBInterface;
use app\models\database\Vehicles_DB;
use app\models\repositories\VehiclesRepositoryInterface;
use app\models\repositories\VehiclesRepository;
use app\models\database\ClientsDBInterface;
use app\models\database\Clients_DB;
use app\models\repositories\ClientsRepositoryInterface;
use app\models\repositories\ClientsRepository;

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

    public static function get_clients_db(): ClientsDBInterface
    {
        return new Clients_DB();
    }

    public static function get_clients_repository(): ClientsRepositoryInterface
    {
        return new ClientsRepository(ModelsConfig::get_Clients_db());
    }


}

const ESTADOS_VEHICULO = ['disponible', 'alquilado', 'mantenimiento'];