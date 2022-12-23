<div class="row">
<section class="content-header">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Offers List</li>
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
                            <th>Offer Name</th>
                            <th>Category Name</th>
                            <th>Offer Type</th>

                            <th>Coupon Code Type</th>
                            <th>Offer Priority</th>
                            <th>Display Banner</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                        <tbody id="borrower_search_list">

                        </tbody>
                        <tbody id="borrower_list">
                        <? 	if($lists){
                            $i=1;
                            foreach($lists as $list){
                                ?>
                                <tr>
                                    <td><?=$i;?></td>
                                    <td><a href="<?= base_url('offers/editoffer/').$list['id'];?>" target="_blank"><?= $list['offer_name'] ?></a></td>
                                    <td><?= $list['category_name'] ?></td>
                                    <td><?= $list['offer_type'] ?></td>
                                    <td><?= $list['coupon_code_type'] ?></td>
                                    <td><?= $list['offer_priority'] ?></td>
                                    <td><?= $list['display_banner'] ?></td>
                                    <td><?= $list['status'] ?></td>
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

                                echo @$pagination;

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
