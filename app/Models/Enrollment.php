<?php

namespace App\Models;
use CodeIgniter\Model;

class Enrollment extends Model
{
    protected $table = 'enrollments';
    protected $allowedFields = ['student_id', 'course_id', 'enrollment_date', 'grade', 'attendance'];
    public $timestamps = true;

    // Optional helper to fetch joined data
    public function getWithDetails()
    {
        return $this->select('enrollments.*, students.name AS student_name, courses.name AS course_name')
                    ->join('students', 'students.id = enrollments.student_id')
                    ->join('courses', 'courses.id = enrollments.course_id')
                    ->findAll();
    }
}
