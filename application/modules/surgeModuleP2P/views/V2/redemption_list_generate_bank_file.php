<!-- Main content -->
<style type="text/css">
	
	.myform-inline {margin-top: 3px;}
	.myform-inline .form-group input {
		max-width: 136px;
	}
</style>

<section class="content">
	<div class="box">

		<div class="box-header with-border">
			<?=getNotificationHtml();?>
		</div>
	

		<!-- /.box-header -->
		<div class="box-body">
		<div class="table-responsive">
			<table id="example" class="table table-bordered table-hover box" >
				<thead>
				<tr>
				 <th>S.no.</th>
				 <th>ID.</th>
            <th>Created Date</th>
			<th>Select</th>
            <th>Lender Id</th>
            <th>Lender Name</th>
			
            <th>Investment No</th>
            <th>Mobile</th>
            <th>Amount</th>
            <th>Basic Rate</th>
            <th>Source</th>
			<th>Partner's Name
			<th>Scheme</th>
            <th>Payout Type</th>
            <th>Payment Type</th>
            <th>Current Value</th>
            <th>Interest Days</th>
            <th>Status</th>
			<th>Partner Name</th>
            <th></th>
					 
				</tr>
				
				
				</thead>
				<tbody>
				<?php
if (@lists) {
    $i = 1;
	//	print_r($lists);
    foreach($lists as $list) {
			
		//print_r($list[1]);
	//	$list = $hotLeadList_data[];
	$unique_id = $list['lendsocial_lender_payout_schedule_table_id'];
        ?>
		
        <tr   onclick="toggleCheckbox(<?php echo $unique_id; ?>)" >
			 <td><?php echo $unique_id; ?></td>
			 <td> <?php echo $list['lender_id']; ?></td>
            <td><?php echo date('Y-m-d', strtotime($list['created_date'])); ?></td>
			 <td><input type="checkbox" id="<?php echo $unique_id; ?>" value="<?php echo base64_encode($unique_id."||".$list['investment_No']."||".$list['payment_type']."||".$list['lender_id']."||".$list['payout_amount']); ?>"></td>
            <td> <?php echo $list['lender_id']; ?></td>
            <td><?php echo $list['lender_name']; ?></td>
			
            <td><?php echo $list['investment_No']; ?></td>
            <td><?php echo $list['lender_mobile']; ?></td>
            <td>₹<?php echo $list['payout_amount']; ?></td>
            <td><?php echo $list['basic_rate']; ?></td>
            <td><?php echo $list['source']; ?></td>
			<td><?php echo $list['company_name']; ?></td>
			 <td><?php echo $list['scheme_name']; ?></td>
            <td><?php echo $list['payout_type']; ?></td>
            <td><?php echo $list['payment_type']; ?></td>
            <td><?php echo $list['payout_amount']; ?></td>
            <td><?php echo $list['interest_days']; ?></td>
			 <td><?php echo $list['redemption_status_name']; ?></td>
			<td><?php echo $list['partner_name']; ?></td>
			</tr>
           
		
          <!--  <td><a href="<?php echo base_url(''); ?>abcddetails?id=<?php echo $list['id']; ?>">View</a></td>
        </tr> -->
        <?php
		$i++;
    }
} else {
    ?>
    <tr>
	
        <td colspan="8">No records found</td>
    </tr>
    <?php
}
?>
<button class="btn btn-primary" onclick="confirmAndGetSelectedValues()">Generate Bank File</button>

			</table>
		</div>
		</div>
		<!-- /.box-body -->
		<div class="box-footer clearfix">
			<nav aria-label="Page navigation">
				<ul class="setPaginate pull-right pagination">
					<li><?php echo  @$links; ?></li>
				</ul>
			</nav>


		</div>
	</div>
</section>
<!-- /.content -->
<style>
        .unclickable {
            pointer-events: none;
        }
    </style>
<script>
        function confirmAndGetSelectedValues() {
							
							// Get the current date and time
				var currentDate = new Date();
				var formattedDate = currentDate.toISOString().slice(0, 19).replace('T', ' '); // Format: YYYY-MM-DD HH:MM:SS

				var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
			    // Show a confirmation popup
       
					
			if(checkboxes.length==0){
        
		alert("Please select atleast one record, to generate Bank File");
			}else{
        var confirmed = window.confirm('Are you sure you want to generate Bank File?');

        if (confirmed) {
            // Proceed to get selected values
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            var selectedValues = [];

            checkboxes.forEach(function(checkbox) {
				//alert(JSON.stringify(checkbox)); return false;
                selectedValues.push(checkbox.value);
				 checkbox.disabled = true; // Disable the checkbox

            });

          //  alert('Selected values: ' + selectedValues.join(', '));
			var selectedValuesAll = selectedValues.join(',');
			const newStatus = 2; // under process; this is a next step after Bank file is generated
			const request_id = "<?php echo $request_id; ?>";
			/************starting of ajax here********/
			// Make an AJAX request
        $.ajax({
            type: 'POST',
            url: '../surge/update_investment_status_v2',
            data: { ids: selectedValuesAll, status: newStatus, request_id: request_id },
            success: function(response) {
				
			
               var jsonData = JSON.parse(response);
                if (jsonData.status==1) {
                   alert(jsonData.msg);
				   	 // Handle the CSV content received from the server
        // For simplicity, let's create a downloadable link
        var blob = new Blob([jsonData.csv_data], { type: 'text/csv' });
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
       // link.download = 'Bank_file.csv';
	   link.download = 'Bank_file_' + formattedDate + '.csv';
        link.click();
				   
                } else {
                    alert(jsonData.msg);
                } 
            },
            error: function() {
                alert('Error occurred during the AJAX request');
            }
        }); /****************ending of ajax here********/
    
				
        }
		
			}
    }
</script>



<script>
    function toggleCheckbox(id) {
        var checkbox = document.getElementById(id);
        checkbox.checked = !checkbox.checked;
    }
</script>


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
		$('#example').DataTable({
			"paging":   false,
			"searching": false,
			"showNEntries" : false,
		});

	} );
</script>
