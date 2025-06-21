<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2><i class="bi bi-pencil-square"></i> Edit Student</h2>

<form action="<?= base_url('/students/update/'.$student['id']) ?>" method="post">
  <?= csrf_field() ?> 
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?= esc($student['name']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Age</label>
    <input type="number" name="age" class="form-control" value="<?= esc($student['age']) ?>" required>
  </div>
  <button class="btn btn-success">
    <i class="bi bi-check-circle"></i> Update
  </button>
  <a href="<?= base_url('/students') ?>" class="btn btn-secondary">
    <i class="bi bi-arrow-left-circle"></i> Cancel
  </a>
</form>

<?= $this->endSection() ?>
