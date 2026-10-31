<?php

namespace app\models\database;

interface VehiclesDBInterface
{
    public function exc_select($sql): array;
    public function exc_query($sql): bool;
}
