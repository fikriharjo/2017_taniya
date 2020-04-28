<section class="content-header">
    <h1>Dashboard</h1>
    <ol class="breadcrumb">
        <li class="active"><i class="fa fa-home"></i> Dashboard</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <?php
                    $this->db->select('count(type_document_id) document');
                    $this->db->from('type_of_document');
                    $doc = $this->db->get()->row_array();
                    ?>
                    <h3><?= $doc['document'] ?></h3>

                    <p>Jenis Document</p>
                </div>
                <div class="icon">
                    <i class="ion ion-clipboard"></i>
                </div>
                <a href="<?php echo base_url('document') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <?php
                    $this->db->select('count(id) document');
                    $this->db->from('document');
                    // $this->db->group_by('nama_dokumen');
                    $doc = $this->db->get()->row_array();
                    ?>
                    <h3><?= $doc['document'] ?></h3>

                    <p>Jumlah Dokumen Tersimpan</p>
                </div>
                <div class="icon">
                    <i class="ion ion-filing"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <?php
                    $doc = 'SELECT SUM(biaya) AS biaya
                            FROM document
                            WHERE DATE_FORMAT(tgl_terbit,"%Y")';
                    $query = $this->db->query($doc)->row_array();
                    ?>
                    <h3><?= date('Y') ?></h3>

                    <p><small>Total Biaya <?= formatRp($query['biaya']) ?></small></p>
                </div>
                <div class="icon">
                    <i class="ion ion-cash"></i>
                </div>
                <a href="<?= base_url('document/laporan') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <?php
                    $data = 'SELECT count(id) AS document
                            FROM document
                            WHERE `status`=3';
                    $query1 = $this->db->query($data)->row_array();
                    ?>
                    <h3><?= $query1['document'] ?></h3>

                    <p><small>Dokumen tidak aktif</small></p>
                </div>
                <div class="icon">
                    <i class="ion ion-folder"></i>
                </div>
                <a href="<?= base_url('document/laporan') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Donut Chart</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="sales-chart" style="height: 300px; position: relative;"><svg height="300" version="1.1" width="511" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative;">
                        </svg></div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
    <!-- ./col -->
    <!-- ./col -->
</section>
<script>
    $(function() {
        "use strict";

        //DONUT CHART
        var donut = new Morris.Donut({
            element: 'sales-chart',
            resize: true,
            colors: ["#3c8dbc", "#f56954", "#00a65a", '#f39c12', '#00c0ef', '#964B00', '#00FF00', '#d2d6de', '#0000FF'],
            data: <?php echo $count ?>,
            hideHover: 'auto'
        });
        //BAR CHART

    });
</script>