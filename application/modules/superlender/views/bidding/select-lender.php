<?= getNotificationHtml(); ?>
<div class="row">
	<div class="col-md-12 col-xs-12">
		<?
		if (empty($pageTitle)) {
			$pageTitle = "";
		}
		?>
		<div class="mytitle row">
			<div class="left col-md-12">
				<div class="col-md-2"><h1><?= $pageTitle; ?></h1></div>
			</div>
		</div>
	</div>
</div>
<div class="white-box">
	<div class="col-md-12">
		<div class="col-md-6">
			<select class="form-control" id="lender_id" name="lender_id" onchange="return selectLender(this.value)">
				<option value="">Select Lender</option>
				<?php if($lender_list){ foreach ($lender_list AS $lender) { ?>
					<option value="<?=$lender['lender_id']?>"><?=$lender['name']?></option>
				<?}} ?>
			</select>
		</div>
	</div>
</div>
<script>
	function selectLender(lenderId) {
       window.location.href = "<?php echo base_url(); ?>superlender/lender/"+lenderId;
	}
</script>
