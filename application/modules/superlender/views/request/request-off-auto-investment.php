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
                            <th>Request Date</th>
                            <th>Lender ID</th>
                            <th>Lender Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="request_list">
                        <? 	if($list){
                            $i=1;
                            foreach($list as $row){
                                ?>
                                <tr>
                                    <td><?=$i;?></td>
                                    <td><?=$row['created_date'];?></td>
                                    <td><?=$row['lender_id'];?></td>
                                    <td><?=$row['name'];?></td>
                                    <td><?=$row['mobile'];?></td>
                                    <td><?=$row['email'];?></td>
                                    <td><? if($row['status'] == 0){?>
                                        <input type="button" class="btn btn-primary" onclick="return requestAction(<?=$row['request_id']?>, <?=$row['user_id']?>, 'Accept')" value="Accept">
                                        <input type="button" class="btn btn-primary" onclick="return requestAction(<?=$row['request_id']?>, <?=$row['user_id']?>, 'Reject')" value="Reject">
									<?php }
									 if($row['status'] == 1){echo "Accepted";} if($row['status'] == 2){echo "Rejected";}  ?>
									</td>

                                </tr>
                                <? $i++;}}else
                        {?>
                            <tr>
                                <td colspan="7">No Records Found!</td>
                            </tr>
                        <? }?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="12">
                                <?php

                                //echo $pagination;

                                ?></td></tr>
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
	function requestAction(request_id, lender_id, action) {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>superlender/actionRequestautoinvest",
			data: {request_id:request_id, lender_id:lender_id, action:action},
			success: function (data) {
				var response = $.parseJSON(data);
				alert(response.message);
			}
		})
	}
</script>
