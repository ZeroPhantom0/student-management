<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container py-4">
  <h2 class="mb-4 text-center"><i class="bi bi-speedometer2"></i> Dashboard</h2>

  <div class="row g-4 text-center">
    <div class="col-md-4">
      <div class="card text-white bg-primary shadow h-100">
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
          <i class="bi bi-people-fill display-4 mb-2"></i>
          <h3><?= $studentCount ?></h3>
          <p class="mb-0">Total Students</p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-white bg-success shadow h-100">
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
          <i class="bi bi-journal-bookmark-fill display-4 mb-2"></i>
          <h3><?= $courseCount ?></h3>
          <p class="mb-0">Total Courses</p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-dark bg-warning shadow h-100">
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
          <i class="bi bi-ui-checks-grid display-4 mb-2"></i>
          <h3><?= $enrollmentCount ?></h3>
          <p class="mb-0">Total Enrollments</p>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
