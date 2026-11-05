<?php

namespace app\models\database;

interface ClientsDBInterface
{
    public function exc_select($sql): array;
    public function exc_query($sql): bool;
}
