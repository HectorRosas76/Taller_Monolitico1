<?php

namespace app\controllers\vehicles;

use app\controllers\mappers\VehiclesControllerMappers;
use app\models\repositories\VehiclesRepositoryInterface;
use app\models\entities\Vehicles;
use Exception;

class VehiclesController implements VehiclesControllerInterface
{

    private VehiclesRepositoryInterface $vehicles_model;

    public function __construct(VehiclesRepositoryInterface $vehicles_model)
    {
        $this->vehicles_model = $vehicles_model;
    }

    public function get_vehicles(): array
    {
        $list = $this->vehicles_model->get_vehicles_all();
        return $list;
    }

    public function vehicle_create(array $post_data): bool
    {
        $dato_form = VehiclesControllerMappers::to_entity($post_data);
        $vehicle = $this->vehicles_model->save_new_vehicles($dato_form);
        return !empty($vehicle);
    }

    public function get_vehicle(int $id): Vehicles
    {
        if (empty($id)) {
            throw new Exception("id incorrecto", 1);
        }
        $vehicle = $this->vehicles_model->find_vehicles_by_id($id);
        if (empty($vehicle)) {
            throw new Exception("Id:$id no existe", 2);
        }
        return $vehicle;
    }

    public function vehicle_update(array $post_data): bool
    {
        $datos_form = VehiclesControllerMappers::to_entity($post_data);;
        $vehicles = $this->vehicles_model->save_vehicles($datos_form);
        return !empty($vehicles);
    }
}
