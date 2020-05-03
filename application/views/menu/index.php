<section class="content-header">
    <h1><?php echo $title ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('admin') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-user"></i> <?= $title ?></a></li>
    </ol>
</section>

<section class="content">
    <?php echo $this->session->flashdata('message'); ?>
    <?php echo form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                <i class="fa fa-plus"> Tambah Data</i>
            </button>
            <hr>
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Menu</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0;
                    foreach ($menu as $m) : $no++; ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $m['menu'] ?></td>
                            <td align="center">
                                <a href="<?php echo base_url('menu/edit_menu/') . $m['id'] ?>" class="btn btn-warning" title="edit"><i class="fa fa-edit"></i></a>
                                <a href="<?php echo base_url('menu/deleteData/') . $m['id'] ?>" class="btn btn-danger" title="delete"><i class="fa fa-trash"></i></a>
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
<div class="modal fade in" id="modal-default" style="display:  padding-right: 17px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Data Menu</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('menu') ?>" method="POST">
                    <div class="form-group">
                        <label>Menu</label>
                        <input type="text" name="menu" class="form-control" placeholder='-- Masukan menu --'>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>