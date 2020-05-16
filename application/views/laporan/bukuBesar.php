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
            <form method="POST" action="<?php echo site_url('laporan/bukuBesar') ?>">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-5">
                            <label>pilih akun</label>
                            <select class="form-control select2" name="akun">
                                <option disabled selected>--pilih akun--</option>
                                <?php foreach ($coa as $row) { ?>
                                    <option value="<?php echo $row['kode_akun'] ?>"><?php echo $row['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-xs-6">
                            <label>Pilih Tanggal</label>
                            <input type="month" name='month' class='form-control'>
                        </div>
                        <div class="col-xs-1">
                            <label for='tombol'>&nbsp</label>
                            <button type="submit" id='tombol' class="btn btn-primary form-control"><i class="fa fa-list"></i> filter</button>
                        </div>
                    </div>
                </div>
            </form>
            <?php 
                if (!empty($_POST['month'])) { ?>
                    <hr>
                    <center>
                        <strong>
                            <!-- <h2>Balai Latihan Kerja</h2> -->
                            <h3>Buku Besar</h3>
                            <h4>Periode Bulan <?php echo date('M',strtotime($_POST['month'])) . ' Tahun ' . date('Y',strtotime($_POST['month'])) ?></h4>
                        </strong>
                    </center>
                    <div class="col-xs-12">
                        <?php
                            $total = 0;
                            foreach ($before as $val) {
                                if($val->coa1 == $akun){
                                    $total = $total+$val->nominal;
                                } else {
                                    $total = $total-$val->nominal;
                                }
                            }
                            $nol = 0;
                            $pisah = str_split($akun);
                            $header = $pisah[0];
                        ?>
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center; vertical-align: top">Tanggal</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: top">Keterangan</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: top">Ref</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: top">Debet</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: top">Kredit</th>
                                    <th colspan="2" style="text-align: center">Saldo</th>
                                </tr>
                                <tr>
                                    <th>Debet</th>
                                    <th>Kredit</th>
                                </tr>
                                <tr>
                                    <th colspan="5" style="text-align: center">Saldo awal</th>
                                    <th>
                                        <?php 
                                            if(($header == 1) or ($header == 5)){
                                                echo 'Rp. ' . number_format($total, 2, ',', '.');
                                            } else {
                                                echo 'Rp. ' . number_format($nol, 2, ',', '.');
                                            }
                                        ?>
                                    </th>
                                    <th>
                                        <?php 
                                            if(($header > 1) and ($header < 5)){
                                                echo 'Rp. ' . number_format($total, 2, ',', '.');
                                            } else {
                                                echo 'Rp. ' . number_format($nol, 2, ',', '.');
                                            }
                                        ?>
                                    </th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $a = 0;
                                    // var_dump($buku_besar);die();
                                    foreach ($buku_besar as $row) { 
                                        $show = false;
                                        foreach ($coa as $val) {
                                            if(($row['coa1'] == $val['kode_akun']) and ($row['coa1'] == $akun)){
                                                $nama   = $val['nama'];
                                                //
                                                $jenis  = 'COA1';
                                                //
                                                $reff   = $val['kode_akun'];
                                                $show   = true;
                                            } else if(($row['coa2'] == $val['kode_akun']) and ($row['coa2'] == $akun)){
                                                $nama   = $val['nama'];
                                                //
                                                $jenis  = 'COA2';
                                                //
                                                $reff   = $val['kode_akun'];
                                                $show   = true;
                                            }
                                        } 
                                        if($show == true){ 
                                            $nol = 0; ?>
                                            <tr>
                                                <td><?php echo $row['tgl_realisasi'] ?></td>
                                                <td><?php echo $nama ?></td>
                                                <td><?php echo $reff ?></td>
                                                <td>
                                                    <?php 
                                                        // if(($row['jenis_anggaran'] == 'Pendapatan') and ($show == true)){
                                                        if(($jenis == 'COA1') and ($show == true)){
                                                            if(($header == 1) or ($header == 5)){
                                                                $total = $total+$row['nominal'];
                                                            } else {
                                                                $total = $total-$row['nominal'];
                                                            }
                                                            echo 'Rp. ' . number_format($row['nominal'], 2, ',', '.');
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        // if(($row['jenis_anggaran'] == 'Pengeluaran') and ($show == true)){
                                                        if(($jenis == 'COA2') and ($show == true)){
                                                            if(($header > 1) and ($header < 5)){
                                                                $total = $total+$row['nominal'];
                                                            } else {
                                                                $total = $total-$row['nominal'];
                                                            }
                                                            echo 'Rp. ' . number_format($row['nominal'], 2, ',', '.');
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        if(($header == 1) or ($header == 5)){
                                                        // if($jenis == 'COA1'){
                                                            echo 'Rp. ' . number_format($total, 2, ',', '.');
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        if(($header > 1) and ($header < 5)){
                                                        // if($jenis == 'COA2'){
                                                            echo 'Rp. ' . number_format($total, 2, ',', '.');
                                                        }
                                                    ?>
                                                </td>
                                            </tr> <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div> <?php 
                } 
            ?>
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