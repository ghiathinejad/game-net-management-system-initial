<?php

namespace App\Models;

use Core\Exceptions\InvalidInputException;
use Core\Exceptions\NotFoundException;
use Core\Model;

class Device extends Model
{
    const TYPE_PC = 'pc';
    const TYPE_CONSOLE = 'console';

    public static function create(array $data): ?Model
    {
        // TODO: Implement
    }
}