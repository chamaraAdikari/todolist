<?php $this->extend('admin/layouts/admin_layout'); ?>

<?php $this->section('content'); ?>
<h1 class="text-white">My All tasks</h1>
<!-- Search Form -->
<form action="/tasks/search" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search by title or description" name="keyword">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>


<?php foreach ($tasks as $task): ?>
    <?php if (session()->get('role') == 'Admin' || session()->get('user_id') == $task['users_user_id']) : ?>
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
                <li class="list-group-item">Importance Status:</strong> <?= esc($task['importance_status']) ?></li>
                <li class="list-group-item">Estimated Time:</strong> <?= esc($task['estimated_time']) ?></li>
                <li class="list-group-item">due date : <?= esc($task['due_date']) ?></li>
                <li class="list-group-item"><?= esc($task['status']) ?></li>
            </ul>
            <div class="card-body">

                <?php if (session()->get('role') == 'User'): ?>
                    <form action="/tasks/start/<?= esc($task['task_id']) ?>" method="post" class="d-inline">
                        <button class="btn btn-success" type="submit" <?= $task['status'] == 'started' ? 'disabled' : '' ?>>Start</button>
                    </form>
                    <form action="/tasks/finish/<?= esc($task['task_id']) ?>" method="post" class="d-inline">
                        <button class="btn btn-danger" type="submit" <?= $task['status'] == 'finished' ? 'disabled' : '' ?>>Finish</button>
                    </form>
                <?php endif; ?>

                
            </div>
        </div>
    </div>
    

<?php 
endif;
endforeach; 
?>





<?php $this->endSection(); ?>