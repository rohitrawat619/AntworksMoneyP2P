<div class="mytitle row">
		<div class="left col-md-4">
			<h1><?=$pageTitle;?></h1>
		</div>
	</div>
	
	
	<div class="white-box">
		<div class="table-responsive kyc-main">
			<table class="table m-t-30 table-bordered kyc-main">
				<tr>
					<th>#</th>
					<th>Loan Id</th>
					<th>Status</th>
				</tr>
				<tr>
					<td><input type="radio" id='regular' name="optradio" checked="checked"></td>
					<td>LN100015</td>
					<td>Running</td>
				</tr>
				<tr>
					<td><input type="radio" id='express' name="optradio"></td>
					<td>LN100016</td>
					<td>Closed</td>
				</tr>
				<tr>
					<td><input type="radio" id="run2" name="optradio"></td>
					<td>LN100017</td>
					<td>Running</td>
				</tr>
				<tr>
					<td><input type="radio" id="run3" name="optradio"></td>
					<td>LN100018</td>
					<td>Running</td>
				</tr>
			</table>
			<button class="btn btn-primary pull-right m-t-10 m-b-30" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Generate Statement</button>
		</div>
		<div class="col-md-12 m-t-40 collapse" id="collapseExample">
			<div class="table-responsive kyc-main">
				<table class="table m-t-30 table-bordered kyc-main">
					<tr>
						<th>Borrower Name</th>
						<th>Loan Id</th>
						<th>Date of Disbursement</th>
						<th>Principal Outstanding</th>
						<th>Each EMI Amount</th>
						<th>Number of EMI Serviced</th>
						<th>Tenure</th>
						<th>Next Repay</th>
					</tr>
					<tr>
						<td>Mr. X</td>
						<td>0000-00-00 00:00:00</td>
						<td></td>
						<td></td>
						<td>3000</td>
						<td>3</td>
						<td>12%</td>
						<td></td>
					</tr>
					<tr>
						<td>Mr. Y</td>
						<td>0000-00-00 00:00:00</td>
						<td></td>
						<td></td>
						<td>3000</td>
						<td>3</td>
						<td>12%</td>
						<td></td>
					</tr>
					<tr>
						<td>Mr. Z</td>
						<td>0000-00-00 00:00:00</td>
						<td></td>
						<td></td>
						<td>3000</td>
						<td>3</td>
						<td>12%</td>
						<td></td>
					</tr>
			</table>
		</div>
		</div>
		
	</div>