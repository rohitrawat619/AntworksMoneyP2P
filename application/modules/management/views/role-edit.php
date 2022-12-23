<?=getNotificationHtml();?>
<div class="row">
        <div class="col-md-12">
          
          <div class="panel panel-info">
            <div class="panel-wrapper collapse in" aria-expanded="true">
              <div class="panel-body">
             <form action="<?=base_url();?>management/update_role/<? echo $editlist['role_id'];?>" method="post">
              <div class="form-body">
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Role Name</label>
                      <input id="role" class="form-control" value="<?=$editlist['role'];?>" type="text" readonly="readonly">
                  </div>
                </div>
                <!--/row-->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Status</label>
                      <select class="form-control" name="status">
                      <? $active = "";$inactive = "";
					  if($editlist['status']==1)
					  {
						  $active = " selected";
					  }
					  else if($editlist['status']==2)
					  {
						  $inactive = " selected";
					  }?>
                        <option value="1" <?=$active;?>>Active</option>
                        <option value=2 <?=$inactive;?>>Inactive</option>
                      </select>
                      </div>
                  </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                <a href="<?=base_url();?>management/list_roles/"><button type="button" class="btn btn-default">Cancel</button></a>
              </div>
            </form>
              </div>
            </div>
          </div>  
        </div>
      </div>
      
<script>
$(window).load(function() {
	$('li').removeClass('active1');
	$('.user div').removeClass('collapse');
	$('.list-roles').addClass('active1');
});
</script>
