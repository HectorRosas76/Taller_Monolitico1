<?php

namespace app\models\repositories;

use app\models\entities\Vehicles;

interface VehiclesRepositoryInterface
{
    public function get_vehicles_all(): array;
    public function save_new_vehicles(Vehicles $vehicles): bool;
    public function find_vehicles_by_id(int $id): Vehicles|null;
    public function save_vehicles(Vehicles $vehicles): bool;
}
