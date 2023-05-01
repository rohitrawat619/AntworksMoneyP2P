
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

        ///////First Step
        var current =  $(".f1-steps").find(".active").attr('id');
        if(current == 'step_1')
        {
            if($("#name").val() == '')
            {
                $("#error_name").html('<p>Please enter your name as its showing in your PAN Card</p>');
                $("#name").addClass('input-error');
                next_step = false;
            }
            if($("#datepicker").val() == '')
            {
                $("#error_datepicker").html('<p>Please enter your Date of Birth</p>');
                $("#datepicker").addClass('input-error');
                next_step = false;
            }

            if($("#gender").val() == '')
            {
                $("#error_gender").html('<p>Please select your Gender</p>');
                $("#gender").addClass('input-error');
                next_step = false;
            }
            if($("#email").val() == '')
            {
                $("#error_email").html('<p>Please enter your valid E-mail ID</p>');
                $("#email").addClass('input-error');
                next_step = false;
            }

            if($("#mobile").val() == '' && $("#mobile").length != 10)
            {
                $("#error_mobile").html('<p>Please enter valid Mobile number</p>');
                $("#mobile").addClass('input-error');
                next_step = false;
            }
            if($("#mobile").val() != '' && $("#verify_otp").val() == '')
            {
                $("#error_mobile").html('<p>Please send otp</p>');
                $("#mobile").addClass('input-error');
                next_step = false;
            }
            if($("#pan").val() == '')
            {
                $("#error_pan").html('<p>Please enter your valid PAN number</p>');
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
                $("#error_cpassword").html('<p>Please re-enter your password</p>');
                $("#cpassword").addClass('input-error');
                next_step = false;
            }
            if($("#verify_otp").val() == '' || $("#verify_otp").val() !='Verified')
            {
                $("#verify_otp").addClass('input-error');
                next_step = false;
            }
            var email = $("#email").val();
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(email) || email == '') {
                $("#error_email").html('<p>Please enter your valid email ID</p>');
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
                            $("#error_email").html("<p>This email id is already registered. Please try Login<p>");
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
                $("#error_pan").html('<p>Please enter your valid PAN Number</p>');
                $("#pan").addClass('input-error');
                next_step = false;
            }

            var passwordstrongmeter = $("#password-strength-meter").val();
            if(passwordstrongmeter<3)
            {
                $("#error_password").html("<p>Please choose a strong password. Password must be atleast of 8 character and Includes Numbers, Symbols, Capital Letters, and Lower-Case Letters.</p>");
                $("#password").addClass('input-error');
                next_step = false;
            }
            var password = $("#password").val();
            var cpassword = $("#cpassword").val();
            if(password != cpassword)
            {
                $("#error_cpassword").html("<p>Invalid Password! Please check and try again.</p>");
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
                $("#error_datepicker").html('<p>Your application could not be approved at this time. Please try again after 3 months</p>');
                $("#datepicker").addClass('input-error');
                next_step = false;
            }

            if($("#highest_qualification").val() == '')
            {
                $("#error_highest_qualification").html('<p>Please select your Qualification</p>');
                $("#highest_qualification").addClass('input-error');
                next_step = false;
            }
        }

        if(current == 'step_2')
        {
            if($("#address1").val() == '')
            {
                $("#error_address1").html('<p>Please enter your Residence Address</p>');
                $("#address1").addClass('input-error');
                next_step = false;
            }
            if($("#state").val() == '')
            {
                $("#error_state").html('<p>Please select State</p>');
                $("#state").addClass('input-error');
                next_step = false;
            }
            if($("#city").val() == '')
            {
                $("#error_city").html('<p>Please select City</p>');
                $("#city").addClass('input-error');
                next_step = false;
            }
            if($("#pincode").val() == '')
            {
                $("#error_pincode").html('<p>Please enter PIN Code</p>');
                $("#pincode").addClass('input-error');
                next_step = false;
            }
        }

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
    if(occuption == 1 || occuption == '')
    {
        if(occuption == '')
        {
            $("#error_occupation").html('<p>Please select Occupation </p>');
            $("#occupation").addClass('input-error');
            validation = false;
        }
        if($("#employed_company1").val() == '')
        {
            $("#error_employed_company1").html('<p>Please select Employment</p>');
            $("#employed_company1").addClass('input-error');
            validation = false;
        }
        if($("#net_monthly_income1").val() == '')
        {
            $("#error_net_monthly_income1").html('<p>Please enter Company Name</p>');
            $("#net_monthly_income1").addClass('input-error');
            validation = false;
        }
        if($("#company_name1").val() == '')
        {
            $("#error_company_name1").html('<p>Please enter company name</p>');
            $("#net_monthly_income1").addClass('input-error');
            validation = false;
        }
    }
    if(occuption == 2)
    {
        if($("#industry_type2").val() == '')
        {
            $("#error_industry_type2").html('<p>Please select Industry</p>');
            $("#industry_type2").addClass('input-error');
            validation = false;
        }
        if($("#total_experience2").val() == '')
        {
            $("#error_total_experience2").html('<p>Please enter Total Experience</p>');
            $("#total_experience2").addClass('input-error');
            validation = false;
        }
        if($("#turnover_last_year2").val() == '')
        {
            $("#error_turnover_last_year2").html('<p>Please enter your turnover for last year</p>');
            $("#turnover_last_year2").addClass('input-error');
            validation = false;
        }
        if($("#turnover_last2_year2").val() == '')
        {
            $("#error_turnover_last2_year2").html('<p>Please enter turnover for year two</p>');
            $("#turnover_last2_year2").addClass('input-error');
            validation = false;
        }


    }
    if(occuption == 3)
    {
        if($("#professional_type3").val() == '')
        {
            $("#error_professional_type3").html('<p>Please select Profession type</p>');
            $("#professional_type3").addClass('input-error');
            validation = false;
        }
        if($("#total_experience3").val() == '')
        {
            $("#error_professional_type3").html('<p>Please enter Experience</p>');
            $("#total_experience3").addClass('input-error');
            validation = false;
        }
        if($("#turnover_last_year3").val() == '')
        {
            $("#error_professional_type3").html('<p>Please enter your turnover for last year</p>');
            $("#turnover_last_year3").addClass('input-error');
            validation = false;
        }
        if($("#turnover_last2_year3").val() == '')
        {
            $("#error_professional_type3").html('<p>Please enter turnover for year two</p>');
            $("#turnover_last2_year3").addClass('input-error');
            validation = false;
        }

    }
    if(occuption == 4)
    {
        if($("#company_name4").val() == '')
        {
            $("#error_company_name4").html('<p>Please enter Company Name</p>');
            $("#company_name4").addClass('input-error');
            validation = false;
        }
        if($("#net_monthly_income4").val() == '')
        {
            $("#error_net_monthly_income4").html('<p>Please enter your Monthly Income</p>');
            $("#net_monthly_income4").addClass('input-error');
            validation = false;
        }
    }
    if(occuption == 5)
    {
        if($("#pursuing5").val() == '')
        {
            $("#error_pursuing5").html('<p>Please select Pursuing Course</p>');
            $("#pursuing5").addClass('input-error');
            validation = false;
        }
        if($("#institute_name5").val() == '')
        {
            $("#error_institute_name5").html('<p>Please enter Institute name</p>');
            $("#institute_name5").addClass('input-error');
            validation = false;
        }
        if($("#net_monthly_income5").val() == '')
        {
            $("#error_net_monthly_income5").html('<p>Please enter Monthly Income</p>');
            $("#net_monthly_income5").addClass('input-error');
            validation = false;
        }

    }
    if(occuption == 6)
    {
        if($("#net_monthly_income6").val() == '')
        {
            $("#error_net_monthly_income6").html('<p>Please enter monthly income</p>');
            $("#net_monthly_income6").addClass('input-error');
            validation = false;
        }

    }
    if(occuption == 7)
    {
        if($("#net_monthly_income7").val() == '')
        {
            $("#error_net_monthly_income7").html('<p>Please enter monthly income</p>');
            $("#net_monthly_income7").addClass('input-error');
            validation = false;
        }

    }
    if($('#term_and_condition').is(":not(:checked)"))
    {
        $("#error_term_and_condition").html('<p>Please accept Terms and condition.</p>');
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


/////////////////////////////////////

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
            success: function (data) {
                if(data=="Yes")
                {
                    $("#error_email").html("");
                }
                else
                {
                    $("#error_email").html("<p style='color:red'>Email id already registered<p>");

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
                async: false,
                success: function (data) {

                    if(data == 1)
                    {
                        $("#error_mobile").html('<p></p>');
                        $("#mobile").removeClass('input-error');;
                        $("#verify_otp_main").show();
                        $("#resend_otp").removeClass('btn btn-primary');
                        $("#resend_otp").addClass('btn btn-danger');
                        $("#resend_otp").html('<i class="fa fa-share-square" aria-hidden="true"></i>');
                    }
                    if(data == 2)
                    {
                        $("#mobile").addClass('input-error');
                        $("#error_mobile").html('<p>You have reached the maximum number of attempt. Please login after some time</p>');
                    }
                    if(data == 3)
                    {
                        $("#mobile").addClass('input-error');
                        $("#error_mobile").html('<p>Mobile number already exists. Please try Login</p>');
                    }
                }
            });
        } else {
            $("#mobile").addClass('input-error');
        }
    }
    else {
        $("#mobile").addClass('input-error');
    }
}

function verifyOtp(otp) {


    if(otp.length==6){
        var mobile = $("#mobile").val();
        $.ajax({
            type: "POST",
            url: baseURL+"Borrower_registration/verify_mobile/",
            data: "otp="+otp+"&mobile="+mobile,
            async: false,
            success: function (data) {
                result = JSON.parse(data);
                if(result['response'] == "Not")
                {
                    $("#verify_otp").addClass('input-error');
                }
                if(result['response'] == "Expired"){
                    $("#verify_otp").addClass('input-error');
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
        $("#oocup1").show();
        $("#oocup2").hide();
        $("#oocup3").hide();
        $("#oocup4").hide();
        $("#oocup5").hide();
        $("#oocup6").hide();
        $("#oocup7").hide();
    }
    else if(occupation == 2)
    {
        $("#oocup1").hide();
        $("#oocup2").show();
        $("#oocup3").hide();
        $("#oocup4").hide();
        $("#oocup5").hide();
        $("#oocup6").hide();
        $("#oocup7").hide();
    }
    else if(occupation == 3)
    {
        $("#oocup1").hide();
        $("#oocup2").hide();
        $("#oocup3").show();
        $("#oocup4").hide();
        $("#oocup5").hide();
        $("#oocup6").hide();
        $("#oocup7").hide();
    }
    else if(occupation == 4)
    {
        $("#oocup1").hide();
        $("#oocup2").hide();
        $("#oocup3").hide();
        $("#oocup4").show();
        $("#oocup5").hide();
        $("#oocup6").hide();
        $("#oocup7").hide();
    }
    else if(occupation == 5)
    {
        $("#oocup1").hide();
        $("#oocup2").hide();
        $("#oocup3").hide();
        $("#oocup4").hide();
        $("#oocup5").show();
        $("#oocup6").hide();
        $("#oocup7").hide();
    }
    else if(occupation == 6)
    {
        $("#oocup1").hide();
        $("#oocup2").hide();
        $("#oocup3").hide();
        $("#oocup4").hide();
        $("#oocup5").hide();
        $("#oocup6").show();
        $("#oocup7").hide();
    }

    else if(occupation == 7)
    {
        $("#oocup1").hide();
        $("#oocup2").hide();
        $("#oocup3").hide();
        $("#oocup4").hide();
        $("#oocup5").hide();
        $("#oocup6").hide();
        $("#oocup7").show();
    }
}

function get_city()
{
    var state_code = $("#state").val();
    if(state_code){
        $.ajax({
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
        $("#oocup1").show();
        $("#oocup2").hide();
        $("#oocup3").hide();
        $("#oocup4").hide();
        $("#oocup5").hide();
        $("#oocup6").hide();
        $("#oocup7").hide();

        jQuery(function () {
            jQuery("#mytinynav").tinyNav();
        });

    }

);