<?php

namespace app\controllers\vehicles;

use app\models\entities\Vehicles;

interface VehiclesControllerInterface
{
    public function get_vehicles(): array;
    public function vehicle_create(array $post_data): bool;
    public function get_vehicle(int $id): Vehicles;
    public function vehicle_update(array $post_data): bool;
}
