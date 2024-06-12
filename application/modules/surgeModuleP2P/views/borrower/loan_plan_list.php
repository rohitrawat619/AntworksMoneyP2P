<!-- Main content -->


<section class="content">
	<div class="box">

		<div class="box-header with-border">
			<?=getNotificationHtml();?>
		</div>
	

		<!-- /.box-header -->
		<div class="box-body">
			<table id="example" class="table table-striped table-bordered" >
					<thead>
					<tr>
					<th style="width: 10px">Sno.</th> 
					<th >Amount</th>
					<th >Interest Rate (% p.a)</th>
					<th >Tenure (days)</th>
					<th style="width: 180px" >Partner Name</th>
					<th >Created Date</th>
					<th >Option</th>
					</tr>
					</thead>
				<tbody>
				<?php
if (@lists) {
    $i = 1;
	//	print_r($lists);
    foreach($lists as $list) {

        ?>
        <tr>
			
            <td><?php echo $i++; ?></td>
					
			<td>&#8377;<?php echo $list['amount']; ?>
            <td><?php echo $list['interest']; ?>%</td>
			<td><?php echo $list['tenor']; ?></td>
			<td><?php echo $list['partner_name']; ?></td>
			 <td><?php echo date('d-M-Y h:i A',strtotime($list['created_at'])); ?></td>
           <td><a class="btn btn-primary" href="../borrower/add_loan_plan_form?id=<?php echo $list['id']; ?>">Edit</a></td>
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
