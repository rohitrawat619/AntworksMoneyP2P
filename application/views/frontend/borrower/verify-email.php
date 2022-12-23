<style>
.text-center
{
	text-align:center;
}
</style>
<? if($result==1)
	{
		$msg = "Your account has been activated, you can now login.";			
	}
	else if($result==2)
	{
		$msg = "Your account is already Verified.";			
	}
	else
	{
		$msg = "Invalid approach, please use the link that has been send to your email!";
	}
?>
<section class="sec-pad login-register" style="background-color: #e8e8e8;">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <div class="sec-title text-center">
          <p style="font-size:25px; font-weight:bolder; color:black;"><?=$msg;?></p>
         
      </div>
     <? if(($result==1) || ($result==2))
		{?><a href="<?php echo base_url();?>login/borrower"><button class="thm-btn" type="button">GO TO MY ACCOUNT</button></a>
        <? }?>
    </div>
  </div>
</section>
