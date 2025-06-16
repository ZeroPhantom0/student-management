<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

<div class="row justify-content-center mt-5">
  <div class="col-md-6 col-lg-5">
    <div class="card shadow">
      <div class="card-body">
        <h3 class="mb-4 text-center"><i class="bi bi-box-arrow-in-right"></i> Login</h3>

        <?php if(session()->getFlashdata('error')): ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('/login') ?>" method="post">
          <?= csrf_field() ?> <!-- Add this line -->
          
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-envelope-fill"></i> Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
          </div>

          <div class="mb-3">
            <label class="form-label"><i class="bi bi-lock-fill"></i> Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
          </div>

          <div class="d-grid">
            <button class="btn btn-primary">
              <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
          </div>  
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

</body>
</html>