<?php

namespace App\Models;

use CodeIgniter\Model;

class Task extends Model
{
    protected $table            = 'tasks';
    protected $primaryKey       = 'task_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'description', 'estimated_time', 'importance_status', 'status', 'due_date','projects_project_id','users_user_id'];

     // Validation rules
     protected $validationRules = [
        'title' => 'required',
        'description' => 'required',
        'estimated_time' => 'required',
        'importance_status' => 'required',
        'due_date' => 'required',
    ];

  

    public function getTasksByProject($projectId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tasks');
        $builder->select('tasks.*');      
        $builder->where('projects_project_id', $projectId);
        $query = $builder->get();
        return $query->getResultArray();
    }
    public function getTasksByUser($userId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tasks');
        $builder->select('tasks.*');
        $builder->where('users_user_id', $userId);
        $query = $builder->get();
        return $query->getResultArray();
    }
    public function getFinishedTaskCount($projectId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tasks');
        $builder->selectCount('tasks.task_id', 'finished_task_count');
        $builder->where('projects_project_id', $projectId);
        $builder->where('tasks.status', 'finished');
        $query = $builder->get();
        return $query->getRow()->finished_task_count;
    }
}
