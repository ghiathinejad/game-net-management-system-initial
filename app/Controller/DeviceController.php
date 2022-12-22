<?php

namespace App\Controller;

use App\Models\Device;
use Core\Request;
use Core\Response;
use Exception;

class DeviceController
{
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

        return Response::make()->setBody(Device::getList(null, 'ASC', $page, $limit));
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        try {
            $createdField = ['type', 'cost_per_hour'];
            $params = Request::getParams();
            $data = [];
            foreach ($createdField as $item) {
                if (key_exists($item, $params)) {
                    $data[$item] = $params[$item];
                }
            }

            return Response::make()->setBody(Device::create($data)->toArray())->setStatusCode(201);
        } catch (Exception $exception) {
            return Response::make()->setStatusCode(400);
        }
    }

    /**
     * @return Response
     * @throws \Core\Exceptions\NotFoundException
     */
    public function delete(): Response
    {
        $id = Request::getParam('id');
        Device::delete($id);
        return Response::make()->setBody(['success' => true]);
    }

    /**
     * @return Response
     */
    public function update(): Response
    {
        try {
            $id = Request::getParam('id');
            $updateField = ['type', 'cost_per_hour'];
            $params = Request::getParams();
            $update = [];
            foreach ($updateField as $item) {
                if (key_exists($item, $params)) {
                    $update[$item] = $params[$item];
                }
            }
            if (!empty($update))
                return Response::make()->setBody(Device::update($id, $update)->toArray());

            return Response::make()->setStatusCode(400);
        } catch (Exception $exception) {
            return Response::make()->setStatusCode(400);
        }
    }
}