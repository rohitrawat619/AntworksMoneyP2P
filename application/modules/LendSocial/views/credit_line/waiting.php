<section class="container">
	<div class="row">
		<div class="col-md-2 col-sm-12 text-center"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div class="creditline-success">
				<img src="<?php echo $imageBaseUrl; ?>/waiting-icon.png" class="creditline-icon">
				<h2 class="creditline-waittxt">We are assessing your profile for eligibility</h2>
				<p class="creditline-p">Please bear with us for few seconds and  we will update you.</p>
			</div>
		</div>
	</div>
</section>



	<script>
$(document).ready(function() {
  // When the document is ready, execute this function
  $.ajax({
    url: 'waiting_ajax', // Replace with the actual PHP file containing the function
    type: 'POST', // Or 'GET' depending on your function's requirements
    success: function(response) {
      // Handle the response from the PHP function here
      console.log(response);
	//   console.log(response.status);
	var resp =  JSON.parse(response);
	// alert(resp.status); return false;
	if(resp.status==1){
		window.location.href = 'success';
	}
	else{
		alert(resp.msg);
		window.location.href = 'info';
	}
    },
    error: function(xhr, status, error) {
      // Handle errors here
      console.error('Error:', error);
	  window.location.href = 'info';
    }
  });
});
</script>