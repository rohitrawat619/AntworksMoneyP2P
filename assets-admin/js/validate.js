function validatePassword(pwd)
{
	var pattern = new RegExp("^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$");
	var status = pattern.test(pwd);
	if(status)
    {
    	return true
    }
    else
    {
    	return false;
    }
}

function validateName(val){    
    var re = /^[A-Za-z ]+$/;
    if(re.test(val))
      return true;
    else
      return false;     
}

function validateEmail(email) 
{
	var re =  /\S+@\S+\.\S+/;
    $a=re.test(email);
    if($a==false)
    {
    	return true;
    }
    else
    {
    	return false;
    }   
}

function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if ((charCode > 47 && charCode < 58) || (charCode == 8)) {
		return true;
	}
	else {
		return false;
	}
}

function isNumberKeyWithDot(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if ((charCode >= 46 && charCode < 58) || (charCode == 8)) {
		return true;
	}
	else {
		return false;
	}
}

function validatePan(s)
{
	var ss = s.toUpperCase();
	var pattern = new RegExp("[A-Z]{5}[0-9]{4}[A-Z]{1}");
	var status = pattern.test(ss);
	if (status) {
	  return true;
	}else
	{
		return false;
	}
}

function getAge(bday){
	var validDOB = false;
	
	var today = new Date(); 
	var nowyear = today.getFullYear();
	
	var bdate = bday.replace(/-/g,"-");
	d = bdate.split("-");
	var byr = parseInt(d[0]); 
	if (byr <1900) {byr = byr + 2000}
	var bmth = parseInt(d[1],10);   // radix 10!
	var bdy = parseInt(d[2],10);   // radix 10!
	
	checkValidDate(byr,bmth,bdy);
	//if (!validDOB) {return false}
	
	var age = nowyear - byr;
	var nowmonth = today.getMonth();  // months are 0-11
	var nowday = today.getDate();
	var nowmonth_new = nowmonth+1;
	
	var new_age = age;
	if (bmth > nowmonth_new)
	{
		var new_age = age;
	}  // next birthday not yet reached
	else if((bmth == nowmonth_new) && (nowday < bdy))
	{
		var new_age = age - 1;
	}  // next birthday not yet reached
	
	//alert('You are ' + new_age + ' years old'); 
	if(new_age >= 18)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function checkValidDate(yr,mmx,dd) {

	var today = new Date(); 
	var nowyear = today.getFullYear();
	if (yr <1910 || yr > nowyear-1) {  // you may want to change this to some other year!
		//alert ("Impossible Year Of Birth!")
		return false;
	}

	mm = mmx-1;  // remember that in Javascript date objects the months are 0-11
	var nd = new Date();
	nd.setFullYear(yr,mm,dd);  // format YYYY,MM(0-11),DD
	
	var ndmm = nd.getMonth();
	if (ndmm != mm)
	{
		//alert (dd + "-" + mmx + "-" + yr  + " is an Invalid Date!");
		validDOB = false; 
		return validDOB;
	}
	else
	{
		//alert (dd + "-" + mmx + "-" + yr  + " is a validDOB Date");
		validDOB = true;
		return validDOB;
	}
}

function add_user_valid()
{
	$(".errors-class").html("");
	//$(".help-block").css('display', 'none');
	
	if($("#username").val()=="")
	{
		$("#username-error").html("Please fill detail.");
		$("#username").focus();
		$("#username").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#password").val()=="")
	{
		$("#password-error").html("Please fill detail.");
		$("#password").focus();
		$("#password").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if(($("#password").val()!="") && validatePassword($("#password").val())==false)
	{
		$("#password-error").html("Please fill valid Password.");
		$("#password").focus();
		$("#password").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#first_name").val()=="")
	{
		$("#first_name-error").html("Please fill out this field.");
		$("#first_name").focus();
		$("#first_name").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#email").val()=="")
	{
		$("#email-error").html("Please fill out this field.");
		$("#email").focus();
		$("#email").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if(($("#email").val()!="") && validateEmail($("#email").val()))
	{
		$("#email-error").html("Invalid email ID.");
		$("#email").focus();
		$("#email").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#mobile").val()=="")
	{
		$("#mobile-error").html("Please fill out this field.");
		$("#mobile").focus();
		$("#mobile").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if(($("#mobile").val()!="") && $("#mobile").val().length<10)
	{
		$("#mobile-error").html("Invalid Phone number. Please check and try again.");
		$("#mobile").focus();
		$("#mobile").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#datepicker-autoclose").val()=="")
	{
		$("#datepicker-autoclose-error").html("Please fill out this field.");
		$("#datepicker-autoclose").focus();
		$("#datepicker-autoclose").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if(($("#datepicker-autoclose").val()!="") && (getAge($("#datepicker-autoclose").val())==false))
	{
		$("#datepicker-autoclose-error").html("Please check your DOB. DOB should be minimum 18 years.");
		$("#datepicker-autoclose").focus();
		$("#datepicker-autoclose").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#gender").val()=="")
	{
		$("#gender-error").html("Please fill out this field.");
		$("#gender").focus();
		$("#gender").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#state").val()=="")
	{
		$("#state-error").html("Please fill out this field.");
		$("#state").focus();
		$("#state").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#city").val()=="")
	{
		$("#city-error").html("Please fill out this field.");
		$("#city").focus();
		$("#city").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#address").val()=="")
	{
		$("#address-error").html("Please fill out this field.");
		$("#address").focus();
		$("#address").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	/*else if($("#profilepic").val()=="")
	{
		$("#profilepic-error").html("Please fill out this field.");
		$("#profilepic").focus();
		$("#profilepic").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}*/
	
	
	else
	{
		return true;
	}
}

function add_role_valid()
{
	$(".errors-class").html("");
	//$(".help-block").css('display', 'none');
	
	if($("#role").val()=="")
	{
		$("#role-error").html("Please fill out this field.");
		$("#role").focus();
		$("#role").css('border-color', 'red');
		return false;
	}
	
	
	else
	{
		return true;
	}
}

function edit_user_valid()
{
	$(".errors-class").html("");
	//$(".help-block").css('display', 'none');
	
	if($("#username").val()=="")
	{
		$("#username-error").html("Please fill out this field.");
		$("#username").focus();
		$("#username").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}/*
	else if($("#password").val()=="")
	{
		$("#password-error").html("Please fill out this field.");
		$("#password").focus();
		$("#password").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}*/
	else if(($("#password").val()!="") && validatePassword($("#password").val())==false)
	{
		$("#password-error").html("Please fill valid Password.");
		$("#password").focus();
		$("#password").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#fullname").val()=="")
	{
		$("#fullname-error").html("Please fill out this field.");
		$("#fullname").focus();
		$("#fullname").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#email").val()=="")
	{
		$("#email-error").html("Please fill out this field.");
		$("#email").focus();
		$("#email").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if(($("#email").val()!="") && validateEmail($("#email").val()))
	{
		$("#email-error").html("Invalid email ID.");
		$("#email").focus();
		$("#email").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#mobile").val()=="")
	{
		$("#mobile-error").html("Please fill out this field.");
		$("#mobile").focus();
		$("#mobile").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if(($("#mobile").val()!="") && $("#mobile").val().length<10)
	{
		$("#mobile-error").html("Invalid Phone number. Please check and try again.");
		$("#mobile").focus();
		$("#mobile").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#datepicker-autoclose").val()=="")
	{
		$("#datepicker-autoclose-error").html("Please fill out this field.");
		$("#datepicker-autoclose").focus();
		$("#datepicker-autoclose").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if(($("#datepicker-autoclose").val()!="") && (getAge($("#datepicker-autoclose").val())==false))
	{
		$("#datepicker-autoclose-error").html("Please check your DOB. DOB should be minimum 18 years.");
		$("#datepicker-autoclose").focus();
		$("#datepicker-autoclose").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#gender").val()=="")
	{
		$("#gender-error").html("Please fill out this field.");
		$("#gender").focus();
		$("#gender").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#city").val()=="")
	{
		$("#city-error").html("Please fill out this field.");
		$("#city").focus();
		$("#city").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#address").val()=="")
	{
		$("#address-error").html("Please fill out this field.");
		$("#address").focus();
		$("#address").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}/*
	else if($("#profilepic").val()=="")
	{
		$("#profilepic-error").html("Please fill out this field.");
		$("#profilepic").focus();
		$("#profilepic").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}*/
	
	
	else
	{
		return true;
	}
}


//validation advanced form borrower

function validate_advanced1()
{
	$(".errors-class").html("");
	/*if($("#mobile").val()=="")
	{
		$("#mobile-error").html("Please fill out this field.");
		$("#mobile").focus();
		return false;
	}
	else if(($("#mobile").val()!="") && $("#mobile").val().length<10)
	{
		$("#mobile-error").html("Invalid Phone number. Please check and try again.");
		$("#mobile").focus();
		return false;
	}
	else if($("#datepicker-autoclose").val()=="")
	{
		$("#datepicker-autoclose-error").html("Please fill out this field.");
		$("#datepicker-autoclose").focus();
		return false;
	}
	else if(($("#datepicker-autoclose").val()!="") && (getAge($("#datepicker-autoclose").val())==false))
	{
		$("#datepicker-autoclose-error").html("Please check your DOB. DOB should be minimum 18 years.");
		$("#datepicker-autoclose").focus();
		return false;
	}
	else*/ if($("#pan").val()=="")
	{
		$("#pan-error").html("Please fill out this field.");
		$("#pan").focus();
		return false;
	}
	else if(($("#pan").val()!="") && validatePan($("#pan").val())==false)
	{
		$("#pan-error").html("Please fill valid PAN Number.");
		$("#pan").focus();
		return false;
	}
	else if(($("#aadhaar").val()!="") && $("#aadhaar").val().length<12)
	{
		$("#aadhaar-error").html("Aadhaar can't be less than 12 digits.");
		$("#aadhaar").focus();
		return false;
	}
	
	else
	{
		$('.div1').removeClass('current');
		$('.div2').addClass('current');
		$('.div1').addClass('done');
		$("#div1").hide();
		$("#div3").hide();
		$("#div2").show();
		return true
	}
}

function previous11()
{
	$('.div1').removeClass('done');
	$('.div2').removeClass('current');
	$('.div3').removeClass('current');
	$('.div1').addClass('current');
	$("#div1").show();
	$("#div2").hide();
	$("#div3").hide();
}

function validate_advanced11()
{
	$(".errors-class").html("");
	if($("#occupation").val()=="")
	{
		$("#occupation-error").html("Please fill out this field.");
		$("#occupation").focus();
		return false;
	}
	else if($("#investments").val()=="")
	{
		$("#investments-error").html("Please fill detail.");
		$("#investments").focus();
		return false;
	}
	else if($("#min_loan_preference").val()=="")
	{
		$("#min_loan_preference-error").html("Please fill out this field.");
		$("#min_loan_preference").focus();
		return false;
	}
	else if(($("#min_loan_preference").val()!="") && (($("#min_loan_preference").val())<100000))
	{
		$("#min_loan_preference-error").html("Loan Amounnt is not less than 1 Lac");
		$("#min_loan_preference").focus();
		return false;
	}
	else if(($("#min_loan_preference").val()!="") && (($("#min_loan_preference").val())>20000000))
	{
		$("#min_loan_preference-error").html("Loan Amounnt is not greater than 2 Crore");
		$("#min_loan_preference").focus();
		return false;
	}
	else if($("#max_loan_preference").val()=="")
	{
		$("#max_loan_preference-error").html("Please fill out this field.");
		$("#max_loan_preference").focus();
		return false;
	}
	else if(($("#max_loan_preference").val()!="") && (($("#max_loan_preference").val())<100000))
	{
		$("#max_loan_preference-error").html("Loan Amounnt is not less than 1 Lac");
		$("#max_loan_preference").focus();
		return false;
	}
	else if(($("#max_loan_preference").val()!="") && (($("#max_loan_preference").val())>20000000))
	{
		$("#max_loan_preference-error").html("Loan Amounnt is not greater than 2 Crore");
		$("#max_loan_preference").focus();
		return false;
	}
	else if(($("#min_interest_rate").val()=="") || ($("#max_interest_rate").val()==""))
	{
		$("#min_interest_rate-error").html("Please fill out this field.");
		$("#min_interest_rate").focus();
		return false;
	}
	else if(($("#min_tenor").val()=="") || ($("#max_tenor").val()==""))
	{
		$("#min_tenor-error").html("Please fill detail.");
		$("#min_tenor").focus();
		return false;
	}
	else if($("#description").val()=="")
	{
		$("#description-error").html("Please fill out this field.");
		$("#description").focus();
		return false;
	}
	
	else
	{
		$('.div1').removeClass('current');
		$('.div2').removeClass('current');
		$('.div1').addClass('done');
		$('.div2').addClass('done');
		$('.div3').addClass('current');
		$("#div1").hide();
		$("#div2").hide();
		$("#div3").show();
		return true
	}
}


function previous12()
{
	$('.div1').removeClass('current');
	$('.div2').removeClass('done');
	$('.div3').removeClass('current');
	$('.div2').addClass('current');
	$('.div1').addClass('done');
	$("#div3").hide();
	$("#div1").hide();
	$("#div2").show();
}

function validate_finish()
{
	$("#validation").submit();	
}

function validate_lenders_proposal()
{
	$(".errors-class").html("");
	//$(".help-block").css('display', 'none');
	
	if($("#loan_amount").val()=="")
	{
		$("#loan_amount-error").html("Please fill out this field.");
		$("#loan_amount").focus();
		return false;
	}
	else if($("#interest_rate").val()=="")
	{
		$("#interest_rate-error").html("Please fill out this field.");
		$("#interest_rate").focus();
		return false;
	}
	/*else if($("#proposal_description").val()=="")
	{
		$("#proposal_description-error").html("Please fill out this field.");
		$("#proposal_description").focus();
		return false;
	}*/	
	
	else
	{
		return true;
	}
}


function previous2()
{
	$('.div1').removeClass('current');
	$('.div2').removeClass('done');
	$('.div3').removeClass('current');
	$('.div1').addClass('done');
	$('.div2').addClass('current');
	$("#div1").hide();
	$("#div2").show();
	$("#div3").hide();
}
function validate_advanced2()
{
	$(".errors-class").html("");
	if($("#state").val()=="")
	{
		$("#state-error").html("Please select State.");
		$("#state").focus();
		return false;
	}
	else if($("#city").val()=="")
	{
		$("#city-error").html("Please select City.");
		$("#city").focus();
		return false;
	}
	else if($("#address").val()=="")
	{
		$("#address-error").html("Please fill Address.");
		$("#address").focus();
		return false;
	}
	/*else if(($("#pincode").val()!="") && $("#pincode").val().length<6)
	{
		$("#pincode-error").html("Pincode can't be less than 6 digits.");
		$("#pincode").focus();
		return false;
	}*/
	
	else
	{
		$('.div1').removeClass('current');
		$('.div2').removeClass('current');
		$('.div3').addClass('current');
		$('.div1').addClass('done');
		$('.div2').addClass('done');
		$("#div1").hide();
		$("#div2").hide();
		$("#div3").show();
		return true
	}
}

function validate_finish_fc()
{
	$(".errors-class").html("");
	//$(".help-block").css('display', 'none');
	
	if($("#business_type").val()=="")
	{
		$("#business_type-error").html("Please fill detail.");
		$("#business_type").focus();
		return false;
	}
	else if($('#already_in_business').val()=="")
	{
		$("#already_in_business-error").html("Please fill detail.");
		$("#already_in_business").focus();
		return false;
	}
	else if(($('#already_in_business').val()=="YES") && ($('#agency').val()==""))
	{
		$("#agency-error").html("Please fill out this field.");
		$("#agency").focus();
		return false;
	}
	
	else
	{
		$("#validation").submit();
	}
}


function validateForm1()
{
	if($("#loan_type").val()=="")
	{
		alert("Please select I am.");
		$("#loan_type").focus();
		return false;
	}
	else if($("#loan_purpose").val()=="")
	{
		alert("Please select Looking For.");
		$("#loan_purpose").focus();
		return false;
	}
	else if($("#first_name").val()=="")
	{
		alert("Please enter your First Name.");
		$("#first_name").focus();
		return false;
	}
	else if($("#last_name").val()=="")
	{
		alert("Please enter your Last Name.");
		$("#last_name").focus();
		return false;
	}
	else if($("#datepicker-autoclose").val()=="")
	{
		alert("Please enter Date of Birth.");
		$("#datepicker-autoclose").focus();
		return false;
	}
	else if(($("#datepicker-autoclose").val()!="") && (getAge($("#datepicker-autoclose").val())==false))
	{
		alert("You aged less than 18 years, as per policy we do not cater services to minors.");
		$("#datepicker-autoclose").focus();
		return false;
	}
	else if($("#gender").val()=="")
	{
		alert("Please select Gender.");
		$("#gender").focus();
		return false;
	}
	else if($("#username").val()=="")
	{
		alert("Please enter Username.");
		$("#username").focus();
		return false;
	}
	else if($("#password").val()=="")
	{
		alert("Please enter Password.");
		$("#password").focus();
		return false;
	}
	else if(($("#password").val()!="") && validatePassword($("#password").val())==false)
	{
		alert("Invalid Password, please check and try again");
		$("#password").focus();
		return false;
	}
	else if($("#email").val()=="")
	{
		alert("Please enter Email.");
		$("#email").focus();
		return false;
	}
	else if(($("#email").val()!="") && validateEmail($("#email").val()))
	{
		alert("Invalid email ID.");
		$("#email").focus();
		return false;
	}
	else if($("#mobile").val()=="")
	{
		alert("Please fill Mobile No.");
		$("#mobile").focus();
		return false;
	}
	else if(($("#mobile").val()!="") && $("#mobile").val().length<10)
	{
		alert("Invalid Phone number. Please check and try again.");
		$("#mobile").focus();
		return false;
	}
	else if($("#highest_qualification").val()=="")
	{
		alert("Please select Highest Qualification.");
		$("#highest_qualification").focus();
		return false;
	}
	else if($("#pan").val()=="")
	{
		alert("Please fill Pancard No.");
		$("#pan").focus();
		return false;
	}
	else if(($("#pan").val()!="") && (validatePan($("#pan").val())==false))
	{
		alert("Please check your pancard.");
		$("#pan").focus();
		return false;
	}
	else if($("#r_address").val()=="")
	{
		alert("Please fill Residential address.");
		$("#r_address").focus();
		return false;
	}
	else if($("#state").val()=="")
	{
		alert("Please select State.");
		$("#state").focus();
		return false;
	}
	else if($("#city").val()=="")
	{
		alert("Please select city.");
		$("#city").focus();
		return false;
	}
	else if($("#r_pincode").val()=="")
	{
		alert("Please fill pincode.");
		$("#r_pincode").focus();
		return false;
	}
	else if(($("#r_pincode").val()!="") && ($("#r_pincode").val().length!=6))
	{
		alert("Pincode can not be less than 6 digits.");
		$("#r_pincode").focus();
		return false;
	}
	
	else
	{
		$('html, body').animate({ scrollTop: 0 }, 'fast');
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

function previous()
{
	$('html, body').animate({ scrollTop: 0 }, 'fast');
	$("#form1").show();
	$("#form2").hide();
	$("#form3").hide();
	
	$("#step-form1").removeClass();
	$("#step-form1").addClass("is-active");
	$("#step-form2").removeClass();
	$("#step-form3").removeClass();
}

function validateForm2()
{
	if($("#occupation").val()=="")
	{
		alert("Please select Occupation.");
		$("#occupation").focus();
		return false;
	}
	
	// For Salaried
	else if(($("#occupation").val()=="1") && ($("#employed_company1").val()==""))
	{
		alert("Please select type of company employed with.");
		$("#employed_company1").focus();
		return false;
	}
	else if(($("#occupation").val()=="1") && ($("#company_name1").val()==""))
	{
		alert("Please enter Company Name.");
		$("#company_name1").focus();
		return false;
	}
	else if(($("#occupation").val()=="1") && ($("#net_monthly_income1").val()==""))
	{
		alert("Please fill Net Monthly Income.");
		$("#net_monthly_income1").focus();
		return false;
	}
	else if(($("#occupation").val()=="1") && ($("#current_emis1").val()==""))
	{
		alert("Please fill Current EMIs.");
		$("#current_emis1").focus();
		return false;
	}
	else if(($("#occupation").val()=="1") && ($("#defaulted1").val()==""))
	{
		alert("Please fill Ever defaulted on any loan or credit card.");
		$("#defaulted1").focus();
		return false;
	}
	
	// For Self employed Business
	else if(($("#occupation").val()=="2") && ($("#industry_type2").val()==""))
	{
		alert("Please select Industry Type.");
		$("#industry_type2").focus();
		return false;
	}
	else if(($("#occupation").val()=="2") && ($("#total_experience2").val()==""))
	{
		alert("Please fill Total Experience.");
		$("#total_experience2").focus();
		return false;
	}
	else if(($("#occupation").val()=="2") && ($("#turnover_last_year2").val()==""))
	{
		alert("Please fill Gross Turnover Last Year.");
		$("#turnover_last_year2").focus();
		return false;
	}
	else if(($("#occupation").val()=="2") && ($("#turnover_last2_year2").val()==""))
	{
		alert("Please fill Gross Turnover Year 2.");
		$("#turnover_last2_year2").focus();
		return false;
	}
	else if(($("#occupation").val()=="2") && ($("#current_emis2").val()==""))
	{
		alert("Please fill Current EMIs.");
		$("#current_emis2").focus();
		return false;
	}
	else if(($("#occupation").val()=="2") && ($("#defaulted2").val()==""))
	{
		alert("Please fill Ever defaulted on any loan or credit card.");
		$("#defaulted2").focus();
		return false;
	}
	
	// For Self employed Professional
	else if(($("#occupation").val()=="3") && ($("#professional_type3").val()==""))
	{
		alert("Please select Profession Type.");
		$("#professional_type3").focus();
		return false;
	}
	else if(($("#occupation").val()=="3") && ($("#total_experience3").val()==""))
	{
		alert("Please fill Total Experience.");
		$("#total_experience3").focus();
		return false;
	}
	else if(($("#occupation").val()=="3") && ($("#turnover_last_year3").val()==""))
	{
		alert("Please fill Gross Turnover Last Year.");
		$("#turnover_last_year3").focus();
		return false;
	}
	else if(($("#occupation").val()=="3") && ($("#turnover_last2_year3").val()==""))
	{
		alert("Please fill Gross Turnover Year 2.");
		$("#turnover_last2_year2").focus();
		return false;
	}
	else if(($("#occupation").val()=="3") && ($("#office_ownership3").val()==""))
	{
		alert("Please fill Office Ownership.");
		$("#office_ownership3").focus();
		return false;
	}
	else if(($("#occupation").val()=="3") && ($("#current_emis3").val()==""))
	{
		alert("Please fill Current EMIs.");
		$("#current_emis3").focus();
		return false;
	}
	else if(($("#occupation").val()=="3") && ($("#defaulted3").val()==""))
	{
		alert("Please fill Ever defaulted on any loan or credit card.");
		$("#defaulted3").focus();
		return false;
	}
	
	// For Retired
	else if(($("#occupation").val()=="4") && ($("#company_type4").val()==""))
	{
		alert("Please select type of company employed with.");
		$("#company_type4").focus();
		return false;
	}
	else if(($("#occupation").val()=="4") && ($("#company_name4").val()==""))
	{
		alert("Please enter Company Name.");
		$("#company_name4").focus();
		return false;
	}
	else if(($("#occupation").val()=="4") && ($("#net_monthly_income4").val()==""))
	{
		alert("Please fill Net Monthly Income.");
		$("#net_monthly_income4").focus();
		return false;
	}
	else if(($("#occupation").val()=="4") && ($("#current_emis4").val()==""))
	{
		alert("Please fill Current EMIs.");
		$("#current_emis4").focus();
		return false;
	}
	else if(($("#occupation").val()=="4") && ($("#defaulted4").val()==""))
	{
		alert("Please fill Ever defaulted on any loan or credit card.");
		$("#defaulted4").focus();
		return false;
	}
	
	// For Student
	else if(($("#occupation").val()=="5") && ($("#pursuing5").val()==""))
	{
		alert("Please select I am pursuing.");
		$("#p_address").focus();
		return false;
	}
	else if(($("#occupation").val()=="5") && ($("#institute_name5").val()==""))
	{
		alert("Please fill Name of Educational Institution.");
		$("#institute_name5").focus();
		return false;
	}else if(($("#occupation").val()=="5") && ($("#net_monthly_income5").val()==""))
	{
		alert("Please fill Net Monthly Income.");
		$("#net_monthly_income5").focus();
		return false;
	}
	else if(($("#occupation").val()=="5") && ($("#current_emis5").val()==""))
	{
		alert("Please fill Current EMIs.");
		$("#current_emis5").focus();
		return false;
	}
	else if(($("#occupation").val()=="5") && ($("#defaulted5").val()==""))
	{
		alert("Please fill Ever defaulted on any loan or credit card.");
		$("#defaulted5").focus();
		return false;
	}
	
	else
	{
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


function previous1()
{
	if($("#loan_type").val()==1)
	{
		$("#form2").show();
		$("#form1").hide();
		$("#form3").hide();
		
		$("#step-form1").removeClass();
		$("#step-form1").addClass("is-complete");
		$("#step-form2").removeClass();
		$("#step-form2").addClass("is-active");
		$("#step-form3").removeClass();
	}
	else if($("#loan_type").val()==2)
	{
		$("#form2").hide();
		$("#form1").show();
		$("#form3").hide();
	}
	
}

function validateForm3()
{
	if($("#loan").val()=="")
	{
		alert("Please select loan amount.");
		$("#loan_type").focus();
		return false;
	}
	else if(($("#min-range").val()=="") || ($("#max-range").val()==""))
	{
		alert("Please select Minimum and Maximum interest Range.");
		$("#min-range").focus();
		return false;
	}
	else if($("#tenor-range").val()=="")
	{
		alert("Please select Tenor in months.");
		$("#tenor-range").focus();
		return false;
	}
	else if(($("#collateral_flag").val()=="Yes") && ($("#collateral_details").val()==""))
	{
		alert("Please provide details of collateral.");
		$("#collateral_details").focus();
		return false;
	}
	else if($("#loan_description").val()=="")
	{
		alert("Please enter Loan Pitch.");
		$("#loan_description").focus();
		return false;
	}
	else if($("#tc_flag").is(':checked')==false)
	{
		alert("Please accept Terms and condition.");
		$("#tc_flag").focus();
		return false;
	}
	
	else
	{
		return true;
	}
	
}

function validateCorp()
{
	if($("#loan_type").val()=="")
	{
		alert("Please select I am.");
		$("#loan_type").focus();
		return false;
	}
	else if($("#loan_purpose").val()=="")
	{
		alert("Please select Looking For.");
		$("#loan_purpose").focus();
		return false;
	}
	else if($("#company_name").val()=="")
	{
		alert("Please enter Company Name.");
		$("#company_name").focus();
		return false;
	}
	else if($("#person_name").val()=="")
	{
		alert("Please enter Person Name.");
		$("#person_name").focus();
		return false;
	}
	else if($("#company_email").val()=="")
	{
		alert("Please enter Email.");
		$("#company_email").focus();
		return false;
	}
	else if(($("#company_email").val()!="") && validateEmail($("#company_email").val()))
	{
		alert("Invalid email ID.");
		$("#company_email").focus();
		return false;
	}
	else if($("#company_password").val()=="")
	{
		alert("Please enter Password.");
		$("#company_password").focus();
		return false;
	}
	else if(($("#company_password").val()!="") && validatePassword($("#company_password").val())==false)
	{
		alert("Invalid Password, please check and try again.");
		$("#company_password").focus();
		return false;
	}
	else if($("#company_username").val()=="")
	{
		alert("Please fill Username.");
		$("#company_username").focus();
		return false;
	}
	else if($("#company_mobile").val()=="")
	{
		alert("Please enter Mobile Number.");
		$("#company_mobile").focus();
		return false;
	}
	else if(($("#company_mobile").val()!="") && $("#company_mobile").val().length<10)
	{
		alert("Invalid Phone number. Please check and try again.");
		$("#company_mobile").focus();
		return false;
	}
	else if($("#yr_incorp").val()=="")
	{
		alert("Please enter Year of Incorporation.");
		$("#yr_incorp").focus();
		return false;
	}
	else if($("#company_industry").val()=="")
	{
		alert("Please select Industry Type.");
		$("#company_industry").focus();
		return false;
	}
	
	else
	{
		$("#form3").show();
		$("#form1").hide();
	}

}


function edit_lender_profile()
{
	$(".errors-class").html("");
	//$(".help-block").css('display', 'none');
	
	if($("#username").val()=="")
	{
		$("#username-error").html("Please fill out this field.");
		$("#username").focus();
		$("#username").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}/*
	else if($("#password").val()=="")
	{
		$("#password-error").html("Please fill out this field.");
		$("#password").focus();
		$("#password").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}*/

// check for confirm password
	else if($("#password").val()!=$("#passwordcnf").val())
	{
		$("#password-cnf-error").html("Passwords don't match.");
		$("#passwordcnf").focus();
		$("#passwordcnf").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}

	else if(($("#password").val()!="") && validatePassword($("#password").val())==false)
	{
		$("#password-error").html("Please fill valid Password.");
		$("#password").focus();
		$("#password").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}

	/*
	else if($("#fullname").val()=="")
	{
		$("#fullname-error").html("Please fill out this field.");
		$("#fullname").focus();
		$("#fullname").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#email").val()=="")
	{
		$("#email-error").html("Please fill out this field.");
		$("#email").focus();
		$("#email").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if(($("#email").val()!="") && validateEmail($("#email").val()))
	{
		$("#email-error").html("Please fill valid email ID.");
		$("#email").focus();
		$("#email").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#mobile").val()=="")
	{
		$("#mobile-error").html("Please fill out this field.");
		$("#mobile").focus();
		$("#mobile").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if(($("#mobile").val()!="") && $("#mobile").val().length<10)
	{
		$("#mobile-error").html("Invalid Phone number. Please check and try again.");
		$("#mobile").focus();
		$("#mobile").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}*/
	else if($("#datepicker-autoclose").val()=="")
	{
		$("#datepicker-autoclose-error").html("Please fill out this field.");
		$("#datepicker-autoclose").focus();
		$("#datepicker-autoclose").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if(($("#datepicker-autoclose").val()!="") && (getAge($("#datepicker-autoclose").val())==false))
	{
		$("#datepicker-autoclose-error").html("Please check your DOB. DOB should be minimum 18 years.");
		$("#datepicker-autoclose").focus();
		$("#datepicker-autoclose").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#gender").val()=="")
	{
		$("#gender-error").html("Please fill out this field.");
		$("#gender").focus();
		$("#gender").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#city").val()=="")
	{
		$("#city-error").html("Please fill out this field.");
		$("#city").focus();
		$("#city").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#address").val()=="")
	{
		$("#address-error").html("Please fill out this field.");
		$("#address").focus();
		$("#address").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#pan").val()=="")
	{
		$("#pan-error").html("Please fill out this field.");
		$("#pan").focus();
		return false;
	}
	else if(($("#pan").val()!="") && validatePan($("#pan").val())==false)
	{
		$("#pan-error").html("Please fill valid PAN Number.");
		$("#pan").focus();
		return false;
	}
	else if(($("#aadhaar").val()!="") && $("#aadhaar").val().length<12)
	{
		$("#aadhaar-error").html("Aadhaar can't be less than 12 digits.");
		$("#aadhaar").focus();
		return false;
	}
	else if($("#occupation").val()=="")
	{
		$("#occupation-error").html("Please fill out this field.");
		$("#occupation").focus();
		return false;
	}
	else if($("#investments").val()=="")
	{
		$("#investments-error").html("Please fill detail.");
		$("#investments").focus();
		return false;
	}
	else if($("#min_loan_preference").val()=="")
	{
		$("#min_loan_preference-error").html("Please fill out this field.");
		$("#min_loan_preference").focus();
		return false;
	}
	else if(($("#min_loan_preference").val()!="") && (($("#min_loan_preference").val())<100000))
	{
		$("#min_loan_preference-error").html("Loan Amounnt is not less than 1 Lac");
		$("#min_loan_preference").focus();
		return false;
	}
	else if(($("#min_loan_preference").val()!="") && (($("#min_loan_preference").val())>20000000))
	{
		$("#min_loan_preference-error").html("Loan Amounnt is not greater than 2 Crore");
		$("#min_loan_preference").focus();
		return false;
	}
	else if($("#max_loan_preference").val()=="")
	{
		$("#max_loan_preference-error").html("Please fill out this field.");
		$("#max_loan_preference").focus();
		return false;
	}
	else if(($("#max_loan_preference").val()!="") && (($("#max_loan_preference").val())<100000))
	{
		$("#max_loan_preference-error").html("Loan Amounnt is not less than 1 Lac");
		$("#max_loan_preference").focus();
		return false;
	}
	else if(($("#max_loan_preference").val()!="") && (($("#max_loan_preference").val())>20000000))
	{
		$("#max_loan_preference-error").html("Loan Amounnt is not greater than 2 Crore");
		$("#max_loan_preference").focus();
		return false;
	}
	else if(($("#min_interest_rate").val()=="") || ($("#max_interest_rate").val()==""))
	{
		$("#min_interest_rate-error").html("Please fill out this field.");
		$("#min_interest_rate").focus();
		return false;
	}
	else if(($("#min_tenor").val()=="") || ($("#max_tenor").val()==""))
	{
		$("#min_tenor-error").html("Please fill detail.");
		$("#min_tenor").focus();
		return false;
	}
	else if($("#description").val()=="")
	{
		$("#description-error").html("Please fill out this field.");
		$("#description").focus();
		return false;
	}/*
	else if($("#profilepic").val()=="")
	{
		$("#profilepic-error").html("Please fill out this field.");
		$("#profilepic").focus();
		$("#profilepic").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}*/
	
	
	else
	{
		return true;
	}
}


function edit_fb_profile()
{
	$(".errors-class").html("");
	//$(".help-block").css('display', 'none');
	
	if($("#username").val()=="")
	{
		$("#username-error").html("Please fill out this field.");
		$("#username").focus();
		$("#username").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}/*
	else if($("#password").val()=="")
	{
		$("#password-error").html("Please fill out this field.");
		$("#password").focus();
		$("#password").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}*/
	else if(($("#password").val()!="") && validatePassword($("#password").val())==false)
	{
		$("#password-error").html("Please fill valid Password.");
		$("#password").focus();
		$("#password").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}/*
	else if($("#fullname").val()=="")
	{
		$("#fullname-error").html("Please fill out this field.");
		$("#fullname").focus();
		$("#fullname").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#email").val()=="")
	{
		$("#email-error").html("Please fill out this field.");
		$("#email").focus();
		$("#email").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if(($("#email").val()!="") && validateEmail($("#email").val()))
	{
		$("#email-error").html("Please fill valid email ID.");
		$("#email").focus();
		$("#email").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#mobile").val()=="")
	{
		$("#mobile-error").html("Please fill out this field.");
		$("#mobile").focus();
		$("#mobile").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if(($("#mobile").val()!="") && $("#mobile").val().length<10)
	{
		$("#mobile-error").html("Invalid Phone number. Please check and try again.");
		$("#mobile").focus();
		$("#mobile").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}*/
	else if($("#datepicker-autoclose").val()=="")
	{
		$("#datepicker-autoclose-error").html("Please fill out this field.");
		$("#datepicker-autoclose").focus();
		$("#datepicker-autoclose").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if(($("#datepicker-autoclose").val()!="") && (getAge($("#datepicker-autoclose").val())==false))
	{
		$("#datepicker-autoclose-error").html("Please check your DOB. DOB should be minimum 18 years.");
		$("#datepicker-autoclose").focus();
		$("#datepicker-autoclose").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#gender").val()=="")
	{
		$("#gender-error").html("Please fill out this field.");
		$("#gender").focus();
		$("#gender").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#city").val()=="")
	{
		$("#city-error").html("Please fill out this field.");
		$("#city").focus();
		$("#city").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#address").val()=="")
	{
		$("#address-error").html("Please fill out this field.");
		$("#address").focus();
		$("#address").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}
	else if($("#pan").val()=="")
	{
		$("#pan-error").html("Please fill out this field.");
		$("#pan").focus();
		return false;
	}
	else if(($("#pan").val()!="") && validatePan($("#pan").val())==false)
	{
		$("#pan-error").html("Please fill valid PAN Number.");
		$("#pan").focus();
		return false;
	}
	else if(($("#aadhaar").val()!="") && $("#aadhaar").val().length<12)
	{
		$("#aadhaar-error").html("Aadhaar can't be less than 12 digits.");
		$("#aadhaar").focus();
		return false;
	}
	else if($("#business_type").val()=="")
	{
		$("#business_type-error").html("Please fill detail.");
		$("#business_type").focus();
		return false;
	}
	else if($('#already_in_business').val()=="")
	{
		$("#already_in_business-error").html("Please fill detail.");
		$("#already_in_business").focus();
		return false;
	}
	else if(($('#already_in_business').val()=="YES") && ($('#agency').val()==""))
	{
		$("#agency-error").html("Please fill detail.");
		$("#agency").focus();
		return false;
	}/*
	else if($("#profilepic").val()=="")
	{
		$("#profilepic-error").html("Please fill out this field.");
		$("#profilepic").focus();
		$("#profilepic").css('background-image','linear-gradient(#e34539, #e34539),linear-gradient(rgba(120,130,140,0.13), rgba(120,130,140,0.13)');
		return false;
	}*/
	
	
	else
	{
		return true;
	}
}
