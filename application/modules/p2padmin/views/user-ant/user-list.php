<div class="row">
<section class="content-header">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">App User List</li>
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
                <div class="col-md-12">
                    <div class="table-responsive">
                    <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list " data-page-size="100">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Model No</th>
                            <th>Added date</th>
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
									<td><a href="<?=base_url();?>p2padmin/appdetails/view/<?=$row['user_id'];?>" target="_blank"><?=$row['first_name'];?></a></td>
									<td><?=$row['mobile'];?></td>
                                    <td><?=$row['email'];?></td>
                                    <td><?= $row['model_no'] ;?></a></td>
                                    <td><?= $row['date_added']; //date('Y-m-d', strtotime());?></td>
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
