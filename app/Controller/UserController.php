<?php

namespace App\Controller;

use App\Models\User;
use Core\Exceptions\NotFoundException;
use Core\Request;
use Core\Response;
use Exception;

class UserController
{

    /**
     * @return Response
     */
    public function get(): Response
    {
        $id = Request::getParam('id');
        try {
            return Response::make()->setBody(User::getById($id)->toArray());
        } catch (Exception $exception) {
            return Response::make()->setStatusCode(404);
        }
    }

    /**
     * @return Response
     */
    public function list(): Response
    {
        $params = Request::getParams();
        $page = null;
        if (isset($params['page']))
            $page = $params['page'];

        $limit = null;
        if (isset($params['limit']))
            $limit = $params['limit'];

        return Response::make()->setBody(User::getList(null, 'ASC', $page, $limit));
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        try {
            $createdField = ['firstname', 'lastname', 'wallet_amount'];
            $params = Request::getParams();
            $data = [];
            foreach ($createdField as $item) {
                if (key_exists($item, $params)) {
                    $data[$item] = $params[$item];
                }
            }
            return Response::make()->setBody(User::create($data)->toArray())->setStatusCode(201);

        } catch (Exception $exception) {
            return Response::make()->setStatusCode(400);
        }
    }

    /**
     * @return Response
     * @throws NotFoundException
     */
    public function delete(): Response
    {
        $id = Request::getParam('id');
        User::delete($id);
        return Response::make()->setBody(['success' => true]);
    }

    /**
     * @return Response
     */
    public function update(): Response
    {
        try {
            $id = Request::getParam('id');
            $updateField = ['firstname', 'lastname', 'wallet_amount'];
            $params = Request::getParams();
            $update = [];
            foreach ($updateField as $item) {
                if (key_exists($item, $params)) {
                    $update[$item] = $params[$item];
                }
            }
            if (!empty($update))
                return Response::make()->setBody(User::update($id, $update)->toArray());

            return Response::make()->setStatusCode(400);
        } catch (Exception $exception) {
            return Response::make()->setStatusCode(400);
        }
    }
}
