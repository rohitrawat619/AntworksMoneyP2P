</div>

    <!-- /.container-fluid -->
    <!--<footer class="footer text-center"> 2016 &copy; Antworks Money Admin </footer>-->
  </div>
  <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Bootstrap Core JavaScript -->
<script src="<?=base_url();?>assets-admin/bootstrap/dist/js/bootstrap.min.js"></script>

<script>
 function confirm_delete()
  {
	  var con = confirm('Are you sure to delete the data?');
	  if(con)
	  {
		  return true;
	  }
	  else
	  {
		  return false;
	  }
  }
</script>
<!-- Magnific Popup JavaScript -->
<script src="<?=base_url();?>assets-admin/js/jquery.magnific-popup.min.js"></script>
<!--slimscroll JavaScript -->
<script src="<?=base_url();?>assets-admin/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?=base_url();?>assets-admin/js/waves.js"></script>
<!--Counter js -->
<script src="<?=base_url();?>assets-admin/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
<script src="<?=base_url();?>assets-admin/plugins/bower_components/counterup/jquery.counterup.min.js"></script>
<!--Morris JavaScript -->
<script src="<?=base_url();?>assets-admin/plugins/bower_components/raphael/raphael-min.js"></script>
<script src="<?=base_url();?>assets-admin/plugins/bower_components/morrisjs/morris.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?=base_url();?>assets-admin/js/custom.min.js"></script>
<script src="<?=base_url();?>assets-admin/js/dashboard4.js"></script>
<!-- Sparkline chart JavaScript -->
<script src="<?=base_url();?>assets-admin/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="<?=base_url();?>assets-admin/plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
<script src="<?=base_url();?>assets-admin/plugins/bower_components/toast-master/js/jquery.toast.js"></script>

<!-- Footable -->
<script src="<?=base_url();?>assets-admin/plugins/bower_components/footable/js/footable.all.min.js"></script>
<script src="<?=base_url();?>assets-admin/plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<!--FooTable init-->
<script src="<?=base_url();?>assets-admin/js/footable-init.js"></script>
<!-- Date Picker Plugin JavaScript -->
<script src="<?=base_url();?>assets-admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- jQuery peity -->
<script src="<?=base_url();?>assets-admin/plugins/bower_components/peity/jquery.peity.min.js"></script>
<script src="<?=base_url();?>assets-admin/plugins/bower_components/peity/jquery.peity.init.js"></script>

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
	$( "#datepicker-autoclose" ).datepicker({
	  changeMonth: true,//this option for allowing user to select month
	  changeYear: true, //this option for allowing user to select from year range
	  dateFormat: 'yy-mm-dd',
	  yearRange: '1950:2000'
	});
  }
);
</script>
<? if($this->session->flashdata('init-success')==1){
?>
<script type="text/javascript">

  $(document).ready(function() {
      $.toast({
        heading: 'Welcome <?php echo $this->session->userdata("name") ?>',
        text: '',
        position: 'top-right',
        loaderBg:'#ff6849',
        icon: 'info',
        hideAfter: 3500,

        stack: 6
      });
      $('.vcarousel').carousel({
            interval: 3000
       });
    });
  $('input').change(function() {
      $(this).removeClass('input-error');
      var attr_id = $(this).attr('id');
      $("#error_"+attr_id).html('<p></p>');
  });

  $('select').change(function() {
      $(this).removeClass('input-error');
      var attr_id = $(this).attr('id');
      $("#error_"+attr_id).html('<p></p>');
  });
  $('checkbox').change(function() {
      $(this).removeClass('input-error');
      var attr_id = $(this).attr('id');
      $("#error_"+attr_id).html('<p></p>');
  });
  $('textarea').change(function() {
      $(this).removeClass('input-error');
      var attr_id = $(this).attr('id');
      $("#error_"+attr_id).html('<p></p>');
  });
</script>
<? }?>

<!-- Sweet-Alert  -->
<script src="<?=base_url();?>assets-admin/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="<?=base_url();?>assets-admin/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>

<!--Style Switcher -->
<script src="<?=base_url();?>assets-admin/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
<!--dataTables -->
<script src="<?=base_url();?>assets-admin/plugins/datatables/jquery.dataTables.min.js"></script>
<!--Validate Plugin -->
<script src="<?=base_url();?>assets-admin/js/validate.js"></script>

<script src="<?=base_url();?>assets-admin/js/jquery-ui.js"></script>
<script src="<?=base_url();?>assets-admin/js/myjs.js"></script>

<!--Function Plugin -->
<? //include_once('function.php');?>
<script src="https://www.jqueryscript.net/demo/Pie-Donut-Chart-SVG-jChart/src/js/jchart.js?v3"></script>
<script type="text/javascript">
	$('#bidrules, #loanagreements').slimScroll({
		color: '#000'
		, size: '10px'
		, height: '300px'
		, alwaysVisible: true
	});
</script>
<script>
    let jchart1;
    $(function () {
        jchart1 = $("#element3").jChart({
            data: [
                {
                    value: 150,
					color: {
                        normal: '#607eac',
                        active: '#333',
                    },
                },
				{
                    value: 10,
					color: {
                        normal: '#ff9e16',
                        active: '#333',
                    },
                },
				{
                    value: 20,
					color: {
                        normal: '#fdc634',
                        active: '#333',
                    },
                },
				{
                    value: 30,
					color: {
                        normal: '#f7e62d',
                        active: '#333',
                    },
                },
				{
                    value: 60,
					color: {
                        normal: '#90db24',
                        active: '#333',
                    },
                },
				{
                    value: 90,
					color: {
                        normal: '#74b23e',
                        active: '#333',
                    },
                },

                {
                    value: 200,
                    color: {
                        normal: '#77cbe0',
                        active: '#333',
                    },
                    draw: true, //false
                    push: true, //false
                },
            ],
            appearance: {
                type: 'pie',
                baseColor: '#ddd',
            }

        });

    });
</script>
<script>
	$(document).ready(function () {
		$('#myTable').DataTable();
		$(document).ready(function () {
			var table = $('#example').DataTable({
				"columnDefs": [
					{
						"visible": false
						, "targets": 2
					}
	  ]
				, "order": [[2, 'asc']]
				, "displayLength": 25
				, "drawCallback": function (settings) {
					var api = this.api();
					var rows = api.rows({
						page: 'current'
					}).nodes();
					var last = null;
					api.column(2, {
						page: 'current'
					}).data().each(function (group, i) {
						if (last !== group) {
							$(rows).eq(i).before('<tr class="group"><td colspan="2">' + group + '</td></tr>');
							last = group;
						}
					});
				}
			});
			// Order by the grouping
			$('#example tbody').on('click', 'tr.group', function () {
				var currentOrder = table.order()[0];
				if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
					table.order([2, 'desc']).draw();
				}
				else {
					table.order([2, 'asc']).draw();
				}
			});
		});
	});
	$('#example23').DataTable({
		dom: 'Bfrtip'
		, buttons: [
		'copy', 'csv', 'excel', 'pdf', 'print'
	]
	});
</script>
<script>
		$(function(){
			var inputs = $('.input');
			var paras = $('.description-flex-container').find('p');
			$(inputs).click(function(){
				var t = $(this),
						ind = t.index(),
						matchedPara = $(paras).eq(ind);

				$(t).add(matchedPara).addClass('active');
				$(inputs).not(t).add($(paras).not(matchedPara)).removeClass('active');
			});
		});
	</script>
</body>
</html>
