<?php

namespace App\Controllers;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;

class Home extends BaseController
{
    public function index()
    {
        $studentCount = (new Student())->countAll();
        $courseCount = (new Course())->countAll();
        $enrollmentCount = (new Enrollment())->countAll();

        return view('dashboard', [
            'studentCount' => $studentCount,
            'courseCount' => $courseCount,
            'enrollmentCount' => $enrollmentCount,
            'title' => 'Dashboard'
        ]);
    }
}
