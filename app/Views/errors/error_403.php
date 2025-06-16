<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-1 text-danger">403</h1>
            <h2>Access Denied</h2>
            <p class="lead">You don't have permission to access this page.</p>
            <a href="/dashboard" class="btn btn-primary">Return to Dashboard</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>