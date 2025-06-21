<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2><i class="bi bi-people-fill"></i> Student List</h2>
  <a href="<?= base_url('/students/create') ?>" class="btn btn-primary">
    <?= csrf_field() ?> 
    <i class="bi bi-plus-circle"></i> Add Student
  </a>
</div>

<table class="table table-striped table-hover">
  <thead class="table-dark">
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Age</th>
      <th class="text-center">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($students as $i => $s): ?>
      <tr>
        <td><?= $i + 1 ?></td>
        <td><?= esc($s['name']) ?></td>
        <td><?= esc($s['age']) ?></td>
        <td class="text-center">
          <a href="<?= base_url('/students/edit/'.$s['id']) ?>" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil-square"></i> Edit
          </a>
          <a href="<?= base_url('/students/delete/'.$s['id']) ?>" onclick="return confirm('Delete this student?')" class="btn btn-danger btn-sm">
            <i class="bi bi-trash"></i> Delete
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?= $this->endSection() ?>
