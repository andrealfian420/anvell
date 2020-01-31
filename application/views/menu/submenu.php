                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $titlePage;  ?></h1>

                    <div class="row">
                        <div class="col-lg-10">

                            <?php if (validation_errors()) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong><?= validation_errors(); ?></strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->session->flashdata('addSuccess')) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    New Sub Menu has been <strong><?= $this->session->flashdata('addSuccess'); ?></strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->session->flashdata('deleteSuccess')) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Sub Menu has been <strong><?= $this->session->flashdata('deleteSuccess'); ?></strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <!-- Button trigger modal -->
                            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#menuModal">Add New Sub Menu</a>

                            <table class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Menu</th>
                                        <th scope="col">Url</th>
                                        <th scope="col">Icon</th>
                                        <th scope="col">Active</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($subMenu as $sm) : ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $sm['title']; ?></td>
                                            <td><?= $sm['menu']; ?></td>
                                            <td><?= $sm['url']; ?></td>
                                            <td><?= $sm['icon']; ?></td>
                                            <td><?= $sm['is_active']; ?></td>
                                            <td>
                                                <a href="#" class="badge badge-success">Edit</a>
                                                <a href="<?= base_url('menu/deleteSubMenu');  ?>/<?= $sm['id'];  ?>" class="badge badge-danger btnDelete">Delete</a>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->



                <!-- Modal -->
                <div class="modal fade" id="menuModal" tabindex="-1" role="dialog" aria-labelledby="menuModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="menuModalLabel">Add Sub New Menu</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <!-- Modal Form -->
                            <form action="<?= base_url('menu/submenu');  ?>" method="post">
                                <div class="modal-body">

                                    <div class="form-group">
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title">
                                    </div>

                                    <div class="form-group">
                                        <select name="menu_id" id="menu_id" class="form-control">
                                            <option value="" selected disabled>-Select Menu-</option>
                                            <?php foreach ($menu as $m) : ?>
                                                <option value="<?= $m['id'];  ?>"><?= $m['menu']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" id="url" name="url" placeholder="Submenu url">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon">
                                    </div>

                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" value="1" name="is_active" id="is_active" checked>
                                            <label class="form-check-label" for="is_active">Is active?</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                            <!--End of Modal Form -->

                        </div>
                    </div>
                </div>
                </div>