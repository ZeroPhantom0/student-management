<?php

namespace App\Models;

use CodeIgniter\Model;

class FileModel extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'filename', 'original_name', 'file_type', 'file_size'];
    protected $useTimestamps = false; // Disable automatic timestamps
    
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function getAllFiles()
    {
        // Admin sees all files, regular users see only their own
        return session('user.role') === 'admin' 
            ? $this->findAll()
            : $this->where('user_id', session('user.id'))->findAll();
    }

    
}