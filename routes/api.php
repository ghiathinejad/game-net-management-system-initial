<?php

use App\Controller\DeviceController;
use App\Controller\ReservationController;
use App\Controller\UserController;
use App\Controller\WalletController;
use Core\Router;

Router::get('/user', [UserController::class, 'get']);
Router::get('/users', [UserController::class, 'list']);
Router::post('/user', [UserController::class, 'create']);
Router::delete('/user', [UserController::class, 'delete']);
Router::patch('/user', [UserController::class, 'update']);

Router::post('/wallet/user', [WalletController::class, 'recharge']);

Router::get('/devices', [DeviceController::class, 'list']);
Router::post('/device', [DeviceController::class, 'create']);
Router::delete('/device', [DeviceController::class, 'delete']);
Router::patch('/device', [DeviceController::class, 'update']);

Router::get('/reservation/list', [ReservationController::class, 'getReservations']);
Router::post('/reservation', [ReservationController::class, 'create']);
