<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2><i class="bi bi-person-plus-fill"></i> Add Enrollment</h2>

<form action="<?= base_url('/enrollments/store') ?>" method="post" class="mt-3">
  <div class="mb-3">
    <label class="form-label"><i class="bi bi-person"></i> Student</label>
    <select name="student_id" class="form-select" required>
      <option value="">Select Student</option>
      <?php foreach ($students as $s): ?>
        <option value="<?= $s['id'] ?>"><?= esc($s['name']) ?></option>
      <?php endforeach ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label"><i class="bi bi-book"></i> Course</label>
    <select name="course_id" class="form-select" required>
      <option value="">Select Course</option>
      <?php foreach ($courses as $c): ?>
        <option value="<?= $c['id'] ?>"><?= esc($c['name']) ?></option>
      <?php endforeach ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label"><i class="bi bi-award"></i> Grade</label>
    <input type="text" name="grade" class="form-control" placeholder="e.g. A, 90, Pass">
  </div>

  <div class="mb-3">
    <label class="form-label"><i class="bi bi-bar-chart-line"></i> Attendance (%)</label>
    <input type="number" name="attendance" class="form-control" placeholder="0–100">
  </div>

  <div class="mb-3">
    <label class="form-label"><i class="bi bi-calendar-date"></i> Enrollment Date</label>
    <input type="date" name="enrollment_date" class="form-control" required>
  </div>

  <button class="btn btn-success">
    <i class="bi bi-check-circle"></i> Save
  </button>
  <a href="<?= base_url('/enrollments') ?>" class="btn btn-secondary">
    <i class="bi bi-arrow-left-circle"></i> Cancel
  </a>
</form>

<?= $this->endSection() ?>
