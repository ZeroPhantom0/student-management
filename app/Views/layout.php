<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?? 'Student Management System' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .main-content {
      flex: 1;
    }

  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="<?= base_url('/') ?>"><i class="bi bi-mortarboard"></i> SMS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php if (session('isLoggedIn')): ?>
          <!-- Common items for all logged in users -->
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/dashboard') ?>">
              <i class="bi bi-speedometer2"></i> Dashboard
            </a>
          </li>
          
          <!-- Regular user items -->
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/students') ?>">
              <i class="bi bi-people"></i> Students
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/courses') ?>">
              <i class="bi bi-journal-bookmark"></i> Courses
            </a>
          </li>
          
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('/enrollments') ?>">
                <i class="bi bi-ui-checks"></i> My Enrollments
              </a>
            </li>
          
          <!-- Common items -->
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/files') ?>">
              <i class="bi bi-file-earmark"></i> Files
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= site_url('/logout') ?>">
              <i class="bi bi-box-arrow-right"></i> Logout
            </a>
          </li>
        <?php else: ?>
          <!-- Guest items -->
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/login') ?>">
              <i class="bi bi-box-arrow-in-right"></i> Login
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/signup') ?>">
              <i class="bi bi-person-plus"></i> Sign Up
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="d-flex flex-column min-vh-100">

<main class="flex-fill">
    <div class="container mt-4">
      <?= $this->renderSection('content') ?>
    </div>
  </main>

<footer class="bg-dark text-white text-center py-3 mt-4">
  <small>&copy; <?= date('Y') ?> Student Management System</small>
</footer>

</body>
</html>