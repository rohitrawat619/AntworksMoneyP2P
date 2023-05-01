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
	if ((charCode > 46 && charCode < 58) || (charCode == 8)) {
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

function validatePassport(s)
{
	var ss = s.toUpperCase();
	var pattern = new RegExp("[A-Z]{1}[0-9]{7}");
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
	//alert(bday);
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
	//	alert (dd + "-" + mmx + "-" + yr  + " is an Invalid Date!");
		validDOB = false; 
		return validDOB;
	}
	else
	{
	//	alert (dd + "-" + mmx + "-" + yr  + " is a validDOB Date");
		validDOB = true;
		return validDOB;
	}
}


function validate_lender()
{
	if($("#first_name").val()==="")
	{
		alert("Please fill out first name field.");
		$("#first_name").focus();
		return false;
	}
	else if($("#last_name").val()==="")
	{
		alert("Please fill out last name field.");
		$("#last_name").focus();
		return false;
	}
	else if($("#email").val()==="")
	{
		alert("Please fill out email field.");
		$("#email").focus();
		return false;
	}
	else if(($("#email").val()!=="") && validateEmail($("#email").val()))
	{
		alert("Please fill valid email ID.");
		$("#email").focus();
		return false;
	}
	else if($("#mobile").val()==="")
	{
		alert("Please fill out contact field.");
		$("#mobile").focus();
		return false;
	}
	else if(($("#mobile").val()!=="") && $("#mobile").val().length<10)
	{
		alert("Contact cann't be less than 10 digits.");
		$("#mobile").focus();
		return false;
	}
	else if($("#datepicker").val()==="")
	{
		alert("Please fill out DOB field.");
		$("#datepicker").focus();
		return false;
	}
	else if(($("#datepicker").val()!=="") && (getAge($("#datepicker").val())===false))
	{
		alert("Please check your DOB, You must be 18 years or older for filling this form.");
		$("#datepicker").focus();
		return false;
	}
	else if($("#remember").is(':checked')==false)
	{
		alert("Please accept T&C.");
		$("#tc_flag").focus();
		return false;
	}
	
	else
	{
		return true;

	}
}

function validate_borrower()
{
	if($("#first_name").val()=="")
	{
		alert("Please fill out first name field.");
		$("#first_name").focus();
		return false;
	}
	else if($("#last_name").val()=="")
	{
		alert("Please fill out last name field.");
		$("#last_name").focus();
		return false;
	}
	else if($("#email").val()=="")
	{
		alert("Please fill out email field.");
		$("#email").focus();
		return false;
	}
	else if(($("#email").val()!="") && validateEmail($("#email").val()))
	{
		alert("Please fill valid email ID.");
		$("#email").focus();
		return false;
	}
	else if($("#mobile").val()=="")
	{
		alert("Please fill out contact field.");
		$("#mobile").focus();
		return false;
	}
	else if(($("#mobile").val()!="") && $("#mobile").val().length<10)
	{
		alert("Contact cann't be less than 10 digits.");
		$("#mobile").focus();
		return false;
	}
	else if($("#datepicker").val()=="")
	{
		alert("Please fill out DOB field.");
		$("#datepicker").focus();
		return false;
	}
	else if(($("#datepicker").val()!="") && (getAge($("#datepicker").val())==false))
	{
		alert("Please check your DOB , Dob cann't be less than 18 years.");
		$("#datepicker").focus();
		return false;
	}
	else if($("#remember").is(':checked')==false)
	{
		alert("Please accept T&C.");
		$("#tc_flag").focus();
		return false;
	}
	
	else
	{
		return true;

	}
}

function validate_fb()
{
	if($("#first_name").val()=="")
	{
		alert("Please fill out first name field.");
		$("#first_name").focus();
		return false;
	}
	else if($("#last_name").val()=="")
	{
		alert("Please fill out last name field.");
		$("#last_name").focus();
		return false;
	}
	else if($("#email").val()=="")
	{
		alert("Please fill out email field.");
		$("#email").focus();
		return false;
	}
	else if(($("#email").val()!="") && validateEmail($("#email").val()))
	{
		alert("Please fill valid email ID.");
		$("#email").focus();
		return false;
	}
	else if($("#mobile").val()=="")
	{
		alert("Please fill out contact field.");
		$("#mobile").focus();
		return false;
	}
	else if(($("#mobile").val()!="") && $("#mobile").val().length<10)
	{
		alert("Contact cann't be less than 10 digits.");
		$("#mobile").focus();
		return false;
	}
	else if($("#datepicker").val()=="")
	{
		alert("Please fill out DOB field.");
		$("#datepicker").focus();
		return false;
	}
	else if(($("#datepicker").val()!="") && (getAge($("#datepicker").val())==false))
	{
		alert("Please check your DOB , Dob cann't be less than 18 years.");
		//alert($("#datepicker").val());
		$("#datepicker").focus();
		return false;
	}
	else if($("#remember").is(':checked')==false)
	{
		alert("Please accept T&C.");
		$("#tc_flag").focus();
		return false;
	}
	
	else
	{
		return true;

	}
}