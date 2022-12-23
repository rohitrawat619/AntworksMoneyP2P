
<div class="mytitle row">
	<div class="left col-md-4">
		<h1><?=$pageTitle;?></h1>
	</div>
</div>
	
	
	<div class="white-box prsnl-dtls">
			<h3 class="borrower-prof-hd"><i class="ti-user"></i> Documents Submitted</h3>
			<div class="row">
                <ul class="documnt-verify">
                    <?php foreach($kycDoctype AS $doctype){?>

                        <li><i class="fa fa-check-square-o" aria-hidden="true"></i>
							<?php echo str_replace('_', ' ', $doctype['docs_type']) ?>
							<a href="<?php echo base_url() ?>assets/borrower-documents/<?= $doctype['docs_name'] ?>" target="_blank">
							<img width="100" height="100" src="<?php echo base_url() ?>assets/borrower-documents/<?= $doctype['docs_name'] ?>">
							</a>
						</li>
                    <?php } ?>


                </ul>
			</div>
		</div>
