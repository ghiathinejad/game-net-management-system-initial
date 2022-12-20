<?php

namespace App\Models;

use Core\Exceptions\InvalidInputException;
use Core\Exceptions\NotFoundException;
use Core\Model;

class User extends Model
{
    /**
     * @param array $data
     * @return Model|null
     * @throws InvalidInputException
     * @throws NotFoundException
     */
    public static function create(array $data): ?Model
    {
        if(isset($data['wallet_amount']) && $data['wallet_amount'] > 0) unset($data['wallet_amount']);
        return parent::create($data);
    }
}
