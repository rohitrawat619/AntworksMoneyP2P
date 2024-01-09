
<!-- Main content -->
<section class="content" >
	<?= getNotificationHtml(); ?>
	<div class="box">

		
		
		<form class="form form-material" id="app_user_data_form"
			  action="<?php echo base_url('surgeModule/surge/'); ?>insert_raise_ticket" method="POST">
			<div class="col-md-12" >
				<h2>Raise Ticket</h2>
			
				<div class="box-body">
					<div class="row">

					
					 

    <div class="col-md-12 form-group">
        <label for="title">Title:</label><br>
        <input  class="form-control" required type="text" id="title" name="title" placeholder="Enter Title">
		  <?php echo form_error('title', '<div class="alert alert-danger">', '</div>'); ?>

		<br>
    </div>

    <div class="col-md-12 form-group">
        <label for="description">Description:</label><br>
        <textarea  class="form-control" required type="text" id="description" name="description" placeholder="Enter Description"></textarea><br>
     <?php echo form_error('description', '<div class="alert alert-danger">', '</div>'); ?>
	</div>

   

    <div class="col-md-4 form-group">
       <label class="form-label" for="priority">Priority:</label>
    <select class="form-control"  id="priority" name="priority">
        <option value="Low">Low</option>
        <option value="Medium" selected>Medium</option>
        <option value="High">High</option>
    </select>
	 <?php echo form_error('priority', '<div class="alert alert-danger">', '</div>'); ?>
    </div>



					</div>
				</div>
				<div class="row">
					<div class="box-footer text-right">
					<input  class="form-control"type="hidden" name="status" value="Open" >
						<input  class="form-control"type="hidden" class="csrf-security"
							   name="<?php echo $this->security->get_csrf_token_name(); ?>"
							   value="<?php echo $this->security->get_csrf_hash(); ?>">
					
						<input  class="form-control"class="form-control" type="hidden" name="id" >
						<input   type="submit" name="submit" id="aaaa" value="Submit Ticket" class="btn btn-primary"/>
					</div>
				</div>

			</div>
		</form>
	</div>


	<div class="box-footer clearfix"></div>
	<div class="clearfix"></div>
	
</section>



