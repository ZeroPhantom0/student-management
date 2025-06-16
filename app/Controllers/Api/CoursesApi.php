<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Course;
use CodeIgniter\API\ResponseTrait;

class CoursesApi extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        if (!$this->validateToken()) {
            return $this->failUnauthorized('Invalid or missing token');
        }

        $model = new Course();
        $courses = $model->findAll();

        return $this->respond([
            'status' => 'success',
            'data' => $courses
        ]);
    }

    public function show($id)
    {
        if (!$this->validateToken()) {
            return $this->failUnauthorized('Invalid or missing token');
        }

        $model = new Course();
        $course = $model->find($id);

        if (!$course) {
            return $this->failNotFound('Course not found');
        }

        return $this->respond([
            'status' => 'success',
            'data' => $course
        ]);
    }

    public function create()
    {
        if (!$this->validateToken() || !$this->isAdmin()) {
            return $this->failForbidden('Access denied');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'description' => 'permit_empty|max_length[500]'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $model = new Course();
        $data = [
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description')
        ];

        $model->insert($data);

        return $this->respondCreated([
            'status' => 'success',
            'message' => 'Course created successfully',
            'data' => ['id' => $model->getInsertID()]
        ]);
    }

    public function update($id)
    {
        if (!$this->validateToken() || !$this->isAdmin()) {
            return $this->failForbidden('Access denied');
        }

        $model = new Course();
        $course = $model->find($id);

        if (!$course) {
            return $this->failNotFound('Course not found');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'description' => 'permit_empty|max_length[500]'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description')
        ];

        $model->update($id, $data);

        return $this->respond([
            'status' => 'success',
            'message' => 'Course updated successfully'
        ]);
    }

    public function delete($id)
    {
        if (!$this->validateToken() || !$this->isAdmin()) {
            return $this->failForbidden('Access denied');
        }

        $model = new Course();
        $course = $model->find($id);

        if (!$course) {
            return $this->failNotFound('Course not found');
        }

        $model->delete($id);

        return $this->respondDeleted([
            'status' => 'success',
            'message' => 'Course deleted successfully'
        ]);
    }

    private function validateToken()
    {
        $token = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $token);

        return $token === '1234567890abcdef'; // Replace with your actual token validation logic

        if (empty($token)) {
            return false;
        }

        // In a real app, you'd validate the token against your authentication system
        // This is a simplified example
        $validToken = session()->get('api_token');
        return $token === $validToken;
    }

    private function isAdmin()
    {
        $user = session()->get('user');
        return isset($user['role']) && $user['role'] === 'admin';
    }
}