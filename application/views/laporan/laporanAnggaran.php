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
            <form method="POST" action="<?php echo site_url('laporan/LaporanAnggaran') ?>">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-10">
                            <label for="month">Tanggal</label>
                            <input type="month" class='form-control' name='month' id='month'>
                        </div>
                        <div class="col-xs-2 ">
                            <label>&nbsp</label>
                            <button type="submit" class="btn btn-primary form-control">
                                <i class="fa fa-list"></i> filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <?php 
                if (!empty($lap)) { ?>
                    <center>
                        <!-- <h2>Balai Latihan Kerja Bandung</h2> -->
                        <h3>Laporan Anggaran</h3>
                        <h4>Periode : <?php echo 'Bulan ' . $bulan . ' Tahun ' . $tahun ?> </h4>
                    </center>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td><h4>Anggaran Pendapatan : Rp. <?= number_format($pendapatan) ?></h4></td>
                            </tr>
                            <tr>
                                <td><h4>Anggaran Pengeluaran : Rp. <?= number_format($pengeluaran) ?></h4></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <?php
                        $a = 0;
                        $b = 0;
                        $itung = 0;
                        // var_dump($lap);die();
                        foreach ($lap as $val) {
                            $jenisnya = strtoupper($val->jenis_anggaran);
                            if($jenisnya != 'PENDAPATAN'){
                                $a++;
                                if($a == 1){
                                    $b++;
                                    $itung++;
                                    $jenis[$b] = $val->kd_jenis_kegiatan ?>
                                    <td>Jenis Kegiatan : <?php echo $val->jenis_kegiatan ?></td>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Kegiatan</th>
                                                <th>Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $itung ?></td>
                                                <td><?php echo $val->nama_kegiatan ?></td>
                                                <td><?php echo formatRp($val->nominal) ?></td>
                                            </tr> <?php
                                            $nominal[$b]    = $val->nominal;
                                            } else {
                                                $c = 0;
                                                $init = false;
                                                while ($c < $b) {
                                                    $c++;
                                                    if($val->kd_jenis_kegiatan == $jenis[$c]){
                                                        $init = true;
                                                        $itung++; ?>
                                                        <tr>
                                                            <td><?php echo $itung; ?></td>
                                                            <td><?php echo $val->nama_kegiatan ?></td>
                                                            <td><?php echo formatRp($val->nominal) ?></td>
                                                        </tr> <?php
                                                        $nominal[$b]    = $nominal[$b]+$val->nominal;
                                                    }
                                                }

                                                if($init == false){ ?>
                                                <tr>
                                                    <td colspan='2' style='text-align:center'>Total</td>
                                                    <td><?php echo formatRp($nominal[$b]) ?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?php
                                                $b++;
                                                $itung = 1;
                                                $jenis[$b] = $val->kd_jenis_kegiatan;
                                            ?>
                                            <br>
                                            <td>Jenis Kegiatan : <?php echo $val->jenis_kegiatan ?></td>
                                            <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Kegiatan</th>
                                                    <th>Nominal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $itung ?></td>
                                                    <td><?php echo $val->nama_kegiatan ?></td>
                                                    <td><?php echo formatRp($val->nominal) ?></td>
                                                </tr> <?php
                                                $nominal[$b]    = $val->nominal;
                                            }
                                        }
                                    } 
                                } ?>
                            
                                <tr>
                                    <td colspan='2' style='text-align:center'>Total</td>
                                    <td><?php echo formatRp($nominal[$b]) ?></td>
                                </tr>
                            </tbody> 
                        </table><br>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style='text-align:center'>Total anggaran</th>
                                    <th>
                                        <?php
                                            //bisa
                                            $e = 0;
                                            $nominal_akhir = 0;
                                            while ($e < $b) {
                                                $e++;
                                                $nominal_akhir = $nominal[$e]+$nominal_akhir;
                                            }
                                            echo formatRp($nominal_akhir); ?>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    <br> <?php 
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