<?php

namespace App\Controllers;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;

class Enrollments extends BaseController
{
    public function index()
    {
        $model = new Enrollment();
        $data['enrollments'] = $model->getWithDetails(); // fetch with student & course info
        $data['title'] = 'Enrollments';
        return view('enrollments/index', $data);
    }

    public function create()
    {
        $data['students'] = (new Student())->findAll();
        $data['courses'] = (new Course())->findAll();
        $data['title'] = 'Add Enrollment';
        return view('enrollments/create', $data);
    }

    public function store()
    {
        $model = new Enrollment();
        $model->insert([
            'student_id' => $this->request->getPost('student_id'),
            'course_id' => $this->request->getPost('course_id'),
            'enrollment_date' => $this->request->getPost('enrollment_date'),
            'grade' => $this->request->getPost('grade'),
            'attendance' => $this->request->getPost('attendance'),
        ]);
        return redirect()->to('/enrollments');
    }

    public function edit($id)
    {
        $model = new Enrollment();
        $data['enrollment'] = $model->find($id);
        $data['students'] = (new Student())->findAll();
        $data['courses'] = (new Course())->findAll();
        $data['title'] = 'Edit Enrollment';
        return view('enrollments/edit', $data);
    }

    public function update($id)
    {
        $model = new Enrollment();
        $model->update($id, [
            'student_id' => $this->request->getPost('student_id'),
            'course_id' => $this->request->getPost('course_id'),
            'enrollment_date' => $this->request->getPost('enrollment_date'),
            'grade' => $this->request->getPost('grade'),
            'attendance' => $this->request->getPost('attendance'),
        ]);
        return redirect()->to('/enrollments');
    }

    public function delete($id)
    {
        $model = new Enrollment();
        $model->delete($id);
        return redirect()->to('/enrollments');
    }
}
