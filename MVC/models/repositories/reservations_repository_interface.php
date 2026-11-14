<?php

namespace app\models\repositories;

use app\models\entities\Reservations;

interface ReservationsRepositoryInterface
{
    public function get_reservations_all(): array;
    public function save_new_reservations(Reservations $reservations): bool;
    public function find_reservations_by_id(int $id): Reservations|null;
    public function save_reservations(Reservations $reservations): bool;
}
