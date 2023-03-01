<div class="container">
      <!-- <h1><?php echo $data['title']?></h1> -->
	  <div>
		<!-- <p class="lead"><?php echo $data['data']?></p> -->
	  </div>
	  <form action="<?php echo base_url('investweb/login_users'); ?>" method="post">
		<table>
		<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
			<tr><td>Email</td><td><input type="email" name="Email"/></td></tr>
			<tr><td>Password</td><td><input type="password" name="Passowrd"/></td></tr>
			<tr><td></td><td><input type="submit" name="submit"/></td></tr>
		</table>
	  </form>
	  
	  		<?php
			
				// if($this->input->post('submit') != NULL )
				// echo 'Loading';

			?>
    </div>
    