<?=getNotificationHtml();?>

<div class="row">
    <div class="col-md-12">
        <div class="white-box p-0">
            <!-- .left-right-aside-column-->
            <div class="page-aside">
                <!-- .left-aside-column-->

                <!-- /.left-aside-column-->
                <div class="">
                    <h2><?php echo $pageTitle; ?></h2>
                    <div class="m-t-30">
                        <div class="right-page-header">
                            <form method="post" action="<?php echo base_url(); ?>p2padmin/searchborrower">
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" readonly name="start_date" id="datepicker-autoclose" placeholder="Starting date" class="form-control" id="start_date">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" readonly name="end_date" id="datepicker-autoclose2" placeholder="End date" class="form-control" id="end_date">
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
                                            <select class="form-control" name="status" id="status">
                                                <option value="">--Select--</option>
                                                <option value="0">Not Verified</option>
                                                <option value="1">Verified</option>
                                            </select>
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
                    <div class="clearfix"></div>
                    <div class="scrollable">
                        <div class="table-responsive">
                            <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-page-size="100">
                                <thead>
                                <tr>
                                    <th>
                                    <th>Borrower Id</th>
                                    <th>Name</th>

                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?  $i=1;
                                foreach($list as $row){

                                    ?>
                                    <tr>
                                        <td><span class="footable-toggle"></span><?=$i?></td>
                                        <td><?=ucwords($row['borrower_id']);?></td>
                                        <td><?=ucwords($row['name']);?></td>
                                        <td><?php //if($row['verify']==0 ){ echo "Unverified"; } else{echo "Verify";} ?></td>
                                        <td><a href='<?=base_url();?>p2padmin/documentverification/viewborrowerdoc/<?=$row['borrower_id']?>'>View</a></td>

                                    </tr>
                                    <? $i++;}?>
                                </tbody>
                                <tfoot>
                                <tr>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- .left-aside-column-->

            </div>
            <!-- /.left-right-aside-column-->
        </div>
    </div>
</div>
