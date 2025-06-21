<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        if (session('user.role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Access denied');
        }

        // Get counts for admin dashboard
        $data = [
            'title' => 'Admin Dashboard',
            'studentCount' => model('Student')->countAll(),
            'courseCount' => model('Course')->countAll(),
            'enrollmentCount' => model('Enrollment')->countAll(),
            'fileCount' => model('FileModel')->countAll()
        ];

        return view('/dashboard', $data);
    }
}