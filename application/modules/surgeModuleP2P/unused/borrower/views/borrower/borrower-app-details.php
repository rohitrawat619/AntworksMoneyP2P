<div class="row">
<section class="content-header">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>
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
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody id="borrower_search_list">

                        </tbody>
                        <tbody id="borrower_list">
                        <? 	if($contactDetails){
                            $i=1;
                            foreach($contactDetails as $contactDetail){
                                ?>
                                <tr>
                                    <td><?=$i;?></td>
                                    <td><?=$contactDetail['contact_name'];?></td>
                                    <td><?php echo $contactDetail['contact_no']; //echo "******".$newstring = substr($contactDetail['contact_no'], -4); ?></td>
									<td><input type="button" name="call_now" class="btn btn-primary callnow" value="Call Now"></td>
                                </tr>
                                <? $i++;}}else
                        {?>
                            <tr>
                                <td colspan="9">No Records Found!</td>
                            </tr>
                        <? }?>
                        </tbody>
                        <tfoot>
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
<script>
	$(".callnow").click(function (){
		alert("wait call is in processing");
	})
</script>
