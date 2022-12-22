<?php

namespace App\Controller;

use App\Models\User;
use App\Models\WalletTransaction;
use Core\Exceptions\NotFoundException;
use Core\Request;
use Core\Response;
use Exception;

class WalletController
{

    /**
     * @return Response
     */
    public function recharge(): Response
    {

        $id = Request::getParam('user_id');
        $amount = Request::getParam('amount');
        if(!is_numeric($amount)){
            return Response::make()->setStatusCode(404);
        }

        try {
            try {
                $userObj = User::getById($id);
            }catch (Exception $e){
                return Response::make()->setStatusCode(404);
            }

            $user = $userObj->toArray();

            $date = date('Y-m-d H:i:s');
            WalletTransaction::create(['user_id' => $id, 'amount' => $amount, 'type' => 'credit', 'created_at' => $date]);

            $userUpdate['wallet_amount'] = $user['wallet_amount'] + $amount;

            return Response::make()->setBody(User::update($id, $userUpdate)->toArray());
        }catch (Exception $e){
            return Response::make()->setStatusCode(404);
        }

    }
}