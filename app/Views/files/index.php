<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><?= esc($title) ?></h2>
        <a href="/files/upload" class="btn btn-primary">
            <i class="bi bi-upload"></i> Upload File
        </a>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <?php if($is_admin ?? false): ?>
                        <th>Owner</th>
                    <?php endif; ?>
                    <th>File Name</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Uploaded</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($files)): ?>
                    <tr>
                        <td colspan="<?= ($is_admin ?? false) ? 6 : 5 ?>" class="text-center">No files uploaded yet</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($files as $file): ?>
                        <tr>
                            <?php if($is_admin ?? false): ?>
                                <td>
                                    <?= esc($file['username'] ?? 'User #'.$file['user_id']) ?>
                                    <?php if($file['user_id'] == session('user.id')): ?>
                                        <span class="badge bg-danger">Admin</span>
                                    <?php endif; ?>
                                    <?php if($file['user_id'] !== session('user.id')): ?>
                                        <span class="badge bg-success">Staff</span>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                            <td><?= esc($file['original_name']) ?></td>
                            <td>
                                <?= esc($file['file_type']) ?>
                                <?php if(strpos($file['file_type'], 'image/') === 0): ?>
                                    <i class="bi bi-image text-primary"></i>
                                <?php elseif($file['file_type'] === 'application/pdf'): ?>
                                    <i class="bi bi-file-earmark-pdf text-danger"></i>
                                <?php endif; ?>
                            </td>
                            <td><?= formatSizeUnits($file['file_size'] ?? 0) ?></td>
                            <td><?= date('M d, Y H:i', strtotime($file['created_at'])) ?></td>
                            <td>
                                <?php if (strpos($file['file_type'] ?? '', 'image/') === 0 || $file['file_type'] === 'application/pdf'): ?>
                                    <a href="/files/view/<?= $file['id'] ?>" class="btn btn-sm btn-outline-info me-1" target="_blank" data-bs-toggle="tooltip" title="View File">
                                        <i class="bi bi-eye"></i> 
                                    </a>
                                <?php endif; ?>
                                <a href="/files/download/<?= $file['id'] ?>" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="Download">
                                    <i class="bi bi-download"></i>
                                </a>
                                <?php if(($is_admin ?? false) || $file['user_id'] == session('user.id')): ?>
                                    <a href="/files/delete/<?= $file['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this file?\n<?= esc($file['original_name']) ?>')" data-bs-toggle="tooltip" title="Delete">
                                        <i class="bi bi-trash"></i> 
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<?= $this->endSection() ?>