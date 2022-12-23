<?=getNotificationHtml();?>

<div class="row">
    <div class="col-md-12">
        <div class="mytitle row">
            <div class="left col-md-12">
                <h1 id="pagetitle"><?=$pageTitle;?></h1>
            </div>
        </div>
        <div class="white-box p-0">
            <!-- .left-right-aside-column-->
            <div class="page-aside">
                <!-- .left-aside-column-->
                <div class="m-t-30">
                    <div class="right-page-header">
                        <form method="post" action="<?php echo base_url(); ?>lender/request/lender-ledger-search">
                            <div class="col-md-12">
                                <div class="col-md-3">
									<div class="form-group">
										<input type="text" readonly name="filter_by_date" id="daterange-btn" value="<?= $this->input->post('filter_by_date') ? $this->input->post('filter_by_date') : '--';?>" placeholder="Filter by date" class="form-control filter-by-date">
									</div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="submit" id="search" value="Search" name="search" class="btn btn-primary">
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.left-aside-column-->
                <div class="col-md-12">
                    <div class="right-page-header">
                        
                    </div>
                    <div class="clearfix"></div>
                    <div class="scrollable">
                    <div class="col-md-12">
                    <div class="table-responsive">
                            <table class="table m-t-30 table-bordered marz-t-30" data-page-size="100">
									<tr>
										<td class="p2ploans-hd" colspan="7" style="font-size: 21px; text-align: center; color: #444; padding: 15px 0;">Lender's Ledger</td>
									</tr>	
									<tr>
										<th class="col-md-1">SN</th>
										<th class="col-md-2"></th>
										<th class="col-md-3">Reference</th>
										<th class="col-md-2">Date</th>
										<th class="col-md-1">Debit</th>
										<th class="col-md-1">Credit</th>
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
									</tr>
								<?php if($ledger_balance){
                                    $i = 1;
									foreach($ledger_balance AS $result)
									{
									?>
									<tr>
										<td><?=$i?></td>
										<td><?=$result['title']?></td>
										<td><?=$result['reference_1']?></td>
										<td><?=$result['created_date']?></td>
										<td><?=$result['debit']?$result['debit']:''?></td>
										<td><?=$result['credit']?$result['credit']:''?></td>
										<td><?=$result['balance']?></td>
									</tr>

								<?php $i++;}
								} ?><td>
                                    <td colspan="5">Current Balance</td>
                                    <td><?php if($remainningAmount){echo $remainningAmount['account_balance'];} else{echo '0.00';} ?></td>
                                </tr>

                            </table>

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
