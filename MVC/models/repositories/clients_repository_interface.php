<?php

namespace app\models\repositories;

use app\models\entities\Clients;

interface ClientsRepositoryInterface
{
    public function get_clients_all(): array;
    public function save_new_clients(Clients $clients): bool;
    public function find_clients_by_id(int $id): Clients|null;
    public function save_clients(Clients $clients): bool;
}
