<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center mt-5">
  <div class="col-md-6 col-lg-5">
    <div class="card shadow">
      <div class="card-body">
        <h3 class="mb-4 text-center"><i class="bi bi-person-plus-fill"></i> Sign Up</h3>

        <?php if(session()->getFlashdata('error')): ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('success')): ?>
          <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('/signup') ?>" method="post">
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-person-fill"></i> Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
          </div>

          <div class="mb-3">
            <label class="form-label"><i class="bi bi-envelope-fill"></i> Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
          </div>

          <div class="mb-3">
            <label class="form-label"><i class="bi bi-lock-fill"></i> Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
          </div>

          <div class="d-grid">
            <button class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Register</button>
          </div>

          <p class="mt-3 text-center">
            Already have an account? <a href="<?= base_url('/login') ?>">Login here</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
