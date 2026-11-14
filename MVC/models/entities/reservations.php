<?php

namespace app\models\entities;

//foreign key cliente_id references clients(id) and vehiculo_id references vehicles(id)
class Reservations
{
    private int $id;
    private string $cliente_id;
    private string $vehiculo_id;
    private string $fecha_inicio;
    private string $fecha_fin;

    private string $estado;

    public function __construct(
        int $id,
        string $cliente_id,
        string $vehiculo_id,
        string $fecha_inicio,
        string $fecha_fin,
        string $estado
    ) {
        $this->id = $id;
        $this->cliente_id = $cliente_id;
        $this->vehiculo_id = $vehiculo_id;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->estado = $estado;
    }

    public function get_id(): int
    {
        return $this->id;
    }
    public function get_client_id(): string
    {
        return $this->cliente_id;
    }
    public function get_vehicle_id(): string
    {
        return $this->vehiculo_id;
    }
    public function get_start_date(): string
    {
        return $this->fecha_inicio;
    }
    public function get_end_date(): string
    {
        return $this->fecha_fin;
    }
    public function get_status(): string
    {
        return $this->estado;
    }
}

