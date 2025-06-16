<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4><i class="fas fa-upload"></i> Upload File</h4>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (isset($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <?= esc($error) ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="/files/store" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="userfile" class="form-label">Select File</label>
                    <input class="form-control" type="file" id="userfile" name="userfile" required>
                    <div class="form-text">
                        Allowed types: JPG, PNG, PDF, DOC, DOCX (Max 5MB or 1024KB)
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="/files" class="btn btn-secondary me-md-2">
                        <i class="fas fa-arrow-left"></i> Back to Files
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload File
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>