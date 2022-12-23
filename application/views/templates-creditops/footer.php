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
<script src="<?=base_url();?>assets-admin/js/dashboard1.js"></script> 
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
<script src="<?=base_url();?>assets-admin/js/bootstrap-datetimepicker.js"></script>


<script>
jQuery('#datepicker-autoclose').datetimepicker({
        autoclose: true,
        todayHighlight: true,
		format: 'yyyy-mm-dd hh:mm:ss',
		buttonClasses: ['btn', 'btn-sm'],
		applyClass: 'btn-danger',
		cancelClass: 'btn-inverse'
      });
</script>
<script>
    jQuery('#datepicker-autoclose2').datetimepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd hh:mm:ss',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });
</script>
<? if($this->session->flashdata('init-success')==1){
?>
<script type="text/javascript">
  
  $(document).ready(function() {
      $.toast({
        heading: 'Welcome to Antworks Money Admin',
        text: 'Use the predefined ones, or specify a custom position object.',
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
 
</script>
<? }?>

<!-- Sweet-Alert  -->
<script src="<?=base_url();?>assets-admin/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="<?=base_url();?>assets-admin/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
<!-- jQuery peity -->
<script src="<?=base_url();?>assets-admin/plugins/bower_components/peity/jquery.peity.min.js"></script>
<script src="<?=base_url();?>assets-admin/plugins/bower_components/peity/jquery.peity.init.js"></script>

<!--Style Switcher -->
<script src="<?=base_url();?>assets-admin/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
<!--Validate Plugin -->
<script src="<?=base_url();?>assets-admin/js/validate.js"></script>

<script src="<?=base_url();?>assets-admin/js/jquery-ui.js"></script>
<script src="<?=base_url();?>assets-admin/js/myjs.js"></script>

<!--Function Plugin -->
<? include_once('function.php');?>
<script src="https://www.jqueryscript.net/demo/Pie-Donut-Chart-SVG-jChart/src/js/jchart.js?v3"></script>
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
</body>
</html>
