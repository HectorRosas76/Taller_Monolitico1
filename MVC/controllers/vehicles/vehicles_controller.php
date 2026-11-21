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
    
              public function vehicle_delete(int $id): bool
    {
        if (empty($id)) {
            throw new Exception("id incorrecto", 1);
        }
        return $this->vehicles_model->delete_vehicles($id);
    }

    //Validar fechas 
    public function get_available_vehicles(string $start, string $end): array
    {
        $d1 = \DateTime::createFromFormat('Y-m-d', $start);
        $d2 = \DateTime::createFromFormat('Y-m-d', $end);
        if (!$d1 || !$d2 || $d1->format('Y-m-d') !== $start || $d2->format('Y-m-d') !== $end) {
            throw new Exception("Las fechas no son válidas.", 3);
        }
        if ($end < $start) {
            throw new Exception("La fecha final no puede ser anterior a la inicial.", 4);
        }
        return $this->vehicles_model->get_available_vehicles($start, $end);
    }
}
