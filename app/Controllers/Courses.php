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
        $courseData = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ];
        
        $model->insert($courseData);
        
        // Log activity
        $activityModel = model('ActivityModel');
        $activityModel->insert([
            'user_id' => session()->get('user.id'),
            'activity_type' => 'course',
            'details' => 'Added new course: ' . $courseData['name'],
            'ip_address' => $this->request->getIPAddress()
        ]);

        return redirect()->to('/courses')->with('success', 'Course added successfully');
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
        $courseData = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ];
        
        $model->update($id, $courseData);
        
        // Log activity
        $activityModel = model('ActivityModel');
        $activityModel->insert([
            'user_id' => session()->get('user.id'),
            'activity_type' => 'course',
            'details' => 'Updated course #' . $id . ': ' . $courseData['name'],
            'ip_address' => $this->request->getIPAddress()
        ]);

        return redirect()->to('/courses')->with('success', 'Course updated successfully');
    }

    public function delete($id)
    {
        $model = new Course();
        $course = $model->find($id);
        $model->delete($id);
        
        // Log activity
        $activityModel = model('ActivityModel');
        $activityModel->insert([
            'user_id' => session()->get('user.id'),
            'activity_type' => 'course',
            'details' => 'Deleted course #' . $id . ': ' . $course['name'],
            'ip_address' => $this->request->getIPAddress()
        ]);

        return redirect()->to('/courses')->with('success', 'Course deleted successfully');
    }
}