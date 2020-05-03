<section class="content-header">
    <h1><?php echo $title ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('admin') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-user"></i> <?= $title ?></a></li>
    </ol>
</section>

<section class="content">
    <?php echo form_error('nama_kegiatan', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?php echo form_error('jenis_kegiatan', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?php echo $this->session->flashdata('message'); ?>
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
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0;
                    foreach ($result as $row) {
                        $no++; ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $row->name ?></td>
                            <td><?= $row->email ?></td>
                            <td><?= $row->role_id ?></td>
                            <td align="center">
                                <a data-id="<?= $row->id_user ?>" data-name="<?= $row->name ?>" data-email="<?= $row->email ?>" data-toggle="modal" data-target="#modal-edit" href="#" class="btn btn-warning btn-sm" title="edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a class="btn btn-danger btn-sm" title="hapus"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<div class="modal fade in" id="modal-default" style="display:  padding-right: 17px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Tambah User</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="<?= base_url('user/tambah_user') ?>" method="POST" enctype="multipart/form-data">
                <!-- <form action="<?php echo base_url('user/tambah_user') ?>" method="POST"> -->
                    <div class="form-group col-md-12">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder='-- Masukan username --'>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Nama</label>
                        <input type="text" name="nama_user" class="form-control" placeholder='-- Masukan nama user --'>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" placeholder='-- Masukan email --'>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder='-- Masukan password --'>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Role</label>
                        <select name="role" class="form-control">
                            <option disabled selected>-- Pilih role --</option>
                            <option value='1'>1</option>
                            <option value='2'>2</option>
                            <option value='3'>3</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Foto</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-default pull-left " data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade in" id="modal-edit" style="display:  padding-right: 17px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Edit User </span></h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= base_url('user/edit_user') ?>">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="name" id='name'>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" id="email">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Simpan</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    $(function() {
        $('#example1').DataTable()
        $('#example2').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false
        })
    });
    $(document).on('click', '.btn-warning', function() {
        var id      = $(this).attr('data-id'),
            name    = $(this).attr('data-name'),
            email   = $(this).attr('data-email');
        $('#id').val(id);
        $('#name').val(name);
        $('#email').val(email);
    })
</script>