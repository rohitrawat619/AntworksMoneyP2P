<div class="row">
	<section class="content-header">
		<h1>
			<?php echo $pageTitle; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">KYC Rule</li>
		</ol>
	</section>
<!-- Main content -->
<section class="content">
	
	<div class="box">
		<?=getNotificationHtml();?>
		<!-- /.box-header -->
		<div class="box-body">
			<table class="table table-bordered">
				<tr>
					<th style="width: 70px">Sr. No.</th>
					<th>KYC Name</th>
					<th>PAN KYC</th>
					<th>Aadhar KYC</th>
					<th>Aadhar OKYC</th>
					<th>Bank Account KYC</th>
					<th>Liveliness KYC</th>
					<th>Cross Matching Rule</th>
				</tr>
				
				<? if($product_kyc_rule){?>
                    <form method="post" action="<?= base_url('kyc_module/action') ?>" enctype="multipart/form-data">					
					<? $i = 1; 
					foreach ($product_kyc_rule as $list){?>
					<tr>
						<td><?=$i++;?></td>
						<input type="hidden" name="id[]" value="<?= $list['id']?>"> 
						<td><?=$list['kyc_name'];?></td>
						<td> <input type="checkbox" name="pan_kyc_<?= $list['id']?>" value="ok" <? if ($list['pan_kyc'] == 'ok') { echo "checked"; } ?>></td>
						<td> <input type="checkbox" name="aadhar_KYC_<?= $list['id']?>" value="ok" <? if ($list['aadhar_KYC'] == 'ok') { echo "checked"; } ?>></td>
						<td> <input type="checkbox" name="aadhar_OKYC_<?= $list['id']?>" value="ok" <? if ($list['aadhar_OKYC'] == 'ok') { echo "checked"; } ?>></td>
						<td> <input type="checkbox" name="bank_account_kyc_<?= $list['id']?>" value="ok" <? if ($list['bank_account_kyc'] == 'ok') { echo "checked"; } ?>></td>
						<td> <input type="checkbox" name="liveliness_kyc_<?= $list['id']?>" value="ok" <? if ($list['liveliness_kyc'] == 'ok') { echo "checked"; } ?>></td>
						<td> <input type="checkbox" name="cross_matching_rule_<?= $list['id']?>" value="ok" <? if ($list['cross_matching_rule'] == 'ok') { echo "checked"; } ?>></td>
						
					</tr>
				<?} ?>
				<tr><td colspan="7"></td> <td>
				<input type="hidden" name="product_id" value="<?= $productId?>"> 
				<input type="submit" name="submit" class=" btn btn-primary"></td></tr>
				</form>
				<? } else{?>
					<tr>
						<td colspan="4">No records found</td>
					</tr>
				<?} ?>
			</table>
		</div>
		<!-- /.box-body -->
		
		      <div class="box-footer clearfix">
				<nav aria-label="Page navigation">
						<ul class="setPaginate pull-right pagination">
						  <li> <?php echo  @$links; ?> </li>
						</ul>
					</nav>
				</div>
	</div>
      
</section>
</div>
<!-- /.content -->

<script>
$(document).ready(function() {
        $(document).on('click', '.status_active', function() {
			row_id = $(this).attr('row_id');
            status = $(this).attr('status');
            if (status == '1') {
                var r = confirm("Are you sure you want to Activate");
            } else {
                var r = confirm("Are you sure you want to De-Activate");
            }
            if (r == true){
                $.ajax({
					url: '<?php echo base_url();?>bizhub_app/updateStatus/',
					type: 'POST',
					datatype: 'json',
					data: {'row_id':row_id,'status':status},
					success: function(response){
						if(response){
						obj = JSON.parse(response);
						$('.row_status_'+row_id).html(obj.data);	
						}
					},
					error: function(){
					   
					}
				});
            }
        });
		
		
		
	});
</script>