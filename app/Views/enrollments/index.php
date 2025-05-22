<?= $this->extend('layout') ?>
<?= $this->section('content') ?>


<div class="d-flex justify-content-between align-items-center mb-3">
  <h2><i class="bi bi-people-fill"></i> Enrollments</h2>
  <a href="<?= base_url('/enrollments/create') ?>" class="btn btn-primary">
    <i class="bi bi-plus-circle"></i> Add Enrollment
  </a>
</div>
<div class="table-responsive">
  <table class="table table-bordered table-hover align-middle">
    <thead class="table-dark text-center">
      <tr>
        <th>#</th>
        <th>Student</th>
        <th>Course</th>
        <th>Grade</th>  
        <th>Attendance</th>
        <th>Enrollment Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($enrollments as $i => $e): ?>
        <tr>
          <td class="text-center"><?= $i + 1 ?></td>
          <td><?= esc($e['student_name']) ?></td>
          <td><?= esc($e['course_name']) ?></td>
          <td class="text-center"><?= esc($e['grade']) ?></td>
          <td class="text-center"><?= esc($e['attendance']) ?>%</td>
          <td class="text-center"><?= esc($e['enrollment_date']) ?></td>
          <td class="text-center">
            <a href="<?= base_url('/enrollments/edit/'.$e['id']) ?>" class="btn btn-warning btn-sm me-1">
              <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="<?= base_url('/enrollments/delete/'.$e['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this enrollment?')">
              <i class="bi bi-trash-fill"></i> Delete
            </a>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
