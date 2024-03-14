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
					<th style="width: 10px">ID</th>
					<th style="width: 10px">firstName</th>
					<th style="width: 10px">Email</th>
					<th style="width: 10px">Mobile </th>
					<th style="width: 70px">Date</th>
					<th style="width: 70px">Modified Date</th>
					
					<th style="width: 100px">More Details</th>
				

				</tr>
				</thead>
				<tbody>
				<? if(@userData_list){
					$i=1;
					foreach ($userData_list as $list){?>
						<tr>
							<td><?php echo $i++;?></td>
							<td><?php echo $list['firstName'];?></td>
							<td><?php echo $list['email'];?></td>
							<td><?php echo $list['mobile'];?></td>
							<td><?php echo $list['created_date'];?></td>
							<td><?php echo $list['date_modified'];?></td>
							<td><span class="badge bg-red"><a href="<?php echo base_url('');?>Premiumplan/premiumplanuserDetail?id=<?=$list['id'];?>">More Details</a></span></td>
							
						
						</tr>
					<?}} else{?>
				<tr>
					<td colspan="4">No records found</td>
				</tr></tbody>
				<?} ?>
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
