<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900">Change password for</h1>
                                    <h5 class="mb-3"><?= $this->session->userdata('reset_email');  ?></h5>

                                    <!-- Alert -->

                                    <?php if ($this->session->flashdata('unknownEmail')) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <p><strong>The email <?= $this->session->flashdata('unknownEmail'); ?> in our server!</strong></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($this->session->flashdata('isNotActive')) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <p><strong>The email is not <?= $this->session->flashdata('isNotActive'); ?></strong></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($this->session->flashdata('successRecover')) : ?>
                                        <div class="alert alert-success" role="alert">
                                            <p><strong><?= $this->session->flashdata('successRecover'); ?></strong></p>
                                        </div>
                                    <?php endif; ?>
                                    <!-- end alert  -->
                                </div>

                                <!-- Form -->
                                <form action="<?= base_url('auth/changepassword');  ?>" method="post" class="user">
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Enter New Password">
                                        <?= form_error('password1', '<small class="text-danger ml-3">', "</small>"); ?>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Re-Enter New Password">
                                        <?= form_error('password2', '<small class="text-danger ml-3">', "</small>"); ?>
                                    </div>

                                    <button type="submit" class="btn tombolLogin btn-user btn-block">
                                        Reset Password
                                    </button>
                                </form>
                                <!-- end Form -->
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>