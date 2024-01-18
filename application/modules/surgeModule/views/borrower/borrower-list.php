<div class="row">
<section class="content-header">
     <h1 style="padding-left:40px;">
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
            <?php echo getNotificationHtml();?>
        </div>
        <div class="box-body">
            <!--<div class="row">
                <div class="m-t-30">
                    <div class="right-page-header">
                        <form method="post" id="download_borrower" action="<?php/*=base_url('p2padmin/p2pborrower/downloadBorrowers');*/?>">
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
                        <form method="post" id="download_borrower" action="<?php/*=base_url('p2padmin/p2pborrower/downloadBorrowers_disbursal');*/?>">
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
            </div>-->

            <!--<div class="row">
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
            </div>-->
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                    <table id="demo-foo-addrow" class="table table-striped table-bordered dataTable no-footer" data-page-size="100">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Borrower ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status/Stage</th>
                            <th>Visit Date</th>
                            <th>Last active date</th>
                            <th>view</th>
                        </tr>
                        </thead>

                        <tbody id="borrower_search_list">

                        </tbody>
                        <tbody id="borrower_list">
                        <?php 	if($list){
                            $i=1;
                            foreach($list as $row){
                               $current_step = $this->Borroweraddmodel->get_current_status_credit_line($row['id']);
							   
                                ?>
                                <tr>
                                    <td><?=$i;?></td>
                                    <td><?=$row['borrower_id'];?></td>
                                    <td><?= $row['name'] ;?></td>
                                    <td><?=$row['email'];?></td>
                                    <td><?=$current_step['step'];?></td>

                                    <td><?=$ff = date('d-M-Y', strtotime($row['created_date']));?></td>
                                    <td></td>
                                    <td><a  class="btn btn-primary" href="<?php echo $base_url;?>viewborrower/<?=$row['borrower_id'];?>"> View</a></td>
                                </tr>
                                <?php $i++;}}else
                        {?>
                            <tr>
                                <td colspan="9">No Records Found!</td>
                            </tr>
                        <?php }?>
                        </tbody>
                        <tfoot>
                       
                        </tr>
                        </tfoot>
                    </table>
												 <div class="box-footer clearfix">
			<nav aria-label="Page navigation">
				<ul class="setPaginate pull-right pagination">
					<li><?php echo  $pagination; ?></li>
				</ul>
			</nav> </div>
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
