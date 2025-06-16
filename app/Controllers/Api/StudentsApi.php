<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Student;
use CodeIgniter\API\ResponseTrait;

class StudentsApi extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        if (!$this->validateToken()) {
            return $this->failUnauthorized('Invalid or missing token');
        }

        $model = new Student();
        $students = $model->findAll();

        return $this->respond([
            'status' => 'success',
            'data' => $students
        ]);
    }

    // Other methods similar to CoursesApi.php
    // Implement show(), create(), update(), delete() following the same pattern

    /**
     * Validates the API token from the request headers.
     * @return bool
     */
    protected function validateToken()
    {
        $token = $this->request->getHeaderLine('Authorization');
        // Replace 'your-secret-token' with your actual token or validation logic
        return $token === 'Bearer your-secret-token';
    }
}