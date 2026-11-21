<?php

namespace app\models\database;

use mysqli;
use mysqli_sql_exception;

class Vehicles_DB implements VehiclesDBInterface
{
    private string $host_db = "localhost";
    private string $user_db = "root";
    private string $pwd_db = "";
    private string $name_db = "alquiler_vehiculos_db";
    private int $port_db = 3306;

    private ?mysqli $conex = null;

    public function __construct()
    {
        $this->conex = new mysqli(
            $this->host_db,
            $this->user_db,
            $this->pwd_db,
            $this->name_db,
            $this->port_db
        );
        if ($this->conex->connect_error) {
            print($this->conex->connect_error);
            die();
        }
        $this->conex->set_charset("utf8mb4");
    }

    // La conexión queda abierta mientras exista el objeto,se cierra en __destruct.
    public function exc_select($sql): array
    {
        $result = $this->conex->query($sql);
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            array_push($rows, $row);
        }
        return $rows;
    }

    public function exc_query($sql): bool
    {
        try {
            return (bool) $this->conex->query($sql);
        } catch (mysqli_sql_exception $e) {
            error_log("[Vehicles_DB] " . $e->getMessage() . " | SQL: " . $sql);
            return false;
        }
    }

    public function __destruct()
    {
        if ($this->conex instanceof mysqli) {
            @$this->conex->close();
        }
    }
}
