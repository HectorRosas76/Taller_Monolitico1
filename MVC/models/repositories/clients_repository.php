<?php

namespace app\models\repositories;

use app\models\database\ClientsDBInterface;
use app\models\entities\Clients;
use app\models\mappers\ClientsMappers;
use Exception;

class ClientsRepository implements ClientsRepositoryInterface
{
    private ClientsDBInterface $clients_db;

    public function __construct(ClientsDBInterface $clients_db)
    {
        $this->clients_db = $clients_db;
    }

    public function get_clients_all(): array
    {
        $sql = "select * from clientes";
        $rows_db = $this->clients_db->exc_select($sql);
        $clients = [];
        foreach ($rows_db as $item) {
            array_push($clients, ClientsMappers::to_entity($item));
        }
        return $clients;
    }

    public function save_new_clients(Clients $clients): bool
    {
        $sql = "insert into clientes(nombre,telefono,correo,numero_licencia)values";
        $sql .= "('" . $clients->get_name() . "','" . $clients->get_phone() . "','" . $clients->get_email() . "','" . $clients->get_license_number() . "')";
        $result = $this->clients_db->exc_query($sql);
        return $result;
    }

    public function find_clients_by_id(int $id): Clients|null
    {
        $sql = "select * from clientes where id=$id";
        $rows_db = $this->clients_db->exc_select($sql);
        foreach ($rows_db as $item) {
            return ClientsMappers::to_entity($item);
        }
        return null;
    }

    public function save_clients(Clients $clients): bool
    {
        $sql = "update clientes set ";
        $sql .= " nombre='" . $clients->get_name() . "', ";
        $sql .= " telefono='" . $clients->get_phone() . "', ";
        $sql .= " correo='" . $clients->get_email() . "', ";
        $sql .= " numero_licencia='" . $clients->get_license_number() . "' ";
        $sql .= " where id=" . $clients->get_id();
        return $this->clients_db->exc_query($sql);
    }
}
