<link href="<?=base_url();?>assets/css/materialize.css" rel="stylesheet">
<link href="<?=base_url();?>assets/css/materialize.forms.css" rel="stylesheet">
<section class="sec-pad service-box-one service" id="top"> <!--style=" background-image:url(<?=base_url();?>assets/img/calculator-bg.jpg); background-repeat:repeat"-->
    <!--<main id="content" role="main" itemscope="itemscope" itemprop="mainContentOfPage">-->
        <!-- #ht-kb -->
        <div class="container">
            <strong>
                <header class="entry-header">
                    <div class="sec-title text-left">
                        <h4>Emi Calculator</h4>
                        <span class="decor-line"> <span class="decor-line-inner"></span> </span> </div>
                </header>
            </strong>

            <div class="row">
				<div class="col-md-6">
					<div class=" emi-cal" style="width:100%;" >
					  <div class="card" id="form1">
						<div class="card-content ">
							<div class="row">
							  <div class="col-sm-12">
							  <div class="row ">
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
								
								 <div class="row ">
								<div class="input-field col s12 m12 required" id="">
								  <label>Loan Amount applied for</label>
								  <input type="text" id="loan_amount" onkeypress="return isNumberKey(event)">
								</div>
								
							 </div>
								  <div id="focus-div">
								 <div class="row ">
									  
								 <div class="field-label col-md-12">Interest Rate (in %)</div>
										   <br><br>
									<div class="form-group col s12 m12">
									 
									  <div id="interest-calc"  class="noUi-target noUi-ltr noUi-horizontal"></div>
									  <input type="text" id="interest-range-calc" value="4"/>
									</div>
							 </div>

							   <div class="row">
								 
									<div class="field-label col-md-12">Tenor (in months)</div>
									 <br><br>
									<div class="form-group col s12 m12">
									  <div id="tenor-calc"  class="noUi-target noUi-ltr noUi-horizontal"></div>
									  <input type="text" class="col-md-12" id="tenor-range-calc" value="6" />
									</div>
							  </div>
							  <div class="col s12 m12">
								
								  <input id="emi_cal_btn" type="submit" value="Calculate" class="btn btn-primary" onclick="emi_cal();">
							   
								  <input type="submit" value="Reset" class="btn btn-primary" onclick="clearfields();">
								</div>
							  </div>
							 </div>
							  
							  <div class="col-sm-12" style="display:none" id="response">
								<hr>
								<div class="input-field col s12 m4 required" id="">
								  <label>Your EMI Rs:</label>
								  <br>
								  <h4 id="emi_rs"></h4>
								</div>
								<div class="input-field col s12 m4 required" id="">
								  <label>Intrest Amount Rs:</label>
								  <br>
								  <h4 id="interest"></h4>
								</div>
								<div class="input-field col s12 m4 required" id="">
								  <label>Total Amount Payable Rs:</label>
								  <br>
								  <h4 id="total_amount"></h4>
								</div>
							  </div>
							  </div>
							  <!--end of row--> 
							</div>
							<!--end of container--> 
						</div>
					</div>
				
				</div>
                <div class="col-md-6">
                    <p>Need a loan? Don't just get into a rush to apply for one. Instead, make sure to analyze all your financial commitments. Once this is done, calculate the amount of money that you can spare per month. But, that is not all.</p>
                    <p>Before you zero in on the amount that you need to apply a loan for, make sure to find out the EMI that you may have to pay for it every month.</p>
					<br><img style="width:100%; max-width:480px;" src="https://www.antworksmoney.com/assets/img/ant-works-money-bank-corporate-emi-cal-inner1.jpg" alt="Antworks Money EMI Calculator">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
					<h3>How to Calculate the EMI?</h3>
                    <ul class="myul" style="list-style-type: decimal !important;">
                        <li>First select the kind of loan you are looking for. It can be a</li>
                        <ul class="myul">
                            <li>Housing loan</li>
                            <li>Car loan</li>
                            <li>Personal loan</li>
                            <li>Credit card payments</li></ul>
                        <li>Enter the amount that you need </li>
                        <li>Next select the interest rate that you are willing to go with. Remember that various financial organizations offer different interest rates for the same kind of loan</li>
                        <li>Now, select the tenure of the loan. This has to be entered in the terms of months. So, if you are thinking of settling a personal loan within 5 years, enter the tenure as 60 months</li>
                        <li>Once all the details are in place, click. The EMI amount will be calculated and displayed on the screen</li>
                    </ul>
                </div>
				
				<div class="col-md-6">
					<h3>Why Use the EMI Calculator?</h3>
                    <ul class="myul">
                       <li>Easy and convenient way to make complex calculations </li>
                       <li>No worries about errors as accuracy is guaranteed</li>
                       <li>Wastage of time is a thing of the past. With this automatic calculator, you can get the result within a matter of a few seconds</li>
                       <li>No need to remember complex formulae. This EMI calculator has all the different formulae in place</li>
                       <li>Can be used for all kinds of loans what with the calculator being specially designed for EMIs.</li>
                    </ul>
				</div>
            </div>
        </div>
        <!-- /.container -->
</section>

<script>
function emi_cal()
{
	LoanA=$('#loan_amount').val();
	IntR=$('#interest-range-calc').val();
	TimeP=$('#tenor-range-calc').val();
	Amt = parseFloat(LoanA);
	rateValue1 =  (IntR.substr(IntR.lastIndexOf(".")+1,IntR.length))
	
	if(LoanA=="")
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
	else if(IntR < 4){
		alert("Rate of interest cannot be less than 4%");
		$('#interest-range-calc').focus();
		$('#interest-range-calc').select();		
		return false;
	}
	else if( rateValue1.length > 2 ){
		alert("Rate of interest with more than 2 number after decimal are not allowed");
		$('#interest-range-calc').focus();
		$('#interest-range-calc').select();		
		return false;
	}
	else if (TimeP == "" ) {
		alert("Please select Tenor")
		$('#tenor-range-calc').focus();
		return false;
	}
	else if(TimeP < 6){
		alert("Term cannot be Zero");
		$('#tenor-range-calc').focus();
		$('#tenor-range-calc').select();		
		return false;
	}
	
	Multiplier=12;
	TimeP=TimeP/12;
	$('#response').show();
		
	numerator=LoanA*Math.pow((1+IntR/(Multiplier*100)),TimeP*Multiplier);
	//alert(numerator);
	denominator=100*Multiplier*(Math.pow((1+IntR/(Multiplier*100)),TimeP*Multiplier)-1)/IntR;
	//alert(denominator);
	EMI=numerator/denominator;
	
	emi=Math.round(EMI);
	
	$('#emi_rs').html(emi);
	$('#interest').html((emi*(TimeP*12))-LoanA);
	$('#total_amount').html(emi*(TimeP*12));
}

function clearfields() 
{
	$('#response').hide();
	$('#loan_amount').val("");
	$('#interest-range-calc').val("");
	$('#tenor-range-calc').val("");
	$('#emi_rs').html("");
	$('#interest').html("");
	$('#total_amount').html("");
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

$("#emi_cal_btn").click(function() {
    $('html, body').animate({
        scrollTop: $("#focus-div").offset().top
    }, 2000);
});
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
