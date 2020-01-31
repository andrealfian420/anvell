                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $titlePage;  ?></h1>

                    <div class="row">
                        <div class="col-lg-7">
                            <h5>Role : <?= $roles['role'];  ?></h5>

                            <?php if ($this->session->flashdata('access')) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Access <strong><?= $this->session->flashdata('access'); ?></strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <!-- start table -->
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Menu</th>
                                        <th scope="col">Access</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($menu as $m) : ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $m['menu']; ?></td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" <?= check_access($roles['id'], $m['id']); ?> data-role="<?= $roles['id']; ?>" data-menu="<?= $m['id']; ?>">
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- end of table -->
                            <a href="<?= base_url('admin/role');  ?>" class="btn btn-primary">Go Back</a>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->