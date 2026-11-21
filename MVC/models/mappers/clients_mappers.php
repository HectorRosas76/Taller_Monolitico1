<?php

namespace app\models\mappers;

use app\models\entities\Clients;

class ClientsMappers
{
    public static function to_entity(array $row_db): Clients
    {
        return new Clients(
            $row_db["id"],
            $row_db["nombre"],
            $row_db["telefono"],
            $row_db["correo"],
            $row_db["numero_licencia"],
        );
    }
}
