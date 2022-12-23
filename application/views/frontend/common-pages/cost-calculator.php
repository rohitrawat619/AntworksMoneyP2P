<link href="<?=base_url();?>assets/css/materialize.css" rel="stylesheet">
<link href="<?=base_url();?>assets/css/materialize.forms.css" rel="stylesheet">
<section class="sec-pad service-box-one service" id="top"> <!--style=" background-image:url(<?=base_url();?>assets/img/calculator-bg.jpg); background-repeat:repeat"-->
    <!--<main id="content" role="main" itemscope="itemscope" itemprop="mainContentOfPage">-->
        <!-- #ht-kb -->
        <div class="container">
            <strong>
                <header class="entry-header">
                    <div class="sec-title text-left">
                        <h4>ALL IN COST CALCULATOR</h4>
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
									  <label>Processing fees</label>
									  <input type="text" id="pro_fees" onkeypress="return isNumberKey(event)">
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
							  <div class="col-sm-12" style="display:none" id="response">
								<hr>
								<br>
								
								<div class="input-field col s12 m6 required" id="">
								  <label>All inclusive interest cost:</label>
								  <br>
								  <br>
								  <h4 id="interest_cost"></h4>
								</div>
								<div class="input-field col s12 m6 required" id="">
								  <label>  EMI on Loan  Apllied for:</label>
								  <br>
								  <br>
								  <h4 id="emi_rs"></h4>
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
                    <p>Need some fluid cash to meet the current financial requirements? Go ahead and opt for a bank loan. With so many banks offering loan at varied interest rates, finding the best choice is really not that hard.</p>
                    <p>However, the one thing that you need to remember is that when it comes to securing a loan, you are not just expected to pay the EMI but also some processing fee. Thus all in all, the monthly installment amount may notch up than what you thought.</p>
                    <p>Worried? Don't be. Just check out the total cost that you have to incur for a certain loan amount and choose the one that seems suitable for you. Wondering how to do this?</p>
                    <p>Use all in cost calculator to find the exact installment that you will have to pay every month.</p>
					<br><img style="width:100%; max-width:420px;" src="https://www.antworksmoney.com/assets/img/ant-works-money-bank-cost-calulator-inner1.jpg" alt="Antworks Money Bank Cost Calculator">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h3>How this Works?</h3>
					<ul class="myul" style="list-style-type: decimal !important;">
                        <li>1. First select the kind of loan that you are looking for</li>
                        <li>2. Then enter the amount that you wish to borrow from the bank</li>
                        <li>3. Next use the slider to enter the interest rate that you are willing to pay. You may have to alter this a number of times to find the best suited option</li>
                        <li>4. Select a suitable tenure within which you can settle the loan amount. This should be entered in terms of month. So, if you are looking for a loan tenure of 5 years, enter 60 months</li>
                        <li>Now enter the processing fee and click on Calculate </li>
                    </ul>
				</div>
				<div class="col-md-6">
                    <h3>Why Use a Cost Calculator?</h3>
                    <ul class="myul">
                        <li>An easy and convenient way to calculate the total monthly installment amount</li>
                        <li>Guaranteed accuracy thanks to the calculator having been designed by our experts</li>
                        <li>No need to remember complicated formulae and deal with long calculations. Just enter the specifics and the figure will be displayed to you in a matter of a few minutes</li>
                        <li>Can be used for all types of loans</li>
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
	np=$('#tenor-range-calc').val();
	fv=0;
	type=0;
	ht=$('#pro_fees').val();
	
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
		alert("Please input Processing fees")
		$('#pro_fees').focus();
		return false;
	}
	else
	{
		$('#response').show();
		var pmt, pvif;
		
		pvif = Math.pow(1 + ir, np);
		pmt = (ir * (pv * pvif + fv) / (pvif - 1));
		
		/*var values=[{}];
		XIRR(values, dates, guess);*/
		
		//pu = pv*100/pv_value;
		
		$('#emi_rs').html(pmt.toFixed());
		//$('#interest_cost').html(pu.toFixed(2));
		
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

function XIRR(values, dates, guess) {
  
  // Calculates the resulting amount
  var irrResult = function(values, dates, rate) {
    var r = rate + 1;
    var result = values[0];
    for (var i = 1; i < values.length; i++) {
      result += values[i] / Math.pow(r, moment(dates[i]).diff(moment(dates[0]), 'days') / 365);
    }
    return result;
  }

  // Calculates the first derivation
  var irrResultDeriv = function(values, dates, rate) {
    var r = rate + 1;
    var result = 0;
    for (var i = 1; i < values.length; i++) {
      var frac = moment(dates[i]).diff(moment(dates[0]), 'days') / 365;
      result -= frac * values[i] / Math.pow(r, frac + 1);
    }
    return result;
  }

  // Check that values contains at least one positive value and one negative value
  var positive = false;
  var negative = false;
  for (var i = 0; i < values.length; i++) {
    if (values[i] > 0) positive = true;
    if (values[i] < 0) negative = true;
  }
  
  // Return error if values does not contain at least one positive value and one negative value
  if (!positive || !negative) return '#NUM!';

  // Initialize guess and resultRate
  var guess = (typeof guess === 'undefined') ? 0.1 : guess;
  var resultRate = guess;
  
  // Set maximum epsilon for end of iteration
  var epsMax = 1e-10;
  
  // Set maximum number of iterations
  var iterMax = 50;

  // Implement Newton's method
  var newRate, epsRate, resultValue;
  var iteration = 0;
  var contLoop = true;
  do {
    resultValue = irrResult(values, dates, resultRate);
    newRate = resultRate - resultValue / irrResultDeriv(values, dates, resultRate);
    epsRate = Math.abs(newRate - resultRate);
    resultRate = newRate;
    contLoop = (epsRate > epsMax) && (Math.abs(resultValue) > epsMax);
  } while(contLoop && (++iteration < iterMax));

  if(contLoop) return '#NUM!';

  // Return internal rate of return
  return resultRate;
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
