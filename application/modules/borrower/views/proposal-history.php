
<div class="mytitle row">
	<div class="left col-md-4">
		<h1><?=$pageTitle;?></h1>
	</div>
</div>
	
	
	<div class="white-box">
		<div class="col-md-12 proposal-h">	
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#bidall" aria-controls="bidall" role="tab" data-toggle="tab">All</a></li>
				<li role="presentation"><a href="#biddingopen" aria-controls="biddingopen" role="tab" data-toggle="tab">Bidding Open</a></li>
				<li role="presentation"><a href="#biddingclose" aria-controls="biddingclose" role="tab" data-toggle="tab">Bidding Closed</a></li>
				<li role="presentation"><a href="#bidsuccessful" aria-controls="bidsuccessful" role="tab" data-toggle="tab">Successful</a></li>
				<li role="presentation"><a href="#bidpartially" aria-controls="bidpartially" role="tab" data-toggle="tab">Partiallly Approved</a></li>
			  </ul>

			  <!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="bidall">
					<div class="col-md-12">	
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
								<tr>
									<th>#</th>
									<th>Loan Type</th>
									<th>Peer Loan Request Number(PLRN)</th>
									<th>Amount(in INR)</th>
									<th>Interest Rate Range(%)</th>
									<th>Tenor(in months)</th>
									<th>DateTime of Proposal</th>
									<th>Status</th>
								</tr>
                                <?php if($all_proposal_info){ $i = 1; foreach($all_proposal_info AS $proposal_info){
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>Individual</td>
                                        <td><?php echo $proposal_info['PLRN']; ?></td>
                                        <td><?php echo $proposal_info['loan_amount']; ?></td>
                                        <td><?php echo $proposal_info['min_interest_rate']; ?></td>
                                        <td><?php echo $proposal_info['tenor_months']; ?></td>
                                        <td><?php echo $proposal_info['date_added']; ?></td>
                                        <td><?php echo $proposal_info['proposal_status_name']; ?></td>
                                    </tr>
                                <?php $i++; }} else{
                                    echo "No record Found";
                                } ?>
							</table>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="biddingopen">
					<div class="col-md-12">	
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
								<tr>
									<th>#</th>
									<th>Loan Type</th>
									<th>Peer Loan Request Number(PLRN)</th>
									<th>Amount(in INR)</th>
									<th>Interest Rate Range(%)</th>
									<th>Tenor(in months)</th>
									<th>DateTime of Proposal</th>
									<th>Status</th>
								</tr>
                                <?php if($open_proposal_info){ $i = 1; foreach($open_proposal_info AS $proposal_info){
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>Individual</td>
                                        <td><?php echo $proposal_info['PLRN']; ?></td>
                                        <td><?php echo $proposal_info['loan_amount']; ?></td>
                                        <td><?php echo $proposal_info['min_interest_rate']; ?></td>
                                        <td><?php echo $proposal_info['tenor_months']; ?></td>
                                        <td><?php echo $proposal_info['date_added']; ?></td>
                                        <td><?php echo $proposal_info['proposal_status_name']; ?></td>
                                    </tr>
                                    <?php $i++; }}else{
                                    echo "No record Found";
                                } ?>
							</table>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="biddingclose">
					<div class="col-md-12">	
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
								<tr>
									<th>#</th>
									<th>Loan Type</th>
									<th>Peer Loan Request Number(PLRN)</th>
									<th>Amount(in INR)</th>
									<th>Interest Rate Range(%)</th>
									<th>Tenor(in months)</th>
									<th>DateTime of Proposal</th>
									<th>Status</th>
								</tr>
                                <?php if($closed_proposal_info){ $i = 1; foreach($closed_proposal_info AS $proposal_info){
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>Individual</td>
                                        <td><?php echo $proposal_info['PLRN']; ?></td>
                                        <td><?php echo $proposal_info['loan_amount']; ?></td>
                                        <td><?php echo $proposal_info['min_interest_rate']; ?></td>
                                        <td><?php echo $proposal_info['tenor_months']; ?></td>
                                        <td><?php echo $proposal_info['date_added']; ?></td>
                                        <td><?php echo $proposal_info['proposal_status_name']; ?></td>
                                    </tr>
                                    <?php $i++; }}else{
                                    echo "No record Found";
                                } ?>
							</table>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="bidsuccessful">
					<div class="col-md-12">	
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
								<tr>
									<th>#</th>
									<th>Loan Type</th>
									<th>Peer Loan Request Number(PLRN)</th>
									<th>Amount(in INR)</th>
									<th>Interest Rate Range(%)</th>
									<th>Tenor(in months)</th>
									<th>DateTime of Proposal</th>
									<th>Status</th>
								</tr>
                                <?php if($successfull_proposal_info){ $i = 1; foreach($successfull_proposal_info AS $proposal_info){
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>Individual</td>
                                        <td><?php echo $proposal_info['PLRN']; ?></td>
                                        <td><?php echo $proposal_info['loan_amount']; ?></td>
                                        <td><?php echo $proposal_info['min_interest_rate']; ?></td>
                                        <td><?php echo $proposal_info['tenor_months']; ?></td>
                                        <td><?php echo $proposal_info['date_added']; ?></td>
                                        <td><?php echo $proposal_info['proposal_status_name']; ?></td>
                                    </tr>
                                    <?php $i++; }}else{
                                    echo "No record Found";
                                } ?>
							</table>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="bidpartially">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
								<tr>
									<th>#</th>
									<th>Loan Type</th>
									<th>Peer Loan Request Number(PLRN)</th>
									<th>Amount(in INR)</th>
									<th>Interest Rate Range(%)</th>
									<th>Tenor(in months)</th>
									<th>DateTime of Proposal</th>
									<th>Status</th>
								</tr>
                                <?php if($partially_proposal_info){ $i = 1; foreach($partially_proposal_info AS $proposal_info){
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>Individual</td>
                                        <td><?php echo $proposal_info['PLRN']; ?></td>
                                        <td><?php echo $proposal_info['loan_amount']; ?></td>
                                        <td><?php echo $proposal_info['min_interest_rate']; ?></td>
                                        <td><?php echo $proposal_info['tenor_months']; ?></td>
                                        <td><?php echo $proposal_info['date_added']; ?></td>
                                        <td><?php echo $proposal_info['proposal_status_name']; ?></td>
                                    </tr>
                                    <?php $i++; }}else{
                                    echo "No record Found";
                                } ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>