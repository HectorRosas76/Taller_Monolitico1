<?php

namespace app\controllers\reservations;

use app\controllers\mappers\ReservationsControllerMappers;
use app\models\repositories\ReservationsRepositoryInterface;
use app\models\entities\Reservations;
use Exception;

class ReservationsController implements ReservationsControllerInterface
{

    private ReservationsRepositoryInterface $reservationsRepositoryInterface_model;

    public function __construct(ReservationsRepositoryInterface $reservationsRepositoryInterface_model)
    {
        $this->reservationsRepositoryInterface_model = $reservationsRepositoryInterface_model;
    }

    public function get_reservations(): array
    {
        $list = $this->reservationsRepositoryInterface_model->get_reservations_all();
        return $list;
    }

    public function reservation_create(array $post_data): bool
    {
        $dato_form = ReservationsControllerMappers::to_entity($post_data);
        $reservation = $this->reservationsRepositoryInterface_model->save_new_reservations($dato_form);
        return !empty($reservation);
    }

    public function get_reservation(int $id): Reservations
    {
        if (empty($id)) {
            throw new Exception("id incorrecto", 1);
        }
        $reservation = $this->reservationsRepositoryInterface_model->find_reservations_by_id($id);
        if (empty($reservation)) {
            throw new Exception("Id:$id no existe", 2);
        }
        return $reservation;
    }

    public function reservation_update(array $post_data): bool
    {
        $datos_form = ReservationsControllerMappers::to_entity($post_data);;
        $reservations = $this->reservationsRepositoryInterface_model->save_reservations($datos_form);
        return !empty($reservations);
    }

          public function reservation_delete(int $id): bool
    {
        if (empty($id)) {
            throw new Exception("id incorrecto", 1);
        }
        return $this->reservationsRepositoryInterface_model->delete_reservations($id);
    }
}
