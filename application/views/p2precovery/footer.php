    </div>
<!--footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2019-2020 <a href="https://adminlte.io">Antworks P2P</a>.</strong> All rights
    reserved.
</footer-->

<!-- Control Sidebar -->
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->



    <!-- jQuery 3 -->
    <script src="<?=base_url();?>assets-p2padmin/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?=base_url();?>assets-p2padmin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- ChartJS -->
    <script src="<?=base_url();?>assets-p2padmin/bower_components/chart.js/Chart.js"></script>
    <!-- FastClick -->
    <script src="<?=base_url();?>assets-p2padmin/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=base_url();?>assets-p2padmin/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?=base_url();?>assets-p2padmin/dist/js/demo.js"></script>
    <!-- date-range-picker -->
    <script src="<?=base_url();?>assets-p2padmin/bower_components/moment/min/moment.min.js"></script>
    <script src="<?=base_url();?>assets-p2padmin/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script>
        $('#daterange-btn').val();
        $(function () {
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                {
                    ranges   : {
                        'Today'       : [moment(), moment()],
                        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    autoApply: true,
                    startDate: moment().subtract(29, 'days'),
                    endDate  : moment()
                },
                function (start, end) {
                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))

                }
            )
            $('.filter-by-date').val("");

        });
        function clearForm(){
            $('#search_admin').find("input[type=text], select").val("");
            $("#borrower_list").show();
            $("#borrower_search_list").html('');
        }
    </script>
	<script src="<?=base_url();?>assets-p2padmin/assets/js/validation.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript">
		$(function () {
			$('.datepicker').datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss'
			});
		});
	</script>
</body>
</html>
