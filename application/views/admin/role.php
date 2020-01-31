                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $titlePage;  ?></h1>

                    <div class="row">
                        <div class="col-lg-7">


                            <!-- Button trigger modal -->
                            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#roleModal">Add New Role</a>

                            <table class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($roles as $role) : ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $role['role']; ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/roleAccess/') . $role['id'];  ?>" class="badge badge-warning btnDelete">Access</a>
                                                <a href="#" class="badge badge-success">Edit</a>
                                                <a href="<?= base_url('menu/delete');  ?>/<?= $role['id'];  ?>" class="badge badge-danger btnDelete">Delete</a>
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
                <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="roleModalLabel">Add New Role</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('admin/role');  ?>" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="role" name="role" placeholder="Role name">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
                </div>