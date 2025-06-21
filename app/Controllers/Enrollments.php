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
        $data['enrollments'] = $model->getWithDetails();
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
        $studentModel = new Student();
        $courseModel = new Course();
        
        $studentId = $this->request->getPost('student_id');
        $courseId = $this->request->getPost('course_id');
        
        $student = $studentModel->find($studentId);
        $course = $courseModel->find($courseId);
        
        $enrollmentData = [
            'student_id' => $studentId,
            'course_id' => $courseId,
            'enrollment_date' => $this->request->getPost('enrollment_date'),
            'grade' => $this->request->getPost('grade'),
            'attendance' => $this->request->getPost('attendance'),
        ];
        
        $model->insert($enrollmentData);
        
        // Log activity
        $activityModel = model('ActivityModel');
        $activityModel->insert([
            'user_id' => session()->get('user.id'),
            'activity_type' => 'enrollment',
            'details' => 'Enrolled student ' . $student['name'] . ' in course ' . $course['name'],
            'ip_address' => $this->request->getIPAddress()
        ]);

        return redirect()->to('/enrollments')->with('success', 'Enrollment added successfully');
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
        $studentModel = new Student();
        $courseModel = new Course();
        
        $studentId = $this->request->getPost('student_id');
        $courseId = $this->request->getPost('course_id');
        
        $student = $studentModel->find($studentId);
        $course = $courseModel->find($courseId);
        
        $enrollmentData = [
            'student_id' => $studentId,
            'course_id' => $courseId,
            'enrollment_date' => $this->request->getPost('enrollment_date'),
            'grade' => $this->request->getPost('grade'),
            'attendance' => $this->request->getPost('attendance'),
        ];
        
        $model->update($id, $enrollmentData);
        
        // Log activity
        $activityModel = model('ActivityModel');
        $activityModel->insert([
            'user_id' => session()->get('user.id'),
            'activity_type' => 'enrollment',
            'details' => 'Updated enrollment #' . $id . ' for student ' . $student['name'] . ' in course ' . $course['name'],
            'ip_address' => $this->request->getIPAddress()
        ]);

        return redirect()->to('/enrollments')->with('success', 'Enrollment updated successfully');
    }

    public function delete($id)
    {
        $model = new Enrollment();
        $studentModel = new Student();
        $courseModel = new Course();
        
        $enrollment = $model->find($id);
        $student = $studentModel->find($enrollment['student_id']);
        $course = $courseModel->find($enrollment['course_id']);
        
        $model->delete($id);
        
        // Log activity
        $activityModel = model('ActivityModel');
        $activityModel->insert([
            'user_id' => session()->get('user.id'),
            'activity_type' => 'enrollment',
            'details' => 'Deleted enrollment #' . $id . ' for student ' . $student['name'] . ' in course ' . $course['name'],
            'ip_address' => $this->request->getIPAddress()
        ]);

        return redirect()->to('/enrollments')->with('success', 'Enrollment deleted successfully');
    }
}