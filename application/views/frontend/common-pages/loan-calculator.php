<link href="<?=base_url();?>assets/css/materialize.css" rel="stylesheet">
<link href="<?=base_url();?>assets/css/materialize.forms.css" rel="stylesheet">
<section class="sec-pad service-box-one service" id="top"> <!--style=" background-image:url(<?=base_url();?>assets/img/calculator-bg.jpg); background-repeat:repeat"-->
	<main id="content" role="main" itemscope="itemscope" itemprop="mainContentOfPage">
		<!-- #ht-kb -->
		<div class="container">
			<strong>
				<header class="entry-header">
					<div class="sec-title text-left">
						<h4>Loan Eligibility Calculator</h4>
						<span class="decor-line"> <span class="decor-line-inner"></span> </span> </div>
				</header>
			</strong>

			<div class="row">
				<div class="col-md-6">
					<div class="loan-cal" style="width:100%;" >
					  <div class="card" id="form1">
						<div class="card-content ">
							<div class="row">
							  <div class="col-sm-12">
							   <div class="row">
								<div class="select-field col s12 m12  required" id="">
								  <label>Type of Loan Applied for</label>
								  <select name="Select Loan" >
									<option value="">Housing loan</option>
									<option value="">Car loan</option>
									<option value="">Personal loan</option>
									<option value="">Credit Card</option>
									<option value="">Others</option>
								  </select>
								</div>
								</div>
								<div class="row">
								<div class="input-field col s12 m12 required" id="">
								  <label>Loan Amount applied for</label>
								  <input type="text" id="loan_amount" onkeypress="return isNumberKey(event)">
								</div>
								</div>
								<div class="row">

									<div class="field-label col-md-12">Interest Rate (in %)</div>
									<br>
									<br>
									 <div class="form-group col s12 m12">
									  <div id="interest-calc"  class="noUi-target noUi-ltr noUi-horizontal"></div>
									  <input type="text" id="interest-range-calc" value="4"/>
									</div>

								</div>
								<div id="focus-div">
								<div class="row">

									<div class="field-label col-md-12">Tenor (in months)</div>
									<br>
									<br>
								 <div class="form-group col s12 m12">
									  <div id="tenor-calc"  class="noUi-target noUi-ltr noUi-horizontal"></div>
									  <input type="text" class="col-md-12" id="tenor-range-calc" value="6" />
									</div>

								</div>

								<div class="row">
									<div class="input-field col s12 m12 required" id="">
									  <label>Monthly take home Income (net of Income tax)</label>
									  <input type="text" id="home_take" onkeypress="return isNumberKey(event)">
									</div>
									</div>

								  <div class="row">
									<div class="input-field col s12 m12 required" id="">
									  <label>Current EMI obligations on loans already taken</label>
									  <input type="text" id="current_emi" onkeypress="return isNumberKey(event)">
									</div>

								</div>
								<br>
								<br>
							   <div class="col s12 m12">

								  <input id="emi_cal_btn" type="submit" value="Calculate" class="btn btn-primary" onclick="return loan_cal();">

								  <input type="submit" value="Reset" class="btn btn-primary" onclick="clearfields();">
								</div>
							  </div>
							  </div>
							  <div class="col-sm-12" style="display:none" id="response1">
								<h5 id="alert-msg1">Congratulations! You are eligible for applied loan</h5>
							  </div>
							  <div class="col-sm-12" style="display:none" id="response">
								<hr>
								<br>
								<div class="input-field col s12" id="">
								  <label> Net Disposable Income:</label><br>
								  <h4 id="disposal_income"></h4>
								</div>
								<h5 id="alert-msg"></h5>
								<div class="input-field col s12 m4 required" id="">
								  <label> Your EMI on <br>
									Apllied Loan:</label>
								  <br>
								  <br>
								  <h4 id="emi_rs"></h4>
								</div>
								<div class="input-field col s12 m4 required" id="">
								  <label>You are Eligible for <br>
									total loans of:</label>
								  <br>
								  <br>
								  <h4 id="total_loan"></h4>
								</div>
								<div class="input-field col s12 m4 required" id="">
								  <label>% utlisation of total <br>
									loan limits:</label>
								  <br>
								  <br>
								  <h4 id="per_utilization"></h4>
								</div>
							  </div>
							  <!--end of row-->
							</div>
							<!--end of container-->
						</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<p>Need a loan to meet an urgent requirement? Worried about the amount that you need to get ready as down payment? Well, first things first, find out the amount of loan that you are eligible for. Once you get this right, it will become easier for you to estimate the amount that you have to arrange in some other manner.</p>
                    <p>Wondering how? Just use the loan eligibility calculator. Designed by our experienced team, it integrates all the important formulae of calculation, thus giving you a figure within a matter of a few seconds.</p>
					<br><img style="width:100%;" src="https://www.antworksmoney.com/assets/img/ant-works-money-bank-loan-cals-inner1.jpg" alt="Antworks Money Bank Loan Calculater">
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<h3>How does this Work?</h3>
					<ul class="myul" style="list-style-type: decimal !important;">
						<li>First select the type of loan you are applying for. This EMI calculator can be used for all kinds of loans be it home loan, personal loan, car loan or credit card.</li>						<li>Enter the amount that you need </li>
						<li>Next select the interest rate that you are willing to pay.</li>
						<li>Choose the tenure for the loan. This should be entered in the terms of months. So, if you are looking for loan tenure for 10 years, it should be entered as 120 months. </li>
						<li>Then specify your monthly take home package.</li>
						<li>Follow this with the details of the other EMIs that you may be paying each month.</li>
						<li>Click on Calculate. The calculator will present you with the loan eligibility amount within a matter of a few seconds. </li>
					</ul>
				</div>
				<div class="col-md-6">
					<h3>Why Use Loan Eligibility Calculator?</h3>
					<ul class="myul">
						<li>Easy and convenient way to calculate the loan eligibility amount </li>
						<li>Accuracy guaranteed thanks to the team of experts who have designed this calculator with complete precision</li>
						<li>No worries about wasting of time. The figure would be at your fingertips within a matter of seconds. </li>
						<li>Remembering formulae not required as the calculator is integrated with all the necessary details. </li>
						<li>Perfect for all types of loans.</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- /.container -->
</section>
<script>
function loan_cal()
{
	/*
     * ir   - interest rate per month
     * np   - number of periods (months)
     * pv   - present value
     * fv   - future value
     * type - when the payments are due:
     *        0: end of the period, e.g. end of month (default)
     *        1: beginning of period
     */

	pv=$('#loan_amount').val();
	IntR=$('#interest-range-calc').val();
	ir=IntR/1200;
	//alert(ir);
	np=$('#tenor-range-calc').val();
	fv=0;
	type=0;
	ht=$('#home_take').val();
	ci=$('#current_emi').val();

	//pv = parseFloat(pv);
	//rateValue1 =  (ir.substr(ir.lastIndexOf(".")+1,ir.length))

	if(pv=="")
	{
		alert("Please enter Required Loan Amount")
		$('#loan_amount').focus();
		return false;
	}
	else if(IntR=="")
	{
		alert("Please select Rate of interest")
		$('#interest-range-calc').focus();
		return false;
	}
	else if(IntR>36){
		alert("Rate of interest cannot be greater than 36%");
		$('#interest-range-calc').focus();
		$('#interest-range-calc').select();
		return false;
	}
	else if(IntR<4){
		alert("Rate of interest cannot be less than 4%");
		$('#interest-range-calc').focus();
		$('#interest-range-calc').select();
		return false;
	}
	/*else if( rateValue1.length > 2 ){
		alert("Rate of interest with more than 2 number after decimal are not allowed");
		$('#interest-range-calc').focus();
		$('#interest-range-calc').select();
		return false;
	}*/
	else if (np == "" ) {
		alert("Please select Tenor")
		$('#tenor-range-calc').focus();
		return false;
	}
	else if(np < 6){
		alert("Tenor cannot be less than 6 months");
		$('#tenor-range-calc').focus();
		$('#tenor-range-calc').select();
		return false;
	}
	else if(np>360){
		alert("Tenor cannot be greater than 360 months");
		$('#tenor-range-calc').focus();
		$('#tenor-range-calc').select();
		return false;
	}
	else if (ht == "" ) {
		alert("Please input home Take")
		$('#home_take').focus();
		return false;
	}
	else if (ci == "" ) {
		alert("Please input Current EMI")
		$('#current_emi').focus();
		return false;
	}
	else
	{
		var pmt, pvif, ndi;

		ndi = (ht/2)-ci;

		pvif = Math.pow(1 + ir, np);
		pmt = (ir * (pv * pvif + fv) / (pvif - 1));


		//x = Math.pow(1 + ir, -np);
		//y = Math.pow(1 + ir, np);
		//pv_value = - ( x * ( ndi * ir - pmt + y * pmt )) / ir;

		rate = eval(ir);
		periods = eval(np);
		pv_value = -(((1 - Math.pow(1 + rate, periods)) / rate) * ndi * (1 +rate * type) - fv) / Math.pow(1 + rate, periods);
		//alert(pv_value);
		pu = pv*100/pv_value;

		if(pu>100)
		{
			$('#response1').show();
			$('#response').hide();
			$('#alert-msg1').html("Sorry! You are not eligible for applied loan");
		}
		else
		{
			$('#response').show();
			$('#alert-msg').html("Congratulations! You are eligible for applied loan");
		    $('#response1').hide();
			$('#disposal_income').html(ndi);

			$('#emi_rs').html(pmt.toFixed());
			$('#total_loan').html(pv_value.toFixed());
			$('#per_utilization').html(pu.toFixed(2));
		}

		$("#emi_cal_btn").click(function() {
			$('html, body').animate({
				scrollTop: $("#focus-div").offset().top
			}, 2000);
		});
	}
}

function clearfields()
{
	$('#response').hide();
	$('#response1').hide();
	$('#loan_amount').val("");
	$('#interest-range-calc').val("");
	$('#tenor-range-calc').val("");
	$('#emi_rs').html("");
	$('#total_loan').html("");
	$('#per_utilization').html("");
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

</script>

<script src="<?=base_url();?>assets/assets/noUiSlider.9.1.0/nouislider.js"></script>
<script>
    var connectSlider = document.getElementById('interest-calc');
    var input1 = document.getElementById('interest-range-calc');
    noUiSlider.create(connectSlider, {
        start: 4,
        step: .25,
        connect: [true, false],
        range: {
            'min': 4,
            'max': 36
        }
    });
    connectSlider.noUiSlider.on('update', function( value ) {
        input1.value = value;
    });
    $("#interest-range-calc").change(function () {
        var value = this.value;
        connectSlider.noUiSlider.set(value);
    });
    var connectSlider1 = document.getElementById('tenor-calc');
    var input2 = document.getElementById('tenor-range-calc');
    noUiSlider.create(connectSlider1, {
        start: 6,
        step: 6,
        connect: [true, false],
        range: {
            'min': 6,
            'max': 360
        },
    });
    connectSlider1.noUiSlider.on('update', function( value ) {
        input2.value = value;
    });

    $("#tenor-range-calc").change(function () {
        var value = this.value;
        connectSlider1.noUiSlider.set(value);
    });
</script>

