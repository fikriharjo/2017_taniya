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
            <form method="POST" action="<?php echo site_url('laporan/bandingkanPendapatan') ?>">
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
                        <h3>Laporan Pendapatan</h3>
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
                        $nol = 0;
                        $total_realisasi = 0;
                        $realisasi_nominal = 0;
                        // var_dump($lap);die();
                        $z = 0;
                        foreach ($realisasi as $value) {
                            $z++;
                            $real_no_anggaran[$z]   = $value->no_anggaran;
                            $real_nominal[$z]       = $value->nominal;
                        }

                        foreach ($lap as $val) {
                            $jenisnya = strtoupper($val->jenis_anggaran);
                            if($jenisnya == 'PENDAPATAN'){
                                $a++;
                                if($a == 1){
                                    $b++;
                                    $itung++;
                                    $nilai = 0;
                                    $jenis[$b] = $val->kd_jenis_kegiatan ?>
                                    <td>Jenis Kegiatan : <?php echo $val->jenis_kegiatan ?></td>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Kegiatan</th>
                                                <th>Anggaran</th>
                                                <th>Realisasi</th>
                                                <th>Persentase</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $itung ?></td>
                                                <td><?php echo $val->nama_kegiatan ?></td>
                                                <td><?php echo formatRp($val->nominal) ?></td>
                                                <td>
                                                    <?php 
                                                        // var_dump($realisasi); die();
                                                        $y = 0;
                                                        $x = 0;
                                                        $inisialisasi = false;
                                                        while ($y < $z) { 
                                                            $y++;
                                                            if($val->no_anggaran == $real_no_anggaran[$y]){
                                                                echo formatRp($real_nominal[$y]);
                                                                $inisialisasi = true;
                                                                $x = $y;
                                                                $y = $z;
                                                            }
                                                        }
                                                        if($inisialisasi == false){
                                                            $total_realisasi    = $total_realisasi+0;
                                                            $realisasi_nominal  = 0;
                                                            echo formatRp($nol);
                                                        } else {
                                                            $realisasi_nominal  = $realisasi_nominal+$real_nominal[$x];
                                                            $total_realisasi    = $total_realisasi+$real_nominal[$x];
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $hasil = $realisasi_nominal/$val->nominal*100;
                                                        echo number_format($hasil,0,',','.').'%';
                                                    ?>
                                                </td>
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
                                                            <td>
                                                                <?php
                                                                    $y = 0;
                                                                    $x = 0;
                                                                    $inisialisasi = false;
                                                                    while ($y < $z) {
                                                                        $y++;
                                                                        if($val->no_anggaran == $real_no_anggaran[$y]){
                                                                            echo formatRp($real_nominal[$y]);
                                                                            $inisialisasi = true;
                                                                            $x = $y;
                                                                            $y = $z;
                                                                        }
                                                                    }
                                                                    if($inisialisasi == false){
                                                                        $total_realisasi    = $total_realisasi+0;
                                                                        $realisasi_nominal  = $realisasi_nominal+0;
                                                                        $nilai = 0;
                                                                        echo formatRp($nol);
                                                                    } else {
                                                                        $nilai = $real_nominal[$x];
                                                                        $realisasi_nominal  = $realisasi_nominal+$real_nominal[$x];
                                                                        $total_realisasi    = $total_realisasi+$real_nominal[$x];
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    $hasil = $nilai/$val->nominal*100;
                                                                    echo number_format($hasil,0,',','.').'%';
                                                                ?>
                                                            </td>
                                                        </tr> <?php
                                                        $nominal[$b]    = $nominal[$b]+$val->nominal;
                                                    }
                                                }

                                                if($init == false){ ?>
                                                <tr>
                                                    <td colspan='2' style='text-align:center'>Total</td>
                                                    <td><?php echo formatRp($nominal[$b]) ?></td>
                                                    <td><?php echo formatRp($realisasi_nominal) ?></td>
                                                    <td>
                                                        <?php
                                                            $hasil = $realisasi_nominal/$nominal[$b]*100;
                                                            echo (number_format($hasil,0,',','.')).'%';
                                                        ?>
                                                    </td>
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
                                                    <th>Anggaran</th>
                                                    <th>Realisasi</th>
                                                    <th>Persentase</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $itung ?></td>
                                                    <td><?php echo $val->nama_kegiatan ?></td>
                                                    <td><?php echo formatRp($val->nominal) ?></td>
                                                    <td>
                                                        <?php
                                                            $y = 0;
                                                            $x = 0;
                                                            $inisialisasi = false;
                                                            while ($y < $z) {
                                                                $y++;
                                                                if($val->no_anggaran == $real_no_anggaran[$y]){
                                                                    echo formatRp($real_nominal[$y]);
                                                                    $inisialisasi = true;
                                                                    $x = $y;
                                                                    $y = $z;
                                                                }
                                                            }
                                                            if($inisialisasi == false){
                                                                $total_realisasi    = $total_realisasi+0;
                                                                $realisasi_nominal  = 0;
                                                                echo formatRp($nol);
                                                            } else {
                                                                $realisasi_nominal  = $real_nominal[$x];
                                                                $total_realisasi    = $total_realisasi+$real_nominal[$x];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $hasil = $realisasi_nominal/$val->nominal*100;
                                                            echo number_format($hasil,0,',','.').'%';
                                                        ?>
                                                    </td>
                                                </tr> <?php
                                                $nominal[$b]    = $val->nominal;
                                            }
                                        }
                                    } 
                                } ?>
                            
                                <tr>
                                    <td colspan='2' style='text-align:center'>Total</td>
                                    <td><?php echo formatRp($nominal[$b]) ?></td>
                                    <td><?php echo formatRp($realisasi_nominal) ?></td>
                                    <td>
                                        <?php 
                                            $hasil = $realisasi_nominal/$nominal[$b]*100;
                                            echo (number_format($hasil,0,',','.')).'%';
                                        ?>
                                    </td>
                                </tr>
                            </tbody> 
                        </table><br>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style='text-align:center'>Total</th>
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
                                    <th><?php echo formatRp($total_realisasi) ?></th>
                                    <th>
                                        <?php 
                                            $hasil  = $total_realisasi/$nominal_akhir*100;
                                            echo (number_format($hasil,0,',','.')).'%';
                                        ?>
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