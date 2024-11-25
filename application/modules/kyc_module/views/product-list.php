
<div class="row">
	<section class="content-header">
		<h1>
			<?php echo $pageTitle; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Product List</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<?= getNotificationHtml(); ?>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="m-t-30">
						<div class="right-page-header">

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list "
								   data-page-size="100">
								<thead>
								<tr>
									<th style="width: 70px">Sr. No.</th>
									<th>Product Name</th>
									<th>Action</th>
								</tr>
								</thead>

								<tbody id="">

								</tbody>
								<tbody id="laon_list">
								<?php if ($kyc_products) {
									$i = 1;
									foreach ($kyc_products AS $list) {
										?>
										<tr>
											<td><?= $i ?></td>
											<td><?=$list['product_name'];?></td>
											<td><a href="<?= base_url('kyc_module/kyc_rule/').$list['id']?>">Update KYC Rule</a></td>
										</tr>
										<?php $i++;
									}
								} else { ?>

									<tr>
										<td></td>
										<td>No Record Found</td>
										<td></td>
									</tr>
								<?php } ?>
								</tbody>
								
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">

			</div>
			<!-- /.box-footer-->
		</div>
		<!-- /.box -->

	</section>
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
        $('.modal-body').load('<?php echo base_url(); ?>p2padmin/loanmanagement/createLoanledger/' + loan_disbursement_id, function () {
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
