<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Dashboard</title>
  </head>
  <body>

  	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <div class="container-fluid">
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <a class="navbar-brand" href="#"><?php 
if($this->session->userdata('venloginsession'))
{
 $udata = $this->session->userdata('venloginsession');
    echo 'Welcome'.' '.$udata['fullname']; }
else { redirect(base_url('welcome/login')); }
 ?>
<?php 
// echo "<pre>"; 
//  print_r($udata);
?> 
</a>

<!-- Array ( [fullname] => Startest [email] => Star@test.com [RID] => 1 [VID] => 3 )  -->
		    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link active" aria-current="page" href="<?=base_url('welcome/vendordashboard')?>">Home</a>
		        </li>
				<li class="nav-item">
		          <a class="nav-link" href="<?=base_url('welcome/Invest_Schemesven?VID='.$udata['VID'])?>">Your All Schemes</a>
		        </li>
                <li class="nav-item">
		          <a class="nav-link" href="<?php echo base_url('welcome/Investmentsven?VID='.$udata['VID'])?>">All Investents Under you</a>
		        </li>
                <li class="nav-item">
		          <a class="nav-link" href="<?=base_url('welcome/logout')?>">Logout</a>
		        </li>
		      </ul>
		      <form class="d-flex">
		        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
		        <button class="btn btn-outline-success" type="submit">Search</button>
		      </form>
		    </div>
		  </div>
		</nav>