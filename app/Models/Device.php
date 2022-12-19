<?php

namespace App\Models;

use Core\Exceptions\InvalidInputException;
use Core\Exceptions\NotFoundException;
use Core\Model;

class Device extends Model
{
    const TYPE_PC = 'pc';
    const TYPE_CONSOLE = 'console';

    /**
     * @param array $data
     * @return Model|null
     * @throws InvalidInputException
     * @throws NotFoundException
     */
    public static function create(array $data): ?Model
    {
        if(isset($data['type']) && in_array($data['type'],[self::TYPE_PC,self::TYPE_CONSOLE]))
            return Parent::create($data);

        throw new InvalidInputException('type: '.$data['type'].' not defined');
    }
}