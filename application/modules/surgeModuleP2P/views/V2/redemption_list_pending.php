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
            <th>Detail</th>
					 
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
        ?>
        <tr>
			
         	
		
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
            <td> 
                <?php
				if($list['payout_status'] == 0) {
                     echo"<span class='btn btn-success' onclick=approve_redemption_request_v2('".$list['lendsocial_lender_payout_schedule_table_id']."','".$list['payment_type']."','".$list['investment_No']."') >Approve</span>  ";        
                }else{
					echo "-";
				}
                 
                       
                         ?>
                      
            </td>
		</td> 
          <!--  <td><a href="<?php echo base_url(''); ?>abcddetails?id=<?php echo $list['id']; ?>">View</a></td>
        </tr> -->
        <?php
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
		function approve_redemption_request_v2(ids,payment_type,investment_no){
			const newStatus = 5; // // 5->"Generate Bank File pending";  this is a next step after approved the redemption request
			const request_id = "<?php echo $request_id; ?>";
					
			/************starting of ajax here********/
			// Make an AJAX request
        $.ajax({
            type: 'POST',
            url: '../surge/update_investment_status_v2',
            data: { ids: ids, status: newStatus, payment_type: payment_type, investment_no:investment_no, request_id:request_id },
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
<script>
	$(document).ready(function() {
		$('#example').DataTable({
			"paging":   false,
			"searching": false,
			"showNEntries" : false,
		});

	} );
</script>
