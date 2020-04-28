		<!-- Customizable Javascript -->
		<script type="text/javascript" src="<?php echo base_url('assets/js/custom.js'); ?>"></script>

		<!-- Moment -->
		<script type="text/javascript" src="<?php echo base_url('assets/js/moment.js'); ?>"></script>
		<!-- Select2 -->
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/bower_components/select2/dist/js/select2.full.min.js'); ?>"></script>
		<!-- Bootstrap datetimepicker -->
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/bower_components/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); ?>"></script>
		<!-- date time picker -->
		<script src="<?php echo base_url('assets/plugins/lte/plugins/timepicker/bootstrap-timepicker.min.js'); ?>"></script>
		<!-- Morris.js charts -->
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/bower_components/raphael/raphael.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/bower_components/morris.js/morris.min.js'); ?>"></script>
		<!-- Sparkline -->
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js'); ?>"></script>
		<!-- jvectormap -->
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>"></script>
		<!-- jQuery Knob Chart -->
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/bower_components/jquery-knob/dist/jquery.knob.min.js'); ?>"></script>
		<!-- daterangepicker -->
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/bower_components/moment/min/moment.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/bower_components/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
		<!-- bootstrap datepicker -->
		<script src="<?= base_url('assets/plugins/lte/') ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<!-- bootstrap color picker -->
		<script src="<?= base_url('assets/plugins/lte/') ?>bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
		<!-- bootstrap time picker -->
		<script src="<?= base_url('assets/plugins/lte/') ?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
		<!-- datepicker -->
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'); ?>"></script>
		<!-- Bootstrap WYSIHTML5 -->
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>
		<!-- DataTables -->
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script>
		<!-- Slimscroll -->
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js'); ?>"></script>
		<!-- FastClick -->
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/bower_components/fastclick/lib/fastclick.js'); ?>"></script>
		<!-- AdminLTE App -->
		<script type="text/javascript" src="<?php echo base_url('assets/plugins/lte/dist/js/adminlte.min.js'); ?>"></script>
		<!-- Select2 -->
		<script src="<?php echo base_url('assets/plugins/lte/'); ?>bower_components/select2/dist/js/select2.full.min.js"></script>
		<!-- demo js -->
		<script src="<?php echo base_url('assets/plugins/lte/'); ?>dist/js/demo.js"></script>
		<!-- chained -->
		<script src="<?php echo base_url('assets/plugins/lte/dist/js/jquery.chained.min.js') ?>"></script>
		<script>
			$(document).ready(function() {
				$('#id_type').change(function() {
					var id = $(this).val();
					$.ajax({
						url: "<?php echo base_url(); ?>test",
						method: "POST",
						data: {
							id: id
						},
						async: false,
						dataType: 'json',
						success: function(params) {
							var html = '';
							var i;
							for (i = 0; i < params.length; i++) {
								html += '<option>' + params[i].sub_name + '</option>';
							}
							$('#sub_id_document').html(html);

						}
					});
				});
			});
			$("#sub_id_document").chained("#id_type");
			$('.select2').select2()
		</script>
		</body>

		</html>