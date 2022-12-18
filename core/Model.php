<?php

namespace Core;

use Core\Exceptions\InvalidInputException;
use Core\Exceptions\NotFoundException;
use Exception;
use Illuminate\Support\Str;
use PDO;

abstract class Model
{
    public static function create(array $data): ?Model
    {
        // TODO: Implement
    }

    public static function getById(int $id): ?Model
    {
        // TODO: Implement
    }

    public static function getList(?string $orderBy = null, string $direction = 'ASC', ?int $page = null, ?int $limit = null): array
    {
        // TODO: Implement
    }

    public static function update(int $id, array $data)
    {
        // TODO: Implement
    }

    public static function delete(int $id): void
    {
        // TODO: Implement
    }

    protected static function convertToClassObject($data): Model
    {
        $object = new static;
        foreach ($data as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    public static function getTable(): string
    {
        return Str::snake(Str::pluralStudly(class_basename(new static)));
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
