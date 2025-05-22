<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2><i class="bi bi-person-plus-fill"></i> Add Student</h2>

<form action="<?= base_url('/students/store') ?>" method="post">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Age</label>
    <input type="number" name="age" class="form-control" required>
  </div>
  <button class="btn btn-success">
    <i class="bi bi-check-circle"></i> Save
  </button>
  <a href="<?= base_url('/students') ?>" class="btn btn-secondary">
    <i class="bi bi-arrow-left-circle"></i> Cancel
  </a>
</form>

<?= $this->endSection() ?>
