function addShortlist(proposalId)
{
    $.ajax({
        type:"POST",
        url: baseURL+"bidding/proposalFavourite/",
        data:{proposalId:proposalId},
        success: function(data){

            var response = $.parseJSON(data);
            alert(response.msg);
        }});
}
var elements = document.getElementsByClassName("column");

// Declare a loop variable
var i;

// List View
function listView() {
	$("#proposal_list_ul").addClass('box-list');

}

// Grid View
function gridView() {
	$("#proposal_list_ul").removeClass('box-list');
}

function submitproposal(proposal_id) {
    var bid_data = $("#proposal_id_"+proposal_id).serializeArray();
    var result= [];
    $.each(bid_data, function() {
        result[this.name] = this.value;
    });
    var required_amount = parseInt(result.loan_required);
    var bid_loan_amount = parseInt(result.loan_amount);
    var is_valid = true;
    if($("#auto_investment_lender").val() == 1)
	{
		alert("Sorry your auto investment mode is on you can't bid proposal");
		is_valid = false;
		return  false;
	}
    if(result.loan_amount == ''){

        $("#error_loan_amount_"+proposal_id).html('Required*');
        is_valid = false;
    }
    if(result.accepted_tenor == ''){

        $("#error_accepted_tenor_"+proposal_id).html('Required*');
        is_valid = false;
    }
    if(result.interest_rate == ''){

        $("#error_interest_rate_"+proposal_id).html('Required*');
        is_valid = false;
    }
    if(bid_loan_amount > required_amount)
    {

        $("#error_loan_amount_"+proposal_id).html('Should not be > bid amount');
        is_valid = false;
    }
    if(result.loan_amount > 50000)
    {
        $("#error_loan_amount_"+proposal_id).html('Should not be > 50000');
        is_valid = false;
    }
	if(result.loan_amount < 2500)
	{
		$("#error_loan_amount_"+proposal_id).html('Should not be > 2500');
		is_valid = false;
	}
    if(is_valid === true)
    {

        // $.ajax({
        //     type: "POST",
        //     url: baseURL+"bidding/checkalreadyBid",
        //     data:  $("#proposal_id_"+proposal_id).serialize(),
        //     async: true,
        //     success: function (data) {
        //         if(data == 1)
        //         {
        //             $("#error_loan_amount_"+proposal_id).html('You already bid this');
        //             is_valid = false;
        //         }
        //         if(data == 2)
        //         {
        //             is_valid == true
        //             return true;
        //
        //         }
        //     }
        // });

		var result_confirmation = confirm("Are you sure to BID this proposal?");
		if (result_confirmation) {
			return true;
		}
		else{
			return false;
		}
    }
    else{
        return false;
    }
}
$('input').change(function() {
    var attr_id = $(this).attr('id');
    $("#error_"+attr_id).html('<span></span>');
});

$('select').change(function() {
    //$(this).removeClass('input-error');
    var attr_id = $(this).attr('id');
    $("#error_"+attr_id).html('<span></span>');
});

$(".bid_loan_amount").keyup(function () {
	var bidloan_amount = $("#"+this.id).val();
	var inputId = this.id.split('_');
	var proposalId = inputId[2];
	if(bidloan_amount <= 5000)
	{
		$("#interest_rate_"+proposalId).val(36);
		$("#accepted_tenor_"+proposalId)
			.append($("<option></option>")
				.attr("value",1)
				.text("1 Month"));
		$("#accepted_tenor_"+proposalId).val(1);
		$("#interest_rate_"+proposalId).prop('disabled', 'disabled');
		$("#accepted_tenor_"+proposalId).prop('disabled', 'disabled');
	}
	else{
		$("#accepted_tenor_"+proposalId).empty().append('<option value="">Select Tenor</option>').val('');
		for ( var i = 2; i <= 36; i++)
		{
			if(i <= 6){

				$("#accepted_tenor_" + proposalId)
					.append("<option value='"+i+"'>"+i+" Months</option>");
			}
			else{ i = i+2;
				$("#accepted_tenor_" + proposalId)
					.append("<option value='"+i+"'>"+i+" Months</option>");
			}
		}
		$("#interest_rate_"+proposalId).val("");
		$("#accepted_tenor_"+proposalId).val("");
		$("#interest_rate_"+proposalId).prop('disabled', false);
		$("#accepted_tenor_"+proposalId).prop('disabled', false);
	}
	if(bidloan_amount > 50000)
	{
		$("#error_loan_amount_"+proposalId).html('Should not be > 50000');
	}
});
$(document).ready(function(){
	$( document ).on( 'focus', ':input', function(){
		$( this ).attr( 'autocomplete', 'off' );
	});
});
