<?php

namespace App\Controller;

use App\Models\Device;
use App\Models\Reservation;
use App\Models\User;
use App\Models\WalletTransaction;
use Core\Request;
use Core\Response;
use Exception;

class ReservationController
{

    /**
     * @return Response
     */
    public function getReservations(): Response
    {
        $result['pc'] = Reservation::getReservationsWithPc();
        $result['console'] = Reservation::getReservationsWithConsole();
        return Response::make()->setBody($result);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        $userId = Request::getParam('user_id');
        $deviceId = Request::getParam('device_id');
        $start = Request::getParam('start');
        $end = Request::getParam('end');

        $timestamp1 = strtotime($start);
        $timestamp2 = strtotime($end);
        $hour = abs($timestamp2 - $timestamp1)/(60*60);

        if(Reservation::isReserved($deviceId,$start,$end)) {
            return Response::make()->setStatusCode(400);
        }

        try {
            $user = User::getById($userId)->toArray();
        }catch (Exception $e){
            return Response::make()->setStatusCode(400);
        }
        $userWallet = $user['wallet_amount'];

        try {
            $device = Device::getById($deviceId)->toArray();
        }catch (Exception $e){
            return Response::make()->setStatusCode(400);
        }

        $deviceCostPerHour = $device['cost_per_hour'];
        $deviceCostAll = $deviceCostPerHour * $hour;

        if($userWallet < $deviceCostAll){
            return Response::make()->setStatusCode(400);
        }

        $reservationData = [
            'user_id' => $userId ,
            'device_id' => $deviceId ,
            'cost' => $deviceCostAll ,
            'start' => $start ,
            'end' => $end
        ];

        try {

            $reservationEntity = Reservation::create($reservationData);

            $date = date('Y-m-d H:i:s');
            WalletTransaction::create(['user_id' => $userId , 'type' => 'debit' , 'created_at' => $date , 'amount' => $deviceCostAll]);

            return Response::make()->setBody($reservationEntity->toArray());
        }catch (Exception $e){

            return Response::make()->setStatusCode(400);
        }

    }
}