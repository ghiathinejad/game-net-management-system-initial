<?php

namespace App\Models;

use Core\DB;
use Core\Model;
use PDO;

class Reservation extends Model
{
    public static function getReservationsWithPc(): ?array
    {
        // TODO: Implement
    }

    public static function getReservationsWithConsole(): ?array
    {
        // TODO: Implement
    }

    public static function isReserved(int $deviceId, string $start, string $end): bool
    {
        // TODO: Implement
    }
}
