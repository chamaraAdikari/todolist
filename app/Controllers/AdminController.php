<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Project;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\User;
use App\Models\Task;

class AdminController extends BaseController
{
    public function index()
    {
        $projectModel = new Project();
        $projects = $projectModel->findAll(); // Fetch all users
        $taskModel = new Task();

        foreach ($projects as &$project) {
            // Fetch tasks for the current project
            $project['tasks'] = $taskModel->getTasksByProject($project['project_id']);

            // Get the count of all tasks for the current project
            $project['task_count'] = count($project['tasks']);

            // Get the count of finished tasks for the current project
            $project['finished_task_count'] = $taskModel->getFinishedTaskCount($project['project_id']);
        }

        // Pass $projects array to the view
        return view('admin/index', ['projects' => $projects]);
    }
    public function viewAllTasksOfUser()
    {
        $userId = session()->get('user_id');
        $item = new Task();
        $items = $item->where('users_user_id', $userId)->findAll();
        return view('front/index', ['tasks' => $items]);

    }
    public function viewAllUsers()
    {
        $userModel = new User();
        $users = $userModel->findAll(); // Fetch all users
        return view('admin/users', ['users' => $users]);
    }
    public function search()
{
    $keyword = $this->request->getGet('keyword');
    $projectModel = new Project();
    $userModel = new User();
    $taskModel = new Task();

    $projects = [];
    $users = [];
    $tasks = [];

    if ($keyword) {
        // Search Projects
        $projects = $projectModel->like('title', $keyword)
                                 ->orLike('company', $keyword)
                                 ->findAll();
        foreach ($projects as &$project) {
            // Fetch tasks for the current project
            $project['tasks'] = $taskModel->getTasksByProject($project['project_id']);

            // Get the count of all tasks for the current project
            $project['task_count'] = count($project['tasks']);

            // Get the count of finished tasks for the current project
            $project['finished_task_count'] = $taskModel->getFinishedTaskCount($project['project_id']);
        }

        // Search Users
        $users = $userModel->like('username', $keyword)
                           ->orLike('email', $keyword)
                           ->findAll();

        // Search Tasks
        $tasks = $taskModel->groupStart()
                           ->like('title', $keyword)
                           ->orLike('description', $keyword)
                           ->groupEnd()
                           ->findAll();
    }

    return view('admin/search_results', [
        'projects' => $projects,
        'users' => $users,
        'tasks' => $tasks,
        'keyword' => $keyword
    ]);
}

}
