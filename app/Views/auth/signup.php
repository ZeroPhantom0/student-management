<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center mt-5">
  <div class="col-md-6 col-lg-5">
    <div class="card shadow">
      <div class="card-body">
        <h3 class="mb-4 text-center"><i class="bi bi-person-plus-fill"></i> Sign Up</h3>

        <!-- Flash messages -->
        <?php if(session()->getFlashdata('error')): ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('success')): ?>
          <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <!-- Validation errors -->
        <?php $validation = session()->getFlashdata('validation'); ?>
        <?php if(is_object($validation)): ?>
          <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
          </div>
        <?php endif; ?>

        <form action="<?= base_url('/signup') ?>" method="post">
          <?= csrf_field() ?>
          
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-person-fill"></i> Name</label>
            <input type="text" name="name" class="form-control" value="<?= old('name') ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label"><i class="bi bi-envelope-fill"></i> Email</label>
            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label"><i class="bi bi-lock-fill"></i> Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label"><i class="bi bi-lock-fill"></i> Confirm Password</label>
            <input type="password" name="password_confirm" class="form-control" required>
          </div>
          
          <div class="d-grid">
            <button type="submit" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Register</button>
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
