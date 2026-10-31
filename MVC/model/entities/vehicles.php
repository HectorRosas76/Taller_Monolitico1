<?php

namespace app\models\entities;

class Vehicles
{
    private int $id;
    private string $marca;
    private string $modelo;
    private string $anio;
    private string $categoria;
    private string $estado;
    private string $fecha_inicio;
    private string $fecha_fin;

    public function __construct(
        int $id,
        string $marca,
        string $modelo,
        string $anio,
        string $categoria,
        string $estado,
        string $fecha_inicio,
        string $fecha_fin
    ) {
        $this->id = $id;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->anio = $anio;
        $this->categoria = $categoria;
        $this->estado = $estado;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    public function get_id(): int
    {
        return $this->id;
    }
    public function get_marca(): string
    {
        return $this->marca;
    }
    public function get_model(): string
    {
        return $this->modelo;
    }
    public function get_anio(): string
    {
        return $this->anio;
    }
    public function get_categoria(): string
    {
        return $this->categoria;
    }
    public function get_estado(): string
    {
        return $this->estado;
    }
    public function get_start_date(): string
    {
        return $this->fecha_inicio;
    }
    public function get_end_date(): string
    {
        return $this->fecha_fin;
    }
}
