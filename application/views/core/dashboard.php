<section class="content-header">
    <h1>Dashboard</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Dashboad</li>
    </ol>
</section>

<section class="content">
    <div class="row">

        <div class="col-sm-12 dashboard-menu">
            <div class="box box-info">
                <div class="box-body">
                    <div class="clearfix">
                        <div class="page-header text-center">
                            <h3><strong>Selamat Datang di Aplikasi BLK Bandung</strong></h3>
                            <small>Silakan pilih menu di bawah ini!</small>
                        </div>
                        <div class="text-center">
                            <?php if($this->session->userdata("position") == null){ ?>
                                <a class="btn btn-app" href="<?php echo base_url('transaction'); ?>"><i class="fa fa-money"></i> Saldo Kas</a>
                                <a class="btn btn-app" href="<?php echo base_url('transaction/type'); ?>"><i class="fa fa-mail-reply-all"></i> Jenis Pengeluaran Kas</a>
                                <a class="btn btn-app" href="<?php echo base_url('activity'); ?>"><i class="fa fa-calendar-check-o"></i> Kegiatan</a>
                                <a class="btn btn-app" href="<?php echo base_url('submission'); ?>" title="Pengajuan Kas"><i class="fa fa-user-plus"></i> Pengajuan Kas</a>
                                <a class="btn btn-app" href="<?php echo base_url('cashout');?>"><i class="fa fa-external-link"></i> Transaksi Kas Keluar</a>
                            <?php } if($this->session->userdata("position") == 1){ ?>
                                <a class="btn btn-app" href="<?php echo base_url('user'); ?>"><i class="fa fa-user"></i> User</a>
                                <a class="btn btn-app" href="<?php echo base_url('divisi'); ?>"><i class="fa fa-users"></i> Divisi</a>
                            <?php } if($this->session->userdata("position") == 2){ ?>
                                <a class="btn btn-app" href="<?php echo base_url('submission'); ?>" title="Pengajuan Kas"><i class="fa fa-user-plus"></i> Pengajuan Kas</a>
                                <a class="btn btn-app" href="<?php echo base_url('cashout');?>"><i class="fa fa-external-link"></i> Transaksi Kas Keluar</a>
                                <a class="btn btn-app" href="<?php echo base_url('report/cashflow'); ?>"><i class="fa fa-book"></i> Laporan Pengeluaran Kas</a>
                                <a class="btn btn-app" href="<?php echo base_url('report/cashflow'); ?>"><i class="fa fa-book"></i> Laporan Arus Kas</a>
                                <a class="btn btn-app" href="<?php echo base_url('report/journal'); ?>"><i class="fa fa-book"></i> Jurnal</a>
                                <a class="btn btn-app" href="<?php echo base_url('report/ledger'); ?>"><i class="fa fa-book"></i> Buku Besar</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>
