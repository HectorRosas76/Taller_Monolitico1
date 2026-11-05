<?php

namespace app\controllers\clients;

use app\controllers\mappers\ClientsControllerMappers;
use app\models\repositories\ClientsRepositoryInterface;
use app\models\entities\Clients;
use Exception;

class ClientsController implements ClientsControllerInterface
{

    private ClientsRepositoryInterface $clients_model;

    public function __construct(ClientsRepositoryInterface $clients_model)
    {
        $this->clients_model = $clients_model;
    }

    public function get_clients(): array
    {
        $list = $this->clients_model->get_clients_all();
        return $list;
    }

    public function client_create(array $post_data): bool
    {
        $dato_form = ClientsControllerMappers::to_entity($post_data);
        $client = $this->clients_model->save_new_clients($dato_form);
        return !empty($client);
    }

    public function get_client(int $id): Clients
    {
        if (empty($id)) {
            throw new Exception("id incorrecto", 1);
        }
        $client = $this->clients_model->find_clients_by_id($id);
        if (empty($client)) {
            throw new Exception("Id:$id no existe", 2);
        }
        return $client;
    }

    public function client_update(array $post_data): bool
    {
        $datos_form = ClientsControllerMappers::to_entity($post_data);;
        $clients = $this->clients_model->save_clients($datos_form);
        return !empty($clients);
    }
}
