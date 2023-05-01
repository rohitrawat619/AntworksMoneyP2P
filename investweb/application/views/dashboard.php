Welcome to Dashboard
<?php 
if($this->session->userdata('UserLoginSession'))
{
    $udata = $this->session->userdata('UserLoginSession');
    echo 'Welcome'.' '.$udata['fullname'];
}
else
{
    redirect(base_url('welcome/login'));
}
 ?>
