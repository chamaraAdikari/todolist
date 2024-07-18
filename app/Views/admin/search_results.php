<?php $this->extend('admin/layouts/admin_layout'); ?>

<?php $this->section('content'); ?>

<h1 class="text-white">Search Results for "<?= esc($keyword) ?>"</h1>

<h2>Projects</h2>
<?php if (count($projects) > 0): ?>
    <div class="row d-flex justify-content-center">
        <?php foreach ($projects as $project) { ?>
            <div class="card text-center mx-1 mt-1 mb-1" style="width: 18rem;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center ">
                            <div class="me-2 col-4">
                                <img src="https://via.placeholder.com/40" alt="UD" class="rounded-circle">
                            </div>
                            <div class="col-8">
                                <h6 class="card-subtitle mb-0"><?= esc($project['title']) ?></h6>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-around">
                        <div class="badge bg-success"> <span class="mt-1">ongoing</span> </div>
                        <p class="card-text text-muted mb-1">due date
                            <?= esc($project['due_date']) ?>
                    </div>
                    <h5 class="card-title mt-3"><?= esc($project['company']) ?></h5>
                    <p class="card-text"><?= esc($project['description']) ?></p>
                    <hr>
                    <div class="row d-flex justify-content-around align-content-center mb-3 inner-part">
                        <p class="card-text mt-1">Tasks <span
                                class="text-danger mx-1"><?= esc($project['finished_task_count']); ?></span>/<?= esc($project['task_count']); ?>
                        </p>
                        <div>
                            <a href="/projects/view/<?= esc($project['project_id']) ?>"
                                class="btn btn-outline-primary mt-3">View Project</a>
                            <!-- <a href="/tasks" class="btn btn-outline-primary mt-3">View Project</a> -->
                            <button type="button" class="btn btn-outline-secondary mt-3" data-bs-toggle="modal"
                                data-bs-target="#editProjectModal<?= $project['project_id'] ?>">Edit</button>
                            <a href="/projects/delete/<?= esc($project['project_id']) ?>" class="btn btn-outline-danger mt-3"
                                onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Project Modal -->
            <div class="modal fade" id="editProjectModal<?= $project['project_id'] ?>" tabindex="-1"
                aria-labelledby="editProjectModalLabel<?= $project['project_id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProjectModalLabel<?= $project['project_id'] ?>">Edit Project</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form to Edit Project -->
                            <form action="/projects/update/<?= $project['project_id'] ?>" method="POST">
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
                                    <label for="title<?= $project['project_id'] ?>" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title<?= $project['project_id'] ?>" name="title"
                                        value="<?= esc($project['title']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="company<?= $project['project_id'] ?>" class="form-label">Company</label>
                                    <input type="text" class="form-control" id="company<?= $project['project_id'] ?>"
                                        name="company" value="<?= esc($project['company']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description<?= $project['project_id'] ?>" class="form-label">Description</label>
                                    <textarea class="form-control" id="description<?= $project['project_id'] ?>"
                                        name="description" rows="3" required><?= esc($project['description']) ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="started_date<?= $project['project_id'] ?>" class="form-label">Started
                                        Date</label>
                                    <input type="date" class="form-control" id="started_date<?= $project['project_id'] ?>"
                                        name="started_date" value="<?= esc($project['started_date']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="due_date<?= $project['project_id'] ?>" class="form-label">Due Date</label>
                                    <input type="date" class="form-control" id="due_date<?= $project['project_id'] ?>"
                                        name="due_date" value="<?= esc($project['due_date']) ?>" required>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Update Project</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php else: ?>
    <p>No projects found.</p>
<?php endif; ?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Email</th>
            <th scope="col">User name</th>
            <th scope="col">workload</th>
            <th scope="col">Option</th>
        </tr>
    </thead>
    <tbody></tbody>


    <h2>Users</h2>
    <?php foreach ($users as $user): ?>
        <tr class="<?php
        if ($user['workload'] < 3) {
            echo 'table-success'; // Green
        } elseif ($user['workload'] < 6) {
            echo 'table-warning'; // Yellow
        } else {
            echo 'table-danger'; // Red
        }
        ?>">>
            <th scope="row">1</th>
            <td><?= esc($user['email']) ?></td>
            <td><?= esc($user['username']) ?></td>
            <td><?= esc($user['workload']) ?></td>
            <td>
                <form action="/users/delete/<?= esc($user['user_id']) ?>" method="post" class="d-inline">
                    <input type="hidden" name="redirect" value="<?= current_url() ?>">
                    <button class="btn btn-danger" type="submit"
                        onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                </form>
                <button type="button" class="btn btn-secondary " data-bs-toggle="modal"
                    data-bs-target="#editTaskModal<?= $user['user_id'] ?>">Edit</button>
            </td>
        </tr>
        <!-- Edit Task Modal -->
        <div class="modal fade" id="editTaskModal<?= $user['user_id'] ?>" tabindex="-1"
            aria-labelledby="editTaskModalLabel<?= $user['user_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTaskModalLabel<?= $user['user_id'] ?>">Edit Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form to Edit Task -->
                        <form action="/users/update/<?= $user['user_id'] ?>" method="POST">
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
                                <label for="email<?= $user['user_id'] ?>" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" value="<?= esc($user['email']) ?>"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="username<?= $user['user_id'] ?>" class="form-label">Username</label>
                                <textarea class="form-control" name="username" rows="3"
                                    required><?= esc($user['username']) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="password<?= $user['user_id'] ?>" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" value="">
                            </div>


                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Update Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    </tbody>
</table>
<h2>Tasks</h2>
<?php if (count($tasks) > 0): ?>
    <?php foreach ($tasks as $task): ?>

        <div class="col-12 col-md-4 col-lg-2 d-flex justify-content-center mt-2 mb-2">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?= esc($task['title']) ?></h5>
                    <p class="card-text"><?= esc($task['description']) ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Importance Status:</strong> <?= esc($task['importance_status']) ?></li>
                    <li class="list-group-item">Estimated Time:</strong> <?= esc($task['estimated_time']) ?></li>
                    <li class="list-group-item">due date : <?= esc($task['due_date']) ?></li>
                    <li class="list-group-item"><?= esc($task['status']) ?></li>
                </ul>
                <div class="card-body">
                    <form action="/tasks/start/<?= esc($task['task_id']) ?>" method="post" class="d-inline">
                        <button class="btn btn-success" type="submit" <?= $task['status'] == 'started' ? 'disabled' : '' ?>>Start</button>
                    </form>
                    <form action="/tasks/finish/<?= esc($task['task_id']) ?>" method="post" class="d-inline">
                        <button class="btn btn-danger" type="submit" <?= $task['status'] == 'finished' ? 'disabled' : '' ?>>Finish</button>
                    </form>
                    <button type="button" class="btn btn-secondary " data-bs-toggle="modal"
                        data-bs-target="#editTaskModal<?= $task['task_id'] ?>">Edit</button>
                    <form action="/tasks/delete/<?= esc($task['task_id']) ?>" method="post" class="d-inline">
                        <input type="hidden" name="redirect" value="<?= current_url() ?>">
                        <button class="btn btn-danger" type="submit"
                            onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                    </form>

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
                                <input type="text" class="form-control" id="importance_status<?= $task['task_id'] ?>"
                                    name="importance_status" value="<?= esc($task['importance_status']) ?>" required>
                            </div>


                            <div class="mb-3">
                                <label for="due_date<?= $task['task_id'] ?>" class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="due_date<?= $task['task_id'] ?>" name="due_date"
                                    value="<?= esc($task['due_date']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="users_user_id<?= $task['task_id'] ?>" class="form-label">User</label>
                                <select name="users_user_id<?= $task['task_id'] ?>" id="">
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
    <?php endforeach; ?>
<?php else: ?>
    <p>No tasks found.</p>
<?php endif; ?>

<?php $this->endSection(); ?>