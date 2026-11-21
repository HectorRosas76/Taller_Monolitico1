<?php

namespace app\models\repositories;

use app\models\entities\Reservations;

interface ReservationsRepositoryInterface
{
    public function get_reservations_all(): array;
    public function save_new_reservations(Reservations $reservations): bool;
    public function find_reservations_by_id(int $id): Reservations|null;
    public function save_reservations(Reservations $reservations): bool;
    public function delete_reservations(int $id): bool;

    // Historial y reglas de negocio
    public function get_reservations_by_client(int $client_id): array;
    public function get_reservations_by_vehicle(int $vehicle_id): array;
    public function has_conflict(int $vehicle_id, string $start, string $end, int $exclude_id = 0): bool;
    public function has_active_today(int $vehicle_id): bool;
    public function set_status(int $id, string $status): bool;
}
