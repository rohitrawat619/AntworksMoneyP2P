<style type="text/css">
	.row {
		margin-right: -15px;
		margin-left: -8px;
	}

	form label {
		display: inline-block;
		width: 100px;
	}

	form div {
		margin-bottom: 10px;
	}

	.error {
		color: red;
		margin-left: 5px;
	}

	.msg {
		color: red;
		margin-left: 5px;
	}

	label.error {
		display: inline;
	}
</style>

<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-header with-border"><?= getNotificationHtml(); ?></div>
		<div class="box-body">
			<div class="row">
				<div class="m-t-30">
					<div class="right-page-header">
						<form id="first_form" method="post" action="<?php echo base_url(); ?>p2precovery/insertEmi">
							<div class="col-md-12"><h4 class="modal-title" id="myModalLabel">Pay EMI</h4></div>
							<input type="hidden" name="emi_id" value="<?= @$emi[0]['emi_detil']->id; ?>">
							<input type="hidden" name="loan_id" value="<?= $emi[0]['bid_registration_id']; ?>">
							<div class="col-md-4">
								<div class="form-group">
									<lable for="referece">Referece No:</lable>
									<input type="text" name="referece" class="form-control" id="referece">
									<!--<span id="mylocation" class="error"></span> -->
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<lable for="amount">Amount:</lable>
									<input type="text" name="amount" class="form-control" id="amount">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<lable for="bank">Bank:</lable>
									<input type="text" name="bank" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<lable for="emi_date">Date:</lable>
									<div id="filterDate2">
										<div class="input-group date" data-date-format="yyyy-mm-dd">
											<input type="text" name="emi_date" i class="form-control"
												   placeholder="yyyy-mm-dd" id="emi_date">
											<div class="input-group-addon">
												<span class="glyphicon glyphicon-th"></span>
											</div>
										</div>

									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<lable for="mode">Payment Mode:</lable>
									<select class="form-control" name="mode" id="mode">
										<option value="">Select</option>
										<option value="Online">Online</option>
										<option value="Link">Razorpay Link</option>
										<option value="Razorpay NACH">Razorpay NACH</option>
										<option value="Sign Desk NACH">Sign Desk NACH</option>
										<option value="Recovery Agency">Recovery Agency</option>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<lable for="remarks">Remarks:</lable>
									<textarea name="remarks" class="form-control" id="remarks"></textarea>
								</div>
							</div>

							<div class="col-md-6 ">

								<input type="submit" id="submtbtn" name="submit" value="Submit"
									   class="btn btn-primary pull-right">
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>
		<!-- /.box-body -->
		<div class="box-footer">

		</div>
		<!-- /.box-footer-->
	</div>
	<!-- /.box -->

</section>

<script type="text/javascript">

    $('#first_form').submit(function () {
        var referece = $('#referece').val();
        var amount = $('#amount').val();
        var emi_date = $('#emi_date').val();
        var mode = $('#mode').val();
        var remarks = $('#remarks').val();
        var isValid = true;

        $(".error").remove();

        if (referece.length < 1) {
            $('#referece').after('<span class="error">Please enter your referece no</span>');
            isValid = false;
        }
        if (mode == "") {
            $('#mode').after('<span class="error">Please select mode</span>');
            isValid = false;
        }
        if (emi_date.length < 1) {
            $('#emi_date').after('<span class="error">Please enter date</span>');
            isValid = false;
        } else {
            var regEx = /([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/;
            var validamount = regEx.test(emi_date);
            if (!validamount) {
                $('#emi_date').after('<span class="error">Enter a valid date this format(yyyy-mm-dd)</span>');
                isValid = false;
            }
        }

        if (amount.length < 1) {
            $('#amount').after('<span class="error">Please enter your amount</span>');
            isValid = false;
        } else {
            var regEx = /^[0-9]/;
            var validamount = regEx.test(amount);
            if (!validamount) {
                $('#amount').after('<span class="error">Enter a valid amount</span>');
                isValid = false;
            }
        }
        if (remarks.length < 1) {
            $('#remarks').after('<span class="error">Please enter remarks</span>');
            isValid = false;
        }
        if (isValid == true) {
            return true;
        } else {
            return false;
        }
    });

</script>
