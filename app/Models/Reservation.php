<?php

namespace App\Models;

use Core\DB;
use Core\Model;

class Reservation extends Model
{
    /**
     * @return array|null
     */
    public static function getReservationsWithPc(): ?array
    {
        $whereClause['devices.type'] = 'pc';
        $whereClause['ORDER'] = 'reservations.id';
        $rows = DB::get()->select(static::getTable() , ['[><]devices' => ['device_id' => 'id']],['reservations.id','reservations.user_id','reservations.device_id','reservations.cost','reservations.start','reservations.end'] , $whereClause);

        $result = [];
        foreach ($rows as $row) {
            $result[] = static::convertToClassObject($row);
        }

        return $result;
    }

    /**
     * @return array|null
     */
    public static function getReservationsWithConsole(): ?array
    {
        $whereClause['devices.type'] = 'console';
        $rows = DB::get()->select(static::getTable() , ['[><]devices' => ['device_id' => 'id']],['reservations.id','reservations.user_id','reservations.device_id','reservations.cost','reservations.start','reservations.end'] , $whereClause);

        $result = [];
        foreach ($rows as $row) {
            $result[] = static::convertToClassObject($row);
        }

        return $result;
    }

    /**
     * @param int $deviceId
     * @param string $start
     * @param string $end
     * @return bool
     */
    public static function isReserved(int $deviceId, string $start, string $end): bool
    {
        $whereClause['device_id'] = $deviceId;
        $whereClause['start[<]'] = $end;
        $whereClause['end[>]'] = $start;

        if(DB::get()->select(static::getTable(), '*', $whereClause))
            return true;
        return false;
    }
}
