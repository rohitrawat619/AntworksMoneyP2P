<style>
.banks-logos {border-bottom:1px solid #ddd; margin-bottom:30px; padding-bottom:10px;}
.banks-logos a {display:inline-block; color:#686868; font-weight:600; font-size:14px;}
.banks-logos a img {margin-right:10px; float:left;}
.banks-logos a span {display:block; color:#0017c5; font-weight:100; font-size:12px; padding-left:40px; margin-top:-5px;}
</style>
<div class="mytitle row">
	<div class="left col-md-4">
		<h1><?=$pageTitle;?></h1>
	</div>
</div>
	
<div class="white-box">
	<div class="col-md-2"></div>
	<div class="col-md-8">

        <form action="https://finapp.whatsloan.yodlee.in/authenticate/whatsloan/" method="POST">
            <input type="text" name="app" value="10003600" hidden/>
            <input type="text" name="rsession" hidden value="<?php echo $_SESSION['userSession'] ?>"/>
            <input type="text" name="token" hidden value="<?php echo $token ?>" />
            <input type="text" name="redirectReq" hidden value="true"/>
            <input type="text" id="extraParams" hidden name="extraParams" value="callback=<?php echo base_url(); ?>borrowerprocess/returnResponse"/>
            <input class="mybutton" type="submit"value="Add Bank" name="submit" />
        </form>


    </div>
</div>