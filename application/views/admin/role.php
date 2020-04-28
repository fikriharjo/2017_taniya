<section class="content-header">
    <h1><?php echo $title ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('admin') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-user"></i> <?= $title ?></a></li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $subtitle ?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Access</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0;
                    foreach ($role as $r) : $no++; ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $r['role'] ?></td>
                            <td align="center">
                                <a href="<?php echo base_url('admin/roleAccess/') . $r['id'] ?>" class="btn btn-success" title="access"><i class="fa fa-sign-in"></i></a>
                                <a href="<?php echo base_url('') . $r['id'] ?>" class="btn btn-warning" title="edit"><i class="fa fa-edit"></i></a>
                                <a href="<?php echo base_url('') . $r['id'] ?>" class="btn btn-danger" title="delete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
</section>