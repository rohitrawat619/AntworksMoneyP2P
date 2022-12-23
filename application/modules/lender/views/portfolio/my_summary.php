<style>
	.marz-t-30 {margin-top:30px;}
	.payout-main {max-width:500px; margin:0 auto; }
	.payout-main .form-horizontal .form-group {min-height:auto;}
	.payout-main p {text-align:center;}
	.payout-main p:first-child {font-size:16px;}
	.payout-main p:first-child span {font-weight:600;}
	.payout-bx {border: 1px solid #00477a; padding:0 0 50px 0; margin-top:15px;}
	.payout-hd {background: #01548f; text-transform:uppercase; color:#fff; padding:5px 15px; font-size:18px; margin-bottom:15px;}
	.payout-main .form-horizontal {margin-left: 15px; margin-right: 20px;}

	@media screen {
		#printSection {
			display: none;
		}
	}

	@media print {
		body * {
			visibility: hidden;
		}
		#printSection,
		#printSection * {
			visibility: visible;
		}
		#printSection {
			position: absolute;
			left: 0;
			top: 0;
		}
	}


</style>

<section class="sec-pad sec-pad-30">
    <div class="mytitle row">
        <div class="left col-md-12">
            <h1 id="pagetitle"><?=$pageTitle;?></h1>
        </div>
    </div>
    <div class="white-box">
		<div class="table-responsive">
		<table class="table marz-t-30">
			<tr>
				<th>Borrower Name</th>
				<th>Loan Id</th>
				<th>Date of Disbursement</th>
				<th>Loan Amount</th>
				<th>Amount Repaid</th>
				<th>Principal Outstanding</th>
				<th>Each EMI Amount</th>
				<th>Number of EMI Serviced</th>
				<th>Tenure</th>
				<th>Repayment Date</th>
				<th>View Loan Ledger</th>
			</tr>
            <?php if($loan_summary){foreach ($loan_summary AS $summary){
                ?>
                <tr>
                    <td><a target="_blank" href="<? echo base_url('bidding/borrower_profile_details/'). $summary['b_borrower_id']?>"><?php echo $summary['borrower_name'] ?></a></td>
                    <td><?php echo $summary['loan_no'] ?></td>
                    <td><?php echo $summary['disbursement_date'] ?></td>
                    <td><?php echo $summary['loan_amount'] ?></td>
                    <td><?php echo $summary['total_amount_repaid'] ?></td>
                    <td><?php echo $summary['principal_outstanding'] ?></td>
                    <td><?php echo $summary['emi_amount'] ?></td>
                    <td><?php echo $summary['number_of_emi_serviced'] ?></td>
                    <td><?php echo $summary['tenor_months'] ?></td>
                    <td><?php echo $summary['next_repay'] ? $summary['next_repay'] : 'Repaid' ?></td>
					<td><button type="button" class="btn btn-success openBtn" id="<?php echo $summary['loan_disbursement_id']; ?>">View Loan Ledger</button></td>
                </tr>
            <?php }} else{ ?>

			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>No Record Found</td>
			</tr>
           <?php } ?>
		</table>
		</div>
	</div>
</section>
<div class="container">

	<div class="row">
		<div class="col-lg-12">
			<div>
				<div class="modal fade bs-example-modal-lg" id="myModal" role="dialog">
					<div class="modal-dialog modal-lg">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header" style="border-color: transparent">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<div id="printThis">
								<div class="modal-body">

								</div>

							</div>
							<div class="modal-footer" style="border-color: transparent">
								<button id="btnPrint" type="button" class="btn btn-default">Print</button>
								<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<script>
    $('.openBtn').on('click',function(){
        /*$('.modal-body').load('content.html',function(){
			$('#myModal').modal({show:true});
		})*/
        var loan_disbursement_id = $(this).attr('id');
        $('.modal-body').load('<?php echo base_url(); ?>/lender/account/createLoanledger/'+loan_disbursement_id,function(){
            $('#myModal').modal({show:true});
        });
    });
</script>
<script>
    document.getElementById("btnPrint").onclick = function () {
        printElement(document.getElementById("printThis"));
    }

    function printElement(elem) {
        var domClone = elem.cloneNode(true);

        var $printSection = document.getElementById("printSection");

        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }

        $printSection.innerHTML = "";
        $printSection.appendChild(domClone);
        window.print();
    }
</script>
