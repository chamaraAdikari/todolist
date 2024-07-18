<?php $this->extend('admin/layouts/admin_layout'); ?>

<?php $this->section('content'); ?>
<?php if (session()->get('role') == 'Admin'): ?>
<h1 class="text-white">Projects</h1>
<!-- Search Form -->
<form action="/projects/search" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search by title or company" name="keyword">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>

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
                    <a href="/projects/view/<?= esc($project['project_id']) ?>" class="btn btn-outline-primary mt-3">View Project</a>
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

<!-- Add New Project Modal -->
<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectModalLabel">Add New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form to Add New Project -->
                <form action="/projects/add" method="POST">
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
                        <label for="company" class="form-label">Company</label>
                        <input type="text" class="form-control" id="company" name="company" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="started_date" class="form-label">Started Date</label>
                        <input type="date" class="form-control" id="started_date" name="started_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Add Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Button to Trigger Add Project Modal -->
<div class="fixed-bottom mb-4 me-4">
    <button type="button" class="btn btn-success btn-lg float-end" data-bs-toggle="modal"
        data-bs-target="#addProjectModal">
        Add New Project
    </button>
</div>
<?php endif; ?>
<?php $this->endSection(); ?>