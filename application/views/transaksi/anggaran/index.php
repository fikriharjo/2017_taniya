<section class="content-header">
    <h1><?php echo $title ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('admin') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-user"></i> <?= $title ?></a></li>
    </ol>
</section>

<section class="content">
    <?php echo form_error('nama_kegiatan', '<div class="alert alert-danger" role="alert">', '</div>') ?>
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
                        <!-- <th>No anggaran</th> -->
                        <th>Periode Anggaran</th>
                        <th style="text-align:right">Nominal Anggaran</th>
                        <th style="text-align:center">Aksi</th>
                        <!-- <th class="text-center">Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0;
                    foreach ($result as $row) {
                        $no++; ?>
                        <tr>
                            <td><?= $no ?></td>
                            <!-- <td><?= $row['no_anggaran'] ?></td> -->
                            <td><?= get_monthname(substr($row['periode'], 5, 2)) . " - " . substr($row['periode'], 0, 4); ?></td>
                            <td align="right"><?= formatRp($row['nominal']) ?></td>
                            <td align="center">
                                <a href="<?= site_url('transaksi/detail_anggaran/'.$row['periode']) ?>" class="btn btn-info" title="detail"><i class="fa fa-eye"></i></a>
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
                <h4 class="modal-title">Form tambah Anggaran</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('transaksi/tambah_anggaran') ?>" method="POST">
                    <div class="form-group">
                        <label>Jenis Anggaran</label>
                        <select name="jenis_anggaran" class="form-control">
                            <option disabled selected>--Pilih Jenis Anggaran--</option>
                            <?php foreach ($jenis_anggaran as $row) { ?>
                                <option value="<?= $row['no_jenis_anggaran'] ?>"><?= $row['jenis_anggaran'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Date</label>
                                <input type="month" name='month' min=<?php echo date('Y-m') ?> class='form-control'>
                            </div>
                        </div>
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
<div class="modal fade in" id="modal-edit" style="display:  padding-right: 17px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Edit Kegiatan </span></h4>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" name="kgt_id" id="kgt_id">
                    <div class="form-group">
                        <label>Kode Kegiatan</label>
                        <input type="text" name="kode_akun" class="form-control" id="kode">
                    </div>
                    <div class="form-group">
                        <label>Nama Kegiatan</label>
                        <input type="text" name="coa" class="form-control" id="name">
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

    });

    function setMonthPicker() {
        $(".monthpicker").datetimepicker({
            format: "MM",
            useCurrent: false,
            viewMode: "months"
        })
    }
</script>