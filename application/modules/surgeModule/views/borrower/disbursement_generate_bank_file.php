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
			<table id="example" class="table table-bordered table-hover box" >
				<thead>
				<tr>
                        <th>S.no.</th>
                        <th>Created Date</th>
						<th>Select</th>
                        <th>Borrower Id</th>
                        <th>Borrower Name</th>
                        <th>Loan No</th>
                        <th>Mobile</th>
                        <th>Amount</th>
                        <th>Basic Rate</th>
                    </tr>
				
				
				</thead>
				<tbody>
                    <?php
                    if (@lists) {
                        $i = 1;
                        foreach ($lists as $list) {
                            if ($list['status'] == 1) {
                    ?>
                               <tr   onclick="toggleCheckbox('<?php echo $list['id']; ?>')" >
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($list['date_created'])); ?></td>
									<td><input type="checkbox" id="<?php echo $list['id']; ?>"></td>
                                    <td><?php echo $list['borrower_id']; ?></td>
                                    <td><?php echo $list['name']; ?></td>
                                    <td><?php echo $list['loan_no']; ?></td>
                                    <td><?php echo $list['mobile']; ?></td>
                                    <td>₹<?php echo $list['approved_loan_amount']; ?></td>
                                    <td><?php echo $list['approved_interest']; ?></td>
                                    
                                </tr>
                    <?php
                            }
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="8">No records found</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
<!-- <button class="btn btn-primary" onclick="confirmAndGetSelectedValues()">Generate Bank File</button> -->

<button class="btn btn-primary" onclick="confirmAndGetSelectedValues()">Generate Bank File</button>


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
<style>
        .unclickable {
            pointer-events: none;
        }
    </style>
<script>
        function confirmAndGetSelectedValues() {
			var currentDate = new Date();
				var formattedDate = currentDate.toISOString().slice(0, 19).replace('T', ' ');
    var checkboxes = $('input[type="checkbox"]:checked');
    
    if (checkboxes.length === 0) {
        alert("Please select at least one record to generate a Bank File");
    } else {
        var confirmed = window.confirm('Are you sure you want to generate Bank File?');

        if (confirmed) {
            var selectedValues = [];

            checkboxes.each(function() {
                selectedValues.push(this.id);
                $(this).addClass('processed'); // Add a class to mark it as processed
            });

            var selectedValuesAll = selectedValues.join(',');
			//alert(selectedValuesAll); return false;
            const newStatus = 3;
			//var confirmation=confirm("do you really want to generate bank file ? ");
        if(confirmed){
        $.ajax({
            type: 'POST',
            url: 'update_disburse_status',
            data: { ids: selectedValuesAll, status: newStatus },
            success: function(response) {
				console.log(response);
			
               var jsonData = JSON.parse(response);
                if (jsonData.status==1) {
                   alert(jsonData.message);
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
    }
</script>



<script>
    function toggleCheckbox(id) {
        var checkbox = document.getElementById(id);
		// alert(id);
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
