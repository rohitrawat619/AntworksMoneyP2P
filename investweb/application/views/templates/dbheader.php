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
if($this->session->userdata('UserLoginSession'))
{
 $udata = $this->session->userdata('UserLoginSession');
    echo 'Welcome'.' '.$udata['fullname']; }
else { redirect(base_url('welcome/login')); }

 ?></a>
		    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link active" aria-current="page" href="<?=base_url('welcome/dashboard')?>">Home</a>
		        </li>
				<li class="nav-item">
		          <a class="nav-link" href="<?=base_url('welcome/Invest_Schemes?vid='.$udata['vid'])?>">Invest Here</a>
		        </li>
                <li class="nav-item">
		          <a class="nav-link" href="<?php echo base_url('welcome/Investments?&UID='.$udata['uid'].'&VID='.$udata['vid'])?>">Your Investments</a>
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