<div class="mytitle row hidden">
	<div class="left col-md-4">
		<h1><?=$pageTitle;?></h1>
	</div>
</div>
	
<div class="white-box m-t-30">
	<div class="col-md-10 text-center">
		<p class="p-b-20 p-t-20">We are creating your Escrow Account.<br> Please stay by till we process.</p>
		<i class="fa fa-spinner fa-pulse fa-3x "></i>
	</div>
</div>
<script>
    $(document).ready(function() {
        var escrow = 1;
        $.ajax({
            url:'<?php echo base_url();?>lenderaction/create_escrow',
            type:"post",
            data:"escrow="+escrow,
            success: function(data){}
        });
        setTimeout(function() {
            window.location.href = "<?php echo base_url();?>lenderprocess/escrow-account-successful";
        }, 5000);
    });
</script>