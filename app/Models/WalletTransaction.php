<?php

namespace App\Models;

use Core\Exceptions\InvalidInputException;
use Core\Exceptions\NotFoundException;
use Core\Model;

class WalletTransaction extends Model
{
    const TYPE_DEBIT = 'debit';
    const TYPE_CREDIT = 'credit';

    public static function create(array $data): ?Model
    {
        // TODO: Implement
    }
}
