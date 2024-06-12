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
			min-height:120px;
        }

        .number {
            font-size: 1em;
            font-weight: bold;
            color: #333;
			min-height:60px;
        }

        .label {
            font-size: 12px;//1.0em;
            color: #666;
			line-height:20px;
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
		span{
			font-size:15px!important;
		}
		.borrower-status{
			min-height:30px;
		}
    </style>

<?php $dashboardData = $lists['dashboardData']; ?>
<div class="containera" style="padding:10px;">
  <h2 align="center" >Borrower Dashboard</h2>         
  <table class="table table-bordered table-responsive ">
    <thead>
      <tr>
        <th colspan=4><p>Report:</p>  </th>
        
      </tr>
    </thead>
    <tbody>
      <tr>
     
	 	<td>
    <div class="dashboard-item">
        <div class="number">Total Borrower</div>
        <div class="label">Number of User -<span> <?php echo $noOfBorrower;?></span></div>
		<div class="label">Total Amount - <span><?php echo $borrowerAmount;?></span></div>
    </div>	
	</td>
	 
	 <td>
    <div class="dashboard-item">
        <div class="number">Total Registered Borrower</div>
        <div class="label">Number of User -<span><?php echo $noOfBorrower;?></span></div>
		<div class="label">Total Amount - <span><?php echo $borrowerAmount;?></span></div>
    </div>	
	</td>
	
	<td>
    <div class="dashboard-item">
        <div class="number">Total Disbursement</div>
        <div class="label">Number of User -<span> 47</span></div>
		<div class="label">Total Amount - <span>40000</span></div>
    </div>	
	</td>
	
	<td>
    <div class="dashboard-item">
        <div class="number">Total Outstanding</div>
        <div class="label">Number of User -<span> 47</span></div>
		<div class="label">Total Amount - <span>40000</span></div>
    </div>	
	</td>
	
	<td>
    <div class="dashboard-item">
        <div class="number">Total Closed Loan </div>
        <div class="label">Number of User -<span> 47</span></div>
		<div class="label">Total Amount - <span>40000</span></div>
    </div>	
	</td>
	
      </tr>
    
    </tbody>
  </table>



  <table class="table table-bordered table-responsive ">
    <thead>
      <tr>
       
          <!-------------filter section starting here---------->
  		<?php if($this->session->userdata('partner_id')==0){ ?>
				<form action="<?php echo base_url(); ?>surgeModuleP2P/surge/dashboardBorrower" method="post" class="">
  <table class="table table-bordered table-responsive ">
    <thead>
	
	
        <tr>
	
		
            <th colspan="4">

                <div class="row">
				
                  
					<div class="col-md-3 form-group">
							<label>Date Range:</label>
			<?php $date_range = $this->input->post('date_range'); ?>
<input type="text" readonly name="date_range" id="daterange-btn" placeholder="Date Range" class="form-control filter-by-date" required >
						</div>
				<?php //  print_r($this->input->post('date_range')); ?>
               
				
                 
                    <div class="col-md-4">
                        <p>&nbsp;</p>
                        <button class="btn btn-primary form-control">Filter</button>
                    </div>
                </div>	</form>
				
		<?php } ?>
            </th>
        </tr>
    </thead>
	 <!-------------filter section starting here---------->
      </tr>
    </thead>
    <tbody>
      <tr>
     
	 
	 		
		<tr align='center' >
				
												<!-------------row2 starting here--------------->
			 	
		<tr>
     
	 	<td>
    <div class="dashboard-item">
        <div class="number">Total Borrower</div>
        <div class="label">Number of User -<span> 47</span></div>
		<div class="label">Total Amount - <span>40000</span></div>
    </div>	
	</td>
	 
	 <td>
    <div class="dashboard-item">
        <div class="number">Total Registered Borrower</div>
        <div class="label">Number of User -<span> 47</span></div>
		<div class="label">Total Amount - <span>40000</span></div>
    </div>	
	</td>
	
	<td>
    <div class="dashboard-item">
        <div class="number">Total Disbursement</div>
        <div class="label">Number of User -<span> 47</span></div>
		<div class="label">Total Amount - <span>40000</span></div>
    </div>	
	</td>
	
	<td>
    <div class="dashboard-item">
        <div class="number">Outstanding Status</div>
        <div class="label">Due Date Pending -<span> 47</span></div>
		<div class="label">Overdue 0-90 days - <span>40000</span></div>
		<div class="label">Overdue 90+ days - <span>40000</span></div>
    </div>	
	</td>

	
      </tr>		
							<!----------row2 ending here------------------------->
							
				
				
				<!-------------filter section starting here---------->
  <br>		<?php if($this->session->userdata('partner_id')==0){ ?>
				<form action="<?php echo base_url(); ?>surgeModuleP2P/surge/dashboardBorrower" method="post" class="">
  <table class="table table-bordered table-responsive ">
    <thead>
	
	
        <tr>
	
		
            <th colspan="4">

                <div class="row">
				
                  
					<div class="col-md-3 form-group">
							<label>Duration:</label>
			<?php $date_range = $this->input->post('duration'); ?>
<input type="text" readonly name="date_range" id="daterange-btn" placeholder="Date Range" class="form-control filter-by-date" required >
						</div>
				<?php //  print_r($this->input->post('date_range')); ?>
               
				
                 
                    <div class="col-md-4">
                        <p>&nbsp;</p>
                        <button class="btn btn-primary form-control">Filter</button>
                    </div>
                </div>	</form>
				
		<?php } ?>
            </th>
        </tr>
    </thead>
	 <!-------------filter section starting here---------->


							<th colspan=3><p>Borrower Status:</p>  </th>	
							
							
	<!-------------rows starting here--------------->
			 	
		<tr>
		<th>
    <div class="borrower-status">
        
        <div class="label">Total Borrowers</div>
    </div>
	
			<div class="borrower-status">
        
        <div class="label">Stage 1</div>
    </div>

		<div class="borrower-status">
        
        <div class="label">Stage 2</div>
    </div>
	
	<div class="borrower-status">
        
        <div class="label">Stage 3</div>
    </div>
	
	<div class="borrower-status">
        
        <div class="label">Stage 4</div>
    </div>
	
	<div class="borrower-status">
        
        <div class="label">Stage 5</div>
    </div>
	
	<div class="borrower-status">
        
        <div class="label">Stage 6</div>
    </div>
	
	<div class="borrower-status">
        
        <div class="label">Stage 7</div>
    </div>
	</th>


	
		<td>
    <div class="borrower-status">
        
        <div class="label">Number of Users</div>
    </div>
	
			<div class="borrower-status">
        
        <div class="label">1</div>
    </div>

		<div class="borrower-status">
        
        <div class="label">2</div>
    </div>
	
	<div class="borrower-status">
        
        <div class="label">3</div>
    </div>
	
	<div class="borrower-status">
        
        <div class="label">4</div>
    </div>
	
	<div class="borrower-status">
        
        <div class="label">5</div>
    </div>
	
	<div class="borrower-status">
        
        <div class="label">6</div>
    </div>
	
	<div class="borrower-status">
        
        <div class="label">7</div>
    </div>
	
				

	</td>
	</tr>
	


	

							<!----------rowx ending here------------------------->
							
		
							
							
	 
      </tr>
    
    </tbody>
  </table>
  
	
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