<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>

function acceptAlphabetsOnly() {
      var inputValue = this.value;
      var filteredValue = inputValue.replace(/[^a-zA-Z]/g, "");
      this.value = filteredValue;
    }
	 $("#lname").on("keyup", acceptAlphabetsOnly);
	$("#saveremark").click(function () {
		if ($("#status").val() == '') {
			alert("Please Choose status");
			return false;
		}
		if($("#status").val() == 6 && $("#datetimepicker").val() == "")
		 {
			alert("Please select Reminder");
			return false;
		 }
		if ($("#comment").val() == '') {
			alert("Please enter comment");
			return false;
		}
		
			if($("#status").val()==6 || $("#status").val()==2){
			if ($("#lname").val() == '') {
			alert("Please enter last name");
			return false;
			}	}
		
		if ($("#new_to_cibil").val() == '') {
			alert("Please select New to Cibil");
			return false;
		}
		$("#saveremark").hide();
		$.ajax({
			type: "post",
			url: "<?php echo base_url(); ?>premiumplan/userdetailUpdate/",
			data: $("#app_user_data_form").serialize(),
			//alert(data);
			beforeSend: function () {
				$(".preloader").show();
			},
			complete: function () {
				$(".preloader").hide();
			},
			success: function (result) {
				var response = JSON.parse(result)
				console.log(response);
				// alert(response);
				$('.csrf-security').val(response.csrfHash);
				if (response.status == 1 && response.next_lead == true) {
					alert(response.msg+" ( "+response.block+" )");
					if (response.batch_no) {
						window.location.href = "<?php echo base_url(); ?>premiumplan/premiumplanuserDetail?id=" + response.id + "&batch_no=" + response.batch_no;
					} else {
						window.location.href = "<?php echo base_url(); ?>premiumplan/premiumplanuserDetail?id=" + response.id;
					}

				} else {
					alert(response.msg);
				}
			}
		});
	});




	


</script>

<script>
	//**************starting of hotlead js******************//
	$("#saveRemarkHotLead").click(function () {
		if ($("#hotLeadList").val() == '') {
			alert("Please Select hot lead status");
			return false;
		}
	
		if ($("#comment").val() == '') {
			alert("Please enter comment");
			return false;
		}
		
		if ($("#lname").val() == '') {
			alert("Please enter last name");
			return false;
			}
		
	
	//	$("#saveRemarkHotLead").hide();
		$.ajax({
			type: "post",
			url: "<?php echo base_url(); ?>premiumplan/hotLeadUserDetailUpdate/",
			data: $("#app_user_data_form").serialize(),
			//alert(data);
			beforeSend: function () {
				$(".preloader").show();
			},
			complete: function () {
				$(".preloader").hide();
			},
			success: function (result) {
				var response = JSON.parse(result)
				console.log(result);// return false;
				// alert(response);
				$('.csrf-security').val(response.csrfHash);
				if (response.status == 1) {
					alert(response.msg);
						window.location.href = "<?php echo base_url(); ?>premiumplan/hotLeadList";
				} else {
					alert(response.msg);
				} 
			}
		});
	});
	//**********************ending of hotlead js**************/
</script>


<script>
	$("#saveremark_1").click(function () {

		$("#saveremark").hide();
		$.ajax({
			type: "post",
			url: "<?php echo base_url(); ?>premiumplan/test_/",
			data: $("#app_user_data_form").serialize(),
			//alert(data);
			beforeSend: function () {
				$(".preloader").show();
			},
			complete: function () {
				$(".preloader").hide();
			},
			success: function (result) {
				var response = JSON.parse(result)
				console.log(response);
				// alert(response);
				$('.csrf-security').val(response.csrfHash);
				if (response.status == 1 && response.next_lead == true) {
					alert(response.msg);

				} else {
					alert(response.msg);
				}
			}
		});
	});


	//$("#call_now").click(
	function call_now(){ 
		var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
		var csrfHash = $('.csrf-security').val();
		var mobile = $("#mobile").val();
		$.ajax({
			type: "post",
			url: "<?php echo base_url(); ?>callingmodule/call",
			data: {[csrfName]: csrfHash, mobile: mobile},
			beforeSend: function () {
				$(".preloader").show();
			},
			complete: function () {
				$(".preloader").hide();
			},
			success: function (result) {
				var response = JSON.parse(result)
				console.log(response);
				$('.csrf-security').val(response.csrfHash);
				alert(response.msg);
			}
		});
	}
</script>
<script>
	$("#sendtosms").click(function () {
		var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
		var csrfHash = $('.csrf-security').val();
		var customermobile = $("#mobile").val();
		var lead_id = $("#id").val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>premiumplan/sendcustomernotification_PL",
			data: "mobile=" + customermobile + "&lead_id=" + lead_id,
			success: function (result) {
				if (result == 'success') {
					$('#sendtosms').hide();

					alert("Message Sent successfully");
				} else {
					alert('Error to send msg Please contact to the DEVELOPER');
				}
			}
		});
	});

	$("#sendtosmsPremium").click(function () {
		var id = $("#id").val();
		var name = $("#fname").val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>premiumplan/Sendsms/sendSmstoPremium_membershipplan",
			data: {id: id, name: name},
			success: function (result)
			var response = JSON.parse(result)
			console.log(response);
			$('.csrf-security').val(response.csrfHash);
		{

			if (result == 'success') {

				$('#sendtosmsPremium').hide();
				alert("Message Sent successfully");
			} else {
				alert('Error to send msg Please contact to the DEVELOPER');
			}
		}
	})
		;
	});

  
</script>


<script>
	$("#sendPaymentlink").click(function () {
		$.ajax({
			type: "post",
			url: "<?php echo base_url(); ?>premiumplan/Razorpayant",
			data: $("#app_user_data_form").serialize(),
			success: function (result) {
				var response = JSON.parse(result)
				$('.csrf-security').val(response.csrfHash);
				if (response.status == 1) {
					alert(response.msg);
				} else {
					alert(response.msg);
				}

			}
		});

	})
</script>

<script>
	$("#send_link").click(function () {
		var name = $("#fname").val();
		var email = $("#email").val();
		var mobile = $("#mobile").val();
		var payment_service = $("#payment_service").val();
		var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
		var csrfHash = $('.csrf-security').val();
		$.ajax({
			type: "post",
			url: "<?php echo base_url(); ?>Payment_links/send_payment_link",
			data: {fname: name, email: email, mobile: mobile, payment_service: payment_service, [csrfName]: csrfHash},
			success: function (result) {
				var response = JSON.parse(result)
				$('.csrf-security').val(response.csrfHash);
				if (response.status == 1) {
					alert(response.msg);
				} else {
					alert(response.msg);
				}

			}
		});

	})
</script>


<script type="text/javascript">
	$('#company_name').select2({
		placeholder: '-Select Company Name-',
		minimumInputLength: 4,
		ajax: {
			url: "<?php echo base_url(); ?>premiumplan/companylist",
			dataType: 'json',
			delay: 250,
			processResults: function (data) {
				return {
					results: data
				};
			},
			cache: true
		}
	});
</script>

<script type="text/javascript">

	$(document).ready(function () {
		$('select[name="state"]').on('change', function () {
			var stateID = $(this).val();
			if (stateID) {
				$.ajax({
					url: '<?php echo base_url(); ?>premiumplan/liveformcity/' + stateID,
					type: "GET",
					dataType: "json",
					success: function (data) {
						$('select[name="city"]').empty();
						$.each(data, function (key, value) {
							$('select[name="city"]').append('<option value="' + value.city_name + '">' + value.city_name + '</option>');
						});
					}
				});
			} else {
				$('select[name="city"]').empty();
			}
		});
	});
</script>


<script type="text/javascript">
	$(function () {
		$("#ddlPassport").change(function () {
			if ($(this).val() == "Salaried") {
				$("#occ11").show();
				$("#occ12").show();
				$("#occ13").show();
				$("#occ14").show();
				$("#occ15").show();
				$("#occ16").show();
				$("#occ17").show();
				$("#occ21").hide();
				$("#occ22").hide();
				$("#occ23").hide();
				$("#occ24").hide();
				$("#occ25").hide();
				$("#occ26").hide();
				$("#occ27").hide();
				$("#occ28").hide();
				$("#occ31").hide();
				$("#occ41").hide();
				$("#occ42").hide();
			}
			if ($(this).val() == "Self Employed Professional") {
				$("#occ11").hide();
				$("#occ12").hide();
				$("#occ13").hide();
				$("#occ21").show();
				$("#occ22").show();
				$("#occ23").show();
				$("#occ24").show();
				$("#occ25").show();
				$("#occ26").show();
				$("#occ27").show();
				$("#occ28").show();
				$("#occ31").hide();
				$("#occ41").hide();
				$("#occ42").hide();
				$("#occ16").hide();
				$("#occ17").hide();

			}
			if ($(this).val() == "Self employed Business") {
				$("#occ11").hide();
				$("#occ13").hide();
				$("#occ12").hide();
				$("#occ21").hide();
				$("#occ22").show();
				$("#occ23").show();
				$("#occ24").show();
				$("#occ25").show();
				$("#occ26").show();
				$("#occ27").show();
				$("#occ28").show();
				$("#occ31").show();
				$("#occ41").hide();
				$("#occ42").hide();
				$("#occ16").hide();
				$("#occ17").hide();

			}

			if ($(this).val() == "Retired") {
				$("#occ11").show();
				$("#occ12").show();
				$("#occ13").show();
				$("#occ21").hide();
				$("#occ22").hide();
				$("#occ23").hide();
				$("#occ24").hide();
				$("#occ25").hide();
				$("#occ26").hide();
				$("#occ27").hide();
				$("#occ28").hide();
				$("#occ31").hide();
				$("#occ41").hide();
				$("#occ42").hide();
				$("#occ16").hide();
				$("#occ17").hide();

			}

			if ($(this).val() == "Student") {
				$("#occ11").hide();
				$("#occ12").hide();
				$("#occ13").hide();
				$("#occ21").hide();
				$("#occ22").hide();
				$("#occ23").hide();
				$("#occ24").hide();
				$("#occ25").hide();
				$("#occ26").hide();
				$("#occ27").hide();
				$("#occ28").hide();
				$("#occ31").hide();
				$("#occ41").show();
				$("#occ42").show();
				$("#occ16").hide();
				$("#occ17").hide();

			}
			if ($(this).val() == "Home Maker") {
				$("#occ11").hide();
				$("#occ12").hide();
				$("#occ13").hide();
				$("#occ21").hide();
				$("#occ22").hide();
				$("#occ23").hide();
				$("#occ24").hide();
				$("#occ25").hide();
				$("#occ26").hide();
				$("#occ27").hide();
				$("#occ28").hide();
				$("#occ31").hide();
				$("#occ41").hide();
				$("#occ42").hide();
				$("#occ16").hide();
				$("#occ17").hide();

			}

			if ($(this).val() == "Others") {
				$("#occ11").hide();
				$("#occ12").hide();
				$("#occ13").hide();
				$("#occ21").hide();
				$("#occ22").hide();
				$("#occ23").hide();
				$("#occ24").hide();
				$("#occ25").hide();
				$("#occ26").hide();
				$("#occ27").hide();
				$("#occ28").hide();
				$("#occ31").hide();
				$("#occ41").hide();
				$("#occ42").hide();
				$("#occ16").hide();
				$("#occ17").hide();

			}

		});
	});
</script>

<script type="text/javascript">
	$(function () {
		$("#outstanding").change(function () {
			if ($(this).val() == "1") {
				$("#out51").show();

			} else {
				$("#out51").hide();
			}


		});
	});
</script>
<script type="text/javascript">
	$(function () {
		$("#company_name").change(function () {
			if ($(this).val() == "99999") {
				$("#typecompanyname").show();

			} else {
				$("#typecompanyname").hide();
			}


		});
	});


</script>

