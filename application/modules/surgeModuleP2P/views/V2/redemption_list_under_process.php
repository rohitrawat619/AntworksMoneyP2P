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
		<!-- Button to Open Modal -->
					<div class="table-responsive">
			<table id="example" class="table table-bordered table-hover box" >
				<thead>
				<tr>
									 <th>S.no.</th>
				 <th>ID</th>
            <th>Created Date</th>
            <th>Lender Id</th>
            <th>Lender Name</th>
            <th>Investment No</th>
            <th>Mobile</th>
             <th>Payout Amount</th>
            <th>Basic Rate</th>
            <th>Source</th>
			<th>Scheme</th>
            <th>Payout Type</th>
            <th>Payment Type</th>
          
            <th>Interest Days</th>
		<!----	<th>RedemptionStatus</th> ---->
            <th>Status</th>
			<th>Partner Name</th>
            <th width="100px">Reason</th>
					 
				</tr>
				
				
				</thead>
				<tbody>
				<?php
if (@lists) {
    $i = 0;
		
	//	print_r($lists);
    foreach($lists as $list) {
		//print_r($list[1]);
	//	$list = $hotLeadList_data[];
	$i++;
        ?>
        <tr>
			
         	<!-- starting of The Modal --><div class="modal" id="<?php echo $list['lendsocial_lender_payout_schedule_table_id']; ?>">
			<div class="modal-dialog"><div class="modal-content" ><!-- Modal Header -->
			<div class="modal-header"><h4 class="modal-title">Under Process Request:</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div><!-- Modal Body -->
			<div class="modal-body">
			
						 <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Created Date:</label>
								<span><?php echo date('Y-m-d', strtotime($list['created_date'])); ?></span>
							</div>

							<div class="form-group">
								<label>Lender ID:</label>
								<span><?php echo $list['lender_id']; ?></span>
							</div>
							</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Lender Name:</label>
								<span><?php echo $list['lender_name']; ?></span>
							</div>

							<div class="form-group">
								<label>Investment Number:</label>
								<span><?php echo $list['investment_No']; ?></span>
							</div>

						

						</div>
						
						<div class="col-md-6">
							

							<div class="form-group">
								<label>Reference Number:</label>
								<textarea class="form-control" id="<?php echo "reference".$list['lendsocial_lender_payout_schedule_table_id']; ?>" > </textarea>
							</div>

							

						</div>
					</div>
			
			</div><!-- Modal Footer --><div class="modal-footer">
			<!------<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> ------'".$list['lendsocial_lender_payout_schedule_table_id']."','".$list['payment_type']."','".$list['investment_No']."'
			<span><button type="button" class="btn btn-primary" onclick="update_underprocess_status('<?php echo $list['reinvestment_id'].$list['investment_No']; ?>')" >Redeem</button></span> ----->
			<?php
			   echo"<span type='button' class='btn btn-success' onclick=update_underprocess_status_v2('".$list['lendsocial_lender_payout_schedule_table_id']."','".$list['payment_type']."','".$list['investment_No']."') >Redeem</span>  ";   
				$api_response = json_decode($list['api_response'],true);
			?>
			</div></div></div></div>		<!----------ending of The Modal--------->
		
			 <td><?php echo $i++; ?></td>
			 <td><?php echo $list['lendsocial_lender_payout_schedule_table_id']; ?></td>
            <td><?php echo date('Y-m-d', strtotime($list['created_date'])); ?></td>
            <td><?php echo $list['lender_id']; ?></td>
            <td><?php echo $list['lender_name']; ?></td>
			
            <td><?php echo $list['investment_No']; ?></td>
            <td><?php echo $list['lender_mobile']; ?></td>
            <td>₹<?php echo $list['payout_amount']; ?></td>
            <td><?php echo $list['basic_rate']; ?></td>
            <td><?php echo $list['source']; ?></td>
			 <td><?php echo $list['scheme_name']; ?></td>
            <td><?php echo $list['payout_type']; ?></td>
            <td><?php echo $list['payment_type']; ?></td>

            <td><?php echo $list['interest_days']; ?></td>
			 <td><?php echo $list['redemption_status_name']; ?></td>
			 <td><?php echo $list['partner_name']; ?></td>
			 <td><?php echo json_encode($api_response); ?></td>
			
   
        <?php
		/* echo '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#'.$list['lendsocial_lender_payout_schedule_table_id'].'">
   View
</button></td>'; */
    }
} else {
    ?>
    <tr>
        <td colspan="8">No records found</td>
    </tr>
    <?php
}
?>

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


<script>
function update_underprocess_status_v2(ids,payment_type,investment_no){
		const newStatus = 4; // 4->"redeemed" ;  this is a next step after after Bank File is generated	
			var remarks = $("#reference"+ids).val();
			if(remarks==" " || remarks==""){
				alert("Please Enter Remarks");
				return false;
			}
		//	alert("--"+remarks+"--");
			/************starting of ajax here********/
			// Make an AJAX request
        $.ajax({
            type: 'POST',
            url: '../surge/update_investment_status_v2',
          //  data: { ids: reinvestment_id, status: newStatus, remarks:encodeURIComponent(remarks) },
		   data: { ids: ids, status: newStatus, payment_type: payment_type, investment_no:investment_no,remarks:encodeURIComponent(remarks) },
            success: function(response) {
				var jsonData = JSON.parse(response);
                if (jsonData.status==1) {
                    alert(jsonData.msg);
					  location.reload();
                } else {
                  alert(jsonData.msg);
                }
            },
            error: function() {
                alert('Error occurred during the AJAX request');
            }
        }); /****************ending of ajax here********/
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
	$(document).ready(function() {
		$('#example').DataTable({
			"paging":   false,
			"searching": false,
			"showNEntries" : false,
		});

	} );
</script>
