<section class="content-header">
    <h1><?php echo $title ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('admin') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
        <li><a href="<?= base_url('admin/role') ?>"><i class="fa fa-user"></i> <?= $title ?></a></li>
        <li class="active"><i class="fa fa-user"></i> <?= $subtitle ?></li>
    </ol>
</section>

<section class="content">
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
        <div class="box-body" style="">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Role</th>
                        <th scope="col">Access</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0;
                    foreach ($menu as $m) : $no++; ?>
                        <tr>
                            <th scope="row"><?php echo $no ?></th>
                            <td><?php echo $m['menu'] ?></td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" <?= check_access($role['id'], $m['id']) ?> data-role="<?php echo $role['id']; ?>" data-menu="<?php echo $m['id']; ?>">
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<script>
    $('.form-check-input-2').on('click', function() {
        const email = $(this).data('email');
        $.ajax({
            url: "<?php echo base_url('admin/manage_account') ?>",
            type: 'post',
            data: {
                email: email,
            },
            success: function() {
                document.location.href = "<?php echo base_url('admin/manage') ?>";
            }
        });
    });
    $('.custom-file-input').on('change', function() {
        let filename = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(filename);
    });
    $('.form-check-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');
        $.ajax({
            url: "<?php echo base_url('admin/changeaccess') ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?php echo base_url('admin/roleaccess/') ?>" + roleId;
            }
        });
    });
    $('#nominal').keyup(function() {
        var plainTotal = ($(this).val()).replace(/\./g, '');
        $(this).val(rupiahFormat(plainTotal));
    });
</script>