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
				
					<th style="width: 10px">Sno.</th> 
					<th style="width: 180px">First Name</th>
					<th style="width: 180px">Last Name</th>
					<th style="width: 180px">Email</th>
					<th style="width: 10px">Mobile</th>
					 <th style="width: 10px">Partner </th> 
					
						<th style="width: 200px">Role</th>
						<th style="width: 200px">Created Date</th>
					<th style="width: 70px">Status</th>
					<th style="width: 100px">Option</th>
							
				

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
					
			<td><?php echo $list['fname']; ?>
            <td><?php echo $list['lname']; ?></td>
			<td><?php echo $list['email']; ?></td>
            <td><?php echo $list['mobile']; ?></td>
			<td><?php echo $list['partner_name'];  ?> </td>
			 <td><?php echo $list['role_name']; ?></td>
			 <td><?php echo $list['created_date']; ?></td>
			<td><?php echo ($list['status']=="1"? "Active" : "Inactive" );  ?> </td>
           <td><a class="btn btn-primary" href="..//surge/add_user_form?id=<?php echo $list['admin_id']; ?>">Edit</a></td>
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
