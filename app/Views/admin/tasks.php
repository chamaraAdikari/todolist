<?php $this->extend('admin/layouts/admin_layout'); ?>

<?php $this->section('content'); ?>
<h1 class="text-white"><?= esc($project['title']) ?> | All tasks</h1>
<!-- Search Form -->
<form action="/tasks/search/<?= esc($project['project_id']) ?>" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search by title or description" name="keyword">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>

<?php foreach ($tasks as $task): ?>
    <?php if (session()->get('role') == 'Admin' || session()->get('user_id') == $task['users_user_id']): ?>
        <div class="col-12 col-md-4 col-lg-2 d-flex justify-content-center mt-2 mb-2">
            <div class="card" style="width: 20rem;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <div alt="UD" style="width: 30px; height: 30px;" class="rounded-circle 
                             <?php if ($task['importance_status'] == 'High') {
                                 echo 'bg-danger';
                             } else if ($task['importance_status'] == 'Medium') {
                                 echo 'bg-warning';
                             } else {
                                 echo 'bg-success';
                             } ?>"></div>
                        </div>
                        <div class="col-10">
                            <h5 class="card-title"><?= esc($task['title']) ?></h5>
                            <p class="card-text"><?= esc($task['description']) ?></p>
                        </div>
                    </div>



                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Importance Status:</strong> <?= esc($task['importance_status']) ?></li>
                    <li class="list-group-item"><strong>Estimated Time:</strong> <?= esc($task['estimated_time']) ?></li>
                    <li class="list-group-item"><strong>Due Date:</strong> <?= esc($task['due_date']) ?></li>
                    <li class="list-group-item"><strong>Status:</strong> <?= esc($task['status']) ?></li>
                </ul>
                <div class="card-body">
                    <?php if (session()->get('role') == 'Admin'): ?>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#editTaskModal<?= $task['task_id'] ?>"><i class="fa fa-pen-to-square"></i> Edit</button>
                        <form action="/tasks/delete/<?= esc($task['task_id']) ?>" method="post" class="d-inline">
                            <input type="hidden" name="redirect" value="<?= current_url() ?>">
                            <button class="btn btn-danger" type="submit"
                                onclick="return confirm('Are you sure you want to delete this task?')"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

        </div>
        <!-- Edit Task Modal -->
        <div class="modal fade" id="editTaskModal<?= $task['task_id'] ?>" tabindex="-1"
            aria-labelledby="editTaskModalLabel<?= $task['task_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTaskModalLabel<?= $task['task_id'] ?>">Edit Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form to Edit Task -->
                        <form action="/tasks/update/<?= $task['task_id'] ?>" method="POST">
                            <?php if (session()->has('errors')): ?>
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                        <?php foreach (session('errors') as $error): ?>
                                            <li><?= esc($error) ?></li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            <?php endif ?>

                            <div class="mb-3">
                                <label for="title<?= $task['task_id'] ?>" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title<?= $task['task_id'] ?>" name="title"
                                    value="<?= esc($task['title']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="description<?= $task['task_id'] ?>" class="form-label">Description</label>
                                <textarea class="form-control" id="description<?= $task['task_id'] ?>" name="description"
                                    rows="3" required><?= esc($task['description']) ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="estimated_time<?= $task['task_id'] ?>" class="form-label">Estimated time</label>
                                <input type="text" class="form-control" id="estimated_time<?= $task['task_id'] ?>"
                                    name="estimated_time" value="<?= esc($task['estimated_time']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="importance_status<?= $task['task_id'] ?>" class="form-label">Importance
                                    status</label>
                                <select class="form-select" name="importance_status">
                                    <?php if (esc($task['importance_status'])) { ?>
                                        <option value="<?= esc($task['importance_status']) ?>">
                                            <?= esc($task['importance_status']) ?>
                                        </option>
                                    <?php } ?>

                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                </select>

                            </div>


                            <div class="mb-3">
                                <label for="due_date<?= $task['task_id'] ?>" class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="due_date<?= $task['task_id'] ?>" name="due_date"
                                    value="<?= esc($task['due_date']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="users_user_id<?= $task['task_id'] ?>" class="form-label">User</label>
                                <select class="form-select" name="users_user_id<?= $task['task_id'] ?>" id="">
                                    <option value="<?= esc($task['users_user_id']) ?>"><?= esc($task['users_user_id']) ?>
                                    </option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= esc($user['user_id']) ?>"><?= esc($user['email']) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Update Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
    endif;
endforeach;
?>

<!-- Add New Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form to Add New Task -->
                <form action="/tasks/add" method="POST">
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif ?>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="estimated_time" class="form-label">Estimated Time</label>
                        <input type="text" class="form-control" id="estimated_time" name="estimated_time" required>
                    </div>

                    <div class="mb-3">
                        <label for="importance_status" class="form-label">Importance Status</label>
                        <select class="form-select" name="importance_status">
                        
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="users_user_id" class="form-label">User</label>
                        <select class="form-select" name="users_user_id" id="">
                            <?php foreach ($users as $user): ?>
                                <option value="<?= esc($user['user_id']) ?>"><?= esc($user['email']) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <input type="hidden" class="form-control" id="projects_project_id" name="projects_project_id"
                            value="<?= esc($project['project_id']) ?>">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Button to Trigger Add Task Modal -->
<div class="fixed-bottom mb-4 me-4">
    <button type="button" class="btn btn-success btn-lg float-end" data-bs-toggle="modal"
        data-bs-target="#addTaskModal">
        <i class="fa fa-plus"></i> Add New Task
    </button>
</div>

<?php $this->endSection(); ?>