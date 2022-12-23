<?= getNotificationHtml(); ?>
<style>
	.img-thumb{
		margin: 0; padding: 0;
	}
	.img-thumb li{
		display: inline-block;
		margin: 5px;
	}
	.img-thumb li img{
		width: 100px;
	}
</style>
<section class="content-header">
	<h1>
		<?php echo $pageTitle; ?>
	</h1>
	<ol class="breadcrumb">
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
			Add New Category
		</button>
	</ol>
</section>
<section class="content">
	<div class="box">
		<div class="row">

			<div class="col-md-12">
				<div class="clearfix"></div>
				<form action="<? echo base_url('offers/updateOffer') ?>" method="post" class="contact-form"
					  enctype="multipart/form-data">
					<div class="col-md-6">
						<div class="form-group">
							<label>Select Category</label>
							<select name="category_id" id="category_id" class="form-control">
								<option> Select Category</option>
								<? if ($categories) {
									foreach ($categories as $category) { ?>
										<option value="<?= $category['id'] ?>" <? if($offer['category_id'] == $category['id']) { echo "selected"; }?>><?= $category['category_name'] ?></option>
									<? }
								} ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Offer Name</label>
							<input type="text" name="offer_name" id="offer_name" class="form-control"
								   placeholder="Offer Name" value="<? echo $offer['offer_name']; ?>"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Sort Description</label>
							<textarea class="form-control" name="offer_short_description" id="offer_short_description"
									  placeholder="Sort Description"><? echo $offer['offer_short_description']; ?></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Long Description</label>
							<textarea class="form-control" name="offer_long_description" id="offer_long_description"
									  placeholder="Long Description"><? echo $offer['offer_long_description']; ?></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Term & Condition</label>
							<textarea class="form-control" name="term_condition" id="term_condition"
									  placeholder="Term & Condition"><? echo $offer['term_condition']; ?></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>About Company</label>
							<textarea class="form-control" name="about_company" id="about_company"
									  placeholder="About Company"><? echo $offer['about_company']; ?></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Offer Validity</label>
							<input type="date" name="offer_validity" id="offer_validity" value="<? echo $offer['offer_validity']; ?>" class="form-control"
								   placeholder="Offer Validity"/>
						</div>
					</div>
					<div class="col-md-12">
						<hr/>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label>Select Offer Icon:</label>
									<input type="file" name="offer_icon_img" id="offer_icon_img" class="form-control"/>
								</div>
							</div>
							<div class="col-md-4">
								<ul class="img-thumb">
									<li><img src="<? echo $offer['offer_icon_img']; ?>"></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label>Offer Banner</label>
									<input type="file" name="offer_banner_img" id="offer_banner_img" class="form-control"/>
								</div>
							</div>
							<div class="col-md-4">
								<ul class="img-thumb">
									<li><img src="<? echo $offer['offer_icon_img']; ?>"></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label>Select Company Icon:</label>
									<input type="file" name="company_icon_img" id="company_icon_img" class="form-control"/>
								</div>
							</div>
							<div class="col-md-4">
								<ul class="img-thumb">
									<li><img src="<? echo $offer['offer_icon_img']; ?>"></li>
								</ul>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Offer URL</label>
							<input type="text" name="offer_url" id="offer_url" class="form-control"
								   placeholder="Offer URL" value="<? echo $offer['offer_url']; ?>"/>
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
								<option value="Cashback" <? if($offer['offer_type'] == 'Cashback') { echo "selected"; }?>>Cashback</option>
								<option value="Discount" <? if($offer['offer_type'] == 'Discount') { echo "selected"; }?>>Discount</option>
								<option value="Cashback + Discount" <? if($offer['offer_type'] == 'Cashback + Discount') { echo "selected"; }?>>Cashback + Discount</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Select Reward Type</label>
							<select name="discount_reward_type" id="discount_reward_type" class="form-control">
								<option value="Flat" <? if($offer['discount_reward_type'] == 'Flat') { echo "selected"; }?>>Flat (INR)</option>
								<option value="Percentage" <? if($offer['discount_reward_type'] == 'Percentage') { echo "selected"; }?>>Percentage</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Select Coupon Code Type</label>
							<select name="coupon_code_type" id="coupon_code_type" class="form-control">
								<option value="">Select Coupon Code Type</option>
								<option value="Single"  <? if($offer['coupon_code_type'] == 'Single') { echo "selected"; }?>>Single</option>
								<option value="Multiple"  <? if($offer['coupon_code_type'] == 'Multiple') { echo "selected"; }?>>Multiple</option>
							</select>
						</div>
					</div>
					<div id="coupon_code_type_input_parameter">
						<div class="col-md-6"><div class="form-group"><label>Coupon Code</label><input type="text" name="coupon_code" id="coupon_code" value="<? if($coupons){ foreach ($coupons as $coupon){
									echo $coupon['coupon_code'];
								} } ?>" class="form-control" placeholder="Coupon Code"></div></div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Min transaction amount</label>
							<input type="text" name="min_transaction_amount" id="min_transaction_amount"
								   class="form-control" placeholder="Min Transaction Amount" value="<? echo $offer['min_transaction_amount']; ?>"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Max Transaction Amount</label>
							<input type="text" name="max_transaction_amount" id="max_transaction_amount"
								   class="form-control" placeholder="Max Transaction Amount" value="<? echo $offer['max_transaction_amount']; ?>"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Discount Worth</label>
							<input type="text" name="discount_worth" id="discount_worth" class="form-control"
								   placeholder="Discount Worth" value="<? echo $offer['discount_worth']; ?>"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Max Reward</label>
							<input type="text" name="max_reward" id="max_reward" class="form-control"
								   placeholder="Max Reward" value="<? echo $offer['max_reward']; ?>"/>
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
											<option value="<?= $i; ?>" <? if($home_position['offer_position'] == $i){ echo 'selected';} ?> ><?= $i; ?></option>
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
											<option value="<?= $i; ?>" <? if($offer_position['offer_position'] == $i){ echo 'selected';} ?> ><?= $i; ?></option>
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
                      <? if($app_pages_position){ foreach ($app_pages_position as $app_pages_saved){ ?>
						  <div class="col-md-12">
							  <div class="col-md-4"><div class="form-group">
									  <select name="app_page_name[]" class="form-control">
										  <option value="">Select Page Name</option>
										  <? foreach ($app_pages as $app_page) { ?><option value="<?= $app_page["app_page"]; ?>" <? if(in_array($app_pages_saved['app_page_name'], $app_page)){echo "selected";} ?> ><?= $app_page["app_page"]; ?></option><? } ?>
									  </select>
								  </div>
							  </div>
							  <div class="col-md-4">
								  <div class="form-group">
									  <select name="app_page_position[]" id="" class="form-control">
										  <option value="">Select Position</option>
										  <? for ($i = 1; $i <= $total_positions; $i++) { ?><option value="<?= $i; ?>" <? if($i == $app_pages_saved['offer_position']){ echo "selected"; } ?> ><?= $i; ?></option><? } ?>
									  </select>
								  </div>
							  </div>
						  </div>
					  <?}} ?>
					</div>
					<div class="col-md-12">
						<hr/>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Select Payment Method</label>
							<select name="payment_method[]" id="payment_method" class="form-control" multiple>
								<? if($payment_methods){ foreach ($payment_methods as $payment_method){?>
									<option value="<?= $payment_method['payment_method']; ?>"  <? if(in_array($payment_method['payment_method'], json_decode($offer['payment_method'], true))) { echo "selected"; }?>><?= $payment_method['payment_method']; ?></option>
								<?} }?>
							</select>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Select BANK</label>
							<select name="bank[]" id="bank" class="form-control" multiple>
								<? if($banks){ foreach ($banks as $bank){?>
								  <option value="<?= $bank['bank_name']; ?>"  <? if(in_array($bank['bank_name'], json_decode($offer['bank'], true))) { echo "selected"; }?>><?= $bank['bank_name']; ?></option>
								<?} }?>
							</select>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>BIN/INN</label>
							<input type="text" name="bin_inn" id="bin_inn" value="<? echo $offer['bin_inn']; ?>" class="form-control"
								   placeholder="BIN/INN"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>select status</label>
							<select name="status" id="status" class="form-control">
								<option value="">select status</option>
								<option value="1" <? if($offer['status'] == 1) { echo "selected"; }?>>Active</option>
								<option value="0" <? if($offer['status'] == 0) { echo "selected"; }?>>Inactive</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="hidden" name="offer_id" value="<? echo $offer['id']?>">
							<input type="submit" name="add_offer_reward" id="add_offer_reward" value="Update Offer/Reward"
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
