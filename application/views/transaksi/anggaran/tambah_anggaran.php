<section class="content-header">
    <h1><?php echo $title ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('admin') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
        <li><i class="fa fa-money"></i> <?= $title ?></a></li>
        <li class="active"><i class="fa fa-money"></i> <?= $subsubtitle ?></a></li>
    </ol>
</section>

<section class="content">

    <?php echo $this->session->flashdata('message'); ?>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $subsubtitle ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form action="<?= base_url('transaksi/tambah_anggaran') ?>" method="post">
                        <?php
                        $this->db->select('kd_jenis_anggaran,periode');
                        $this->db->from('anggaran');
                        $this->db->where('no_anggaran', $no_anggaran);
                        $query = $this->db->get()->row_array();
                        if (!empty($query)) { ?>
                            <input type="hidden" name="jenis_anggaran" value="<?= $query['kd_jenis_anggaran'] ?>">
                        <?php } else { ?>
                            <input type="hidden" name="jenis_anggaran" value="<?= $jenis_anggaran ?>">
                        <?php } ?>
                        <input type="hidden" name="bulan" value="<?= $bulan ?>">
                        <input type="hidden" name="tahun" value="<?= $tahun ?>">
                        <div class="form-group">
                            <label>No Anggaran </label>
                            <input type="text" name="no_anggaran" class="form-control" value="<?= $no_anggaran ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kegiatan </label>
                            <?php 
                                // var_dump($detail_anggaran); die(); 
                            ?>
                            <select name="jenis_kegiatan" id="" class="form-control">
                                <option disabled selected>--Pilih Jenis Kegiatan</option>
                                <?php 
                                    foreach ($jenis_kegiatan as $row) { 
                                        $sama = false;
                                        foreach ($detail_anggaran as $val) {
                                            if($val['kd_kegiatan'] == $row['unique_id']){
                                                $sama = true;
                                            }
                                        } 
                                        
                                        if($sama == false){ ?>
                                            <option value="<?= $row['unique_id'] ?>"><?= $row['nama_kegiatan'] ?></option> <?php 
                                        }                                        
                                    } 
                                ?>
                            </select>
                            <?= form_error('jenis_kegiatan', '<small class="text-danger pl-3">', '</small>') ?>

                        </div>
                        <div class="form-group">
                            <label>Nominal </label>
                            <input type="text" name="nominal" class="form-control">
                            <?= form_error('nominal', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"> Submit</i></button>
                    </form>
                </div>
            </div>

        </div>
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $subtitle ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No anggaran</th>
                                <th>Jenis Anggaran</th>
                                <th>Jenis Kegiatan</th>
                                <th>Nama Kegiatan</th>
                                <th>Nominal Anggaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0;
                            $nominal = 0;
                            foreach ($detail_anggaran as $row) {
                                $no++; ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $row['no_anggaran'] ?></td>
                                    <td><?= $row['jenis_anggaran'] ?></td>
                                    <td><?= $row['jenis_kegiatan'] ?></td>
                                    <td><?= $row['nama_kegiatan'] ?></td>
                                    <td align="right"><?= formatRp($row['nominal']) ?></td>
                                </tr>
                            <?php $nominal += $row['nominal'];
                                $period = $row['periode'];
                            } ?>
                            <tr>
                                <td colspan="5">Total</td>
                                <td align="right"><?= formatRp($nominal) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <a href=<?php echo base_url('transaksi/anggaran') ?> class='btn btn-info'>
                        <i class="fa fa-save"> Back</i>
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>
<!-- <div class="modal modal-warning fade in" id="modal-warning" style="display:  padding-right: 17px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title text-warning">Penting!!</h4>
            </div>
            <div class="modal-body">
                Harap Pastikan Kembali Data Yang Telah Di isi, Data Tidak Akan Bisa Di Ubah Apabila Data Telah Tersimpan!!!
                <form action="<?php echo base_url('transaksi/selesai_anggaran') ?>" method="POST">
                    <input type="hidden" name="no_anggaran" value="<?= $no_anggaran ?>">
                    <input type="hidden" name="period" value="<?= $period ?>">
                    <input type="hidden" name="nominal" value="<?= $nominal ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline"><i class="fa fa-save"></i> Simpan Perubahan</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div> -->
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