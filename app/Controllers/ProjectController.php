<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Task;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Project;
class ProjectController extends BaseController
{
    public function insert()
    {
        helper(['form', 'url']);
        $validation = \Config\Services::validation();

        // Validate input data
        $validated = $this->validate([
            'title' => 'required|min_length[5]|max_length[100]',
            'company' => 'required',
            'description' => 'required',
            'started_date' => 'required|valid_date',
            'due_date' => 'required|valid_date',
        ], [
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
        ]);

        if (!$validated) {
            // If validation fails, display errors and redirect back
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Data is validated, proceed to insert into database
        $data = [
            'title' => $this->request->getPost('title'),
            'company' => $this->request->getPost('company'),
            'description' => $this->request->getPost('description'),
            'started_date' => $this->request->getPost('started_date'),
            'due_date' => $this->request->getPost('due_date'),
            // Add more fields as needed
        ];

        $projectModel = new Project();

        // Insert data into the database
        if ($projectModel->insert($data)) {
            // Success message or redirect to success page
            return redirect()->to('/admin')->with('success', 'Project created successfully.');
        } else {
            // Error message or redirect to error page
            return redirect()->back()->withInput()->with('error', 'Failed to create project.');
        }
    }

    public function update($id)
    {
        $projectModel = new Project();
        $data = $this->request->getPost();

        if ($projectModel->update($id, $data)) {
            return redirect()->to('/admin')->with('success', 'Project updated successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $projectModel->errors());
        }
    }

    public function delete($id)
    {
        $projectModel = new Project();
        $projectModel->delete($id);

        return redirect()->to('/admin')->with('success', 'Project deleted successfully');
    }

    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        $projectModel = new Project();
        $taskModel = new Task();
        if ($keyword) {
            $projects = $projectModel->like('title', $keyword)->orLike('company', $keyword)->findAll();
        } else {
            $projects = $projectModel->findAll();
        }
        foreach ($projects as &$project) {
            // Fetch tasks for the current project
            $project['tasks'] = $taskModel->getTasksByProject($project['project_id']);

            // Get the count of all tasks for the current project
            $project['task_count'] = count($project['tasks']);

            // Get the count of finished tasks for the current project
            $project['finished_task_count'] = $taskModel->getFinishedTaskCount($project['project_id']);
        }


        return view('admin/index', ['projects' => $projects]);
    }
    public function view($id)
    {
        $projectModel = new Project();
        $taskModel = new Task();
        $userModel = new User();
        $users = $userModel->findAll();

        $project = $projectModel->find($id);
        if (!$project) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Project not found');
        }

        $tasks = $taskModel->getTasksByProject($id);

        $data = [
            'project' => $project,
            'tasks' => $tasks,
            'users' => $users,
        ];

        return view('admin/tasks', $data);
    }
}
