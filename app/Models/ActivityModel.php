<?php
namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model
{
    protected $table = 'activities';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 
        'activity_type', 
        'details', 
        'ip_address',
        'user_role',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';
    
    public function getRecentActivities($limit = 10)
    {
        return $this->select('activities.*, users.name as user_name')
                   ->join('users', 'users.id = activities.user_id')
                   ->select('users.role as user_role')
                   ->orderBy('created_at', 'DESC')
                   ->findAll($limit);
    }
}