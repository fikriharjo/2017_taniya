<section class="content-header">
    <h1><?php echo $title ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('admin') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-user"></i> <?= $title ?></a></li>
    </ol>
</section>

<section class="content">
    <?php echo form_error('kode_akun', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?php echo form_error('coa', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?php echo form_error('kode_akun', '<div class="alert alert-danger" role="alert">', '</div>') ?>
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
                        <th>Kode Akun</th>
                        <th>Nama Akun</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 0;
                        foreach ($result as $row) {
                            if(($row['kode_akun'] != null) and ($row['nama'] != null)){
                                $no++;
                                $pisahin = str_split($row['kode_akun']);
                                // var_dump($pisahin);die();
                                if($no == 22){
                                    var_dump($pisahin);die();
                                }
                                $header[$no] = $pisahin[0];
                                $kode_akun[$no] = $pisahin[1].$pisahin[2];
                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $row['kode_akun'] ?></td>
                                    <td><?= $row['nama'] ?></td>
                                    <td align="center">
                                        <a data-coa_id="<?= $row['id'] ?>" data-name="<?= $row['nama'] ?>" data-kode_akun="<?= $kode_akun[$no] ?>" data-header_akun="<?= $header[$no] ?>" data-toggle="modal" data-target="#modal-edit" href="#" class="btn btn-warning btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-danger btn-sm" title="hapus" href=<?php echo base_url('master_data/delete_coa/'.$row['kode_akun']) ?>>
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr> <?php
                            }
                        } 
                    ?>
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
                <h4 class="modal-title">Data Menu</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('master_data/coa') ?>" method="POST">
                    <div class="form-group">
                        <label>Header Akun</label>
                        <input type="number" name="header_akun" class="form-control" min = 1 max = 5>
                    </div>
                    <div class="form-group">
                        <label>Kode Akun (Tanpa Header)</label>
                        <input type="number" name="kode_akun" class="form-control" min=0 max = 99>
                    </div>
                    <div class="form-group">
                        <label>Nama COA</label>
                        <input type="text" name="coa" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    
                </form>
            </div>
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
                <h4 class="modal-title">Edit COA </span></h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('master_data/edit_coa') ?>" method="POST">
                    <input type="hidden" name="coa_id" id="coa_id">
                    <div class="form-group">
                        <label>Kode Akun (Tanpa Header)</label>
                        <input type="text" name="kode_akun" class="form-control" id="kode_akun" min=1 max=5>
                    </div>
                    <div class="form-group">
                        <label>Nama COA</label>
                        <input type="text" name="coa" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label>Header Akun</label>
                        <input type="number" name="header_akun" class="form-control" id="header_akun" min = 0 max = 99>
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
        var coa_id = $(this).attr('data-coa_id'),
            name = $(this).attr('data-name'),
            kode = $(this).attr('data-kode_akun'),
            header_akun = $(this).attr('data-header_akun');
        $('#coa_id').val(coa_id);
        $('#name').val(name);
        $('#kode_akun').val(kode);
        $('#header_akun').val(header_akun);

    })
</script>