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
            <center>
                <h3>Neutron Bandung 2</h3>
                
            </center>
            <hr>
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Keterangan</th>
                        <!-- <th>Tanggal Realisasi</th> -->
                        <th style="text-align:right">Nominal Realisasi</th>
                        <!-- <th class="text-center">Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0;
                    foreach ($detail as $row) {
                        $no++; ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $row['nama_kegiatan'] ?></td>
                            <!-- <td><?= $row['tgl_realisasi'] ?></td> -->
                            <td align="right"><?= formatRp($row['nominal']) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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