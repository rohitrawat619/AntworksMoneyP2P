<script type="text/javascript">
	function myFunction(docid) {
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>p2padmin/documentverification/updatedoc",
			dataType: "html",
			data: "doc_id=" + docid,
			async: false,
			success: function (data) {
				var response = JSON.parse(data);
				if (response['status'] == 1) {
					alert(response['response']);
					window.location.reload();

				} else {
					alert(response['response']);
				}
			}
		});
	}


	function myFunction2(docid) {
		$('#comment' + docid).show();
	}


	function updatecomment(docid, email) {

		var comment = $('#v_comment' + docid).val();
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>p2padmin/documentverification/updatecomment",
			dataType: "html",
			data: "doc_id=" + docid + "&comment=" + comment + "&email=" + email,
			async: false,
			success: function (data) {
				var response = JSON.parse(data);
				if (response['status'] == 1) {
					alert(response['response']);
					window.location.reload();

				} else {
					alert(response['response']);
				}
			}
		});
	}


	$(document).ready(function () {
		var i = 0;
		$(".upload-mfile-btn").click(function () {
			i = i + 1;
			var domElement = $('<div class="col-md-6 col-sm-4"><div class="form-group"><input class="form-control" type="text" name="doc_name[]" placeholder="Enter Document Name"/><br><input class="form-control" type="file" name="doc_file[]"/></div></div></div>');
			$('.upload-mfile').before(domElement);
		});


	});


	function ititiateEnach(borrowerId) {
		$.ajax({
			async: true,
			type: "POST",
			url: baseURL + "P2padmin/Repayment/initiateEnach",
			data: {borrowerId: borrowerId},
			success: function (data) {
				var response = $.parseJSON(data);
				if (response.status == 1) {
					$("#initiate_enach").hide();
					alert(response.msg);
				} else {
					alert(response.msg);
				}
			}
		});
	}


	function verifyBank(borrowerId) {
		$("verify_banking").hide();
		$.ajax({
			async: true,
			type: "POST",
			url: baseURL + "P2padmin/P2pborrower/verifyBankdetails",
			data: {borrowerId: borrowerId},
			success: function (data) {
				var response = $.parseJSON(data);
				if (response.status == 1) {
					alert(response.msg);
					window.location.reload();
				} else {
					alert(response.msg);
				}
			}
		});
	}

	function acceptborrowerRequest(requestId, borrowerId) {
		$.ajax({
			async: true,
			type: "POST",
			url: baseURL + "P2padmin/P2pborrower/acceptborrowerRequest",
			data: {requestId: requestId, borrowerId: borrowerId},
			success: function (data) {
				// var response = $.parseJSON(data);
				// console.log(response);
				if (data == 1) {
					alert("Record Update successfully");
					window.location.reload();
				}
			}
		});
	}

	function updatepan() {
		$.ajax({
			type: "POST",
			url: baseURL + "p2padmin/p2pborrower/update_borrower_pan_v2",
			data: $("#update_pan").serialize(),
			success: function (data) {
				var response = $.parseJSON(data);
				alert(response.msg);
				window.location.reload();
			}
		});

	}

	function verifyPanstep(borrowerId) {
		var result_confirmation = confirm("Are you sure active Pan step?");
		if (result_confirmation) {
			$.ajax({
				async: true,
				type: "POST",
				url: baseURL + "P2padmin/P2pborrower/verifyPanstep",
				data: {borrowerId: borrowerId},
				success: function (data) {
					var response = $.parseJSON(data);
					alert(response.msg);
				}
			});
		} else {
			return false;
		}

	}

	function sendVerificationlink(borrowerId) {
		var email_id = $("#update_email").val();
		if(email_id){
			$.ajax({
				async: true,
				type: "POST",
				url: baseURL+"P2padmin/p2pborrower/resendverificationlink",
				data: {borrowerId:borrowerId, email:email_id},
				success: function (data) {
					var response =  $.parseJSON(data);
					if(response.status == 1)
					{
						alert(response.msg);
					}
					else {
						alert(response.msg);
					}
				}
			});
		}
		else{
			alert("Please enter borrower email ID");
		}

	}
	//Bypass the mail verification
	function bypass_mail_verification(borrowerId) {
		var email_id = $("#update_email").val();
		if(borrowerId){
			$.ajax({
				async: true,
				type: "POST",
				url: baseURL+"P2padmin/p2pborrower/bypass_mail_verification",
				data: {borrowerId:borrowerId},
				success: function (data) {
					var response =  $.parseJSON(data);
					if(response.status == 1)
					{
						alert(response.msg);
						location.reload();
					}
					else {
						alert(response.msg);
					}
				}
			});
		}
		else{
			alert("Please enter borrower email ID");
		}

	}

	function clearForm(){
		$('#search_admin').find("input[type=text], select").val("");
		$("#borrower_list").show();
		$("#borrower_search_list").html('');
	}

	$("#search_by_admin").click(function () {


		$.ajax({
			url: baseURL+"searchmodule/adminsearch",
			type: "POST",
			data: $("#search_admin").serialize(),
			dataType: "json",
			success: function (data) {
				//console.log(data);
				var response = JSON.stringify(data);
				var j = JSON.parse(response);

				$("#borrower_list").hide();

				$("#borrower_search_list").html(j.search_result);



			}
		});
	});
	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if ((charCode > 47 && charCode < 58) || (charCode == 8)) {
			return true;
		} else {
			return false;
		}
	}
</script>
<script>
    $('#daterange-btn_onlymonth').val();
    $(function () {
        //Date range as a button
        $('#daterange-btn_onlymonth').daterangepicker(
            {

                ranges   : {
                    'Today'       : [moment(), moment()],
                    'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                    'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                /*"dateLimit": {
                    "month": 1
                },*/
                autoApply: false,
                startDate: moment().subtract(29, 'days'),
                endDate  : moment(),
            },
            function (start, end) {
                $('#daterange-btn_onlymonth span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))

            }
        )
        $('.filter-by-date').val("");

    });
    //Date picker
    $('#datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
    })
</script>

<script>
    $('#daterange-btn_onlymonth_1').val();
    $(function () {
        //Date range as a button
        $('#daterange-btn_onlymonth_1').daterangepicker(
            {

                ranges   : {
                    'Today'       : [moment(), moment()],
                    'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                    'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "dateLimit": {
                    "month": 1
                },
                autoApply: false,
                startDate: moment().subtract(29, 'days'),
                endDate  : moment(),
            },
            function (start, end) {
                $('#daterange-btn_onlymonth_1 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))

            }
        )
        $('.filter-by-date').val("");

    });
    //Date picker
    $('#datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
    })
</script>