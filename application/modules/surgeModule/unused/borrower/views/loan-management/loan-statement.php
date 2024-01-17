<?=getNotificationHtml();?>

<div class="row">
    <div class="col-md-12">
        <div class="white-box p-0">
            <!-- .left-right-aside-column-->
            <div class="page-aside">
                <!-- .left-aside-column-->

                <!-- /.left-aside-column-->
                <div class="col-md-12">
                    <div class="right-page-header">
                        
                    </div>
                    <div class="clearfix"></div>
                    <div class="scrollable">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table m-t-30 table-bordered p2ploans" data-page-size="100">

									<tr>
										<th class="col-md-2"></th>
										<th class="col-md-2">Reference 1</th>
										<th class="col-md-2">Reference 2</th>
										<th class="col-md-2">Date</th>
										<th class="col-md-2">Debit</th>
										<th class="col-md-2">Credit</th>
										<th class="col-md-2">Amount</th>
										<th class="col-md-2">Balance</th>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>

										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								<?php if($details){
                                    $i = 0;
									foreach($details AS $result)
									{
									?>
									<tr>
										<th><?=$result['title']?></th>
										<th><?=$result['reference_1']?></th>
										<th><?=$result['reference_2']?></th>
										<th><?=$result['created_date']?></th>
										<th><?=$result['debit']?></th>
										<th><?=$result['credit']?></th>
										<th><?=$result['amount']?></th>
										<th><?=$result['balance']?></th>
									</tr>
                                        <?php if($result['emi_bounce_details']) foreach($result['emi_bounce_details'] AS $emi_bounce_details){?>
                                        <tr>
                                            <th><?php echo $emi_bounce_details['chrages_type'] ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th><?php echo $emi_bounce_details['charges_amount'] ?></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    <?php }?>
								<?php $i++;}
								} ?>


									
						</div>
					</div>
					
                    </div>
                </div>
                <!-- .left-aside-column-->

            </div>
            <!-- /.left-right-aside-column-->
        </div>
    </div>
</div>