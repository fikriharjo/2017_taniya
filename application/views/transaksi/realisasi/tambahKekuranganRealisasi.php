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
            <?=form_open_multipart('transaksi/tambahKekuranganRealisasi/'.$this->session->userdata('data_1')['kd_realisasi'].'/'.$this->session->userdata('data_1')['periode'].'/'.$this->session->userdata('data_1')['kd_jenis_anggaran'], ['class'=>"form-horizontal"]) ?>
                <div class="box-body">
                    <div class="form-group">
                        <label for="kd_realisasi" class="col-sm-3 control-label">
                            <center>Kode Realisasi</center>
                        </label>
                        <label for="tgl" class="col-sm-3 control-label">
                            <center>Tanggal Realisasi</center>
                        </label>
                        <label for="jenis_anggaran" class="col-sm-3 control-label">
                            <center>Jenis Anggaran</center>
                        </label>
                        <label for="periode" class="col-sm-3 control-label">
                            <center>Periode</center>
                        </label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $this->session->userdata('data_1')['kd_realisasi'] ?>" name="kd_realisasi" id='kd_realisasi' readonly>
                        </div>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" value="<?php echo $this->session->userdata('data_1')['tgl_realisasi'] ?>" name="tgl" id='tgl' readonly>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $this->session->userdata('data_1')['kd_jenis_anggaran'] ?>" name="jenis_anggaran" id='jenis_anggaran' readonly>
                        </div>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" value="<?php echo $this->session->userdata('data_1')['periode'] ?>" name="periode" id='periode' readonly>
                        </div>
                    </div>
                    <hr>
                    <?php
                        $a = 0;
                        foreach ($anggaran as $val) { 
                            if($val->no_anggaran == $this->session->userdata('data_2')['no_anggaran']){ ?>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Nama Kegiatan</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id=<?php echo 'nama_kegiatan'.$a ?> name=<?php echo 'nama_kegiatan' ?> value=<?php echo json_encode($val->nama_kegiatan) ?> readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control" id=<?php echo "anggaran_seharusnya" ?> name=<?php echo "anggaran_seharusnya" ?> value=<?php echo $val->nominal ?> readonly>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nominal Realisasi</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" name=<?php echo "nominal" ?> id=<?php echo 'nominal' ?> value=<?php echo $this->session->userdata('data_2')['nominal'] ?> readonly>
                                        <?= form_error('nominal', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <?php 
                                        // $this->session->set_userdata('hasil_kurang', $val->nominal-$this->session->userdata('data_2')['nominal']);
                                    ?>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control" name="nominal_hasil_kurang" id='nominal_hasil_kurang' value=<?php echo $val->nominal-$this->session->userdata('data_2')['nominal'] ?> readonly>
                                        <?= form_error('nominal_hasil_kurang', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Keterangan</label>
                                    <div class="col-sm-10">
                                        <textarea type="text" class="form-control" name="keterangan" readonly><?php echo $this->session->userdata('data_2')['keterangan'] ?></textarea>
                                        <?= form_error('keterangan', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                </div>
                                <hr><?php
                            }
                        }

                        foreach ($anggaran as $val) { 
                            if($val->no_anggaran != $this->session->userdata('data_2')['no_anggaran']){
                                $a++; ?>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Nama Kegiatan</label>
                                    <div class="col-sm-6">
                                        <input type="hidden" class="form-control" id=<?php echo 'no_anggaran'.$a ?> name=<?php echo 'no_anggaran'.$a ?> value=<?php echo json_encode($val->no_anggaran) ?>>
                                        <input type="text" class="form-control" id=<?php echo 'nama_kegiatan'.$a ?> name=<?php echo 'nama_kegiatan'.$a ?> value=<?php echo json_encode($val->nama_kegiatan) ?> readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control" id=<?php echo "anggaran_seharusnya".$a ?> value=<?php echo $val->nominal ?> readonly>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nominal Realisasi</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name=<?php echo "nominal".$a ?> id=<?php echo 'nominal'.$a ?>>
                                        <?= form_error('nominal', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Keterangan</label>
                                    <div class="col-sm-10">
                                        <textarea type="text" class="form-control" name=<?php echo "keterangan".$a ?>></textarea>
                                        <?= form_error('keterangan', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                </div> <hr><?php
                            }
                        }
                    ?>
                    <script>
                        var a = '<?php echo $a ?>';
                    </script>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <center>
                                <button type='button' onclick='cek_kecukupan_anggaran(a)'>Cek</button>
                            </center>
                        </div>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id='selisinya_dua_nilai' name='selisinya_dua_nilai' readonly>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-info pull-right" id='untuk_submit'><i class="fa fa-plus"></i> Tambah</button>
            <?=form_close()?>
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
    $(document).ready(function(){
        $('#untuk_submit').hide();
    })
    $(document).on('click', '.btn-warning', function() {
        var kgt_id = $(this).attr('data-kgt_id'),
            name = $(this).attr('data-name'),
            kode = $(this).attr('data-kode');
        $('#kgt_id').val(kgt_id);
        $('#name').val(name);
        $('#kode').val(kode);

    });

    localStorage.setItem('isian', 0);
    function setMonthPicker() {
        $(".monthpicker").datetimepicker({
            format: "MM",
            useCurrent: false,
            viewMode: "months"
        })
    }

    function cek_kecukupan_anggaran(a){
        var b = 0;
        var kekurangannya   = Number(document.getElementById('nominal_hasil_kurang').value);
        var realisasinya    = 0;
        var lanjut          = true;
        while (b < a) {
            b++;
            var anggaran_seharusnya = Number(document.getElementById('anggaran_seharusnya'+b).value);
            var nominal_digunakan   = Number(document.getElementById('nominal'+b).value);
            if(anggaran_seharusnya >= nominal_digunakan){
                realisasinya = realisasinya+nominal_digunakan;
            } else {
                realisasinya = 0;
                b = a;
                lanjut = false;
            };
        }

        if(lanjut == true){
            realisasinya = Number(realisasinya)+Number(kekurangannya);
            if(realisasinya === 0){
                alert('Bisa diproses');
                $('#untuk_submit').show();
            } else if(realisasinya < 0){
                alert('Masih belum balance '+realisasinya);
                $('#untuk_submit').hide();
            } else {
                alert('Anggaran yang digunakan berlebih '+realisasinya);
                $('#untuk_submit').hide();
            }
        } else {
            alert('Nominal realisasi melebihi anggaran');
            $('#untuk_submit').hide();
        }
        $('#selisinya_dua_nilai').val(realisasinya);
    }

    $('#jenis_anggaran1').change(function(){
        $('#sisa_anggaran').val('');
        $('#anggaran_seharusnya').val('');
        $('#nominal_hasil_kurang').val('');
        $('#nominal').val('');
        $('#nama_kegiatan').html('<option disabled selected>-- Pilih nama kegiatan --</option>');
        var jenisnya = document.getElementById('jenis_anggaran1').value;
        localStorage.setItem('isian', jenisnya);
        $.ajax({
            url : '<?php echo base_url('transaksi/ambil_periode') ?>',
            async : false,
            dataType : 'JSON',
            method : 'POST',
            data : {
                jenis : jenisnya
            },
            success : function(data){
                var periode = [];
                var bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

                data.map(val => {
                    periode.push(val.periode);
                })
                var html =  '<option disabled selected>-- Pilih periode --</option>';

                for (let index = 0; index < periode.length; index++) {
                    var hasilnya = periode[index].split('-');
                    hasilnya[1]  = Number(hasilnya[1]);
                    var bulannya = bulan[hasilnya[1]]+' - '+hasilnya[0];
                    html += '<option value='+periode[index]+'>'+bulannya+'</option>';
                }
                $('#periode').html(html);
            }
        })
    });

    $('#jenis_anggaran2').change(function(){
        $('#sisa_anggaran').val('');
        $('#anggaran_seharusnya').val('');
        $('#nominal_hasil_kurang').val('');
        $('#nominal').val('');
        $('#nama_kegiatan').html('<option disabled selected>-- Pilih nama kegiatan --</option>');
        var jenisnya = document.getElementById('jenis_anggaran2').value;
        localStorage.setItem('isian', jenisnya);
        $.ajax({
            url : '<?php echo base_url('transaksi/ambil_periode') ?>',
            async : false,
            dataType : 'JSON',
            method : 'POST',
            data : {
                jenis : jenisnya
            },
            success : function(data){
                var periode = [];
                var bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

                data.map(val => {
                    periode.push(val.periode);
                })
                var html =  '<option disabled selected>-- Pilih periode --</option>';

                for (let index = 0; index < periode.length; index++) {
                    var hasilnya = periode[index].split('-');
                    hasilnya[1]  = Number(hasilnya[1]);
                    var bulannya = bulan[hasilnya[1]]+' - '+hasilnya[0];
                    html += '<option value='+periode[index]+'>'+bulannya+'</option>';
                }
                $('#periode').html(html);
            }
        })
    });

    $('#periode').change(function(){
        var isi_tanggal = document.getElementById('periode').value;
        $('#anggaran_seharusnya').val('');
        $('#nominal_hasil_kurang').val('');
        $('#nominal').val('');
        $.ajax({
            url : '<?php echo base_url('transaksi/ambil_budget') ?>',
            async : false,
            dataType : 'JSON',
            method : 'POST',
            data : {
                isi_tanggal : isi_tanggal,
                jenis       : localStorage.getItem('isian')
            },
            success : function(data){
                $('#sisa_anggaran').val(data);
            }
        })

        $.ajax({
            url : '<?php echo base_url('transaksi/ambil_kegiatan') ?>',
            async : false,
            dataType : 'JSON',
            method : 'POST',
            data : {
                isi_tanggal : isi_tanggal,
                jenis       : localStorage.getItem('isian')
            }, 
            success : function(data){
                var nama_kegiatannya = [];
                var kode_kegiatan = [];

                data.map(val =>{
                    nama_kegiatannya.push(val.nama_kegiatan);
                    kode_kegiatan.push(val.kd_kegiatan);
                })

                var html =  '<option disabled selected>-- Pilih nama kegiatan --</option>';       
                for (let index = 0; index < nama_kegiatannya.length; index++) {
                    html += '<option value='+kode_kegiatan[index]+'>'+nama_kegiatannya[index]+'</option>';               
                }

                $('#nama_kegiatan').html(html);
            }
        })
    });

    $('#nama_kegiatan').change(function(){
        var isi_tanggal = document.getElementById('periode').value;
        var kegiatan = document.getElementById('nama_kegiatan').value;
        $.ajax({
            url : '<?php echo base_url('transaksi/anggaran_kegiatan') ?>',
            async : false,
            method : 'POST',
            dataType : 'JSON',
            data : {
                tanggal : isi_tanggal,
                kegiatan : kegiatan
            },
            success : function(data){
                var nilai = [];
                
                data.map(val=>{
                    nilai.push(val.nominal);
                })

                $('#anggaran_seharusnya').val(nilai[0])
            }
        })
    })

    // $('#nama_kegiatan').change(function(){
    //     var isi_tanggal         = document.getElementById('periode').value;
    //     var nama_kegiatannya    = document.getElementById('nama_kegiatan').value;
    //     $.ajax({
    //         url : '<?php echo base_url('transaksi/ambil_kegiatan') ?>',
    //         async : false,
    //         dataType : 'JSON',
    //         method : 'POST',
    //         data : {
    //             isi_tanggal : isi_tanggal,
    //             nama_kegiatannya : nama_kegiatannya
    //         },
    //         success : function(data){
    //             alert('jos');
    //         }
    //     })
    // })
</script>