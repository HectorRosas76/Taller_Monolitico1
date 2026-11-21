<?php

namespace app\controllers\reservations;

use app\controllers\mappers\ReservationsControllerMappers;
use app\models\repositories\ReservationsRepositoryInterface;
use app\models\repositories\VehiclesRepositoryInterface;
use app\models\entities\Reservations;
use DateTime;
use Exception;
use InvalidArgumentException;

class ReservationsController implements ReservationsControllerInterface
{
    private ReservationsRepositoryInterface $reservations_model;
    private VehiclesRepositoryInterface $vehicles_model;

    public function __construct(
        ReservationsRepositoryInterface $reservations_model,
        VehiclesRepositoryInterface $vehicles_model
    ) {
        $this->reservations_model = $reservations_model;
        $this->vehicles_model = $vehicles_model;
    }

    public function get_reservations(): array
    {
        return $this->reservations_model->get_reservations_all();
    }

    public function reservation_create(array $post_data): bool
    {
        $this->validate($post_data);
        $entity = ReservationsControllerMappers::to_entity($post_data);
        $ok = $this->reservations_model->save_new_reservations($entity);
        if ($ok) {
            $this->sync_vehicle_status((int) $entity->get_vehicle_id());
        }
        return $ok;
    }

    public function get_reservation(int $id): Reservations
    {
        if (empty($id)) {
            throw new Exception("id incorrecto", 1);
        }
        $reservation = $this->reservations_model->find_reservations_by_id($id);
        if (empty($reservation)) {
            throw new Exception("Id:$id no existe", 2);
        }
        return $reservation;
    }

    public function reservation_update(array $post_data): bool
    {
        $id = (int) ($post_data['id'] ?? 0);
        $old = $this->get_reservation($id);          
        $this->validate($post_data, $id);
        $entity = ReservationsControllerMappers::to_entity($post_data);
        $ok = $this->reservations_model->save_reservations($entity);
        if ($ok) {
            $this->sync_vehicle_status((int) $old->get_vehicle_id());
            $this->sync_vehicle_status((int) $entity->get_vehicle_id());
        }
        return $ok;
    }

    public function reservation_delete(int $id): bool
    {
        $reservation = $this->get_reservation($id);
        $ok = $this->reservations_model->delete_reservations($id);
        if ($ok) {
            $this->sync_vehicle_status((int) $reservation->get_vehicle_id());
        }
        return $ok;
    }

    // Devuelve vehiculo y da a disponible.
    public function reservation_return(int $id): bool
    {
        $reservation = $this->get_reservation($id);
        if ($reservation->get_status() !== 'activa') {
            throw new InvalidArgumentException("Solo se pueden devolver reservas activas.");
        }
        $ok = $this->reservations_model->set_status($id, 'completada');
        if ($ok) {
            $this->sync_vehicle_status((int) $reservation->get_vehicle_id());
        }
        return $ok;
    }

    public function get_history_by_client(int $client_id): array
    {
        return $this->reservations_model->get_reservations_by_client($client_id);
    }

    public function get_history_by_vehicle(int $vehicle_id): array
    {
        return $this->reservations_model->get_reservations_by_vehicle($vehicle_id);
    }

    //  Reglas de negocio ----------

    private function validate(array $d, int $exclude_id = 0): void
    {
        foreach (['cliente_id', 'vehiculo_id', 'fecha_inicio', 'fecha_fin', 'estado'] as $campo) {
            if (empty($d[$campo])) {
                throw new InvalidArgumentException("Faltan datos obligatorios de la reserva.");
            }
        }
        if (!self::is_valid_date($d['fecha_inicio']) || !self::is_valid_date($d['fecha_fin'])) {
            throw new InvalidArgumentException("Las fechas no son válidas.");
        }
        if ($d['fecha_fin'] < $d['fecha_inicio']) {
            throw new InvalidArgumentException("La fecha de fin no puede ser anterior a la fecha de inicio.");
        }
        if (!in_array($d['estado'], ['activa', 'completada', 'cancelada'], true)) {
            throw new InvalidArgumentException("El estado de la reserva no es válido.");
        }

        $vehicle = $this->vehicles_model->find_vehicles_by_id((int) $d['vehiculo_id']);
        if ($vehicle === null) {
            throw new InvalidArgumentException("El vehículo seleccionado no existe.");
        }

        // Si vehiculo se escoge, se bloquea su disponibilidad.
        if ($d['estado'] === 'activa') {
            if ($vehicle->get_estado() === 'mantenimiento') {
                throw new InvalidArgumentException("El vehículo está en mantenimiento y no se puede reservar.");
            }
            if ($this->reservations_model->has_conflict((int) $d['vehiculo_id'], $d['fecha_inicio'], $d['fecha_fin'], $exclude_id)) {
                throw new InvalidArgumentException("Ese vehículo ya tiene una reserva activa que se cruza con las fechas elegidas.");
            }
        }
    }

    // Estado automático: alquilado sino disponible.
    // mantenimiento no.
    private function sync_vehicle_status(int $vehicle_id): void
    {
        $vehicle = $this->vehicles_model->find_vehicles_by_id($vehicle_id);
        if ($vehicle === null || $vehicle->get_estado() === 'mantenimiento') {
            return;
        }
        $new_status = $this->reservations_model->has_active_today($vehicle_id) ? 'alquilado' : 'disponible';
        if ($new_status !== $vehicle->get_estado()) {
            $this->vehicles_model->set_vehicle_status($vehicle_id, $new_status);
        }
    }

    private static function is_valid_date(string $date): bool
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d !== false && $d->format('Y-m-d') === $date;
    }
}
