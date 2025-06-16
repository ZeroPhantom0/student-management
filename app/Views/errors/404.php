<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container py-5">
    <h1>404 - Page Not Found</h1>
    <p>The page you requested was not found.</p>
    <a href="<?= base_url('/') ?>" class="btn btn-primary">Return Home</a>
</div>
<?= $this->endSection() ?>