<?php 
if($this->session->userdata('session_data'))
{
    $udata = $this->session->userdata('session_data');
}
else
{
    redirect(base_url('Surgeadmin/login'));
}
 ?>

<?= getNotificationHtml(); ?>
 


			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<div class="card" style="margin-top: 30px">
					  <div class="card-header text-center">
					   <h2>Add Investment Details</h2>
					  </div>
					  <div class="card-body">
					  <?php if($this->session->flashdata('flashmsg')): ?>
                       <h3><p style="background-color:green;"><?php echo $this->session->flashdata('flashmsg'); ?></p></h3>
                               <?php endif; ?>

					   <form method="post" autocomplete="off" action="<?=base_url('surgeadmin/action_add_investment_from_admin')?>">
					   <div class="mb-3">
						    <label for="scheme" class="form-label">Select Scheme</label>
							<select name="scheme" class="form-control" required>
							 <option value="">Select Scheme</option>
							 <?php foreach($schemes as $val){?>
							   <option value="<?php echo $val['id']?>"><?php echo $val['Scheme_Name']?></option>
							 <?php }?>
							</select>
						   
							<div style="color:red;">
							<?php echo form_error('scheme'); ?>
							</div>
						</div> 
					   	<div class="mb-3">
						    <label for="ant_txn_id" class="form-label">Ant txn. Id</label>
						    <input type="text" placeholder="Ant txn. Id" name="ant_txn_id" class="form-control" id="ant_txn_id" required>
							<div style="color:red;">
							<?php echo form_error('ant_txn_id'); ?>
							</div>
						</div>  
						  <div class="mb-3">
						    <label for="mobile" class="form-label">Mobile</label>
						    <input type="text"  placeholder="Mobile Number" name="mobile" class="form-control" id="mobile" required pattern="[0-9]{10}">
							<div style="color:red;">
							<?php echo form_error('mobile'); ?>
                          </div>
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Amount</label>
						    <input type="text"  placeholder="Amount" name="amount" class="form-control" id="amount" required >
							<div style="color:red;">
							<?php echo form_error('amount'); ?>
							</div>
						  </div>
						  <div class="mb-3">
						    <label for="created_date" class="form-label">Investment Date</label>
						    <input type="date"  placeholder="Investment Date" name="created_date" class="form-control"  required >
							<div style="color:red;">
							<?php echo form_error('created_date'); ?>
							</div>
						  </div><br>
						 <div class="text-center">
						  <button type="submit" class="btn btn-primary">Add Investment</button>
						</div>
						
						</form>
						
					  </div>
					</div>
				</div>
				<div class="col-md-4"></div>
			</div>
		</div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

