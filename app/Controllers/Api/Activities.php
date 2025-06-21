<?php

namespace App\Controllers\Api;

use App\Models\ActivityModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class Activities extends BaseController
{
    use ResponseTrait;

    public function getRecentActivities()
    {
        $model = new ActivityModel();
        $activities = $model->getRecentActivities(10);

        return $this->respond([
            'status' => 'success',
            'data' => $activities
        ]);
    }
}