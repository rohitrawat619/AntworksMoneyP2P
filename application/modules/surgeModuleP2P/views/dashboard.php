  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
  
		
        .dashboard1 {
            display: flex;
            justify-content: center;
            align-items: center;
          //  height: 100vh;
        }

        .dashboard-item {
            text-align: center;
            margin: 10px;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .number {
            font-size: 1em;
            font-weight: bold;
            color: #333;
        }

        .label {
            font-size: 12px;//1.0em;
            color: #666;
        }
		
		
		table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 10px solid black; /* Adjust the thickness as needed */
            padding: 4px;
            text-align: left;
        }
		.gap{
			padding-left:120px;
		}
    </style>
	<?php $dashboardData = $lists['dashboardData']; ?>
<div class="content">
<div class="row">

        <div class="col-md-6 col-sm-6 col-xs-12">

          <div class="info-box">

            <span class="info-box-icon bg-aqua"><i class="ion ion-connection-bars"></i></span>

 

            <div class="info-box-content">

              <span class="info-box-text">Today's Investment</span>

              <span class="info-box-number"><?php echo $dashboardData['TodayInvestment']; ?></span>

            </div>

            <!-- /.info-box-content -->

          </div>

          <!-- /.info-box -->

        </div>

        <!-- /.col -->

        <div class="col-md-6 col-sm-6 col-xs-12">

          <div class="info-box">

            <span class="info-box-icon bg-red"><i class="ion ion-shuffle"></i></span>

 

            <div class="info-box-content">

              <span class="info-box-text">Today's Redemption</span>

              <span class="info-box-number"><?php echo $dashboardData['TodayRedemption']; ?></span>

            </div>

            <!-- /.info-box-content -->

          </div>

          <!-- /.info-box -->

        </div>

        <!-- /.col -->

 

        <!-- fix for small devices only -->

        <div class="clearfix visible-sm-block"></div>

 

        <div class="col-md-6 col-sm-6 col-xs-12">

          <div class="info-box">

            <span class="info-box-icon bg-green"><i class="ion ion-person-stalker"></i></span>

 

            <div class="info-box-content">

              <span class="info-box-text">Number of Investor</span>

              <span class="info-box-number"><?php echo $dashboardData['TodayInvestmentNoOfInvestor']; ?></span>

            </div>

            <!-- /.info-box-content -->

          </div>

          <!-- /.info-box -->

        </div>

        <!-- /.col -->

        <div class="col-md-6 col-sm-6 col-xs-12">

          <div class="info-box">

            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

 

            <div class="info-box-content">

              <span class="info-box-text">Number of Investor</span>

              <span class="info-box-number"><?php echo $dashboardData['TodayRedemptionNoOfInvestor']; ?></span>

            </div>

            <!-- /.info-box-content -->

          </div>

          <!-- /.info-box -->

        </div>

        <!-- /.col -->

      </div>
      </div>

 

<div class="content">
	<div style="display:none;">
  <h2 align="center" >Dashboard</h2>         
  <table class="table table-bordered table-responsive ">
    <thead>
      <tr>
        <th colspan=4><p>Current Report:</p>  </th>
        
      </tr>
    </thead>
    <tbody>
      <tr>
     
	 	<td>
    <div class="dashboard-item">
        <div class="number"><?php echo $dashboardData['TodayInvestment']; ?></div>
        <div class="label">Today's Investment</div>
    </div>	
	
	
	<div class="dashboard-item">
        <div class="number"><?php echo $dashboardData['TodayInvestmentNoOfInvestor']; ?></div>
        <div class="label">Number of Investor</div>
    </div></td>
	 
      
	
		<td>
    <div class="dashboard-item">
        <div class="number"><?php echo $dashboardData['TodayRedemption']; ?></div>
        <div class="label">Today's Redemption</div>
    </div>

		 <div class="dashboard-item">
        <div class="number"><?php echo $dashboardData['TodayRedemptionNoOfInvestor']; ?></div>
        <div class="label">Number of Investor</div>
			</div>
	
	</td>
	
		
      </tr>
    
    </tbody>
  </table>
</div>
<br>
<div class="row">

        <div class="col-md-12">

          <div class="box">

           

            <!-- /.box-header -->

            <div class="box-body">

                          
				
                   <br>		<?php if($this->session->userdata('partner_id')==0){ ?>
				    <div class="row">
				<form action="<?php echo base_url(); ?>surgeModuleP2P/surge/dashboard" method="post" class="">
					<div class="col-md-3 form-group" style="display:none">
							<label>Date Range:</label>
			<?php $date_range = $this->input->post('date_range'); ?>
<input type="text" readonly name="date_range" id="daterange-btn" placeholder="Date Range" class="form-control filter-by-date" required >
						</div>
				<?php //  print_r($this->input->post('date_range')); ?>
               
				<div class="col-md-4 form-group">
        <label for="password">Partner:</label><br>
        <select  class="form-control" name="partner_id" id="partner_id" >
		

		<?php			
					if(count($lists['partnersData'])>1){
							echo'<option value="allPartners">All Partners</option>';
						}else{
								echo '<option value="">Select Partner</option>';
								}
				for($i=0; $i<count($lists['partnersData']); $i++){
				if($this->input->post('partner_id')==$lists['partnersData'][$i]['VID']){
					$selected = "selected";
				}else{
					$selected = "";
					}	
						
			echo '<option '.$selected.' value="'.$lists['partnersData'][$i]['VID'].'">'.$lists['partnersData'][$i]['Company_Name'].'</option>';
		}
			?>
		
		</select>
    </div>
                     <div class="col-md-4 form-group">
        <label for="password">Scheme List:</label><br>
        <select  class="form-control" name="scheme_id" id="scheme_id" >
		

		<?php 
						
					echo'<option  value="" >All Scheme</option>';
				for($i=0; $i<count($lists['schemeList']); $i++){
				if($this->input->post('scheme_id')==$lists['schemeList'][$i]['id']){
					$selected = "selected";
				}else{
					$selected = "";
					}	
						
			echo '<option '.$selected.' value="'.$lists['schemeList'][$i]['id'].'">'.$lists['schemeList'][$i]['Scheme_Name']. 
		"  { ".$lists['schemeList'][$i]['partners_name']." }"
.'</option>';
		}
			?> 
		
		</select>
    </div>
                    <div class="col-md-4">
                        <p>&nbsp;</p>
                        <button class="btn btn-primary form-control">Filter</button>
                    </div>
                </div>	
					</form>
				   <?php } ?>
              <!-- /.row -->

															<!-------------row1 starting here--------------->
					<div class="row">
	
			
		<div class="col-md-4">
    <div class="dashboard-item">
        <div class="number"><?php echo $dashboardData['TotalInvestment']; ?></div>
        <div class="label">Total Investment</div>
    </div>
			
			<div class="dashboard-item">
        <div class="number"><?php echo $dashboardData['TotalInvestmentInvestor']; ?></div>
        <div class="label">Total Investor</div>
    </div>	
			
	</div>
		
			<div class="col-md-4">
    <div class="dashboard-item">
        <div class="number"><?php echo $dashboardData['TotalInvestmentOutstanding']; ?></div>
        <div class="label">Total Investment Outstanding
		</div>
    </div>
			
			 <div class="dashboard-item">
        <div class="number"><?php echo $dashboardData['OutstandingInvestmentNoInvestor']; ?></div>
        <div class="label">No. Investor</div>
    </div>	
			
	</div>
	
				<div class="col-md-4">
    <div class="dashboard-item">
        <div class="number"><?php echo $dashboardData['TotalInvestmentRedeemed']; ?></div>
        <div class="label">Total investment Redeemed</div>
    </div>	
			
			 <div class="dashboard-item">
        <div class="number"><?php echo $dashboardData['RedeemedInvestmentNoInvestor']; ?></div>
        <div class="label">No. Investor</div>
    </div>
	
	</div>
		</div>
						
							<!----------row1 ending here------------------------->

			<!-------------row starting here--------------->
					
		
			<div class="row">
		<div class="col-md-4">
    <div class="dashboard-item">
        <div class="number"><?php echo $dashboardData['AverageROI']; ?></div>
        <div class="label">Average ROI</div>
    </div>	 </div>
		
			<div class="col-md-4">
    <div class="dashboard-item">
        <div class="number"><?php echo $dashboardData['InterestOutstanding']; ?></div>
        <div class="label">Interest Outstanding </div>
    </div>		</div>
	
				<div class="col-md-4">
    <div class="dashboard-item">
        <div class="number"><?php echo $dashboardData['TotalInterestPaidOnRedeemedInvestment']; ?></div>
        <div class="label">Total Interest Paid On Redeemed Investment </div>
    </div>		</div>		
		</div>

							<!----------row ending here------------------------->
							
							
							<!-----------------start------------>
							<div class="row">
							<div class="col-md-4">
							<div class="dashboard-item">
        <div class="number"><?php echo $dashboardData['AverageInvestment']; ?></div>
        <div class="label">Average Investment</div>
    </div>		</div>		
					</div>
							<!--------ending------------------>

            </div>

            <!-- ./box-body -->

           

            <!-- /.box-footer -->

          </div>

          <!-- /.box -->

        </div>

        <!-- /.col -->

      </div>
 
  
	
  </table>
	<!-------------------filter section ending here------------------->
</div>
<script>
	$(function() {
		$('input[name="created_at"]').daterangepicker({
			opens: 'left'
		}, function(start, end, label) {
			console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
		});
	});
</script>
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap.min.js"></script>
<script>
	$(document).ready(function() {
		$('#example1').DataTable({
			"paging":   false,
			"searching": false,
			"showNEntries" : false,
		});

	} );
</script>
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
            $('.filter-by-date').val("<?php echo $date_range; ?>");

        });
      
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      format: 'dd/mm/yyyy',
    })
</script>