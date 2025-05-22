<?php

namespace App\Models;
use CodeIgniter\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $allowedFields = ['name', 'age'];
    public $timestamps = true;
}
