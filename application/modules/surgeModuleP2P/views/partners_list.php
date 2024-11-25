<!-- Main content -->
<style type="text/css">
	
	.myform-inline {margin-top: 3px;}
	.myform-inline .form-group input {
		max-width: 136px;
	}
	.list-img{
		width:90px;
		
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
					<th style="width: 10px">Partner's ID</th>
					<th style="width: 180px">Company Name</th>
					<th style="width: 180px">Address</th>
					<th style="width: 10px">Email</th>
					 <th style="width: 10px">Mobile </th> 
					<th style="width: 200px">Created Date</th>
						<th style="width: 200px">Logo</th>
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
		//print_r($list[1]);
	//	$list = $hotLeadList_data[];
        ?>
        <tr>
			<!----
            <td><?php echo $i++; ?></td>
					---->
			<td><?php echo $list['VID']; ?>
            <td><?php echo $list['Company_Name']; ?></td>
			<td><?php echo $list['Address']; ?></td>
            <td><?php echo $list['Email']; ?></td>
			<td><?php echo $list['Phone'];  ?> </td>
		
            <td><?php echo $list['date_created']; ?></td>
			<td> <img class="list-img" src="<?php echo str_replace("D:/public_html/antworksp2p.com","",$list['logo_path']); ?>" alt="Logo NA" id="partner_logo_imagePreview" /></td>
			<td><?php echo ($list['status']=="1"? "Active" : "Inactive" );  ?> </td>
           <td><a class="btn btn-primary" href="../surge/add_partners_form?id=<?php echo $list['VID']; ?>">Edit</a></td>
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
