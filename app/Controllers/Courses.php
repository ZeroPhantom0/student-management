<?php

namespace App\Controllers;
use App\Models\Course;

class Courses extends BaseController
{
    public function index()
    {
        $model = new Course();
        $data['courses'] = $model->findAll();
        $data['title'] = 'Course List';
        return view('courses/index', $data);
    }

    public function create()
    {
        return view('courses/create', ['title' => 'Add Course']);
    }

    public function store()
    {
        $model = new Course();
        $model->insert([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ]);
        return redirect()->to('/courses');
    }

    public function edit($id)
    {
        $model = new Course();
        $data['course'] = $model->find($id);
        $data['title'] = 'Edit Course';
        return view('courses/edit', $data);
    }

    public function update($id)
    {
        $model = new Course();
        $model->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ]);
        return redirect()->to('/courses');
    }

    public function delete($id)
    {
        $model = new Course();
        $model->delete($id);
        return redirect()->to('/courses');
    }
}
