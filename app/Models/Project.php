<?php

namespace App\Models;

use CodeIgniter\Model;

class Project extends Model
{
    protected $table            = 'projects';
    protected $primaryKey = 'project_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['title','company', 'description', 'started_date', 'due_date'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'title' => 'required|min_length[5]|max_length[100]',
        'description' => 'required',
        'company' => 'required',
        'started_date' => 'required|valid_date',
        'due_date' => 'required|valid_date',
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'The title field is required.',
            'min_length' => 'The title must be at least 5 characters long.',
            'max_length' => 'The title cannot exceed 100 characters.',
        ],
        'company' => [
            'required' => 'The company field is required.',
        ],
        'description' => [
            'required' => 'The description field is required.',
        ],
        'started_date' => [
            'required' => 'The start date field is required.',
            'valid_date' => 'Please enter a valid start date.',
        ],
        'due_date' => [
            'required' => 'The due date field is required.',
            'valid_date' => 'Please enter a valid due date.',
        ],
    ];

    protected $skipValidation = false;

}
