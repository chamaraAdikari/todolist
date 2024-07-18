<?php $this->extend('admin/layouts/admin_layout'); ?>

<?php $this->section('content'); ?>
<?php if (session()->get('role') == 'Admin'): ?>
<h1 class="text-white" >Usres</h1>

<!-- Search Form -->
<form action="/users/search/" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search by username or email" name="keyword">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>

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
                <input type="text" class="form-control" name="email" value="<?= esc($user['email']) ?>" required>
              </div>

              <div class="mb-3">
                <label for="username<?= $user['user_id'] ?>" class="form-label">Username</label>
                <textarea class="form-control" name="username" rows="3" required><?= esc($user['username']) ?></textarea>
              </div>

              <div class="mb-3">
                <label for="password<?= $user['user_id'] ?>" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" value="">
              </div>


              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Update User</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach ?>
  </tbody>
</table>


<!-- Add New User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form to Add New User -->
        <form action="/users/add" method="POST">
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
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="text" class="form-control" id="password" name="password" required>
          </div>

          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Add User</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Button to Trigger Add User Modal -->
<div class="fixed-bottom mb-4 me-4">
  <button type="button" class="btn btn-success btn-lg float-end" data-bs-toggle="modal" data-bs-target="#addUserModal">
    Add New User
  </button>
</div>
<?php endif; ?>


<?php $this->endSection(); ?>