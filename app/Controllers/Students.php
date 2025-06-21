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
        $studentData = [
            'name' => $this->request->getPost('name'),
            'age' => $this->request->getPost('age')
        ];
        
        $model->insert($studentData);
        
        // Log activity
        $activityModel = model('ActivityModel');
        $activityModel->insert([
            'user_id' => session()->get('user.id'),
            'activity_type' => 'student',
            'details' => 'Added new student: ' . $studentData['name'],
            'ip_address' => $this->request->getIPAddress()
        ]);

        return redirect()->to('/students')->with('success', 'Student added successfully');
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
        $studentData = [
            'name' => $this->request->getPost('name'),
            'age' => $this->request->getPost('age')
        ];
        
        $model->update($id, $studentData);
        
        // Log activity
        $activityModel = model('ActivityModel');
        $activityModel->insert([
            'user_id' => session()->get('user.id'),
            'activity_type' => 'student',
            'details' => 'Updated student #' . $id . ': ' . $studentData['name'],
            'ip_address' => $this->request->getIPAddress()
        ]);

        return redirect()->to('/students')->with('success', 'Student updated successfully');
    }

    public function delete($id)
    {
        $model = new Student();
        $student = $model->find($id);
        $model->delete($id);
        
        // Log activity
        $activityModel = model('ActivityModel');
        $activityModel->insert([
            'user_id' => session()->get('user.id'),
            'activity_type' => 'student',
            'details' => 'Deleted student #' . $id . ': ' . $student['name'],
            'ip_address' => $this->request->getIPAddress()
        ]);

        return redirect()->to('/students')->with('success', 'Student deleted successfully');
    }
}