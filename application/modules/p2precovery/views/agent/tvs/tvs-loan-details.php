<?= getNotificationHtml(); ?>

<section class="content-header">
	<h1>
		<?php echo $pageTitle; ?>
	</h1>
</section>
<section class="content">
	<!-- Default box -->
	<div class="box">
		<div class="row">
			<?php if ($loan) { ?>
				<div class="col-md-12">
					<div class="col-md-6"></div>
					<div class="col-md-6"><input class="btn btn-primary" value="Call" type="button" onclick="return call_customer('<?=$loan['Mobile_No']?>', '<?=$loan['SL_NO']?>')"></div>

				</div>/
				<div class="col-md-12">
					<div class="col-md-6 profile-devider">
						<h3>Customer Details</h3>
						<div class="borrower-record">
							<div class="table-responsive">
								<table class="table bdr-rite">
									<tbody>
									<? foreach ($loan AS $key => $value) {?>
										<tr>
											<td><?=$key ?></td>
											<td><?=$value?></td>
										</tr>
									<? } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
                  <? if($comments){ foreach ($comments as $comment){
                  	echo  'Created Date-  '.$comment['created_date'].'--'.$comment['comment_data']; echo "<br>";
				  }}?>
				</div>
				<div class="col-md-12">
					<form id="tvsData" action="<? echo base_url('p2precovery/agentrecovery/saveTvsdata'); ?>" method="post">
					<div class="col-md-3">
						<div class="form-group">
							<label>Disposition Code</label>
							<select class="form-control" name="Disposition_Code">
								<option value="">Status</option>
								<option value="CB" <? if($loan_details['Disposition_Code'] == 'CB'){ echo "selected"; } ?>>CB (Call Back )</option>
								<option value="PTP" <? if($loan_details['Disposition_Code'] == 'PTP'){ echo "selected"; } ?>>PTP ( Promise to pay )</option>
								<option value="RTP" <? if($loan_details['Disposition_Code'] == 'RTP'){ echo "selected"; } ?>>RTP ( Refuse to pay )</option>
								<option value="BP" <? if($loan_details['Disposition_Code'] == 'BP'){ echo "selected"; } ?>>BP ( Broken Promise )</option>
								<option value="NC" <? if($loan_details['Disposition_Code'] == 'NC'){ echo "selected"; } ?>>NC ( No Contact )</option>
								<option value="DP" <? if($loan_details['Disposition_Code'] == 'DP'){ echo "selected"; } ?>>DP ( Dispute )</option>
								<option value="RNR" <? if($loan_details['Disposition_Code'] == 'RNR'){ echo "selected"; } ?>>RNR ( Ringing no response )</option>
								<option value="SWF" <? if($loan_details['Disposition_Code'] == 'SWF'){ echo "selected"; } ?>>SWF (Swiched off )</option>
								<option value="NR" <? if($loan_details['Disposition_Code'] == 'NR'){ echo "selected"; } ?>>NR ( No response )</option>
								<option value="NU" <? if($loan_details['Disposition_Code'] == 'NU'){ echo "selected"; } ?>>NU ( Not in use )</option>
								<option value="WN" <? if($loan_details['Disposition_Code'] == 'WN'){ echo "selected"; } ?>>WN (Wrong No )</option>
								<option value="REPOSSESED" <? if($loan_details['Disposition_Code'] == 'REPOSSESED'){ echo "selected"; } ?>>REPOSSESED ( Seized already )</option>
								<option value="OTS" <? if($loan_details['Disposition_Code'] == 'OTS'){ echo "selected"; } ?>>OTS ( One time Settlement )</option>
								<option value="WVR" <? if($loan_details['Disposition_Code'] == 'WVR'){ echo "selected"; } ?>>WVR ( Waiver Required )</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>PTP Dt</label>
							<input class="form-control" type="text" name="PTP_Dt" value="<?=$loan_details['PTP_Dt'] ?>"></div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>PTP AMOUNT</label>
							<input class="form-control" type="text" name="PTP_AMOUNT" value="<?=$loan_details['PTP_AMOUNT'] ?>"></div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>PTP MODE IF CONTACTED ( NOR / STB / RB / Veh Surrender )</label>
							<select class="form-control" name="PTP_MODE">
								<option value="">Status</option>
								<option value="NOR" <? if($loan_details['PTP_MODE'] == 'NOR'){ echo "selected"; } ?>>NOR</option>
								<option value="STB" <? if($loan_details['PTP_MODE'] == 'STB'){ echo "selected"; } ?>>STB</option>
								<option value="RB" <? if($loan_details['PTP_MODE'] == 'RB'){ echo "selected"; } ?>>RB</option>
								<option value="Veh Surrender" <? if($loan_details['PTP_MODE'] == 'Veh Surrender'){ echo "selected"; } ?>>Veh Surrender</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Next Actions If Not Answered</label>
							<input class="form-control" type="text" value="<?=$loan_details['Next_action'] ?>" name="Next_action"></div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Payment Mode If Accepted ( Link /Pick Up Req Or Others )</label>
							<input class="form-control" type="text" value="<?=$loan_details['Payment_Mode'] ?>" name="Payment_Mode"></div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Paid Amount</label>
							<input class="form-control" type="text" value="<?=$loan_details['Paid_Amount'] ?>" name="Paid_Amount"></div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Paid Dt</label>
							<input class="form-control" type="text" value="<?=$loan_details['Paid_Dt'] ?>" name="Paid_Dt"></div>
					</div>

					<div class="col-md-8">
						<div class="form-group">
							<label>Remarks - Dispute / Recon / Repossesed )</label>
							<textarea name="remarks" placeholder="Remarks"
														  class="form-control"></textarea></div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="hidden" name="tvs_id" value="<? echo $loan['id'];?>">
							<input type="button" name="saveremark" id="saveremark" value="Save"
													   class="btn btn-primary">
						</div>
					</div>
					</form>
				</div>
			<?php } ?>
		</div>
	</div>
</section>
	<script>
		$("#callNow").click(function (){
			alert("wait call is in processing");
		})
	</script>

	<script>
		$("#saveremark").click(function (){
			$.ajax({
				type: "post",
				url: "<?php echo base_url(); ?>p2precovery/agentrecovery/saveTvsdata",
				data: $("#tvsData").serialize(),
				success: function(result){
					var response = JSON.parse(result)
					if(response.status == 1)
					{
						alert(response.msg);
						window.close();
					}
					else{
						alert(response.msg);
					}
				}
			});
		})
	</script>

<script>
	function call_customer(phone, tvs_sl_NO)
	{
		$.ajax({
			type: "post",
			url: "<?php echo base_url(); ?>callingmodule/calling/call",
			data: {'phone':phone, 'tvs_sl_NO':tvs_sl_NO},
			success: function(result){
				console.log(result);
			}
		});
	}
</script>
