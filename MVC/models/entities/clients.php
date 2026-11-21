<?php

namespace app\models\entities;

class Clients
{
    private int $id;
    private string $nombre;
    private string $telefono;
    private string $email;
    private string $numero_licencia;
    private string $fecha_inicio;
    private string $fecha_fin;

    public function __construct(
        int $id,
        string $nombre,
        string $telefono,
        string $correo,
        string $numero_licencia,
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->email = $correo;
        $this->numero_licencia = $numero_licencia;
    }

    public function get_id(): int
    {
        return $this->id;
    }
    public function get_name(): string
    {
        return $this->nombre;
    }
    public function get_phone(): string
    {
        return $this->telefono;
    }
    public function get_email(): string
    {
        return $this->email;
    }
    public function get_license_number(): string
    {
        return $this->numero_licencia;
    }
}

