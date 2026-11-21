<?php

namespace app\controllers\reservations;

use app\models\entities\Reservations;

interface ReservationsControllerInterface
{
    public function get_reservations(): array;
    public function reservation_create(array $post_data): bool;
    public function get_reservation(int $id): Reservations;
    public function reservation_update(array $post_data): bool;
    public function reservation_delete(int $id): bool;

    public function reservation_return(int $id): bool;
    public function get_history_by_client(int $client_id): array;
    public function get_history_by_vehicle(int $vehicle_id): array;
}
