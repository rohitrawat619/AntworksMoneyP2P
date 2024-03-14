
<!-- Main content -->
<section class="content" >
	<?= getNotificationHtml();
		
	?>
	<div class="box">

		
		
		<form class="form form-material" id="app_user_data_form"
			  action="../surge/comment_ticket" method="POST">
			<div class="col-md-12" >
				<h2>Ticket ID: #<?php echo $lists['ticket_id']; ?></h2>
			
				<div class="box-body">
					<div class="row">

					
					 

    <div class="col-md-4 form-group">
        <label for="title">Title:</label><br>
        <div><?php echo $lists['title']; ?></div>
		<hr>
    </div>
	 <div class="col-md-4 form-group">
        <label>Priority:</label><br>
        <div ><?php echo $lists['priority']; ?></div><hr>
    
	</div>


		 <div class="col-md-4 form-group">
        <label for="title">Status:</label><br>
        <div><?php echo $lists['status']; ?></div>
		<hr>
    </div>
		
    <div class="col-md-12 form-group">
        <label>Description:</label><br>
        <div ><?php echo $lists['description']; ?></div>
    
	</div>

   <?php 
					
   if ($lists['comments_list']) {
    $i = 1;
	//	print_r($lists);
    foreach($lists['comments_list'] as $list) {
		echo ".";
	 ?> 
						 <div style="float:<?php echo $list['msg_type']; ?>; "><b><?php echo ($list['msg_type']=="left"? "Other": "You")?></b></div>
				   <div class="message-container_ticket">
				<div class="message_ticket <?php echo $list['msg_type']; ?>-message_ticket"><?php echo$list['comment_text']; ?></div>

			</div>

	   <?php
	
   }		}{
	   
	  
   }
   ?>

		



					</div>
				</div>
						<?php if($lists['status']!="Closed"){ ?>
				<div class="row">
				
					
<div class="col-md-12 form-group">
        <label for="description">Status:</label><br>
        <select  class="form-control"  name="status" required type="text" >
				<option value="Open">Open</option>
				<option value="Closed">Close</option>
		</select><br>
    
	</div>

    <div class="col-md-12 form-group">
        <label for="description">Comment:</label><br>
        <textarea  class="form-control" value="<?php echo ""; ?>" name="comment_text" required type="text" ></textarea><br>
    
	</div>
					<div class="box-footer text-right">
					
					<input name="ticket_id" value="<?php echo $lists['ticket_id']; ?>"  type="hidden"  >
						<input  class="form-control"type="hidden" class="csrf-security"
							   name="<?php echo $this->security->get_csrf_token_name(); ?>"
							   value="<?php echo $this->security->get_csrf_hash(); ?>">
					
						<input  class="form-control"class="form-control" type="hidden" name="id" >
						<input   type="submit" name="submit" id="aaaa" value="Reply" class="btn btn-primary"/>
					</div>
				</div>
							<?php }else{
								echo '<span    class="btn btn-danger"/>'.$lists['status'].'</span>';
							} ?>

			</div>
		</form>
	</div>


	<div class="box-footer clearfix"></div>
	<div class="clearfix"></div>
	
</section>



