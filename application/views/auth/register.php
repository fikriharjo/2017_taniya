<div class="login-box">
    <div class="login-logo">
        <a href="javascript:void(0)"><b>Aplikasi Web<br></b> Zero Cash Budget</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Silahkan registrasi untuk mendapatkan akses aplikasi</p>

        <?php
        $alert = $this->session->flashdata('message');
        echo (isset($alert)) ? $alert : '';
        ?>

        <form method="post" action="<?= base_url('auth/register') ?>">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="fullname" name="name" value="<?= set_value('name') ?>" placeholder="Full Name">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Address..." value="<?= set_value('email') ?>">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="form-group has-feedback">
                <select name="bagian" class="form-control select2">
                    <option selected disabled>--pilih bagian--</option>
                    <option value="1">Admin</option>
                    <option value="2">Pemilik</option>
                    <option value="3">Keuangan</option>
                </select>
                <span class="glyphicon glyphicon-collapse-down form-control-feedback"></span>
                <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username') ?>" placeholder="Username">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <?= form_error('username', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <?= form_error('password1', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" id="password2" name="password2" placeholder="Repeat Password">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
            </div>
        </form>
        <br>
        <a href="<?= base_url('auth') ?>" class="text-center">I already have a membership</a>
        <!-- /.social-auth-links -->

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

</div>
<!-- /.wrapper -->

<script>
    $(function() {
        $('body').css('background-color', '#d2d6de');
        $('body').find('.wrapper').css('background-color', '#d2d6de');
    });
</script>