<?=getNotificationHtml();?>
<section class="sec-pad sec-pad-30">
    <div class="mytitle row">
        <div class="left col-md-12">
            <h1 id="pagetitle"><?=$pageTitle;?></h1>
        </div>
    </div>
	<div class="white-box">
				<form action="<?php echo base_url(); ?>lenderaction/saveRequesttdsstatement" method="post">
					<div class="col-md-3">
						<div class="form-group">
							<input type="text" readonly="" name="tds_statement_date" id="daterange-btn" placeholder="Filter by date" class="form-control filter-by-date">
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="col-sm-12">
								<input class="btn btn-primary" type="submit" name="submit" id="submit">
							</div>
						</div>
					</div>
				</form>
	</div>
</section>

