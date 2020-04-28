<section class="content-header">
    <h1>Divisi Lists<small>Control Panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Divisi Lists</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="id_type" class="text-primary">Jenis Dokumen</label>
                <select name="id_type" id="id_type" class="form-control  
                                    <?php if (form_error('id_type')) {
                                        echo 'is-invalid';
                                    } else {
                                        echo '';
                                    } ?>">
                    <option value="">-pilih jenis dokumen-</option>
                    <?php foreach ($type_of_document as $t) : ?>
                        <option value="<?php echo $t['type_document_id'] ?>"><?php echo $t['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo form_error('id_type', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class=" form-group col-md-6">
                <label for="tgl_expired" class="text-primary">Sub Jenis Dokumen</label>
                <select name="sub_id_document" id="sub_id_document" class="form-control
                                <?php if (form_error('id_type')) {
                                    echo 'is-invalid';
                                } else {
                                    echo '';
                                } ?>">
                    <option value="0">-pilih sub jenis dokumen</option>

                </select>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">

</script>