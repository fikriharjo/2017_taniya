<section class="content-header">
    <h1><?php echo $title ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('admin') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-user"></i> <?= $title ?></a></li>
    </ol>
</section>

<section class="content">
    <!-- <?php echo form_error('nama_kegiatan', '<div class="alert alert-danger" role="alert">', '</div>') ?> -->
    <?php echo $this->session->flashdata('message'); ?>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $subtitle ?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <form class="form-horizontal" action="<?= base_url('transaksi/tambahRealisasi') ?>" method="POST">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Kode Realisasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?= $kode ?>" name="kd_realisasi" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Tanggal Realisasi</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" name="tgl">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php
                            $query = $this->db->get('jenis_anggaran')->result_array();
                            ?>
                            <label>
                                <?php foreach ($query as $row) { ?>
                                    <input type="radio" name="jenis_anggaran" value="<?= $row['no_jenis_anggaran'] ?>"> <?= $row['jenis_anggaran'] ?>
                                    <?= form_error('jenis_anggaran', '<small class="text-danger pl-3">', '</small>') ?>
                                <?php } ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Periode anggaran</label>
                        <div class="col-sm-6">
                            <select name="periode" id='periode' class="form-control">
                                <option disabled selected>--Pilih Periode --</option>
                                <?php foreach ($periode as $row) { ?>
                                    <option value="<?= $row['tgl_anggaran'] ?>"><?= date('M-Y', strtotime($row['tgl_anggaran'])) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="sisa_anggaran" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Nama Kegiatan</label>
                        <div class="col-sm-10">
                            <select name="nama_kegiatan" class="form-control">
                                <option disabled selected>--Pilih Nama Kegiatan--</option>
                                <?php foreach ($kegiatan as $row) { ?>
                                    <option value="<?= $row['unique_id'] ?>"><?= $row['nama_kegiatan'] ?></option>
                                <?php } ?>
                            </select>
                            <?= form_error('nama_kegiatan', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nominal Realisasi</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="nominal">
                            <?= form_error('nominal', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" name="keterangan"></textarea>
                            <?= form_error('nominal', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Tambah</button>
            </form>
        </div>
    </div>
    <?php if (!empty($detail)) { ?>
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Detail Realisasi></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Realisasi</th>
                            <th>Jenis Realisasi</th>
                            <th>Jenis Kegiatan</th>
                            <th>Nama Kegiatan</th>
                            <th class="text:right">Nominal Kegiatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0;
                            $nominal = 0;
                            foreach ($detail as $row) {
                                $no++;
                                $nominal += $row['nominal']; ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $row['kd_realisasi'] ?></td>
                                <td><?= $row['jenis_anggaran'] ?></td>
                                <td><?= $row['jenis_kegiatan'] ?></td>
                                <td><?= $row['nama_kegiatan'] ?></td>
                                <td align="right"><?= formatRp($row['nominal']) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button type="button" class="btn btn-success pull-rigth" data-toggle="modal" data-target="#modal-warning">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    <?php } ?>
</section>
<div class="modal modal-warning fade" id="modal-warning" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h3 class="modal-title">Peringatan!!!!!!</h3>
            </div>
            <div class="modal-body">
                <p>Data Yang Telah Disimpan Tidak Dapat Diubah Dan Dihapus, Mohon Dicek kembali Data Yang Telah Diinputkan</p>
                <form action="<?= base_url('transaksi/selesaiRealisasi') ?>" method="post">
                    <input type="hidden" name="kd_realisasi" value="<?= $kode ?>">
                    <input type="hidden" name="nominal" value="<?= $nominal ?>">
                    <?php $i = 0;
                    foreach ($detail as $row) {
                        $i++; ?>
                        <input type="hidden" name="akt[<?= $i ?>]" value="<?= $row['kd_kegiatan'] ?>">
                    <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save changes</button>
            </div>
            </form>
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

    $('#periode').change(function(){
        var isi_tanggal = document.getElementById('periode').value;
        $.ajax({
            url : '<?php echo base_url('transaksi/ambil_budget') ?>',
            async : false,
            dataType : 'JSON',
            method : 'POST',
            data : {
                isi_tanggal : isi_tanggal
            },
            success : function(data){
                $('#sisa_anggaran').val(data);
            }
        })
    })
</script>