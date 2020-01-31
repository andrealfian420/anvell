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
                                    <h1 class="h4 text-gray-900 mb-3">Anvell Login</h1>

                                    <!-- Alert -->
                                    <?php if ($this->session->flashdata('loginFirst')) :  ?>
                                        <div class="alert alert-danger" role="alert">
                                            <p><strong><?= $this->session->flashdata('loginFirst'); ?></strong> first!</p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($this->session->flashdata('successRegister')) :  ?>
                                        <div class="alert alert-success" role="alert">
                                            <p><strong><?= $this->session->flashdata('successRegister'); ?></strong> your account has been created!</p>
                                            <p>Now please activate your account first!</p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($this->session->flashdata('failedLogin')) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <p><strong><?= $this->session->flashdata('failedLogin'); ?></strong> The email is not registered in our server!</p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($this->session->flashdata('isNotActive')) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <p><strong><?= $this->session->flashdata('isNotActive'); ?></strong> your email first!</p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($this->session->flashdata('wrongPassword')) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <p><strong><?= $this->session->flashdata('wrongPassword'); ?></strong> The password is incorrect!</p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($this->session->flashdata('logout')) : ?>
                                        <div class="alert alert-success" role="alert">
                                            <p>You have been <strong><?= $this->session->flashdata('logout'); ?></strong></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($this->session->flashdata('failedActivate')) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <p>Activation failed! <strong><?= $this->session->flashdata('failedActivate'); ?></strong></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($this->session->flashdata('successActivate')) : ?>
                                        <div class="alert alert-success" role="alert">
                                            <p><strong><?= $this->session->flashdata('successActivate'); ?> has been activated!</strong></p>
                                            <p>Now please login!</p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($this->session->flashdata('recoveryFailed')) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <p><strong>Failed to recover password! <?= $this->session->flashdata('recoveryFailed'); ?></strong></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($this->session->flashdata('successRecovery')) : ?>
                                        <div class="alert alert-success" role="alert">
                                            <p><strong><?= $this->session->flashdata('successRecovery'); ?></strong></p>
                                        </div>
                                    <?php endif; ?>
                                    <!-- end alert  -->
                                </div>

                                <!-- Form -->
                                <form action="<?= base_url();  ?>" method="post" class="user">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email" name="email" value="<?php echo set_value('email') ?>" placeholder="Enter Email Address...">
                                        <?= form_error('email', '<small class="text-danger ml-3">', "</small>"); ?>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                        <?= form_error('password', '<small class="text-danger ml-3">', "</small>"); ?>
                                    </div>

                                    <button type="submit" class="btn tombolLogin btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <!-- end Form -->

                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/forgotpassword')  ?>">Forgot Password?</a>
                                </div>

                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/registration');  ?>">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>