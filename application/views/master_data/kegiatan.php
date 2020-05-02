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
                        <th>Kode Kegiatan</th>
                        <th>Nama Kegiatan</th>
                        <th>Jenis Kegiatan</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0;
                    foreach ($result as $row) {
                        $no++; ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $row['unique_id'] ?></td>
                            <td><?= $row['nama_kegiatan'] ?></td>
                            <td><?= $row['jenis_kegiatan'] ?></td>
                            <td align="center">
                                <a data-kgt_id="<?= $row['id'] ?>" data-name="<?= $row['nama_kegiatan'] ?>" data-kode="<?= $row['unique_id'] ?>" data-toggle="modal" data-target="#modal-edit" href="#" class="btn btn-warning btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                                <a class="btn btn-danger btn-sm" title="hapus" href=<?php echo base_url('master_data/delete_kegiatan/'.$row['unique_id']) ?>>
                                    <i class="fa fa-trash"></i>
                                </a>
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
                <h4 class="modal-title">Data Menu</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('master_data/kegiatan') ?>" method="POST">
                    <div class="form-group col-md-12">
                        <label>Kode Kegiatan</label>
                        <input type="text" name="kode" class="form-control" value="<?= $unique ?>" readonly>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control" placeholder='--Masukan Nama Kegiatan--'>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Jenis Kegiatan</label>
                        <select name="jenis_kegiatan" class="form-control">
                            <option disabled selected>--Pilih Jenis Kegiatan--</option>
                            <?php 
                                foreach ($jenis_kegiatan as $row) { ?>
                                    <option value="<?= $row['kd_jenis_kegiatan'] ?>"><?= $row['jenis_kegiatan'] ?></option> <?php 
                                } 
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Jenis Anggaran</label>
                        <select name="jenis_anggaran" class="form-control">
                            <option disabled selected>--Pilih Jenis Anggaran--</option>
                            <?php 
                                foreach ($jenis_anggaran as $row) { ?>
                                    <option value="<?= $row['no_jenis_anggaran'] ?>"><?= $row['jenis_anggaran'] ?></option> <?php 
                                } 
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>COA Debit</label>
                        <select name="coa1" class="form-control">
                            <option disabled selected>--Pilih COA--</option>
                            <?php 
                                foreach ($coa as $row_coa) { ?>
                                    <option value="<?= $row_coa['kode_akun'] ?>"><?= $row_coa['nama'] ?></option> <?php 
                                } 
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>COA Kredit</label>
                        <select name="coa2" class="form-control">
                            <option disabled selected>--Pilih COA--</option>
                            <?php 
                                foreach ($coa as $row_coa2) { ?>
                                    <option value="<?= $row_coa2['kode_akun'] ?>"><?= $row_coa2['nama'] ?></option> <?php 
                                } 
                            ?>
                        </select>
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
                <h4 class="modal-title">Edit Kegiatan </span></h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= base_url('master_data/edit_jkegiatan') ?>">
                    <input type="hidden" name="kgt_id" id="kgt_id">
                    <div class="form-group">
                        <label>Kode Kegiatan</label>
                        <input type="text" class="form-control" id="kode" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama Kegiatan</label>
                        <input type="text" name="kgt" class="form-control" id="name">
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
        var kgt_id = $(this).attr('data-kgt_id'),
            name = $(this).attr('data-name'),
            kode = $(this).attr('data-kode');
        $('#kgt_id').val(kgt_id);
        $('#name').val(name);
        $('#kode').val(kode);

    })
</script>