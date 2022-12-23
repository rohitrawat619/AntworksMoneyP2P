<div class="row">
<section class="content-header">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Borrower List</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <?=getNotificationHtml();?>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="m-t-30">
                    <div class="right-page-header">
                        <form method="post" id="download_borrower" action="<?=base_url('p2padmin/p2pborrower/downloadBorrowers');?>">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" readonly name="start_date" id="daterange-btn_onlymonth" placeholder="Filter by date" class="form-control filter-by-date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="submit"  value="Download" name="Download" class="btn btn-primary">
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="m-t-30">
                    <div class="right-page-header">
                        <form method="post" id="download_borrower" action="<?=base_url('p2padmin/p2pborrower/downloadBorrowers_disbursal');?>">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" readonly name="start_date" id="daterange-btn_onlymonth_1" placeholder="Filter by date" class="form-control filter-by-date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="submit"  value="Download For Disbursal" name="Download" class="btn btn-primary">
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="m-t-30">
                    <div class="right-page-header">
                        <form method="post" id="search_admin">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" readonly name="start_date" id="daterange-btn" placeholder="Filter by date" class="form-control filter-by-date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Name" class="form-control" id="name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="pan" placeholder="Pancard" class="form-control" id="pan">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="email" placeholder="Email" class="form-control" id="email">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="mobile" placeholder="Mobile" class="form-control" id="mobile">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
										<input type="hidden" name="action_uri" value="p2padmin/p2pborrower/viewborrower/">
                                        <input type="button" id="search_by_admin" value="Search" name="search_by_admin" class="btn btn-primary">
                                        <a href="javascript:void(0)" onclick="return clearForm(event)">clear</a>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                    <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list " data-page-size="100">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Borrower ID</th>
                            <th>Name</th>
                            <th>Email</th>

                            <th>Added date</th>
                            <th>Payment Status</th>
                        </tr>
                        </thead>

                        <tbody id="borrower_search_list">

                        </tbody>
                        <tbody id="borrower_list">
                        <? 	if($list){
                            $i=1;
                            foreach($list as $row){
                                ?>
                                <tr>
                                    <td><?=$i;?></td>
                                    <td><?=$row['borrower_id'];?></td>
                                    <td><a href="<?=base_url();?>p2padmin/p2pborrower/viewborrower/<?=$row['borrower_id'];?>"> <?= $row['name'] ;?></a></td>
                                    <td><?=$row['email'];?></td>

                                    <td><?=$ff = date('Y-m-d', strtotime($row['created_date']));?></td>
                                    <td><?php if($row['step_2'] == 1){ echo "Payment Done"; } else{ echo "Payment Not Done"; } ?></td>
                                </tr>
                                <? $i++;}}else
                        {?>
                            <tr>
                                <td colspan="9">No Records Found!</td>
                            </tr>
                        <? }?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="12">
                                <?php

                                echo $pagination;

                                ?></td></tr>

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
</div>
