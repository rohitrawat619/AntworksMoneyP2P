<style>
	.loan-status-m {width:100%; float:left; min-height:338px; border:1px solid #333; margin-top:30px;}
	.loan-status-hd {font-size:16px; font-weight:bold; padding:5px 10px;}
	.my-summary tr td:last-child {font-weight:bold;}
	.accnt-sumry {width:100% float:left; overflow-x:auto; margin-top:15px; border-top:1px solid #ccc; border-bottom:1px solid #ccc; padding:10px 0;}
	.accnt-sumry tr td {border-top-color: transparent !important; font-size:16px; font-weight:bold;}
	.accnt-sumry h4 {font-size:18px; font-weight:bold;}
	.graph-links, .graph-grade {margin:0; padding:0;}
	.graph-grade li {font-size:14px; color:#333; font-weight:bold; display:block; margin-bottom:10px;}
	.graph-grade li span {padding:2px 5px; color:#fff;}
	.graph-grade li:nth-child(1) span {background:#5576a7;}
	.graph-grade li:nth-child(2) span {background:#70c7dc;}
	.graph-grade li:nth-child(3) span {background:#67a62f;}
	.graph-grade li:nth-child(4) span {background:#82cb19;}
	.graph-grade li:nth-child(5) span {background:#eedd22;}
	.graph-grade li:nth-child(6) span {background:#fcc228;}
	.graph-grade li:nth-child(7) span {background:#fe9707;}
	.graph-grade li:nth-child(8) span {background:#ff0000;}

	.graph-links {margin-bottom:15px;}
	.graph-links li {position:relative; display:inline-block; padding:3px 7px;}
	.graph-links li:first-child:before {position:absolute; content:""; right:0; height:12px; top:8px; width:1px; background:#333;}
	.graph-links li a {display:block; color:#206dd7; font-weight:bold;}

	.preloader {display:none;}

	@media(max-width:767px){

	}

</style>
<?=getNotificationHtml();?>
<section class="sec-pad sec-pad-30">
    <div class="mytitle row">
        <div class="left col-md-12">
            <h1 id="pagetitle"><?=$pageTitle;?></h1>
        </div>
    </div>
    <div class="white-box">

		<div class="col-md-4 col-xs-12">
			<div class="loan-status-m">
				<h4 class="loan-status-hd">Loan Status</h4>
				<table class="table table-responsive my-summary">
					<tr>
						<td>1- Total Aggregate Amount Invested</td>
						<td><i class="fa fa-rupee"></i><?php if($total_aggregateamount){echo round($total_aggregateamount, 2);}else{ echo '0.00'; }?></td>
					</tr>
					<tr>
						<td>2- Total Principal Outstanding</td>
						<td><i class="fa fa-rupee"></i> <?php if($total_principal_outstanding){echo $total_principal_outstanding;}else{ echo '0.00'; }?></td>
					</tr>
                    <tr>
						<td>2A- Total No of Loans</td>
						<td><?php if($total_no_of_loans){echo $total_no_of_loans;}else{ echo '0'; }?></td>
					</tr>
                    <tr>
                        <td>2B- Avg Amount of Loan</td>
                        <td><i class="fa fa-rupee"></i> <?php if($avg_amount_of_loan){echo $avg_amount_of_loan;}else{ echo '0'; }?></td>
                    </tr>
                    <tr>
                        <td>2C- Total No where repayment date is not due</td>
                        <td>  <?php if($total_loan_repayment_date_not_due){echo $total_loan_repayment_date_not_due;}else{ echo '0'; }?></td>
                    </tr>
					<tr>
						<td>3- Total Interest Received</td>
						<td><i class="fa fa-rupee"></i> <?php if($total_interest_recieved){echo $total_interest_recieved;}else{ echo '0.00'; }?></td>
					</tr>
					<tr>
						<td>4- Rate of Interest</td>
						<td><?php if($roi){echo $roi;}else{ echo '0.00'; }?> %</td>
					</tr>
					<tr>
						<td>5- Balance</td>
						<td><i class="fa fa-rupee"></i>  <?php if($account_main_balance){echo $account_main_balance;}else{ echo '0.00'; }?></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="col-md-4 col-xs-12">
			<div class="loan-status-m">
				<div class="col-md-12 col-xs-12">
					<h3>Composition**(RS)</h3>
					<ul class="graph-links">
						<li><a href="javascript:void(0)" onclick="return termGrade('term')">Term</a></li>
						<li><a href="javascript:void(0)" onclick="return termGrade('grade')">Grade</a></li>
					</ul>
				</div>
				<!-- Term -->
				<div class="term-result">
					<div class="col-md-8 col-xs-12">
						<div id="element3" class="element">

						</div>
					</div>
					<div class="col-md-4 col-xs-12">
						<ul class="graph-grade">
							<li><span>A</span> (<?php echo round($termResult['gradeA'], 2); ?>%)</li>
							<li><span>B</span> (<?php echo round($termResult['gradeB'], 2); ?>%)</li>
							<li><span>C</span> (<?php echo round($termResult['gradeC'], 2); ?>%)</li>
							<li><span>D</span> (<?php echo round($termResult['gradeD'], 2); ?>%)</li>
							<li><span>E</span> (<?php echo round($termResult['gradeE'], 2); ?>%)</li>
							<li><span>F</span> (<?php echo round($termResult['gradeF'], 2); ?>%)</li>
							<li><span>G</span> (<?php echo round($termResult['gradeG'], 2); ?>%)</li>
							<li><span>R</span> (<?php echo round($termResult['gradeR'], 2); ?>%)</li>
						</ul>

					</div>
				</div>
				<!-- Grade -->
				<div class="grade-result" style="display: none">
					<div class="col-md-8 col-xs-12">
						<div id="grade" class="element">

						</div>
					</div>
					<div class="col-md-4 col-xs-12">
						<ul class="graph-grade">
							<li><span>A</span> (<?php echo $gradeResult['gradeA']; ?>%)</li>
							<li><span>B</span> (<?php echo $gradeResult['gradeB']; ?>%)</li>
							<li><span>C</span> (<?php echo $gradeResult['gradeC']; ?>%)</li>
							<li><span>D</span> (<?php echo $gradeResult['gradeD'] ?>%)</li>
						</ul>

					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xs-12">
			<div class="loan-status-m">
				<h4 class="loan-status-hd">Details</h4>
				<table class="table table-responsive my-summary">
					<tr>
						<td>0 to 30 days past due</td>
						<td><?php if($past_due_0_30days){echo $past_due_0_30days;}else{ echo '0'; }?></td>
					</tr>
					<tr>
						<td>30-60 days past due</td>
						<td> <?php if($past_due_30_60days){echo $past_due_30_60days;}else{ echo '0'; }?></td>
					</tr>
                    <tr>
						<td>60-90 days past due</td>
						<td> <?php if($past_due_60_90days){echo $past_due_60_90days;}else{ echo '0'; }?></td>
					</tr>
					<tr>
						<td>90+ days past due</td>
						<td><?php if($past_due_plus_90days){echo $past_due_plus_90days;}else{ echo '0'; }?></td>
					</tr>

				</table>
			</div>
		</div>
		<div class="col-md-12 col-xs-12">
			<div class="accnt-sumry">
				<h4>Antworks P2P Account Summary</h4>
				<table class="table">
						<tr>
							<td colspan="2">Available Cash</td>
							<td colspan="2">Outstanding loans</td>
							<td>Account Total</td>
						</tr>
						<tr>
							<td>RS <?php echo $available_cash;?></td>
							<td>+</td>
							<td>RS <?php if($in_funding_notes){echo $in_funding_notes;}else{ echo '0.00'; }?></td>


							<td>=</td>
							<td>RS <?php echo $available_cash + $in_funding_notes ?></td>
						</tr>
				</table>
			</div>
        </div>


	</div>
</section>
<script src="https://www.jqueryscript.net/demo/Pie-Donut-Chart-SVG-jChart/src/js/jchart.js?v3"></script>
<script>
    let jchart1;
    $(function () {
        jchart1 = $("#element3").jChart({
            data: [
                {
                    value: <?php echo $termResult['gradeA']; ?>,
                    color: {
                        normal: '#607eac',
                        active: '#333',
                    },
                },
                {
                    value: <?php echo $termResult['gradeB']; ?>,
                    color: {
                        normal: '#ff9e16',
                        active: '#333',
                    },
                },
                {
                    value: <?php echo $termResult['gradeC']; ?>,
                    color: {
                        normal: '#fdc634',
                        active: '#333',
                    },
                },
                {
                    value: <?php echo $termResult['gradeD']; ?>,
                    color: {
                        normal: '#f7e62d',
                        active: '#333',
                    },
                },
                {
                    value: <?php echo $termResult['gradeE']; ?>,
                    color: {
                        normal: '#90db24',
                        active: '#333',
                    },
                },
                {
                    value: <?php echo $termResult['gradeF']; ?>,
                    color: {
                        normal: '#74b23e',
                        active: '#333',
                    },
                },

                {
                    value: <?php echo $termResult['gradeG']; ?>,
                    color: {
                        normal: '#74b23e',
                        active: '#333',
                    },
                },

                {
                    value: <?php echo $termResult['gradeR']; ?>,
                    color: {
                        normal: '#ff0000',
                        active: '#333',
                    },
                    draw: true, //false
                    push: true, //false
                },
            ],
            appearance: {
                type: 'pie',
                baseColor: '#ddd',
            }

        });

    });
</script>

<script>
	$(function () {
		jchart1 = $("#grade").jChart({
			data: [
				{
					value: <?php echo $gradeResult['gradeA']; ?>,
					color: {
						normal: '#607eac',
						active: '#333',
					},
				},
				{
					value: <?php echo $gradeResult['gradeB']; ?>,
					color: {
						normal: '#ff9e16',
						active: '#333',
					},
				},
				{
					value: <?php echo $gradeResult['gradeC']; ?>,
					color: {
						normal: '#fdc634',
						active: '#333',
					},
				},
				{
					value: <?php echo $gradeResult['gradeD']; ?>,
					color: {
						normal: '#f7e62d',
						active: '#333',
					},
				},
			],
			appearance: {
				type: 'pie',
				baseColor: '#ddd',
			}

		});

	});
</script>
<script>
	function termGrade(termGrade) {
         if(termGrade == 'term')
		 {
            $(".term-result").show();
            $(".grade-result").hide();
		 }
         if(termGrade == 'grade')
		 {
			 $(".grade-result").show();
			 $(".term-result").hide();
		 }
	}
</script>
