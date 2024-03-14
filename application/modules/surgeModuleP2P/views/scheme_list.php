<!-- Main content -->
<style type="text/css">
	strong	{
		background: #fafafa;
		color: #666;
		margin-left: 0;
		border-top-left-radius: 4px;
		border-bottom-left-radius: 4px;
		position: relative;
		float: left;
		padding: 6px 12px;
		margin-left: -1px;
		line-height: 1.42857143;
		text-decoration: none;
		border: 1px solid #ddd;
	}
	.myform-inline {margin-top: 3px;}
	.myform-inline .form-group input {
		max-width: 136px;
	}
</style>

<section class="content">
	<div class="box" >

		<div class="box-header with-border">
			<?=getNotificationHtml();?>
		</div>
	

		<!-- /.box-header -->
		<div class="box-body" >
			<table id="example" class="table table-striped table-bordered" >
				<thead style="background-color:white;">
				<tr>
				<th style="width: 10px">SNo.</th>
				 <th style="width: 10px">Partner's Name</th> 
					<th style="width: 180px">Scheme Name</th>
					<th style="width: 180px">Min Inv Amount</th>
					<th style="width: 10px">Max Inv Amount</th>
					 <th style="width: 10px">Aggregate Amount</th> 
					  <th style="width: 10px">Lockin</th> 
					  <th style="width: 70px">Lockin Period</th>
					   <th style="width: 10px">Cooling Period</th> 
					<th style="width: 200px">Interest Rate</th>
					<th style="width: 70px">Hike Rate</th>
					<th style="width: 70px">Interest_Type</th>
					<th style="width: 70px">Withdrawal Anytime</th>
					<th style="width: 70px">Pre_Mat_Rate</th>
					<th style="width: 70px">Auto Redeem</th>
					<th style="width: 70px">Status</th>
					<th style="width: 70px">Created Date</th>
					<th style="width: 70px">Action</th>
					 
				</tr>
				
				
				</thead>
				<tbody style="background-color:white;">
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
				
			<td><?php echo $list['partners_name']; ?></td>
			<td><?php echo $list['Scheme_Name']; ?></td>
			<td><?php echo $list['Min_Inv_Amount']; ?></td>
			<td><?php echo $list['Max_Inv_Amount']; ?></td>
			<td><?php echo $list['Aggregate_Amount']; ?></td>
			<td><?php echo $list['Lockin']; ?></td>
			<td><?php echo $list['Lockin_Period']; ?></td>
			<td><?php echo $list['Cooling_Period']; ?></td>
			<td><?php echo $list['Interest_Rate']; ?></td>
			<td><?php echo $list['hike_rate']; ?></td>
			<td><?php echo $list['Interest_Type']; ?></td>
			<td><?php
				if($list['Withrawl_Anytime']==1) {
                     echo"<span>Yes</span>  ";        
                }else{
					 echo"<span >No</span>  "; 
				}?></td>
			<td><?php echo $list['Pre_Mat_Rate']; ?></td>
			<td>
			<?php
				if($list['Auto_Redeem']==1) {
                     echo"<span>Yes</span>  ";        
                }else{
					 echo"<span >No</span>  "; 
				}?>
			</td>
			<td>
			<?php
				if($list['status'] == 1) {
                     echo"<span> Active</span>  ";        
                }else{
					 echo"<span > Inactive</span>  "; 
				}?>
			</td>
			<td><?php echo $list['created_date']; ?></td>
			
			
		</td>
         <td><a class="btn btn-primary" href="../surge/add_scheme_form?id=<?php echo $list['id']; ?>">Edit</a></td>
        </tr>
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
