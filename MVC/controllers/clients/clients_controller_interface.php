<?php

namespace app\controllers\clients;

use app\models\entities\Clients;

interface ClientsControllerInterface
{
    public function get_clients(): array;
    public function client_create(array $post_data): bool;
    public function get_client(int $id): Clients;
    public function client_update(array $post_data): bool;
}
