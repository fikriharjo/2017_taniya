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
        <div class="box-body">
            <form method="POST" action="<?php echo site_url('laporan/lihat_jurnal') ?>">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-10">
                            <label>Pilih Bulan</label>
                            <input type="month" name='month' class='form-control'>
                        </div>
                        <div class="col-xs-2">
                            <label for="tombol">&nbsp</label>
                            <button type="submit" class="btn btn-primary form-control" id='tombol'>
                                <i class="fa fa-list"></i> filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <?php
            // var_dump($jurnal); die();
             if ($bulan != 0) : ?>
                <center>
                    <!-- <h2>Balai Latihan Kerja Bandung</h2> -->
                    <h3>Jurnal Umum</h3>
                    <h4>Periode : <?php echo 'Bulan ' . date('m', strtotime($_POST['month'])) . ' Tahun ' . date('Y', strtotime($_POST['month'])) ?> </h4>
                </center>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Ref</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $a = 0;
                            foreach ($coa as $val) {
                                $a++;
                                $kode_akun[$a]  = $val->kode_akun;
                                $nama[$a]       = $val->nama;
                            }
                            $spasi = '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
                            // var_dump($jurnal); die();
                            $debit  = 0;
                            $kredit = 0;
                            foreach ($jurnal as $row) : ?>
                            <tr>
                                <td><?php echo $row['tgl_realisasi'] ?></td>
                                <?php 
                                    $b = 0;
                                    $c = 0;
                                    while ($b < $a) {
                                        $b++;
                                        if($row['coa1'] == $kode_akun[$b]){
                                            $nama_coa[1] = $nama[$b];
                                            $kode_coa[1] = $kode_akun[$b];
                                            $c++;
                                        } else if($row['coa2'] == $kode_akun[$b]){
                                            $c++;
                                            $nama_coa[2] = $nama[$b];
                                            $kode_coa[2] = $kode_akun[$b];
                                        }
                                        
                                        if($c == 2){
                                            $b = $a;
                                        }
                                    }
                                    $debit = $debit+$row['nominal'];
                                    $kredit = $kredit+$row['nominal'];
                                ?>
                                <td><?php echo $nama_coa[1] ?></td>
                                <td><?php echo $kode_coa[1] ?></td>
                                <td><?php echo 'Rp. ' . number_format($row['nominal'], 2, ',', '.') ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><?php echo $row['tgl_realisasi'] ?></td>
                                <td><?php echo $nama_coa[2] ?></td>
                                <td><?php echo $kode_coa[2] ?></td>
                                <td></td>
                                <td><?php echo 'Rp. ' . number_format($row['nominal'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" align="center"><b>Total</b></td>
                            <td><?php echo "Rp. " . number_format($debit, 2, ',', '.') ?></td>
                            <td><?php echo 'Rp. ' . number_format($kredit, 2, ',', '.') ?></td>
                        </tr>
                    </tbody>
                </table>
                <br>
            <?php endif ?>
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
                            <div class="col-md-6">
                                <label for="">Bulan</label>
                                <select name="bulan" class="form-control">
                                    <option disabled selected>--Pilih Bulan--</option>
                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <option value="<?= $i ?>"><?= get_monthname($i) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="">Tahun</label>
                                <select name="tahun" class="form-control">
                                    <option disabled selected>--Pilih Tahun--</option>
                                    <?php for ($i = 2018; $i <= date('Y'); $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
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