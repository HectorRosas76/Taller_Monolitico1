<?php

namespace app\controllers\config;

use app\controllers\clients\ClientsControllerInterface;
use app\controllers\clients\ClientsController;
use app\controllers\vehicles\VehiclesController;
use app\controllers\vehicles\VehiclesControllerInterface;
use app\controllers\reservations\ReservationsController;
use app\controllers\reservations\ReservationsControllerInterface;
use app\models\config\ModelsConfig;


class ControllersConfig
{
    public static function get_vehicles_controller(): VehiclesControllerInterface
    {
        return new VehiclesController(ModelsConfig::get_vehicles_repository());
    }

    public static function get_clients_controller(): ClientsControllerInterface
    {
        return new ClientsController(ModelsConfig::get_clients_repository());
    }

    public static function get_reservations_controller(): ReservationsControllerInterface
    {
        return new ReservationsController(
            ModelsConfig::get_reservations_repository(),
            ModelsConfig::get_vehicles_repository()
        );
    }
}
