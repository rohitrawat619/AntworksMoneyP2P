Welcome to Dashboard
<?php 
if($this->session->userdata('venloginsession'))
{
    $udata = $this->session->userdata('venloginsession');
    echo 'Welcome'.' '.$udata['fullname'];
}
else
{
    redirect(base_url('welcome/login'));
}
 ?>
