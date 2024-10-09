<?php
//echo"<pre>"; print_r($lists);
//$this->session->set_flashdata('message', 'Your form was successfully submitted!');
?>
			<?php if ($this->session->flashdata('message')): ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('message'); ?>
    </div>
<?php endif; ?>
<div class="col-md-12 col-xs-12">
    <div class="surge-list"> <a href='lenderDashboard'> Home</a>
        <div class="col-md-12 col-xs-12">
            <h2 class="dash-hd">Loan Request List (<?php echo htmlspecialchars($lists['investmentNo']); ?>)</h2>
        </div>
		
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S No.</th>
                    <th>Borrower ID</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Request Date</th>
					<th>Status</th>
                    <?php if(count($lists['investmentRequestList']) > 0) { ?>
                        <th>
                            <label for="selectAll">Select All<br> 
                                <input type="checkbox" id="selectAll" value="" checked onclick="toggleCheckboxes(this);" >
                            </label>
                        </th>
                    <?php } else { ?>
                        <th></th> 
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php 
				
							
							
							
				if(count($lists['investmentRequestList']) > 0) { 
				
						
				    $processedPayloads = [];
                    for($i = 0; $i < count($lists['investmentRequestList']); $i++) { 
					$list = $lists['investmentRequestList'][$i];
					
					$amountFinal = (($list->amount)+$amountFinal);
					
					$borrower_id = $list->borrower_id;
					$borrower_name = $list->borrower_name;
					$request_date = $list->request_date;
					$request_status = $list->request_status;
					$borrower_proposed_list_id = $list->borrower_proposed_list_id;
					$batch_id = $list->batch_id;
					$lender_id = $list->lender_id;
					$investment_no = $list->investment_no;
					
					$requestPayload = base64_encode(encrypt_string($lender_id."||".$batch_id."||".$investment_no));
					
					
					$processedPayloads[] = $requestPayload;
		
		
					echo "<input type='hidden' id='requestPayload' value='".$requestPayload."'>";
					?>
                    <tr>
                        <td><?php echo ($i + 1); ?></td>
                        <td><?php echo  $borrower_id; ?></td>
                        <td><?php echo (toSentenceCaseHelper($borrower_name)); ?></td>
                        <td><?php echo ($lists['investmentRequestList'][$i]->amount); ?></td>
                        <td><?php echo timeAgoHelper(strtotime($request_date)); ?></td>
						<td><?php echo toSentenceCaseHelper($request_status); ?></td>
                        <?php if(count($lists['investmentRequestList']) > 0) { ?>
                            <td><input value="<?php echo $borrower_proposed_list_id; ?>" checked type="checkbox" class="item-checkbox"></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
				<tr>
				 <td colspan="3" class="text-center">Total Amount</td>
				<td colspan="1" class="text-center"> <?php echo $amountFinal; ?> </td> </tr>
                <tr>
                    <td colspan="7" class="text-center">
                        <input type="button" onclick="confirmAndGetSelectedValues();" class="btn btn-success mr-2" value="Approve">
                        
                    </td>
                </tr>
                <?php } else { ?>
                <tr> 
                    <td colspan="6" class="text-center">Data Not Found</td>
                </tr>
                <?php }
					//echo"<pre>";	print_r($processedPayloads);
				?>
            </tbody>
        </table>
    </div>
</div>

<script>
function toggleCheckboxes(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"].item-checkbox');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = source.checked;
    }
}
</script>

<script>
    function confirmAndGetSelectedValues() {
        // Get the current date and time
        var currentDate = new Date();
        var formattedDate = currentDate.toISOString().slice(0, 19).replace('T', ' '); // Format: YYYY-MM-DD HH:MM:SS

        var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
        
        if (checkboxes.length == 0) {
            alert("Please select at least one record.");
        } else {
            var confirmed = window.confirm('Are you sure you want to proceed?');

            if (confirmed) {
                // Proceed to get selected values
                var selectedValues = [];

                checkboxes.forEach(function(checkbox) {
					if(checkbox.value!=""){
                    selectedValues.push(checkbox.value);
                   // checkbox.disabled = true; // Disable the checkbox
					}
                });

                var selectedValuesAll = selectedValues.join(',');
              // alert(selectedValuesAll); return false;
			  
				var requestPayload = $("#requestPayload").val();
				
				
                /************starting of ajax here********/
				
				var dataObject = {
				borrower_proposed_list_ids: selectedValuesAll,
				status: "approved",
				requestPayload: requestPayload
				};

var jsonString = JSON.stringify(dataObject);
var base64String = btoa(jsonString);

                // Make an AJAX request
                $.ajax({
                    type: 'POST',
                    url: '../LendSocial/e_sign_borrower_proposed_list_send_otp', // investmentRequestListProcessing
                 //   data: { borrower_proposed_list_ids: selectedValuesAll, status: "approved", requestPayload: requestPayload },
				 data : { requestPayload: base64String},
                    success: function(response) {
						
                       var jsonData = JSON.parse(response);
                        if (jsonData.status == 1) {
                            alert(jsonData.msg);
							window.location.href = 'e_sign_borrower_proposed_list_otp_form?requestPayloadParm='+jsonData.requestPayloadParm;
							//location.reload();
                            
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
</script>

