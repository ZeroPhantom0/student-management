<?= $this->extend('layout') ?>
<?= $this->section('content') ?>


<div class="d-flex justify-content-between align-items-center mb-3">
  <h2><i class="bi bi-people-fill"></i>  Course List</h2>
  <a href="<?= base_url('/courses/create') ?>" class="btn btn-primary">
    <i class="bi bi-plus-circle"></i> Add Course
  </a>
</div>

<div class="table-responsive">
  <table class="table table-bordered table-hover align-middle">
    <thead class="table-dark text-center">
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Description</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($courses as $i => $c): ?>
        <tr>
          <td class="text-center"><?= $i + 1 ?></td>
          <td><?= esc($c['name']) ?></td>
          <td><?= esc($c['description']) ?></td>
          <td class="text-center">
            <a href="<?= base_url('/courses/edit/'.$c['id']) ?>" class="btn btn-warning btn-sm me-1">
              <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="<?= base_url('/courses/delete/'.$c['id']) ?>" onclick="return confirm('Delete this course?')" class="btn btn-danger btn-sm">
              <i class="bi bi-trash-fill"></i> Delete
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
