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
                        <div class="col-xs-5 ">
                            <label>Pilih Bulan</label>
                            <select class="form-control select2" name="bulan">
                                <option disabled selected>--pilih bulan--</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-xs-5 ">
                            <label>Pilih Tahun</label>
                            <select class="form-control select2" name="tahun">
                                <option disabled selected>--pilih tahun--</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                            </select>
                        </div>
                        <div class="col-xs-2 ">
                            <label></label><br>
                            <button type="submit" class="btn btn-primary "><i class="fa fa-list"></i> filter</button>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <?php if (!empty($lap)) { ?>
                <center>
                    <!-- <h2>Balai Latihan Kerja Bandung</h2> -->
                    <h3>Laporan Anggaran</h3>
                    <h4>Periode : <?php echo 'Bulan ' . $_POST['bulan'] . ' Tahun ' . $_POST['tahun'] ?> </h4>
                </center>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><h4>Anggaran Pendapatan : Rp. <?= number_format(@$totalAnggaranPendapatan) ?></h4></td>
                        </tr>
                        <tr>
                            <td><h4>Anggaran Pengeluaran : Rp. <?= number_format(@$totalAnggaranPengeluaran) ?></h4></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <br>
                <td>Jenis Kegiatan : Pendidikan</td>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0;
                            $total = 0;
                            foreach ($lap as $row) {
                                $i++; ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $row['nama_kegiatan'] ?></td>
                                <td><?= formatRp($row['nominal']) ?></td>
                            </tr>
                        <?php $total += $row['nominal'];
                            } ?>
                        <tr>
                            <td colspan="2" align="center">Total</td>
                            <td><?= formatRp($total); ?></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <td>Jenis Kegiatan : Sarana</td>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0;
                            $total = 0;
                            foreach ($lap2 as $row) {
                                $i++; ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $row['nama_kegiatan'] ?></td>
                                <td><?= formatRp($row['nominal']) ?></td>
                            </tr>
                        <?php $total += $row['nominal'];
                            } ?>
                        <tr>
                            <td colspan="2" align="center">Total</td>
                            <td><?= formatRp($total); ?></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <br>
                <td>Jenis Kegiatan : ATK</td>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0;
                            $total = 0;
                            foreach ($lap3 as $row) {
                                $i++; ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $row['nama_kegiatan'] ?></td>
                                <td><?= formatRp($row['nominal']) ?></td>
                            </tr>
                        <?php $total += $row['nominal'];
                            } ?>
                        <tr>
                            <td colspan="2" align="center">Total</td>
                            <td><?= formatRp($total); ?></td>
                        </tr>
                    </tbody>
                </table>
                <br>
            <?php } ?>
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