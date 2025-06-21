<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2><i class="bi bi-bookmark-plus-fill"></i> Add Course</h2>

<form action="<?= base_url('/courses/store') ?>" method="post" class="mt-3">
  <?= csrf_field() ?>
  <div class="mb-3">
    <label class="form-label"><i class="bi bi-journal-text"></i> Course Name</label>
    <input type="text" name="name" class="form-control" placeholder="Enter course name" required>
  </div>

  <div class="mb-3">
    <label class="form-label"><i class="bi bi-card-text"></i> Description</label>
    <textarea name="description" class="form-control" rows="4" placeholder="Enter course description" required></textarea>
  </div>

  <button class="btn btn-success">
    <i class="bi bi-check-circle"></i> Save
  </button>
  <a href="<?= base_url('/courses') ?>" class="btn btn-secondary">
    <i class="bi bi-arrow-left-circle"></i> Cancel
  </a>
</form>

<?= $this->endSection() ?>
