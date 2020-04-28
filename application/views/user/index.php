<section class="content-header">
    <h1><?php echo $title ?></h1>
    <ol class="breadcrumb">
        <?php if ($user['role_id'] == 2) : ?>
            <li>
                <a href="<?= base_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a>
            </li>
        <?php else : ?>
            <li><a href="<?= base_url('admin') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
        <?php endif; ?>
        <li class="active"><i class="fa fa-user"></i> <?= $title ?></a></li>
    </ol>
</section>
<section class="content">
    <section class="content">

        <div class="row">
            <?php echo $this->session->flashdata('message') ?>
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?= base_url('assets/plugins/lte/dist/img/') . $user['image'] ?>" alt="User profile picture">

                        <h3 class="profile-username text-center"><?php echo $user['name'] ?></h3>

                        <p class="text-muted text-center"><?= $role['role'] ?></p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Followers</b> <a class="pull-right">1,173</a>
                            </li>
                            <li class="list-group-item">
                                <b>Following</b> <a class="pull-right">734</a>
                            </li>
                            <li class="list-group-item">
                                <b>Posting</b> <a class="pull-right">62</a>
                            </li>
                        </ul>

                        <a href="https://www.instagram.com/rizalgumelar/?hl=id" class="btn btn-primary btn-block"><b>Follow</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- About Me Box -->
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Settings</a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- /.tab-pane -->
                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal" action="<?= base_url('user/edit') ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" name="email" class="form-control" id="inputEmail" value="<?= $user['email'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" name="name" class="form-control" id="inputName" value="<?= $user['name'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-2">

                                    </div>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <img src="<?php echo base_url('assets/plugins/lte/dist/img/') . $user['image'] ?>" class="img-thumbnail">
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" id="image" name="image">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
</section>