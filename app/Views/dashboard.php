<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container py-4">
  <h2 class="mb-4 text-center">
    <i class="bi bi-speedometer2"></i> Dashboard
    <?php if(session('user.role') === 'admin'): ?>
      <span class="badge bg-danger ms-2">Admin Mode</span>
    <?php endif; ?>
    <?php if(session('user.role') !== 'admin'): ?>
      <span class="badge bg-success ms-2">Staff Mode</span>
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
    <!-- Inside your "Recent Activity Log" section -->
<div class="mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recent Activity Log</h5>
            <button id="refresh-activities" class="btn btn-sm btn-light">
                <i class="bi bi-arrow-clockwise"></i> Refresh
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover" id="activity-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Activity</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody id="activity-body">
                        <!-- Activities will be loaded here via JavaScript -->
                    </tbody>
                </table>
            </div>
            <small class="text-muted" id="last-updated">Last updated: <?= date('h:i:s A') ?></small>
        </div>
    </div>
</div>

<!-- Add this JavaScript at the bottom of the file -->
<script>
// Function to fetch and update activities
function updateActivities() {
    // Show loading state
    const activityBody = document.getElementById('activity-body');
    activityBody.innerHTML = `
        <tr>
            <td colspan="5" class="text-center py-3">
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                Loading activities...
            </td>
        </tr>
    `;

    fetch('/api/activities/recent', {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '<?= csrf_token() ?>'
        },
        credentials: 'same-origin' // Include cookies for session
    })
    .then(response => {
        // First check if response is OK
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        // Then verify content type is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error("Response wasn't JSON");
        }
        
        return response.json();
    })
    .then(data => {
        // Clear loading state
        activityBody.innerHTML = '';

        if (data.status === 'success' && data.data && data.data.length) {
            data.data.forEach(activity => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${new Date(activity.created_at).toLocaleString()}</td>
                    <td>${activity.user_name || 'User #'+activity.user_id}</td>
                    <td><span class="badge ${getRoleBadgeClass(activity.user_role)}">${activity.user_role || 'Unknown'}</span></td>
                    <td>${activity.details}</td>
                    <td><small class="text-muted">${activity.ip_address}</small></td>
                `;
                activityBody.appendChild(row);
            });
        } else {
            activityBody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-muted text-center py-3">
                        <i class="bi bi-info-circle"></i> No recent activities found
                    </td>
                </tr>
            `;
        }
        
        // Update last updated time
        document.getElementById('last-updated').textContent = 
            'Last updated: ' + new Date().toLocaleTimeString();
    })
    .catch(error => {
        console.error('Error:', error);
        const errorMessage = error.message.includes('JSON') 
            ? 'Invalid response format from server' 
            : error.message;
        
        activityBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-danger text-center py-3">
                    <i class="bi bi-exclamation-triangle-fill"></i> 
                    Error loading activities: ${errorMessage}
                    <div class="small">Please try again or check console for details</div>
                </td>
            </tr>
        `;
    });
}

// Helper function to get badge class based on role
function getRoleBadgeClass(role) {
    switch(role) {
        case 'admin': return 'bg-danger';
        case 'staff': return 'bg-success';
        default: return 'bg-secondary';
    }
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Load activities immediately
    updateActivities();
    
    // Set up refresh button
    document.getElementById('refresh-activities').addEventListener('click', function(e) {
        e.preventDefault();
        updateActivities();
    });
    
    // Optional: Auto-refresh every 30 seconds
    // setInterval(updateActivities, 30000);
});
</script>

<?php endif; ?>

<?= $this->endSection() ?>