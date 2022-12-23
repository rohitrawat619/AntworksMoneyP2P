<style>
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

<div class="mytitle row">
	<div class="left col-md-4">
		<h1><?= $pageTitle; ?></h1>
	</div>
</div>


<div class="white-box">
<div class="table-responsive">
	<table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list "
		   data-page-size="100">
		<thead>
		<tr>
			<th>SR</th>
			<th>Lender Name</th>
			<th>Borrower Name</th>
			<th>Loan Id</th>
			<th>Date of Disbursement</th>
			<th>Principal Outstanding</th>
			<th>Each EMI Amount</th>
			<th>Number of EMI Serviced</th>
			<th>Tenure</th>
		</tr>
		</thead>

		<tbody id="">

		</tbody>
		<tbody id="laon_list">
		<?php if ($loan_list) {
			$i = 1;
			foreach ($loan_list AS $laon) {
				?>
				<tr>
					<td><?= $i ?></td>
					<td><?php echo $laon['lender_name'] ?></td>
					<td><?php echo $laon['borrower_name'] ?></td>
					<td><a href="javascript:void(0)" class="openBtn"
						   id="<?php echo $laon['loan_disbursement_id']; ?>"><?php echo $laon['loan_no'] ?></a>
					</td>
					<td><?php echo $laon['disbursement_date'] ?></td>
					<td><?php echo $laon['principal_outstanding'] ?></td>
					<td><?php echo $laon['emi_amount'] ?></td>
					<td><?php echo $laon['number_of_emi_serviced'] ?></td>
					<td><?php echo $laon['tenor_months'] ?></td>
				</tr>
				<?php $i++;
			}
		} else { ?>

			<tr>
				<td colspan="6"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>

				<td>No Record Found</td>
			</tr>
		<?php } ?>
		</tbody>
		<tfoot>
		<tr>
			<td colspan="12">
				<?php

				echo $pagination;

				?></td>
		</tr>

		</tr>
		</tfoot>
	</table>
</div>
</div>

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

<script type="text/javascript">
    $('.openBtn').on('click', function () {
        /*$('.modal-body').load('content.html',function(){
			$('#myModal').modal({show:true});
		})*/
        var loan_disbursement_id = $(this).attr('id');
        $('.modal-body').load('<?php echo base_url(); ?>borroweraction/createLoanledger/' + loan_disbursement_id, function () {
            $('#myModal').modal({show: true});
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
