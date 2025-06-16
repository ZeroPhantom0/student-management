<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h2 class="mb-4 text-center">
        <i class="bi bi-speedometer2"></i> Admin Dashboard
    </h2>

    <div class="row g-4 text-center">
        <div class="col-md-3"> <!-- Changed from col-md-4 to col-md-3 for 4 cards -->
            <div class="card text-white bg-primary shadow h-100">
                <div class="card-body">
                    <i class="bi bi-people-fill display-4 mb-2"></i>
                    <h3><?= $studentCount ?></h3>
                    <p class="mb-0">Students</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow h-100">
                <div class="card-body">
                    <i class="bi bi-journal-bookmark-fill display-4 mb-2"></i>
                    <h3><?= $courseCount ?></h3>
                    <p class="mb-0">Courses</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger shadow h-100">
                <div class="card-body">
                    <i class="bi bi-files display-4 mb-2"></i>
                    <h3><?= $fileCount ?></h3>
                    <p class="mb-0">Files</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow h-100">
                <div class="card-body">
                    <i class="bi bi-clipboard-check display-4 mb-2"></i>
                    <h3><?= $enrollmentCount ?></h3>
                    <p class="mb-0">Enrollments</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>