        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fab fa-strava"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Anvell</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Looping Menu -->
            <?php foreach ($sidemenu as $sideM) : ?>
                <div class="sidebar-heading">
                    <?= $sideM['menu'];  ?>
                </div>

                <!-- Looping Sub Menu -->
                <?php
                $menuId = $sideM['id'];
                $query = "SELECT * FROM user_sub_menu WHERE menu_id = $menuId";
                $sub_menu = $this->db->query($query)->result_array();
                ?>

                <?php foreach ($sub_menu as $subMenu) : ?>
                    <?php if (strpos($titlePage, $subMenu['title']) !== FALSE) : ?>
                        <li class="nav-item active">
                        <?php else : ?>
                        <li class="nav-item">
                        <?php endif; ?>
                        <a class="nav-link pb-0" href="<?= base_url($subMenu['url'])  ?>">
                            <i class="<?= $subMenu['icon'];  ?>"></i>
                            <span><?= $subMenu['title'];  ?></span></a>
                        </li>
                    <?php endforeach; ?>

                    <!-- Divider -->
                    <hr class="sidebar-divider mt-3">

                <?php endforeach; ?>


                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('auth/logout');  ?>">
                        <i class="fas fa-fw fa-sign-out-alt"></i>
                        <span>Logout </span></a>
                </li>



                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

        </ul>
        <!-- End of Sidebar -->