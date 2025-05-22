<?php

namespace App\Models;
use CodeIgniter\Model;

class Course extends Model
{
    protected $table = 'courses';
    protected $allowedFields = ['name', 'description'];
    public $timestamps = true;
}
