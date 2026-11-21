<?php

namespace app\controllers\mappers;

use app\models\entities\Clients;

class ClientsControllerMappers
{
    public static function to_entity(array $request): Clients
    {
        return new Clients(
            empty($request["id"]) ? 0 : $request["id"],
            $request["nombre"],
            $request["telefono"],
            $request["correo"],
            $request["numero_licencia"]
        );
    }
}
