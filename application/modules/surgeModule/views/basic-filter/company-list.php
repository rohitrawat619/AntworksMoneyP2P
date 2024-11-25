<div class="row">
<section class="content-header">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Company List</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <?=getNotificationHtml();?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="<?=base_url('/surgeModule/borrower/export_company_list')?>"><button class="btn btn-primary">Export Company List</button></a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                    <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list " data-page-size="100">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Company Name</th>
                            <th>Company category</th>
                        </tr>
                        </thead>

                        <tbody id="">

                        </tbody>
                        <tbody id="">
                        <? 	if($company_list){
                            $i=1;
                            foreach($company_list as $list){
                                ?>
                                <tr>
                                    <td><?=$i;?></td>
                                    <td><?=$list['company_name'];?></td>
                                    <td><?=$list['company_category']?></td>
                                </tr>
                                <? $i++;}}else
                        {?>
                            <tr>
                                <td colspan="3">No Records Found!</td>
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
