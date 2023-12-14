function sendOtpchangemobile() {
	var mobile = $("#mobile").val();
	if(mobile == '' || mobile.length != 10)
	{
		alert("Please enter valid Mobile number");
		return false;
	}
	else
	{
		$.ajax({
			async: true,
			type: "POST",
			url: baseURL+"lenderresponse/requestChangemobile",
			data: {mobile:mobile},
			success: function (data) {
				var response = JSON.parse(data);
				if(response.status == 1)
				{
					$("#send_otp_user").addClass("hidden");
					$("#verify_mobile").removeClass("hidden");
					$("#button_send_otp").addClass("hidden");
					$("#button_verify_otp").removeClass("hidden");
					alert("OTP send on your mobile please verify same");
				}
				else{
					alert(response.msg);
				}
			}
		});
	}

}

function verifyOtpchangemobile() {
	var mobile = $("#mobile").val();
	var otp = $("#otp").val();
	if(otp == '' || otp.length != 6)
	{
		alert("Please enter valid OTP !!");
		return false;
	}
	else
	{
		$.ajax({
			async: true,
			type: "POST",
			url: baseURL+"lenderresponse/verifyChangemobile",
			data: {otp:otp, mobile:mobile},
			success: function (data) {
				var response = JSON.parse(data);
				if(response.status == 1)
				{
					alert(response.msg);
					window.location.reload();
				}
				else{
					alert(response.msg);
					return false;
				}
			}
		});
	}
}

function payOutlender() {
	var current_lender_amount = $("#avilable_amount").val();
	var payout_amount = $("#amount").val();
	if(payout_amount == '')
	{
       alert("Please enter amount");
       return false;
	}
	if(payout_amount > current_lender_amount)
	{
       alert("Sorry you don't have sufficient balance in your account");
       return false;
	}
	else{
      return  true;
	}

}
