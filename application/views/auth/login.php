<div class="login-box">
    <div class="login-logo">
        <a href="javascript:void(0)"><b><br></b> Zero Based Budgeting </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Login untuk memulai sesi</p>

        <?php
        $alert = $this->session->flashdata('message');
        echo (isset($alert)) ? $alert : '';
        ?>

        <form method="post" action="<?= base_url('auth') ?>">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username Address..." value="<?= set_value('username') ?>">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <?= form_error('username', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
                </div>
            </div>
        </form>
        <br>
        <a href="<?= base_url('auth/register') ?>" class="text-center">Register a new membership</a>
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