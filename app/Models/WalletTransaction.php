<?php

namespace App\Models;

use Core\Exceptions\InvalidInputException;
use Core\Exceptions\NotFoundException;
use Core\Model;

class WalletTransaction extends Model
{
    const TYPE_DEBIT = 'debit';
    const TYPE_CREDIT = 'credit';

    /**
     * @param array $data
     * @return Model|null
     * @throws InvalidInputException
     * @throws NotFoundException
     */
    public static function create(array $data): ?Model
    {
        if(isset($data['type']) && in_array($data['type'],[self::TYPE_DEBIT,self::TYPE_CREDIT]))
            return Parent::create($data);

        throw new InvalidInputException('type: '.$data['type'].' not defined');
    }
}
