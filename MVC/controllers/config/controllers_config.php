<?php

namespace app\controllers\config;

use app\controllers\vehicles\VehiclesController;
use app\controllers\vehicles\VehiclesControllerInterface;
use app\models\config\ModelsConfig;

class ControllersConfig
{
    public static function get_vehicles_controller(): VehiclesControllerInterface
    {
        return new VehiclesController(ModelsConfig::get_vehicles_repository());
    }
}
