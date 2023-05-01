function validatePassword(pwd) {
    var pattern = new RegExp("^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$");
    var status = pattern.test(pwd);
    if (status) {
        return true
    } else {
        return false;
    }
}

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    $a = re.test(email);
    if ($a == false) {
        return true;
    } else {
        return false;
    }
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if ((charCode > 46 && charCode < 58) || (charCode == 8)) {
        return true;
    } else {
        return false;
    }
}

function isNumberKeyWithDot(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if ((charCode >= 46 && charCode < 58) || (charCode == 8)) {
        return true;
    } else {
        return false;
    }
}

function validatePan(s) {
    var ss = s.toUpperCase();
    var pattern = new RegExp("[A-Z]{5}[0-9]{4}[A-Z]{1}");
    var status = pattern.test(ss);
    if (status) {
        return true;
    } else {
        return false;
    }
}

function validatePassport(s) {
    var ss = s.toUpperCase();
    var pattern = new RegExp("[A-Z]{1}[0-9]{7}");
    var status = pattern.test(ss);
    if (status) {
        return true;
    } else {
        return false;
    }
}

function getAge(bday) {
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
    if (new_age >= 18) {
        return true;
    } else {
        return false;
    }
}

function checkValidDate(yr, mmx, dd) {
    var today = new Date();
    var nowyear = today.getFullYear();
    if (yr < 1910 || yr > nowyear - 1) {
        return false;
    }
    mm = mmx - 1;
    var nd = new Date();
    nd.setFullYear(yr, mm, dd);
    var ndmm = nd.getMonth();
    if (ndmm != mm) {
        validDOB = false;
        return validDOB;
    } else {
        validDOB = true;
        return validDOB;
    }
}

function p2p_login_valid() {
    $(".errors-class").html("");
    if ($('input[name=login_type]:checked').length <= 0) {
        $("#login_type1-error").html("Please select this field.");
        $("#login_type1").focus();
        return false;
    } else if ($("#username").val() == "") {
        $("#username-error").html("Please fill out this field.");
        $("#username").focus();
        return false;
    } else if ($("#password").val() == "") {
        $("#password-error").html("Please fill out this field.");
        $("#password").focus();
        return false;
    } else {
        return true;
    }
}

function p2p_lender_register_valid() {
    if ($("#first_name").val() == "") {
        alert("Please fill First Name.");
        $("#first_name").focus();
        return false;
    } else if ($("#last_name").val() == "") {
        alert("Please enter Last Name.");
        $("#last_name").focus();
        return false;
    } else if ($("#datepicker1").val() == "") {
        alert("Please enter Date of Birth.");
        $("#datepicker1").focus();
        return false;
    } else if (($("#datepicker1").val() != "") && (getAge($("#datepicker1").val()) == false)) {
        alert("You aged less than 18 years, as per policy we do not cater services to minors.");
        $("#datepicker1").focus();
        return false;
    } else if ($("#gender").val() == "") {
        alert("Please select Gender.");
        $("#gender").focus();
        return false;
    } else if ($("#username").val() == "") {
        alert("Please enter Username.");
        $("#username").focus();
        return false;
    } else if ($("#password").val() == "") {
        alert("Please fill Password.");
        $("#password").focus();
        return false;
    } else if (($("#password").val() != "") && validatePassword($("#password").val()) == false) {
        alert("Please fill valid Password.");
        $("#password").focus();
        return false;
    } else if ($("#email").val() == "") {
        alert("Please enter Email.");
        $("#email").focus();
        return false;
    } else if (($("#email").val() != "") && validateEmail($("#email").val())) {
        alert("Invalid email ID.");
        $("#email").focus();
        return false;
    } else if ($("#mobile").val() == "") {
        alert("Please enter Mobile Number.");
        $("#mobile").focus();
        return false;
    } else if (($("#mobile").val() != "") && $("#mobile").val().length < 10) {
        alert("Phone cann't be less than 10 digits.");
        $("#mobile").focus();
        return false;
    } else if ($("#address").val() == "") {
        alert("Please fill Address Line1.");
        $("#address").focus();
        return false;
    } else if ($("#state_code").val() == "") {
        alert("Please select state.");
        $("#state_code").focus();
        return false;
    } else if ($("#city").val() == "") {
        alert("Please select city.");
        $("#city").focus();
        return false;
    } else {
        return true;
    }
}

function p2p_borrower_register_valid() {
    $(".errors-class").html("");
    if ($("#fullname").val() == "") {
        $("#fullname-error").html("Please fill out this field.");
        $("#fullname").focus();
        return false;
    } else if (($("#email").val() != "") && validateEmail($("#email").val())) {
        $("#email-error").html("Please fill valid email ID.");
        $("#email").focus();
        return false;
    } else if (($("#mobile").val() != "") && $("#mobile").val().length < 10) {
        $("#mobile-error").html("Phone cann't be less than 10 digits.");
        $("#mobile").focus();
        return false;
    } else {
        return true;
    }
}

function validateForm1() {
    var hert = $("#verify_mobile_name").val();
    if ($("#loan_type").val() == "") {
        alert("Please select I am.");
        $("#loan_type").focus();
        return false;
    } else if ($("#loan_purpose").val() == "") {
        alert("Please select Looking For.");
        $("#loan_purpose").focus();
        return false;
    } else if ($("#first_name").val() == "") {
        alert("Please fill First Name.");
        $("#first_name").focus();
        return false;
    } else if ($("#last_name").val() == "") {
        alert("Please fill Last Name.");
        $("#last_name").focus();
        return false;
    } else if ($("#datepicker1").val() == "") {
        alert("Please fill Date of Birth.");
        $("#datepicker1").focus();
        return false;
    } else if (($("#datepicker1").val() != "") && (getAge($("#datepicker1").val()) == false)) {
        alert("Please check your DOB , Dob cann't be less than 18 years.");
        $("#datepicker1").focus();
        return false;
    } else if ($("#gender").val() == "") {
        alert("Please select gender.");
        $("#gender").focus();
        return false;
    } else if ($("#username").val() == "") {
        alert("Please fill Username.");
        $("#username").focus();
        return false;
    } else if ($("#email").val() == "") {
        alert("Please fill Email.");
        $("#email").focus();
        return false;
    } else if (($("#email").val() != "") && validateEmail($("#email").val())) {
        alert("Please fill valid email ID.");
        $("#email").focus();
        return false;
    } else if ($("#mobile").val() == "") {
        alert("Please fill Mobile No.");
        $("#mobile").focus();
        return false;
    } else if ($("#for-ckeck-mobileclickornot").val() == "") {
        alert("Please verify Mobile Number.");
        $("#mobile").focus();
        return false;
    } else if (($("#mobile").val() != "") && $("#mobile").val().length < 10) {
        alert("Invalid Phone number. Please check and try again.");
        $("#mobile").focus();
        return false;
    } else if (($("#verify_mobile_name").val() == "")) {
        alert("Please Verify OTP");
        $("#mobile").focus();
        return false;
    } else if ($("#password").val() == "") {
        alert("Please enter Password.");
        $("#password").focus();
        return false;
    } else if (($("#password").val() != "") && validatePassword($("#password").val()) == false) {
        alert("Please fill valid Password.");
        $("#password").focus();
        return false;
    } else if ($("#highest_qualification").val() == "") {
        alert("Please select Highest Qualification.");
        $("#highest_qualification").focus();
        return false;
    } else if ($("#r_address").val() == "") {
        alert("Please enter Residential Address.");
        $("#r_address").focus();
        return false;
    } else if ($("#r_state").val() == "") {
        alert("Please select state.");
        $("#r_state").focus();
        return false;
    } else if ($("#r_city").val() == "") {
        alert("Please select city.");
        $("#r_city").focus();
        return false;
    } else if ($("#r_pincode").val() == "") {
        alert("Please enter PIN code.");
        $("#r_pincode").focus();
        return false;
    } else if (($("#r_pincode").val() != "") && ($("#r_pincode").val().length != 6)) {
        alert("Invalid PIN Code! Please check and try again.");
        $("#r_pincode").focus();
        return false;
    } else {
        $('html, body').animate({
            scrollTop: 0
        }, 'fast');
        $("#form2").show();
        $("#form1").hide();
        $("#form3").hide();
        $("#step-form1").removeClass();
        $("#step-form1").addClass("is-complete");
        $("#step-form2").removeClass();
        $("#step-form2").addClass("is-active");
        $("#step-form3").removeClass();
    }
}

function previous() {
    $('html, body').animate({
        scrollTop: 0
    }, 'fast');
    $("#form1").show();
    $("#form2").hide();
    $("#form3").hide();
    $("#step-form1").removeClass();
    $("#step-form1").addClass("is-active");
    $("#step-form2").removeClass();
    $("#step-form3").removeClass();
}

function validateForm2() {
    if ($("#occupation").val() == "") {
        alert("Please select Occupation.");
        $("#occupation").focus();
        return false;
    } else if (($("#occupation").val() == "1") && ($("#employed_company1").val() == "")) {
        alert("Please select type of Company employed with.");
        $("#employed_company1").focus();
        return false;
    } else if (($("#occupation").val() == "1") && ($("#company_name1").val() == "")) {
        alert("Please enter Company Name.");
        $("#company_name1").focus();
        return false;
    } else if (($("#occupation").val() == "1") && ($("#net_monthly_income1").val() == "")) {
        alert("Please enter Net Monthly Income.");
        $("#net_monthly_income1").focus();
        return false;
    } else if (($("#occupation").val() == "1") && ($("#current_emis1").val() == "")) {
        alert("Please enter Current Total EMI.");
        $("#current_emis1").focus();
        return false;
    } else if (($("#occupation").val() == "1") && ($("#defaulted1").val() == "")) {
        alert("Please enter field ‘ever defaulted on any loan or credit card.");
        $("#defaulted1").focus();
        return false;
    } else if (($("#occupation").val() == "2") && ($("#industry_type2").val() == "")) {
        alert("Please select Industry Type.");
        $("#industry_type2").focus();
        return false;
    } else if (($("#occupation").val() == "2") && ($("#total_experience2").val() == "")) {
        alert("Please enter Total Experience.");
        $("#total_experience2").focus();
        return false;
    } else if (($("#occupation").val() == "2") && ($("#turnover_last_year2").val() == "")) {
        alert("Please enter Gross Turnover Last Year.");
        $("#turnover_last_year2").focus();
        return false;
    } else if (($("#occupation").val() == "2") && ($("#turnover_last2_year2").val() == "")) {
        alert("Please enter Gross Turnover Year 2.");
        $("#turnover_last2_year2").focus();
        return false;
    } else if (($("#occupation").val() == "2") && ($("#current_emis2").val() == "")) {
        alert("Please enter Current Total EMI");
        $("#current_emis2").focus();
        return false;
    } else if (($("#occupation").val() == "2") && ($("#defaulted2").val() == "")) {
        alert("Please enter filed ‘ever defaulted on any loan or credit card'.");
        $("#defaulted2").focus();
        return false;
    } else if (($("#occupation").val() == "3") && ($("#professional_type3").val() == "")) {
        alert("Please select Profession Type.");
        $("#professional_type3").focus();
        return false;
    } else if (($("#occupation").val() == "3") && ($("#total_experience3").val() == "")) {
        alert("Please enter Total Experience.");
        $("#total_experience3").focus();
        return false;
    } else if (($("#occupation").val() == "3") && ($("#turnover_last_year3").val() == "")) {
        alert("Please enter Gross Turnover Last Year.");
        $("#turnover_last_year3").focus();
        return false;
    } else if (($("#occupation").val() == "3") && ($("#turnover_last2_year3").val() == "")) {
        alert("Please enter Gross Turnover Year 2.");
        $("#turnover_last2_year2").focus();
        return false;
    } else if (($("#occupation").val() == "3") && ($("#office_ownership3").val() == "")) {
        alert("Please enter Office Ownership.");
        $("#office_ownership3").focus();
        return false;
    } else if (($("#occupation").val() == "3") && ($("#current_emis3").val() == "")) {
        alert("Please enter Current Total EMI.");
        $("#current_emis3").focus();
        return false;
    } else if (($("#occupation").val() == "3") && ($("#defaulted3").val() == "")) {
        alert("Please enter field ‘ever defaulted on any loan or credit card.");
        $("#defaulted3").focus();
        return false;
    } else if (($("#occupation").val() == "4") && ($("#company_type4").val() == "")) {
        alert("Please select type of company employed with");
        $("#company_type4").focus();
        return false;
    } else if (($("#occupation").val() == "4") && ($("#company_name4").val() == "")) {
        alert("Please enter Company Name.");
        $("#company_name4").focus();
        return false;
    } else if (($("#occupation").val() == "4") && ($("#net_monthly_income4").val() == "")) {
        alert("Please enter Net Monthly Income.");
        $("#net_monthly_income4").focus();
        return false;
    } else if (($("#occupation").val() == "4") && ($("#current_emis4").val() == "")) {
        alert("Please enter Current Total EMI.");
        $("#current_emis4").focus();
        return false;
    } else if (($("#occupation").val() == "4") && ($("#defaulted4").val() == "")) {
        alert("Please enter filed ‘ever defaulted on any loan or credit card’.");
        $("#defaulted4").focus();
        return false;
    } else if (($("#occupation").val() == "5") && ($("#pursuing5").val() == "")) {
        alert("Please select I am pursuing.");
        $("#p_address").focus();
        return false;
    } else if (($("#occupation").val() == "5") && ($("#institute_name5").val() == "")) {
        alert("Please enter Name of Educational Institution.");
        $("#institute_name5").focus();
        return false;
    } else if (($("#occupation").val() == "5") && ($("#net_monthly_income5").val() == "")) {
        alert("Please enter Net Monthly Income.");
        $("#net_monthly_income5").focus();
        return false;
    } else if (($("#occupation").val() == "5") && ($("#current_emis5").val() == "")) {
        alert("Please enter Current Total EMI.");
        $("#current_emis5").focus();
        return false;
    } else if (($("#occupation").val() == "5") && ($("#defaulted5").val() == "")) {
        alert("Please enter filed ‘ever defaulted on any loan or credit card’.");
        $("#defaulted5").focus();
        return false;
    } else {
        $("#form3").show();
        $("#form1").hide();
        $("#form2").hide();
        $("#step-form1").removeClass();
        $("#step-form1").addClass("is-complete");
        $("#step-form2").removeClass();
        $("#step-form2").addClass("is-complete");
        $("#step-form3").removeClass();
        $("#step-form3").addClass("is-active");
    }
}

function previous1() {
    if ($("#loan_type").val() == 1) {
        $("#form2").show();
        $("#form1").hide();
        $("#form3").hide();
        $("#step-form1").removeClass();
        $("#step-form1").addClass("is-complete");
        $("#step-form2").removeClass();
        $("#step-form2").addClass("is-active");
        $("#step-form3").removeClass();
    } else if ($("#loan_type").val() == 2) {
        $("#form2").hide();
        $("#form1").show();
        $("#form3").hide();
    }
}

function validateForm3() {
    var count = ($.trim($('[name="loan_description"]').val()).split(' ').filter(function(v) {
        return v !== ''
    }).length);
    if ($("#loan").val() == "") {
        alert("Please enter loan amount.");
        $("#loan_type").focus();
        return false;
    } else if (($("#min-range").val() == "") || ($("#max-range").val() == "")) {
        alert("Please select Minimum and Maximum Interest Range.");
        $("#min-range").focus();
        return false;
    } else if ($("#tenor-range").val() == "") {
        alert("Please select Tenor in months.");
        $("#tenor-range").focus();
        return false;
    } else if (($("#collateral_flag").val() == "Yes") && ($("#collateral_details").val() == "")) {
        alert("Please provide details of collateral");
        $("#collateral_details").focus();
        return false;
    } else if ($("#loan_description").val() == "") {
        alert("Please write a Loan Pitch.");
        $("#loan_description").focus();
        return false;
    } else if (count > 100) {
        alert("Maximum allowed limit exceeded. Allowed length is 100 characters");
        $("#loan_description").focus();
        return false;
    } else if ($("#tc_flag").is(':checked') == false) {
        alert("Please accept Terms and condition.");
        $("#tc_flag").focus();
        return false;
    } else {
        return true;
    }
}

function edit_borrower_details() {
    if($("#father_name").val() == "")
    {
        alert("Please enter Father Name.");
        $("#father_name").focus();
        return false;
    } else if ($("#mobile").val() == "") {
        alert("Please enter Mobile Number.");
        $("#mobile").focus();
        return false;
    } else if (($("#mobile").val() != "") && $("#mobile").val().length < 10) {
        alert("Invalid Phone number. Please check and try again.");
        $("#mobile").focus();
        return false;
    } else if ($("#datepicker1").val() == "") {
        alert("Please enter Date of Birth.");
        $("#datepicker1").focus();
        return false;
    } else if (($("#datepicker1").val() != "") && (getAge($("#datepicker1").val()) == false)) {
        alert("You aged less than 18 years, as per policy we do not cater services to minors.");
        $("#datepicker1").focus();
        return false;
    } else if ($("#gender").val() == "") {
        alert("Please select Gender.");
        $("#gender").focus();
        return false;
    } else if ($("#highest_qualification").val() == "") {
        alert("Please select Highest Qualification.");
        $("#highest_qualification").focus();
        return false;
    } else if ($("#r_address").val() == "") {
        alert("Please enter Residential Address.");
        $("#r_address").focus();
        return false;
    } else if ($("#r_state").val() == "") {
        alert("Please select state.");
        $("#r_state").focus();
        return false;
    } else if ($("#r_city").val() == "") {
        alert("Please select city.");
        $("#r_city").focus();
        return false;
    } else if ($("#r_pincode").val() == "") {
        alert("Please fill pincode.");
        $("#r_pincode").focus();
        return false;
    } else if (($("#r_pincode").val() != "") && ($("#r_pincode").val().length != 6)) {
        alert("Invalid PIN Code! Please check and try again.");
        $("#r_pincode").focus();
        return false;
    } else if (($("#o_pincode").val() != "") && ($("#o_pincode").val().length != 6)) {
        alert("Invalid PIN Code! Please check and try again.");
        $("#o_pincode").focus();
        return false;
    } else if (($("#o_tel_no").val() != "") && ($("#o_tel_no").val().length != 10)) {
        alert("Invalid Office Telephone Number! Please verify and try again.");
        $("#o_tel_no").focus();
        return false;
    } else if (($("#aadhaar").val() == "")) {
        alert("Please Enter Aadhaar Number (We keep your aadhaar number safe with encryption, with no possibilities of misuse)");

        $("#aadhaar").focus();
        return false;
    } else if(($("#aadhaar").val() != "") && ($("#aadhaar").val().length != 12)){
        alert("Invalid Aadhaar Number! Please check and try again.");
        $("#aadhaar").focus();
        return false;
    }else if (($("#passport").val() != "") && (validatePassport($("#passport").val()) == false)) {
        alert("Please check your Passport.");
        $("#passport").focus();
        return false;
    } else if ($("#pan").val() == "") {
        alert("Please enter PAN Number");
        $("#pan").focus();
        return false;
    } else if (($("#pan").val() != "") && (validatePan($("#pan").val()) == false)) {
        alert("We encountered some error while checking your PAN! Please check your PAN number and try again.");
        $("#pan").focus();
        return false;
    } else if ($("#occupation").val() == "") {
        alert("Please select Occupation.");
        $("#occupation").focus();
        return false;
    } else if (($("#occupation").val() == "1") && ($("#employed_company1").val() == "")) {
        alert("Please select type of company employed with.");
        $("#employed_company1").focus();
        return false;
    } else if (($("#occupation").val() == "1") && ($("#company_name1").val() == "")) {
        alert("Please enter Company Name.");
        $("#company_name1").focus();
        return false;
    } else if (($("#occupation").val() == "1") && ($("#net_monthly_income1").val() == "")) {
        alert("Please enter Net Monthly Income.");
        $("#net_monthly_income1").focus();
        return false;
    } else if (($("#occupation").val() == "1") && ($("#current_emis1").val() == "")) {
        alert("Please enter Current Total EMI.");
        $("#current_emis1").focus();
        return false;
    } else if (($("#occupation").val() == "1") && ($("#defaulted1").val() == "")) {
        alert("Please enter filed ‘ever defaulted on any loan or credit card’.");
        $("#defaulted1").focus();
        return false;
    } else if (($("#occupation").val() == "2") && ($("#industry_type2").val() == "")) {
        alert("Please select Industry Type.");
        $("#industry_type2").focus();
        return false;
    } else if (($("#occupation").val() == "2") && ($("#total_experience2").val() == "")) {
        alert("Please enter Total Experience.");
        $("#total_experience2").focus();
        return false;
    } else if (($("#occupation").val() == "2") && ($("#turnover_last_year2").val() == "")) {
        alert("Please enter Gross Turnover Last Year.");
        $("#turnover_last_year2").focus();
        return false;
    } else if (($("#occupation").val() == "2") && ($("#turnover_last2_year2").val() == "")) {
        alert("Please enter Gross Turnover Year 2.");
        $("#turnover_last2_year2").focus();
        return false;
    } else if (($("#occupation").val() == "2") && ($("#current_emis2").val() == "")) {
        alert("Please fill Current EMIs.");
        $("#current_emis2").focus();
        return false;
    } else if (($("#occupation").val() == "2") && ($("#defaulted2").val() == "")) {
        alert("Please fill Ever defaulted on any loan or credit card.");
        $("#defaulted2").focus();
        return false;
    } else if (($("#occupation").val() == "3") && ($("#professional_type3").val() == "")) {
        alert("Please select Profession Type.");
        $("#professional_type3").focus();
        return false;
    } else if (($("#occupation").val() == "3") && ($("#total_experience3").val() == "")) {
        alert("Please enter Total Experience.");
        $("#total_experience3").focus();
        return false;
    } else if (($("#occupation").val() == "3") && ($("#turnover_last_year3").val() == "")) {
        alert("Please enter Gross Turnover Last Year.");
        $("#turnover_last_year3").focus();
        return false;
    } else if (($("#occupation").val() == "3") && ($("#turnover_last2_year3").val() == "")) {
        alert("Please enter Gross Turnover Year 2.");
        $("#turnover_last2_year2").focus();
        return false;
    } else if (($("#occupation").val() == "3") && ($("#office_ownership3").val() == "")) {
        alert("Please enter Office Ownership.");
        $("#office_ownership3").focus();
        return false;
    } else if (($("#occupation").val() == "3") && ($("#current_emis3").val() == "")) {
        alert("Please fill Current EMIs.");
        $("#current_emis3").focus();
        return false;
    } else if (($("#occupation").val() == "3") && ($("#defaulted3").val() == "")) {
        alert("Please fill Ever defaulted on any loan or credit card.");
        $("#defaulted3").focus();
        return false;
    } else if (($("#occupation").val() == "4") && ($("#company_type4").val() == "")) {
        alert("Please select type of company employed with.");
        $("#company_type4").focus();
        return false;
    } else if (($("#occupation").val() == "4") && ($("#company_name4").val() == "")) {
        alert("Please enter company name.");
        $("#company_name4").focus();
        return false;
    } else if (($("#occupation").val() == "4") && ($("#net_monthly_income4").val() == "")) {
        alert("Please enter Net Monthly Income.");
        $("#net_monthly_income4").focus();
        return false;
    } else if (($("#occupation").val() == "4") && ($("#current_emis4").val() == "")) {
        alert("Please enter Current Total EMI.");
        $("#current_emis4").focus();
        return false;
    } else if (($("#occupation").val() == "4") && ($("#defaulted4").val() == "")) {
        alert("Please enter filed ‘ever defaulted on any loan or credit card’.");
        $("#defaulted4").focus();
        return false;
    } else if (($("#occupation").val() == "5") && ($("#pursuing5").val() == "")) {
        alert("Please select I am pursuing.");
        $("#p_address").focus();
        return false;
    } else if (($("#occupation").val() == "5") && ($("#institute_name5").val() == "")) {
        alert("Please enter Name of Educational Institution.");
        $("#institute_name5").focus();
        return false;
    } else if (($("#occupation").val() == "5") && ($("#net_monthly_income5").val() == "")) {
        alert("Please enter Net Monthly Income.");
        $("#net_monthly_income5").focus();
        return false;
    } else if (($("#occupation").val() == "5") && ($("#current_emis5").val() == "")) {
        alert("Please fill Current EMIs.");
        $("#current_emis5").focus();
        return false;
    } else if (($("#occupation").val() == "5") && ($("#defaulted5").val() == "")) {
        alert("Please fill Ever defaulted on any loan or credit card.");
        $("#defaulted5").focus();
        return false;
    } else {
        return true;
    }
}

function add_loan_proposal() {
    if ($("#loan").val() == "") {
        alert("Please enter loan amount.");
        $("#loan_type").focus();
        return false;
    } else if (($("#min-range").val() == "") || ($("#max-range").val() == "")) {
        alert("Please select Minimum and Maximum interest Range.");
        $("#min-range").focus();
        return false;
    } else if ($("#tenor-range").val() == "") {
        alert("Please select Tenor in months.");
        $("#tenor-range").focus();
        return false;
    } else if (($("#collateral_flag").val() == "Yes") && ($("#collateral_details").val() == "")) {
        alert("Please provide details of collateral.");
        $("#collateral_details").focus();
        return false;
    } else if ($("#loan_description").val() == "") {
        alert("Please enter Loan Pitch.");
        $("#loan_description").focus();
        return false;
    } else {
        return true;
    }
}

function validateCorp() {
    if ($("#loan_type").val() == "") {
        alert("Please select I am.");
        $("#loan_type").focus();
        return false;
    } else if ($("#loan_purpose").val() == "") {
        alert("Please select Looking For.");
        $("#loan_purpose").focus();
        return false;
    } else if ($("#company_name").val() == "") {
        alert("Please enter Company Name.");
        $("#company_name").focus();
        return false;
    } else if ($("#person_name").val() == "") {
        alert("Please enter Person Name.");
        $("#person_name").focus();
        return false;
    } else if ($("#company_email").val() == "") {
        alert("Please fill Email.");
        $("#company_email").focus();
        return false;
    } else if (($("#company_email").val() != "") && validateEmail($("#company_email").val())) {
        alert("Please fill valid email ID.");
        $("#company_email").focus();
        return false;
    } else if ($("#company_password").val() == "") {
        alert("Please fill Password.");
        $("#company_password").focus();
        return false;
    } else if (($("#company_password").val() != "") && validatePassword($("#company_password").val()) == false) {
        alert("Invalid Password. Please check and try again.");
        $("#company_password").focus();
        return false;
    } else if ($("#company_username").val() == "") {
        alert("Please fill Username.");
        $("#company_username").focus();
        return false;
    } else if ($("#company_mobile").val() == "") {
        alert("Please fill Mobile No.");
        $("#company_mobile").focus();
        return false;
    } else if (($("#company_mobile").val() != "") && $("#company_mobile").val().length < 10) {
        alert("Invalid Phone number. Please check and try again.");
        $("#company_mobile").focus();
        return false;
    } else if ($("#yr_incorp").val() == "") {
        alert("Please enter Year of Incorporation.");
        $("#yr_incorp").focus();
        return false;
    } else if ($("#company_industry").val() == "") {
        alert("Please select Industry Type.");
        $("#company_industry").focus();
        return false;
    } else {
        $("#form3").show();
        $("#form1").hide();
    }
}

function feedback_valid() {
    if ($("#fname").val() == "") {
        alert("Please enter First Name!");
        $("#fname").focus();
        return false;
    } else if ($("#lname").val() == "") {
        alert("Please enter Last Name!");
        $("#lname").focus();
        return false;
    } else if ($("#email").val() == "") {
        alert("Please enter Email!");
        $("#email").focus();
        return false;
    } else if (($("#email").val() != "") && validateEmail($("#email").val())) {
        alert("Invalid email ID.");
        $("#email").focus();
        return false;
    } else if ($("#state").val() == "") {
        alert("Please select State");
        $("#state").focus();
        return false;
    } else if ($("#city").val() == "") {
        alert("Please select City");
        $("#city").focus();
        return false;
    } else if ($("#mobile").val() == "") {
        alert("Please enter  Mobile");
        $("#mobile").focus();
        return false;
    } else if (($("#mobile").val() != "") && $("#mobile").val().length < 10) {
        alert("Invalid Phone number. Please check and try again.");
        $("#mobile").focus();
        return false;
    } else if ($("#query").val() == "") {
        alert("Please enter Query!");
        $("#query").focus();
        return false;
    } else {
        return true;
    }
}

function exit_form_valid() {
    if ($("#email").val() == "") {
        alert("Please fill Email!");
        $("#email").focus();
        return false;
    } else if (($("#email").val() != "") && validateEmail($("#email").val())) {
        alert("Please fill valid email ID.");
        $("#email").focus();
        return false;
    } else if ($("#mobile").val() == "") {
        alert("Please fill Mobile!");
        $("#mobile").focus();
        return false;
    } else if (($("#mobile").val() != "") && $("#mobile").val().length < 10) {
        alert("Phone cann't be less than 10 digits.");
        $("#mobile").focus();
        return false;
    } else {
        return true;
    }
}

function forgot_password() {
    if ($("#forgot_email").val() == "") {
        alert("Please enter email ID.");
        $("#forgot_email").focus();
        return false;
    } else if (($("#forgot_email").val() != "") && validateEmail($("#forgot_email").val())) {
        alert("Please fill valid email ID.");
        $("#forgot_email").focus();
        return false;
    } else {
        return true;
    }
}

function reset_submit_password() {
    if ($("#n_password").val() == "") {
        alert("Please fill New Password.");
        $("#n_password").focus();
        return false;
    } else if (($("#n_password").val() != "") && validatePassword($("#n_password").val()) == false) {
        alert("Please fill valid Password.");
        $("#n_password").focus();
        return false;
    } else if ($("#c_password").val() == "") {
        alert("Please fill Confirm Password.");
        $("#c_password").focus();
        return false;
    } else if (($("#c_password").val()) != ($("#n_password").val())) {
        alert("Password did not match. Please try again.");
        $("#c_password").focus();
        return false;
    }
}

function subscribedEmail() {

    var email = $("#email").val();
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email) || email == '') {
        $("#subscribed_message").html('<p style="color: red">Please enter valid email</p>');
        return false;
    }
}

function validate_contact()
{
    var v = grecaptcha.getResponse();
    $(".errors-class").html("");
    //$(".help-block").css('display', 'none');

    if($("#name").val()=="")
    {
        $("#name-error").html("Please fill out this field.");
        $("#name").focus();
        return false;
    }
    else if($("#email").val()=="")
    {
        $("#email-error").html("Please fill out this field.");
        $("#email").focus();
        return false;
    }
    else if(($("#email").val()!="") && validateEmail($("#email").val()))
    {
        $("#email-error").html("Please fill valid email ID.");
        $("#email").focus();
        return false;
    }
    else if($("#mobile").val()=="")
    {
        $("#mobile-error").html("Please fill out this field.");
        $("#mobile").focus();
        return false;
    }
    else if(($("#mobile").val()!="") && $("#mobile").val().length<10)
    {
        $("#mobile-error").html("Phone cann't be less than 10 digits.");
        $("#mobile").focus();
        return false;
    }
    else if($("#subject").val()=="")
    {
        $("#subject-error").html("Please fill out this field.");
        $("#subject").focus();
        return false;
    }
    else if($("#message").val()=="")
    {
        $("#message-error").html("Please fill out this field.");
        $("#message").focus();
        return false;
    }
    else if(v.length == 0)
    {
        document.getElementById('captcha').innerHTML="Please complete Captcha verification";
        return false;
    }
    else
    {
        document.getElementById('captcha').innerHTML="Captcha verified successfully";
        return true;
    }

}