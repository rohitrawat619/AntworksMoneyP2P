<section class="content">
	<!-- Default box -->
	<div class="box">
		<div class="box-header with-border">
			<?= getNotificationHtml(); ?>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list "
							   data-page-size="100">

							<thead>
							<tr>
								<th>SR</th>
								<th>CUSTOMER_NAME</th>
								<th>Product</th>
								<th>Mobile_No</th>
								<th>Alternate_nos</th>
								<th>Vehicle_Model</th>
								<th>Reg_No</th>
								<th>DATE_OF_CALLING</th>
								<th>remarks</th>
							</tr>
							</thead>

							<tbody id="">

							</tbody>
							<tbody id="laon_list">
							<?php if ($lists) {
								$i = 1;
								foreach ($lists AS $key => $list) {
									?>
									<tr>
										<td><?= $i ?></td>
										<td><?php echo $list['CUSTOMER_NAME'] ?></td>
										<td><?php echo $list['Product'] ?></td>
										<td><?php echo $list['Mobile_No'] ?></td>
										<td><?php echo $list['Alternate_nos'] ?></td>
										<td><?php echo $list['Vehicle_Model'] ?></td>
										<td><?php echo $list['Reg_No'] ?></td>
										<td><?php echo $list['DATE_OF_CALLING'] ?></td>
										<td><?php echo $list['remarks'] ?></td>
									</tr>
									</tr>
									<?php $i++;
								}
							} else { ?>

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
							</tbody>
							<tfoot>
							<tr>
								<td colspan="12">
									<?php

//									echo $pagination;

									?></td>
							</tr>

							</tr>
							</tfoot>
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
