
<nav class="navbar navbar-default header-navigation stricky">
<div class="top-nav">
	<div class="container">
		<ul class="top-nav-primary">
			<li>
				<div class="top-nav-dropdown">
					<a href="#">Quick Links &nbsp;<i class="fa fa-angle-down"></i></a>
					<div class="top-nav-dropdown-content">
						<ul>
							<li><a href="<?php echo base_url(); ?>fees-and-charges">Fees & Charges</a></li>
							<li><a href="<?php echo base_url(); ?>loan-eligibility-calculator">Loan Eligibility Calculator</a></li>
							<li><a href="<?php echo base_url(); ?>grievance-redressal">Grievance Redressal</a></li>
						</ul>
					</div>
				</div>
			</li>
            <?php if($this->session->userdata('login_type')){ ?>
                <li><a class="top-login-btn" href="<?=base_url();?>/login/logout">Logout</a></li>
            <? } else{ ?>
			<li>
                <a class="top-login-btn" href="<?php echo base_url() ?>login/user-login">Login</a>
            </li>
            <?php }  ?>
<!--			<li><a role="button" data-toggle="collapse" href="#sidebarCollapse" aria-expanded="false" aria-controls="sidebarCollapse"><i class="fa fa-reorder"></i></a></li>-->
		</ul>
	</div>
</div>
  <div class="container"> 
    
    <!-- Brand and toggle get grouped for better mobile display -->
    
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav-bar" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
		<?php if($this->router->fetch_class() == 'Requestmodel')
		{?>
		<a class="navbar-brand" href="https://www.antworksmoney.com/"> <img src="<?=base_url();?>assets/img/logo.png" alt="P2P" height="71"/> </a> </div>

		<?php } else{?>
	  <a class="navbar-brand" href="<?php echo base_url(); ?>"> <img src="<?=base_url();?>assets/img/logo.png" alt="P2P" height="71"/> </a> </div>
		<?php } ?>

    
    <!-- Collect the nav links, forms, and other content for toggling -->
    
    <div class="collapse navbar-collapse" id="main-nav-bar">
      <ul class="nav navbar-nav navigation-box">
        <li> <a href="<?php echo base_url();?>">P2P Loans</a></li>
        <li> <a href="#">MONEY TALK</a>
          <ul class="sub-menu">
            <li><a href="<?php echo base_url(); ?>blog" target="_blank">Blog</a></li>
          </ul>
        </li>
        <li> <a href="#">TOOLS</a>
          <ul class="sub-menu">
            <li><a href="<?php echo base_url(); ?>emi-calculator">EMI Calculator</a></li>
            <li><a href="<?php echo base_url(); ?>loan-eligibility-calculator">Loan Eligibility Calculator</a></li>
            <li><a href="<?php echo base_url(); ?>all-in-cost-calculator">All in Cost Calculator</a></li>
          </ul>
        </li>

      </ul>

    </div>
    <!-- /.navbar-collapse -->
    
  
</nav>
</header>
<!-- /.header -->

<div class="top-login-panels">
<div class="login-close"><i class="fa fa-close"></i></div>
	<div class="inner">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="divtable border-bm">
						<div class="divtable-row">
							<div class="divtable-cell dt-col-3">
								<div class="login-box lb1">
									<h2>Login as <br><b>Lender</b></h2>
									<form action="<?php echo base_url(); ?>login/ValidateUser/" method="post">
									<div class="row">
										<div class="col-md-6">
											<input class="form-control" type="text" name="user" id="username_lender" placeholder="Email ID/ Username" />
										</div>
										<div class="col-md-6">
											<input class="form-control" type="password" name="pwd" id="password_lender" placeholder="Password" />
										</div>
										<div class="col-xs-12">
											<a class="forget" style="color: #fff;margin-bottom: 12px;display:  inline-block;" href="<?php echo base_url();?>login/recoverpassword/">Forgot Password ?</a>
										</div>
									</div>

									<input class="btn" type="submit" name="button_lender" id="button_lender" value="Login" />
									</form>
								</div>
							</div>
							<div class="divtable-cell dt-col-3">
								<div class="login-box  lb2">
									<h2>Login as <br><b>Borrower</b></h2>
									<div class="row">
										<div class="col-md-6">
											<input class="form-control" type="text" name="username_borrower" id="username_borrower" placeholder="Email ID/ Username" />
										</div>
										<div class="col-md-6">
											<input class="form-control" type="password" name="password_borrower" id="password_borrower" placeholder="Password" />
										</div>
										<div class="col-xs-12">
											<a class="forget" style="color: #fff;margin-bottom: 12px;display:  inline-block;" href="<?php echo base_url();?>login/recoverpassword/">Forgot Password ?</a>
										</div>
									</div>
									<input class="btn btn-blue" type="submit" name="button_borrower" id="button_borrower" value="Login" />
								</div>
							</div>
							<div class="divtable-cell dt-col-3">
								<div class="quick-links">
									<h4>Quick Links</h4>
									<ul>
										<li><a href="<?php echo base_url(); ?>blog">P2P Blog</a></li>
										<li><a href="<?php echo base_url(); ?>pricing">Fees & Charges</a></li>
										<li><a href="https://www.antworksmoney.com/Loan-cal/">Loan Eligibility Calculator</a></li>
										<li><a href="https://www.antworksmoney.com/Free-credit-score" target="_blank">Free credit score</a><span>NEW</span></li>
										<li><a href="<?php echo base_url(); ?>">Grievance Redressal</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="register-box">
						<h1>Not registered yet!</h1>
						<p>Stop looking for financial solutions. You are missing all the great advice and opportunities. Sign up today!</p>
						<a class="btn" href="<?php echo base_url(); ?>Lender_register_newdesign">Become a <b>Lender</b></a>
						<a class="btn btn-blue" href="<?php echo base_url(); ?>Borrower_register_login_pageNewDesign">Become a <b>Borrower</b></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="inner-bottom">
		<div class="container" style="position:relative">
			<img class="man" src="<?=base_url();?>assets/img/login-panel-img.png" alt="Antworks Money Login Panel">
		</div>
		<div class="container">
			<div class="col-md-3">
				<a href="#">Become a financial Buddy</a>
			</div>
			<div class="col-md-6">
				<p class="text">Become a financial buddy with AntworksMoney and earn sitting at home or in office just by referring your friends and relatives for loans, credit cards or other investment options.</p>
			</div>
			<div class="col-md-3 text-right">
				<p class="copy">Copyrights © 2017 - 2018 All Rights Reserved.</p>
			</div>
		</div>
	</div>
</div>
<script>

    $("#button_borrower").click(function(event) {

        var username = $('#username_borrower').val();
        var password = $('#password_borrower').val();
		
        if(username == "")
        {
            alert("Please Enter Your username");
            return false;
        }
        else if (password == "")
        {
            alert("Please enter your password");
            return false;

        }

        else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>home/p2p_loginNav/",
                data: "email="+username+"&password="+password+"&login_type="+1,
                success: function (data) {
                    if(data == 1)
                    {
                        window.location.replace("<?php echo base_url(); ?>home/borrower_dashboard");
                    }
                    else {
                        alert("Please Enter Valid Username and Password");
                    }
                }
            });

        }

    });

</script>

<script>

	$("#button_lender").click(function(event) {

		var username = $('#username_lender').val();
		var password = $('#password_lender').val();
		if(username == "")
		{
			alert("Please Enter Your username");
			return false;
		}
		else if (password == "")
		{
			alert("Please enter your password");
			return false;

		}

		else {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>login/ValidateUserThroughp2Lender",
				data: "user="+username+"&pwd="+password,
				success: function (data) {

					console.log(data);
					if(data == 1)
					{

						window.location = "<?php echo base_url(); ?>dashboard";

					}
					else {
						alert("Please Enter Valid Username and Password");
					}
				}
			});

		}

	});

</script>