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
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $subsubtitle ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <?php echo validation_errors() ?><br>
                    <form action="<?= base_url('menu/edit_menu/'.$menu->id) ?>" method="post">
                        <div class="form-group col-md-12">
                            <label>Menu</label>
                            <input type="text" name="menu" class="form-control" value="<?= $menu->menu ?>" required>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"> Submit</i></button>
                        </div>
                    </form>
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