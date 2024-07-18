<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class TaskController extends BaseController
{
    public function index($projectId)
    {
        $taskModel = new Task();
        $tasks = $taskModel->where('projects_project_id', $projectId)->findAll();

        $userModel = new User();
        $users = $userModel->findAll();

        $projectModel = new Project();
        $project = $projectModel->find($projectId);

        return view('admin/tasks', [
            'tasks' => $tasks,
            'users' => $users,
            'project' => $project
        ]);
    }
    public function start($id)
    {
        $taskModel = new Task();
        $task = $taskModel->find($id);
        if ($task) {
            $task['status'] = 'started';
            $taskModel->update($id, $task);
        }
        return redirect()->to('tasks');
    }

    public function finish($id)
    {
        $taskModel = new Task();
        $task = $taskModel->find($id);
        if ($task) {
            $task['status'] = 'finished';
            $taskModel->update($id, $task);
        }
        return redirect()->to('tasks');
    }
    public function delete($id)
    {
        $taskModel = new Task();
        $task = $taskModel->find($id);
        $taskModel->delete($id);
        return redirect()->to('projects/view/'.$task['projects_project_id']);
    }
    public function insert()
    {
        helper(['form', 'url']);
        $validation = \Config\Services::validation();

        // Validate input data
        $validated = $this->validate([
            'title' => 'required|min_length[5]|max_length[100]',
            'description' => 'required',
            'estimated_time' => 'required',
            'importance_status' => 'required',
            'due_date' => 'required|valid_date',
            'users_user_id' => 'required',
            'projects_project_id' => 'required',
        ], [
            'title' => [
                'required' => 'The title field is required.',
                'min_length' => 'The title must be at least 5 characters long.',
                'max_length' => 'The title cannot exceed 100 characters.',
            ],
            
            'description' => [
                'required' => 'The description field is required.',
            ],
            'estimated_time' => [
                'required' => 'The estimated time field is required.',
            ],
            'importance_status' => [
                'required' => 'The importance status field is required.',
            ],
            'users_user_id' => [
                'required' => 'The user field is required.',
            ],
            'projects_project_id' => [
                'required' => 'something went wrong.',
            ],           
            'due_date' => [
                'required' => 'The due date field is required.',
                'valid_date' => 'Please enter a valid due date.',
            ],
        ]);

        if (!$validated) {
            // If validation fails, display errors and redirect back
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Data is validated, proceed to insert into database
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'estimated_time' => $this->request->getPost('estimated_time'),
            'importance_status' => $this->request->getPost('importance_status'),
            'status' => $this->request->getPost('status'),
            'due_date' => $this->request->getPost('due_date'),
            'users_user_id' => $this->request->getPost('users_user_id'),
            'projects_project_id' => $this->request->getPost('projects_project_id'),
            
        ];

        $taskModel = new Task();

        // Insert data into the database
        if ($taskModel->insert($data)) {
            // Success message or redirect to success page
            return redirect()->to('projects/view/'.$this->request->getPost('projects_project_id'))->with('success', 'Task created successfully.');
        } else {
            // Error message or redirect to error page
            return redirect()->back()->withInput()->with('error', 'Failed to create Task.');
        }
    }

    public function update($id)
    {
        $taskModel = new Task();
        $data = $this->request->getPost();

        if ($taskModel->update($id, $data)) {
            return redirect()->to('/admin')->with('success', 'Project updated successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $taskModel->errors());
        }
    }
    public function search($projectId)
    {
        $keyword = $this->request->getGet('keyword');
        
        $taskModel = new Task();
        if ($keyword) {
            $tasks = $taskModel->where('projects_project_id', $projectId)
                               ->groupStart()
                               ->like('title', $keyword)
                               ->orLike('description', $keyword)
                               ->groupEnd()
                               ->findAll();
        } else {
            $tasks = $taskModel->where('projects_project_id', $projectId)->findAll();
        }

        $userModel = new User();
        $users = $userModel->findAll();

        $projectModel = new Project();
        $project = $projectModel->find($projectId);

        return view('admin/tasks', [
            'tasks' => $tasks,
            'users' => $users,
            'project' => $project
        ]);
    }
    public function UserTaskSearch()
    {
        $keyword = $this->request->getGet('keyword');
        $userId = session()->get('user_id'); 
        $taskModel = new Task();
        if ($keyword) {
            $tasks = $taskModel->where('users_user_id', $userId)
                               ->groupStart()
                               ->like('title', $keyword)
                               ->orLike('description', $keyword)
                               ->groupEnd()
                               ->findAll();
        } else {
            $tasks = $taskModel->where('users_user_id', $userId)->findAll();
        }

        return view('front/index', [
            'tasks' => $tasks,
        ]);
    }
    
    public function view($id)
    {
        $taskModel = new Task();

        $tasks = $taskModel->find($id);
        if (!$tasks) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Project not found');
        }

        $tasks = $taskModel->getTasksByProject($id);

        $data = [
            'tasks' => $tasks,
            
        ];

        return view('admin/tasks', $data);
    }
}
