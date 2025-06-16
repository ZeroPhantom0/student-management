<?php

namespace App\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\FileModel;
use App\Models\ActivityModel;

class Home extends BaseController
{
    public function index()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/login');
    }

    $fileModel = new FileModel();
    $activityModel = new ActivityModel(); // Add this line
    $userId = session('user.id');
    
    // Get current user's files count
    $userFileCount = $fileModel->where('user_id', $userId)->countAllResults();
    
    $data = [
        'studentCount' => (new Student())->countAll(),
        'courseCount' => (new Course())->countAll(),
        'enrollmentCount' => (new Enrollment())->countAll(),
        'title' => 'Dashboard',
        'userFileCount' => $userFileCount,
        'activities' => $activityModel->getRecentActivities() // Add this line
    ];

    // Admin-specific data
    if (session('user.role') === 'admin') {
        $data['totalFileCount'] = $fileModel->countAll();
        $data['recentActivity'] = $this->getRecentActivity();
    }

    return view('dashboard', $data);
}

    protected function getRecentActivity()
    {
        $db = \Config\Database::connect();
        
        return [
            'new_users' => $db->table('users')
                             ->where('created_at >=', date('Y-m-d', strtotime('-7 days')))
                             ->countAllResults(),
            
            'file_uploads' => $db->table('files')
                               ->where('created_at >=', date('Y-m-d', strtotime('-7 days')))
                               ->countAllResults(),
            
            'new_enrollments' => $db->table('enrollments')
                                  ->where('enrollment_date >=', date('Y-m-d', strtotime('-7 days')))
                                  ->countAllResults(),
            
            'active_users' => $db->table('users')
                               ->where('last_activity >=', date('Y-m-d H:i:s', strtotime('-24 hours')))
                               ->countAllResults()
        ];
    }
}