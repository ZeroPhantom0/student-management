<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2><i class="bi bi-pencil-square"></i> Edit Enrollment</h2>

<form action="<?= base_url('/enrollments/update/' . $enrollment['id']) ?>" method="post" class="mt-3">
  <?= csrf_field() ?>

  <div class="mb-3">
    <label class="form-label"><i class="bi bi-person"></i> Student</label>
    <select name="student_id" class="form-select" required>
      <option value="">Select Student</option>
      <?php foreach ($students as $s): ?>
        <option value="<?= $s['id'] ?>" <?= $s['id'] == $enrollment['student_id'] ? 'selected' : '' ?>>
          <?= esc($s['name']) ?>
        </option>
      <?php endforeach ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label"><i class="bi bi-book"></i> Course</label>
    <select name="course_id" class="form-select" required>
      <option value="">Select Course</option>
      <?php foreach ($courses as $c): ?>
        <option value="<?= $c['id'] ?>" <?= $c['id'] == $enrollment['course_id'] ? 'selected' : '' ?>>
          <?= esc($c['name']) ?>
        </option>
      <?php endforeach ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label"><i class="bi bi-award"></i> Grade</label>
    <input type="text" name="grade" class="form-control" value="<?= esc($enrollment['grade']) ?>" placeholder="e.g. A, 90, Pass">
  </div>

  <div class="mb-3">
    <label class="form-label"><i class="bi bi-bar-chart-line"></i> Attendance (%)</label>
    <input type="number" name="attendance" class="form-control" value="<?= esc($enrollment['attendance']) ?>" placeholder="0–100">
  </div>

  <div class="mb-3">
    <label class="form-label"><i class="bi bi-calendar-date"></i> Enrollment Date</label>
    <input type="date" name="enrollment_date" class="form-control" value="<?= esc($enrollment['enrollment_date']) ?>" required>
  </div>

  <button type="submit" class="btn btn-primary">
    <i class="bi bi-save"></i> Update
  </button>
  <a href="<?= base_url('/enrollments') ?>" class="btn btn-secondary">
    <i class="bi bi-arrow-left-circle"></i> Cancel
  </a>
</form>

<?= $this->endSection() ?>
