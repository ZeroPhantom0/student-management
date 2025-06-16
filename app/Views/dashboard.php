<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container py-4">
  <h2 class="mb-4 text-center">
    <i class="bi bi-speedometer2"></i> Dashboard
    <?php if(session('user.role') === 'admin'): ?>
      <span class="badge bg-danger ms-2">Admin Mode</span>
    <?php endif; ?>
  </h2>

  <!-- Stats Cards -->
  <div class="row g-4 text-center">
    <div class="col-md-3">
      <div class="card text-white bg-primary shadow h-100">
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
          <i class="bi bi-people-fill display-4 mb-2"></i>
          <h3><?= $studentCount ?></h3>
          <p class="mb-0">Total Students</p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card text-white bg-success shadow h-100">
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
          <i class="bi bi-journal-bookmark-fill display-4 mb-2"></i>
          <h3><?= $courseCount ?></h3>
          <p class="mb-0">Total Courses</p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card text-dark bg-warning shadow h-100">
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
          <i class="bi bi-ui-checks-grid display-4 mb-2"></i>
          <h3><?= $enrollmentCount ?></h3>
          <p class="mb-0">Total Enrollments</p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card text-white bg-secondary shadow h-100">
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
          <i class="bi bi-file-earmark-text-fill display-4 mb-2"></i>
          <h3><?= $userFileCount ?></h3>
          <p class="mb-0">Your Uploaded Files</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Admin-Only Stats -->
  <?php if(session('user.role') === 'admin'): ?>
    <div class="row mt-4 g-4 text-center">
      <div class="col-md-6">
        <div class="card text-white bg-danger shadow h-100">
          <div class="card-body">
            <i class="bi bi-people display-4 mb-2"></i>
            <h3><?= $recentActivity['new_users'] ?></h3>
            <p class="mb-0">New Users (7 days)</p>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card text-white bg-info shadow h-100">
          <div class="card-body">
            <i class="bi bi-activity display-4 mb-2"></i>
            <h3><?= $recentActivity['active_users'] ?></h3>
            <p class="mb-0">Active Users (24h)</p>
            <div class="mt-2 small">
              <div>📁 <?= $recentActivity['file_uploads'] ?> file uploads</div>
              <div>🎓 <?= $recentActivity['new_enrollments'] ?> new enrollments</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Activity Log Table -->
    <div class="mt-4">
      <div class="card shadow">
        <div class="card-header bg-dark text-white">
          <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recent Activity Log</h5>
        </div>
        <div class="card-body">
          <?php if (!empty($activities)): ?>
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>User</th>
                            <th>Activity</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($activities as $activity): ?>
                        <tr>
                            <td><?= date('M j, H:i', strtotime($activity['created_at'])) ?></td>
                            <td><?= $activity['user_name'] ?? 'User #'.$activity['user_id'] ?></td>
                            <td><?= $activity['details'] ?></td>
                            <td><?= $activity['ip_address'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">No recent activity</p>
        <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>