<?=getNotificationHtml();?>
<div class="row">
  <div class="col-md-4 col-xs-12">
    <div class="white-box">
      <div class="user-btm-box"> 
        <!-- .row -->
        <div class="row text-center m-t-10">
          <div class="col-md-6 b-r"><strong>Name</strong>
            <p><?=$lender['lender_id'];?></p>
          </div>
            <div class="col-md-6 b-r"><strong>Name</strong>
            <p><?=$lender['name'];?></p>
          </div>
        </div>
        <!-- /.row -->
        <hr>
        <!-- .row -->
        <div class="row text-center m-t-10">
          <div class="col-md-6 b-r"><strong>Email ID</strong>
            <p><?=$lender['email'];?></p>
          </div>
          <div class="col-md-6"><strong>Phone</strong>
            <p><?=$lender['mobile'];?></p>
          </div>
        </div>
        <!-- /.row -->
        <hr>
        <!-- .row -->
        <div class="row text-center m-t-10">
          <div class="col-md-12"><strong>Address</strong>
            <p><?=$lender['address'];?><br/>
              <?=$lender['city'];?>, India.</p>
          </div>
        </div>
        <hr>
      </div>
    </div>
  </div>
  <div class="col-md-8 col-xs-12">
    <div class="white-box"> 
      <!-- .tabs -->
      <ul class="nav nav-tabs tabs customtab">
       <li class="active tab"><a href="#profile" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">Profile</span> </a> </li>
      </ul>
      <!-- /.tabs -->
      <div class="tab-content"> 
        <!-- .tabs2 -->
        <div class="tab-pane active" id="profile">
          <div class="row">
            <div class="col-md-3 col-xs-6 b-r"> <strong>Full Name</strong> <br>
              <p class="text-muted"><?=$lender['name'];;?></p>
            </div>
            <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong> <br>
              <p class="text-muted"><?=$lender['mobile'];?></p>
            </div>
            <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong> <br>
              <p class="text-muted"><?=$lender['email'];?></p>
            </div>
            <div class="col-md-3 col-xs-6"> <strong>Location</strong> <br>
              <p class="text-muted"><?=$lender['city'];?></p>
            </div>
          </div> 
        
        </div>
        <!-- /.tabs2 --> 
        <!-- .tabs3 -->

        <!-- /.tabs3 --> 
      </div>
    </div>
  </div>
</div>

<script>
$(window).load(function() {
	$('li').removeClass('active1');
	$('.user div').removeClass('collapse');
	$('.list-users').addClass('active1');
});
</script>