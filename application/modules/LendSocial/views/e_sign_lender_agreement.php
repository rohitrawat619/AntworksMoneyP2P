
<section class="container">
	<div class="row">
		<div class="col-md-1 col-xs-12"></div>
		<div class="col-md-10 col-xs-12 e-signbox">
			<div class="e-signbox-txt">
			<?php// echo $encryptedInvestSchemeNAmount; ?>
				<?php echo $view_lender_agreement?>
							</div>
		</div>
	</div>
	<div class="row">
        <div class="col-md-1 col-xs-12"></div>
        <div class="col-md-10 col-xs-12 text-right">
            <a href="#" class="e-signbox-btn" id="eSignButton">Accept and E-Sign</a>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {

        $('#eSignButton').click(function(e) {
            e.preventDefault(); 
			console.log("button clicked");

            $.ajax({
                url: 'e_sign_lender_agreement_send_otp',
                type: 'POST',
                success: function(response) {
					console.log(response);
					var resp =  JSON.parse(response);
					if(resp.status==1){
						window.location.href = 'e_sign_lender_agreement_otp?q=<?php echo $encryptedInvestSchemeNAmount; ?>';
					}
					
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error('Error:', error);
                }
            });
        });
    });
</script>
