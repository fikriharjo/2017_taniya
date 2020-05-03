<header class="main-header">

    <a href="<?php echo base_url(); ?>" class="logo">
        <span class="logo-mini"><b>GCG</b></span>
        <span class="logo-lg">GCG<small>Document</small></span>
    </a>

    <nav class="navbar navbar-static-top">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">


                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo base_url('assets/foto/') . $user['image']; ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo $user["name"]; ?></span>
                    </a>
                    <ul class="dropdown-menu">

                        <li class="user-header">
                            <img src="<?php echo base_url('assets/foto/') . $user['image']; ?>" class="img-circle" alt="User Image">
                            <p>
                                <strong><?php echo $user["name"]; ?></strong>
                            </p>
                        </li>

                        <li class="user-footer">
                            <div class="pull-left">
                                &nbsp;
                            </div>
                            <div class="text-center">
                                <a href="<?php echo base_url('auth/logout'); ?>" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Logout</a>
                            </div>
                        </li>

                    </ul>
                </li>
            </ul>
        </div>
    </nav>

</header>

<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url('assets/foto/') . $user['image']; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $user['name']; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <?php
        $role_id = $this->session->userdata('role_id');
        $queryMenu = "SELECT `user_menu`.`id`,`menu` 
                  From `user_menu` JOIN `user_access_menu`
                  on `user_menu`.`id`=`user_access_menu`.`menu_id`
                  where `user_access_menu`.`role_id`=$role_id
                  ORDER BY `user_access_menu`.`menu_id` ASC
                ";
        $menu = $this->db->query($queryMenu)->result_array();
        ?>
        <ul class="sidebar-menu" data-widget="tree">
            <?php foreach ($menu as $m) : ?>
                <li class="header"><?php echo $m['menu'] ?></li>
                <?php
                    $menuId = $m['id'];
                    $querySubmenu = "SELECT * 
                      From `user_sub_menu` JOIN `user_menu`
                      on `user_sub_menu`.`menu_id`=`user_menu`.`id`
                      where `user_sub_menu`.`menu_id`=$menuId
                      and `user_sub_menu`.`is_active`=1";
                    $submenu = $this->db->query($querySubmenu)->result_array();
                    ?>
                <?php foreach ($submenu as $sm) : ?>
                    <?php if ($title == $sm['title']) : ?>
                        <li class="active">
                        <?php else : ?>
                        <li>
                        <?php endif; ?>
                        <a href="<?= base_url($sm['url']) ?>">
                            <i class="<?= $sm['icon'] ?>"></i> <span><?php echo $sm['title'] ?></span></a>

                        </span>
                        </a>
                        </li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
        </ul>
    </section>

</aside>
<div class="content-wrapper">