</div>

<!-- /.container-fluid -->
<!--<footer class="footer text-center"> 2016 &copy; Antworks Money Admin </footer>-->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Bootstrap Core JavaScript -->
<script src="<?= base_url(); ?>assets-admin/bootstrap/dist/js/bootstrap.min.js"></script>

<script>
	function confirm_delete() {
		var con = confirm('Are you sure to delete the data?');
		if (con) {
			return true;
		} else {
			return false;
		}
	}
</script>
<!-- Magnific Popup JavaScript -->
<script src="<?= base_url(); ?>assets-admin/js/jquery.magnific-popup.min.js"></script>
<!--slimscroll JavaScript -->
<script src="<?= base_url(); ?>assets-admin/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?= base_url(); ?>assets-admin/js/waves.js"></script>
<!--Counter js -->
<script src="<?= base_url(); ?>assets-admin/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
<script src="<?= base_url(); ?>assets-admin/plugins/bower_components/counterup/jquery.counterup.min.js"></script>
<!--Morris JavaScript -->
<script src="<?= base_url(); ?>assets-admin/plugins/bower_components/raphael/raphael-min.js"></script>
<script src="<?= base_url(); ?>assets-admin/plugins/bower_components/morrisjs/morris.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?= base_url(); ?>assets-admin/js/custom.min.js"></script>
<script src="<?= base_url(); ?>assets-admin/js/dashboard1.js"></script>
<!-- Sparkline chart JavaScript -->
<script src="<?= base_url(); ?>assets-admin/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
<script
	src="<?= base_url(); ?>assets-admin/plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
<script src="<?= base_url(); ?>assets-admin/plugins/bower_components/toast-master/js/jquery.toast.js"></script>

<!-- Footable -->
<script src="<?= base_url(); ?>assets-admin/plugins/bower_components/footable/js/footable.all.min.js"></script>
<script src="<?= base_url(); ?>assets-admin/plugins/bower_components/bootstrap-select/bootstrap-select.min.js"
		type="text/javascript"></script>
<!--FooTable init-->
<script src="<?= base_url(); ?>assets-admin/js/footable-init.js"></script>
<!-- Date Picker Plugin JavaScript -->
<script
	src="<?= base_url(); ?>assets-admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

<script>
	/*jQuery('#datepicker-autoclose').datepicker({
			autoclose: true,
			todayHighlight: true,
			format: 'yyyy-mm-dd',
			buttonClasses: ['btn', 'btn-sm'],
			applyClass: 'btn-danger',
			cancelClass: 'btn-inverse'
		  });*/
	$(document).ready(
		function () {
			$("#datepicker-autoclose").datepicker({
				changeMonth: true,//this option for allowing user to select month
				changeYear: true, //this option for allowing user to select from year range
				dateFormat: 'yy-mm-dd',
				yearRange: '1950:2000'
			});
		}
	);
</script>
<script src="<?= base_url(); ?>assets-p2padmin/bower_components/moment/min/moment.min.js"></script>
<script src="<?= base_url(); ?>assets-p2padmin/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
	$('#daterange-btn').val();
	$(function () {
		//Date range as a button
		$('#daterange-btn').daterangepicker(
			{
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				autoApply: true,
				startDate: moment().subtract(29, 'days'),
				endDate: moment()
			},
			function (start, end) {
				$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))

			}
		);
		$('.filter-by-date').val("");

	});
</script>
<? if ($this->session->flashdata('init-success') == 1) {
	?>
	<script type="text/javascript">

		$(document).ready(function () {
			$.toast({
				heading: "Welcome MR. <?php echo $this->session->userdata('name') ?>",
				text: '',
				position: 'top-right',
				loaderBg: '#ff6849',
				icon: 'info',
				hideAfter: 3500,

				stack: 6
			});
			$('.vcarousel').carousel({
				interval: 3000
			});
		});

	</script>
<? } ?>

<!-- Sweet-Alert  -->
<script src="<?= base_url(); ?>assets-admin/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="<?= base_url(); ?>assets-admin/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
<!-- jQuery peity -->
<script src="<?= base_url(); ?>assets-admin/plugins/bower_components/peity/jquery.peity.min.js"></script>
<script src="<?= base_url(); ?>assets-admin/plugins/bower_components/peity/jquery.peity.init.js"></script>

<!--Style Switcher -->
<script src="<?= base_url(); ?>assets-admin/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
<!--Validate Plugin -->
<script src="<?= base_url(); ?>assets-admin/js/validate.js"></script>

<script src="<?= base_url(); ?>assets-admin/js/jquery-ui.js"></script>
<script src="<?= base_url(); ?>assets-admin/js/myjs.js"></script>

<!--Function Plugin -->
<script src="https://www.jqueryscript.net/demo/Pie-Donut-Chart-SVG-jChart/src/js/jchart.js?v3"></script>

<script src="<?php echo base_url(); ?>assets-admin/js/validate.js"></script>
<script src="<?php echo base_url(); ?>assets-admin/js/lenderbackend.js"></script>

</body>
</html>
