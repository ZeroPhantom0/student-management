<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2><i class="bi bi-pencil-square"></i> Edit Course</h2>

<form action="<?= base_url('/courses/update/'.$course['id']) ?>" method="post" class="mt-3">
  <div class="mb-3">
    <label class="form-label"><i class="bi bi-journal-text"></i> Course Name</label>
    <input type="text" name="name" class="form-control" value="<?= esc($course['name']) ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label"><i class="bi bi-card-text"></i> Description</label>
    <textarea name="description" class="form-control" rows="4" required><?= esc($course['description']) ?></textarea>
  </div>

  <button class="btn btn-primary">
    <i class="bi bi-save"></i> Update
  </button>
  <a href="<?= base_url('/courses') ?>" class="btn btn-secondary">
    <i class="bi bi-arrow-left-circle"></i> Cancel
  </a>
</form>

<?= $this->endSection() ?>
