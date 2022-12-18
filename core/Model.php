<?php

namespace Core;

use Core\Exceptions\InvalidInputException;
use Core\Exceptions\NotFoundException;
use Exception;
use Illuminate\Support\Str;

abstract class Model
{

    /**
     * @param array $data
     * @return Model|null
     * @throws InvalidInputException
     * @throws NotFoundException
     * @throws Exception
     */
    public static function create(array $data): ?Model
    {
        if (empty($data)) {
            throw new InvalidInputException('array is empty');
        }
        try {
            DB::get()->insert(static::getTable(), $data);
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }

        return static::getById(DB::get()->id());
    }

    /**
     * @param int $id
     * @return Model|null
     * @throws NotFoundException
     */
    public static function getById(int $id): ?Model
    {
        $data = DB::get()->get(static::getTable(), '*', compact('id'));
        if (empty($data)){
            throw new NotFoundException('there is any data per id:'.$id);
        }
        return static::convertToClassObject($data);
    }

    /**
     * @param string|null $orderBy
     * @param string $direction
     * @param int|null $page
     * @param int|null $limit
     * @return array
     */
    public static function getList(?string $orderBy = null, string $direction = 'ASC', ?int $page = null, ?int $limit = null): array
    {
        $whereClause = [];
        if(!empty($orderBy)){
            $whereClause['ORDER'][$orderBy]= $direction;
        }
        if($page > 0 && $limit > 0){
            $whereClause['LIMIT'] = [($page-1)*$limit, $limit];
        }

        $rows = DB::get()->select(static::getTable(), '*',$whereClause);

        $result = [];
        foreach ($rows as $row) {
            $result[] = static::convertToClassObject($row);
        }

        return $result;
    }

    /**
     * @param int $id
     * @param array $data
     * @return Model|null
     * @throws NotFoundException
     * @throws Exception
     */
    public static function update(int $id, array $data): ?Model
    {
        $dataPerId = DB::get()->get(static::getTable(), '*', compact('id'));
        if (empty($dataPerId)){
            throw new NotFoundException('there is any data per id:'.$id);
        }

        try {
            DB::get()->update(static::getTable(), $data, compact('id'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return static::getById($id);

    }

    /**
     * @param int $id
     * @return void
     * @throws NotFoundException
     */
    public static function delete(int $id): void
    {
        if(!empty(static::getById($id))) {
            DB::get()->delete(static::getTable(),compact('id'));
        }
    }

    /**
     * @param $data
     * @return Model
     */
    protected static function convertToClassObject($data): Model
    {
        $object = new static;
        foreach ($data as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * @return string
     */
    public static function getTable(): string
    {
        return Str::snake(Str::pluralStudly(class_basename(new static)));
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
