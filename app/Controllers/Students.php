<?php

namespace App\Controllers;
use App\Models\Student;

class Students extends BaseController
{
    public function index()
    {
        $model = new Student();
        $data['students'] = $model->findAll();
        $data['title'] = 'Student List';
        return view('students/index', $data);
    }

    public function create()
    {
        return view('students/create', ['title' => 'Add Student']);
    }

    public function store()
    {
        $model = new Student();
        $model->insert([
            'name' => $this->request->getPost('name'),
            'age' => $this->request->getPost('age')
        ]);
        return redirect()->to('/students');
    }

    public function edit($id)
    {
        $model = new Student();
        $data['student'] = $model->find($id);
        $data['title'] = 'Edit Student';
        return view('students/edit', $data);
    }

    public function update($id)
    {
        $model = new Student();
        $model->update($id, [
            'name' => $this->request->getPost('name'),
            'age' => $this->request->getPost('age')
        ]);
        return redirect()->to('/students');
    }

    public function delete($id)
    {
        $model = new Student();
        $model->delete($id);
        return redirect()->to('/students');
    }
}
