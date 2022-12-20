<?php

namespace App\Controller;

use App\Models\User;
use App\Models\WalletTransaction;
use Core\Exceptions\NotFoundException;
use Core\Request;
use Core\Response;
use mysql_xdevapi\Exception;

class WalletController
{
    /**
     * @return Response
     * @throws NotFoundException
     * @throws \Core\Exceptions\InvalidInputException
     */
    public function recharge(): Response
    {

        $id = Request::getParam('user_id');
        $amount = Request::getParam('amount');

        try {
            $user = User::getById($id)->toArray();
            $date = date('Y-m-d H:i:s');
            WalletTransaction::create(['user_id' => $id, 'amount' => $amount, 'type' => 'credit', 'created_at' => $date]);

            $userUpdate['wallet_amount'] = $user['wallet_amount'] + $amount;

            return Response::make()->setBody(User::update($id, $userUpdate)->toArray());
        }catch (Exception $e){
            echo 123;
            return Response::make()->setStatusCode(404);
        }

    }
}