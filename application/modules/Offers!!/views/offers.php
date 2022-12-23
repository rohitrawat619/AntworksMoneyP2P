<?= getNotificationHtml(); ?>
<section class="content-header">
	<h1>
		<?php echo $pageTitle; ?>
	</h1>
	<ol class="breadcrumb">
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
			Add New Category
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal_app_page">
			Add New App Page
		</button>
	</ol>
</section>
<section class="content">
	<div class="box">
		<div class="row">

			<div class="col-md-12">
				<div class="clearfix"></div>
				<form action="<? echo base_url('offers/addOffer') ?>" method="post" class="contact-form"
					  enctype="multipart/form-data">
					<div class="col-md-6">
						<div class="form-group">
							<label>Select Category</label>
							<select name="category_id" id="category_id" class="form-control">
								<option> Select Category</option>
								<? if ($categories) {
									foreach ($categories as $category) { ?>
										<option value="<?= $category['id'] ?>"><?= $category['category_name'] ?></option>
									<? }
								} ?>
							</select>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Offer Name</label>
							<input type="text" name="offer_name" id="offer_name" class="form-control"
								   placeholder="Offer Name"/>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Sort Description</label>
							<textarea class="form-control" name="offer_short_description" id="offer_short_description"
									  placeholder="Sort Description"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Long Description</label>
							<textarea class="form-control" name="offer_long_description" id="offer_long_description"
									  placeholder="Long Description"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Term & Condition</label>
							<textarea class="form-control" name="term_condition" id="term_condition"
									  placeholder="Term & Condition"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>About Company</label>
							<textarea class="form-control" name="about_company" id="about_company"
									  placeholder="About Company"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Offer Validity</label>
							<input type="date" name="offer_validity" id="offer_validity" class="form-control"
								   placeholder="Offer Validity"/>
						</div>
					</div>
					<div class="col-md-12">
						<hr/>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Select Offer Icon:</label>
							<input type="file" name="offer_icon_img" id="offer_icon_img" class="form-control"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Offer Banner</label>
							<input type="file" name="offer_banner_img" id="offer_banner_img" class="form-control"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Select Company Icon:</label>
							<input type="file" name="company_icon_img" id="company_icon_img" class="form-control"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Offer URL</label>
							<input type="text" name="offer_url" id="offer_url" class="form-control"
								   placeholder="Offer URL"/>
						</div>
					</div>
					<div class="col-md-12">
						<hr/>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Select Campaign</label>
							<select name="offer_type" id="offer_type" class="form-control">
								<option value="">Select Campaign</option>
								<option value="Cashback">Cashback</option>
								<option value="Discount">Discount</option>
								<option value="Cashback + Discount">Cashback + Discount</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Select Reward Type</label>
							<select name="discount_reward_type" id="discount_reward_type" class="form-control">
								<option value="Flat">Flat (INR)</option>
								<option value="Percentage">Percentage</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Select Coupon Code Type</label>
							<select name="coupon_code_type" id="coupon_code_type" class="form-control">
								<option value="">Select Coupon Code Type</option>
								<option value="Single">Single</option>
								<option value="Multiple">Multiple</option>
							</select>
						</div>
					</div>
					<div id="coupon_code_type_input_parameter"></div>


					<div class="col-md-6">
						<div class="form-group">
							<label>Min transaction amount</label>
							<input type="text" name="min_transaction_amount" id="min_transaction_amount"
								   class="form-control" placeholder="Min Transaction Amount"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Max Transaction Amount</label>
							<input type="text" name="max_transaction_amount" id="max_transaction_amount"
								   class="form-control" placeholder="Max Transaction Amount"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Discount Worth</label>
							<input type="text" name="discount_worth" id="discount_worth" class="form-control"
								   placeholder="Discount Worth"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Max Reward</label>
							<input type="text" name="max_reward" id="max_reward" class="form-control"
								   placeholder="Max Reward"/>
						</div>
					</div>
					<div class="col-md-12">
						<hr/>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<div class="col-md-3">
								Homepage:
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<select name="home_position" id="home_position" class="form-control">
										<option value="">Select Position</option>
										<? for ($i = 1; $i <= $total_positions; $i++) { ?>
											<option value="<?= $i; ?>"><?= $i; ?></option>
										<? } ?>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<div class="col-md-3">
								Offer Page:
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<select name="offer_page_position" id="offer_page_position" class="form-control">
										<option value="">Select Position</option>
										<? for ($i = 1; $i <= $total_positions; $i++) { ?>
											<option value="<?= $i; ?>"><?= $i; ?></option>
										<? } ?>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="col-md-3">
							Other Pages:
						</div>
						<div class="col-md-1">
							<div class="form-group">
							<i class="fa fa-plus add-app-page-multiple" aria-hidden="true"></i>
							</div>
						</div>
					</div>
					<div class="multiple_pages">

					</div>



					<div class="col-md-12">
						<hr/>
					</div>


					<div class="col-md-6">
						<div class="form-group">
							<label>Select Payment Method</label>
							<select name="payment_method[]" id="payment_method" class="form-control" multiple>
								<? if($payment_methods){ foreach ($payment_methods as $payment_method){?>
									<option value="<?= $payment_method['payment_method']; ?>"><?= $payment_method['payment_method']; ?></option>
								<?} }?>
							</select>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Select BANK</label>
							<select name="bank[]" id="bank" class="form-control" multiple>
								<? if($banks){ foreach ($banks as $bank){?>
									<option value="<?= $bank['bank_name']; ?>"><?= $bank['bank_name']; ?></option>
								<?} }?>
							</select>
						</div>
					</div>


					<div class="col-md-6">
						<div class="form-group">
							<label>BIN/INN</label>
							<input type="text" name="bin_inn" id="bin_inn" class="form-control"
								   placeholder="BIN/INN"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>select status</label>
							<select name="status" id="status" class="form-control">
								<option value="">select status</option>
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="submit" name="add_offer_reward" id="add_offer_reward" value="Add Offer/Reward"
								   class="btn btn-primary">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="col-md-12">
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" name="add_category_name" id="add_category_name" class="form-control"
							   placeholder="Category Name"/>
					</div>
				</div>
				<div class="col-md-6">
					<button type="button" class="btn btn-primary" id="addCategory">Add</button>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="exampleModal_app_page" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add New APP page</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="col-md-12">
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" name="add_app_page" id="add_app_page" class="form-control"
							   placeholder="APP Page"/>
					</div>
				</div>
				<div class="col-md-6">
					<button type="button" class="btn btn-primary" id="addApppage">Add</button>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

			</div>
		</div>
	</div>
</div>
