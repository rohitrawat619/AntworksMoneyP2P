function scroll_to_class(element_class, removed_height) {
	var scroll_to = $(element_class).offset().top - removed_height;
	if($(window).scrollTop() != scroll_to) {
		$('html, body').stop().animate({scrollTop: scroll_to}, 0);
	}
}

function bar_progress(progress_line_object, direction) {
	var number_of_steps = progress_line_object.data('number-of-steps');
	var now_value = progress_line_object.data('now-value');
	var new_value = 0;
	if(direction == 'right') {
		new_value = now_value + ( 100 / number_of_steps );
	}
	else if(direction == 'left') {
		new_value = now_value - ( 100 / number_of_steps );
	}
	progress_line_object.attr('style', 'width: ' + new_value + '%;').data('now-value', new_value);
}

jQuery(document).ready(function() {
	
    $('.f1 fieldset:first').fadeIn('slow');
    
    // next step
    $('.f1 .btn-next').on('click', function() {
    	var parent_fieldset = $(this).parents('fieldset');
    	var next_step = true;
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
    	// fields validation
        //console.log(current_active_step);
    	///////First Step
       var current =  $(".f1-steps").find(".active").attr('id');
        if(current == 'step_1')
        {
            if($("#name").val() == '')
            {
                $("#error_name").html('<p>Please enter your name as PAN Card</p>');
                $("#name").addClass('input-error');
                next_step = false;
            }
            if($("#datepicker").val() == '')
            {
                $("#error_datepicker").html('<p>Please enter your DOB</p>');
                $("#datepicker").addClass('input-error');
                next_step = false;
            }

            if($("#gender").val() == '')
            {
                $("#error_gender").html('<p>Please select your gender</p>');
                $("#gender").addClass('input-error');
                next_step = false;
            }
            if($("#email").val() == '')
            {
                $("#error_email").html('<p>Please enter your valid email address</p>');
                $("#email").addClass('input-error');
                next_step = false;
            }

            if($("#mobile").val() == '' && $("#mobile").length != 10)
            {
                $("#error_mobile").html('<p>Please enter your valid mobile no</p>');
                $("#mobile").addClass('input-error');
                next_step = false;
            }
            if($("#mobile").val() != '' && $("#resend_otp").hasClass("btn-primary"))
            {
                $("#error_mobile").html('<p>Please send otp</p>');
                $("#mobile").addClass('input-error');
                next_step = false;
            }
            if($("#pan").val() == '')
            {
                $("#error_pan").html('<p>Please enter your valid PAN no</p>');
                $("#pan").addClass('input-error');
                next_step = false;
            }
            if($("#password").val() == '')
            {
                $("#error_password").html('<p>Please enter your password</p>');
                $("#password").addClass('input-error');
                next_step = false;
            }
            if($("#cpassword").val() == '')
            {
                $("#error_cpassword").html('<p>Please enter your confirm password</p>');
                $("#cpassword").addClass('input-error');
                next_step = false;
            }
            if($("#verify_otp").val() == '' || $("#verify_otp").val() !='Verified')
            {
                $("#error_verify_otp").html('<p>Please enter valid OTP</p>');
                $("#verify_otp").addClass('input-error');
                next_step = false;
            }
            var email = $("#email").val();
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(email) || email == '') {
                $("#error_email").html('<p>Please enter your valid email address</p>');
                $("#email").addClass('input-error');
                next_step = false;
            }
            else{
                $.ajax({
                    async: true,
                    type: "POST",
                    url: baseURL+"Borrower_registration/check_email_availability",
                    data: "email="+email,
                    success: function (data) {
                        if(data=="Yes")
                        {
                            $("#error_email").html('');
                        }
                        else
                        {
                            $("#error_email").html("<p>Email id already registered<p>");
                            next_step = false;
                        }
                    }
                });
            }

            var pan = $("#pan").val();
            var ss = pan.toUpperCase();
            var pattern = new RegExp("[A-Z]{5}[0-9]{4}[A-Z]{1}");
            var status = pattern.test(ss);
            if (status) {
                if(pan.length == 10)
                {
                    $.ajax({
                        type: "POST",
                        url: baseURL+"Borrower_registration/check_pan_availability",
                        data: "pan="+pan,
                        async: true,
                        success: function (data) {
                            if(data=="Yes")
                            {
                                $("#error_pan").html("");
                            }
                            else
                            {
                                $("#error_pan").html("<p style='color:red'>PAN already exit.<p>");
                                next_step = false;
                            }
                        }
                    });
                }
            } else {
                $("#error_pan").html('<p>Please enter your valid PAN no</p>');
                $("#pan").addClass('input-error');
                next_step = false;
            }

            var passwordstrongmeter = $("#password-strength-meter").val();
            if(passwordstrongmeter<3)
            {
                $("#error_password").html("<p>Please choose strong password.</p>");
                $("#password").addClass('input-error');
                next_step = false;
            }
            var password = $("#password").val();
            var cpassword = $("#cpassword").val();
            if(password != cpassword)
            {
                $("#error_cpassword").html("<p>Password doesn't match</p>");
                $("#cpassword").addClass('input-error');
                next_step = false;
            }
            var bday = $("#datepicker").val();
            var validDOB = false;
            var today = new Date();
            var nowyear = today.getFullYear();
            var bdate = bday.replace(/-/g, "-");
            d = bdate.split("-");
            var byr = parseInt(d[0]);
            if (byr < 1900) {
                byr = byr + 2000
            }
            var bmth = parseInt(d[1], 10);
            var bdy = parseInt(d[2], 10);
            checkValidDate(byr, bmth, bdy);
            var age = nowyear - byr;
            var nowmonth = today.getMonth();
            var nowday = today.getDate();
            var nowmonth_new = nowmonth + 1;
            var new_age = age;
            if (bmth > nowmonth_new) {
                var new_age = age;
            } else if ((bmth == nowmonth_new) && (nowday < bdy)) {
                var new_age = age - 1;
            }
            if (new_age < 18) {
                $("#error_datepicker").html('<p>Sorry you are not eligible.</p>');
                $("#datepicker").addClass('input-error');
                next_step = false;
            }

            if($("#highest_qualification").val() == '')
            {
                $("#error_highest_qualification").html('<p>Please select your qualification</p>');
                $("#highest_qualification").addClass('input-error');
                next_step = false;
            }
        }
        //next_step = true;
        if(current == 'step_2')
        {
            if($("#address1").val() == '')
            {
                $("#error_address1").html('<p>Please enter your address</p>');
                $("#address1").addClass('input-error');
                next_step = false;
            }
            if($("#state").val() == '')
            {
                $("#error_state").html('<p>Please select your state</p>');
                $("#state").addClass('input-error');
                next_step = false;
            }
            if($("#city").val() == '')
            {
                $("#error_city").html('<p>Please select your city</p>');
                $("#city").addClass('input-error');
                next_step = false;
            }
            if($("#pincode").val() == '')
            {
                $("#error_pincode").html('<p>Please enter your pincode</p>');
                $("#pincode").addClass('input-error');
                next_step = false;
            }
            if($("#present_residence").val() == '')
            {
                $("#error_present_residence").html('<p>Please select present residence</p>');
                $("#present_residence").addClass('input-error');
                next_step = false;
            }

        }
        //alert(next_step);
        //next_step = true;
    	// fields validation
    	if( next_step ) {
    		parent_fieldset.fadeOut(400, function() {
    			// change icons
    			current_active_step.removeClass('active').addClass('activated').next().addClass('active');
    			// progress bar
    			bar_progress(progress_line, 'left');
    			// show next step
	    		$(this).next().fadeIn();
	    		// scroll window to beginning of the form
    			scroll_to_class( $('.f1'), 20 );
	    	});
    	}
    	
    });
    
    // previous step
    $('.f1 .btn-previous').on('click', function() {
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
    	
    	$(this).parents('fieldset').fadeOut(400, function() {
    		// change icons
    		current_active_step.removeClass('active').prev().removeClass('activated').addClass('active');
    		// progress bar
    		bar_progress(progress_line, 'right');
    		// show previous step
    		$(this).prev().fadeIn();
    		// scroll window to beginning of the form
			scroll_to_class( $('.f1'), 20 );
    	});
    });
});

function userFunctionvalidate() {
        var occuption = $("#occupation").val();
        var validation = true;

        if(occuption == '')
        {
            $("#error_occupation").html('<p>This fields is required*</p>');
            $("#occupation").addClass('input-error');
            validation = false;
        }

        var $inputs = $('#occuption_change_value :input');
        var ids = {};
        $inputs.each(function (index)
        {
            if($("#"+$(this).attr('id')).val() == '')
            {
                $("#error_"+$(this).attr('id')).html('<p>This fields is required*</p>');
                $("#"+$(this).attr('id')).addClass('input-error');
                validation = false;
            }
        });
        if($("#loan_amount_borrower").val() == '' || $("#loan_amount_borrower").val() == ''>1000000)
        {
            $("#error_loan_amount_borrower").html('<p>Please enter loan amount</p>');
            $("#loan_amount_borrower").addClass('input-error');
            validation = false;
        }
        if($("#tenor_borrower").val() == '')
        {
            $("#error_tenor_borrower").html('<p>Please select tenor</p>');
            $("#tenor_borrower").addClass('input-error');
            validation = false;
        }
        if($("#borrower_interest_rate").val() == '')
        {
            $("#error_borrower_interest_rate").html('<p>Please select interest rate</p>');
            $("#borrower_interest_rate").addClass('input-error');
            validation = false;
        }
        if($("#p2p_product_id").val() == '')
        {
            $("#error_p2p_product_id").html('<p>Please Select Loan Purpose</p>');
            $("#p2p_product_id").addClass('input-error');
            validation = false;
        }
        if($("#borrower_loan_desc").val() == '')
        {
            $("#error_borrower_loan_desc").html('<p>Please enter loan description</p>');
            $("#borrower_loan_desc").addClass('input-error');
            validation = false;
        }
        if($('#term_and_condition').is(":not(:checked)"))
        {
            $("#error_term_and_condition").html('<p>Please select Term and Condition</p>');
            validation = false;
        }
        if(validation)
        {
        var password = $("#password").val();
        var crypted_password = CryptoJS.SHA512(password);
        $('#password').val(crypted_password);
        var password = $("#cpassword").val();
        var crypted_password_c = CryptoJS.SHA512(password);
        $('#cpassword').val(crypted_password_c);
        }
        else{
            return false;
        }

}
//////////////////////////////////////////////////////

$('input').change(function() {
    $(this).removeClass('input-error');
     var attr_id = $(this).attr('id');
    $("#error_"+attr_id).html('<p></p>');
});

$('select').change(function() {
    $(this).removeClass('input-error');
    var attr_id = $(this).attr('id');
    $("#error_"+attr_id).html('<p></p>');
});
$('checkbox').change(function() {
    $(this).removeClass('input-error');
    var attr_id = $(this).attr('id');
    $("#error_"+attr_id).html('<p></p>');
});
$('textarea').change(function() {
    $(this).removeClass('input-error');
    var attr_id = $(this).attr('id');
    $("#error_"+attr_id).html('<p></p>');
});

function checkExistpan(pan) {

    var ss = pan.toUpperCase();
    var pattern = new RegExp("[A-Z]{5}[0-9]{4}[A-Z]{1}");
    var status = pattern.test(ss);
    if (status) {
        if(pan.length == 10)
        {
            $.ajax({
                type: "POST",
                url: baseURL+"Borrower_registration/check_pan_availability",
                data: "pan="+pan,
                async: true,
                success: function (data) {
                    if(data=="Yes")
                    {
                        $("#error_pan").html("");
                    }
                    else
                    {
                        $("#error_pan").html("<p style='color:red'>PAN already exit.<p>");

                    }
                }
            });
        }
    } else {
        $("#error_pan").html('<p>Please enter Valid Pan Number</p>');
        $("#error_pan").show();
        validation = false;
    }
}

function checkExist(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {

    }
    else{
        $.ajax({
            type: "POST",
            url: baseURL+"Borrower_registration/check_email_availability",
            data: "email="+email,
            async: true,
            success: function (data) {
                if(data=="Yes")
                {
                    $("#error_email").html("");
                }
                else
                {
                    $("#error_email").html("<p style='color:red'>Email id already registered.<p>");

                }
            }
        });
    }
}

function sendOtp() {
    var mobNum = $("#mobile").val();
    var filter = /^\d*(?:\.\d{1,2})?$/;

    if (filter.test(mobNum)) {
        if(mobNum.length==10){
            $.ajax({
                type: "POST",
                url: baseURL+"Borrower_registration/sendOTP/",
                data: "mobile="+mobNum,
                async: true,
                success: function (data) {

                    if(data == 1)
                    {
                        $("#error_mobile").html('<p></p>');
                        $("#mobile").removeClass('input-error');
                        $("#verify_otp_main").show();
                        $("#resend_otp").removeClass('btn btn-primary');
                        $("#resend_otp").addClass('btn btn-danger');
                        $("#resend_otp").html('<i class="fa fa-share-square" aria-hidden="true"></i>');
                    }
                    if(data == 2)
                    {
                        $("#mobile").addClass('input-error');
                        $("#error_mobile").html('<p>You have tried many times</p>');

                    }
                    if(data == 3)
                    {
                        $("#mobile").addClass('input-error');
                        $("#error_mobile").html('<p>Mobile no already exist</p>');
                    }
                }
            });
        } else {
            $("#mobile").addClass('input-error');
            $("#error_mobile").html("<p>Please enter valid mobile no</p>");
        }
    }
    else {
        $("#mobile").addClass('input-error');
        $("#error_mobile").html("<p>Please enter valid mobile no</p>");
    }
}

function verifyOtp(otp) {


    if(otp.length==6){
        var mobile = $("#mobile").val();
        $.ajax({
            type: "POST",
            url: baseURL+"Borrower_registration/verify_mobile/",
            data: "otp="+otp+"&mobile="+mobile,
            async: true,
            success: function (data) {
                result = JSON.parse(data);
                if(result['response'] == "Not")
                {
                    $("#verify_otp").addClass('input-error');
                    $("#error_verify_otp").show();
                    $("#error_verify_otp").html('<p style="color: red">Your OTP not verified</p>');
                }
                if(result['response'] == "Expired"){
                    $("#verify_otp").addClass('input-error');
                    $("#error_verify_otp").show();
                    $("#error_verify_otp").html('<p style="color: red">OTP Expired, Please Resend and try again</p>');
                }
                if(result['response'] == "verify"){
                    $("#error_verify_otp").html('<p></p>');
                    $("#verify_otp").val('Verified');
                    $('#verify_otp').attr("disabled", true);
                    $('#mobile').attr("readonly", true);
                    $("#resend_otp_borrower").hide();
                }
            }
        });
    }


}

function showResult1(str) {

    if (str.length==0) {
        $("#livesearch1").hide();
        return;
    }

    $.ajax({
        async: true,
        type: "POST",
        url: baseURL+"Borrower_registration/company_list_search/",
        dataType: "html",
        data: "q="+str,
        async: false,
        success: function (data) {
            $("#livesearch1").html(data);
            $("#livesearch1").show();
        }
    });
}

function livesearchbox1(str)
{
    $("#company_name1").val($('#ls1'+str).html());
    $("#livesearch1").hide();

}

function occupation_value()
{
    var occupation = $("#occupation").val();
	if(occupation == 1)
	{
		$("#p2p_product_id option[value='4']").remove();
		if($("#p2p_product_id option[value='3']").length == 0)
		{
			$("#p2p_product_id").append('<option value="3">Personal loan/to meet various personal financial commitments</option>');
		}

	}
	if(occupation == 2 || occupation == 3)
	{
		$("#p2p_product_id option[value='3']").remove();
		if($("#p2p_product_id option[value='4']").length == 0)
		{
			$("#p2p_product_id").append('<option value="2">Business loan/to meet various Business financial commitments</option>');
		}
	}
    $("#occuption_change_value").html("");
        $("occuption_change_value").html("");
        $.ajax({
            type: "POST",
            url: baseURL+"Borrower_registration/getOccuptionfields",
            data: "occuaption="+occupation,
            async: true,
            success: function (data) {
                if(data)
                {
                    $("#occuption_change_value").html(data);
                }
                else
                {
                    //$("#error_pan").html("<p style='color:red'>PAN already exit.<p>");

                }
            }
        });

}

function get_city()
{
    var state_code = $("#state").val();
    if(state_code){
        $.ajax({
            async: true,
            type:"POST",
            url: baseURL+"frontendresponse/city_list/",
            data:{'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',"state":state_code},
            success: function(result){
                $("#city").html(result);
            }});
    }

}

$(document).ready(
    function () {
        $( "#datepicker" ).datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd',
            yearRange: '1950:2000'
        });
        jQuery(function () {
            jQuery("#mytinynav").tinyNav();
        });

    }

);
