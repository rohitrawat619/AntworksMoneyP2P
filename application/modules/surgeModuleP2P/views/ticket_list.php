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
	<div class="box">

		<div class="box-header with-border">
			<?=getNotificationHtml();?>
		</div>
	

		<!-- /.box-header -->
		<div class="box-body">
			<table id="example" class="table table-striped table-bordered" >
				<thead>
				<tr>
				<!----	<th style="width: 10px">SNo.</th> --->
					<th style="width: 4px">Ticket ID</th>
					<th style="width: 60px">Title</th>
					<th style="width: 400px">Description</th>
					<th style="width: 10px">Status</th>
					 <th style="width: 10px">Priority </th> 
					 <th style="width: 10px">User Name</th> 
					<th style="width: 20px">Created Date</th>
					<th style="width: 20px">Updated Date</th>
					<th style="width: 40px">Details</th>
				
				

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
			<!----
            <td><?php echo $i++; ?></td>
					---->
			<td>#<?php echo $list['ticket_id']; ?>
            <td><?php echo $list['title']; ?></td>
			<td><?php echo $list['description']; ?></td>
            <td><?php echo $list['status']; ?></td>
			<td><?php echo $list['priority'];  ?> </td>
			<td><?php echo $list['partner_name_first']."".$list['partner_name_last'];  ?> </td>
            <td><?php echo $list['created_at']; ?></td>
			  <td><?php echo $list['updated_at']; ?></td>
				
          <td><a class="btn btn-primary" href="../surge/ticket_detail_form?id=<?php echo base64_encode($list['ticket_id']); ?>">View</a></td>
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
