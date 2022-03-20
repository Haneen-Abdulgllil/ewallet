<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?=site_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title><?=$page_title?></title>
</head>
<body>

<nav class="navbar navbar-dark bg-primary shadow-sm">
  <div class="container">
      
    <a class="navbar-brand" href="#">
      <img src="assets/images/wallet.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
      DeTym
    </a>
    <?php
if(isset($_SESSION['Auth'])){ ?>
  <div class="">
  <a class="btn btn-sm btn-dark" href="assets/php/process.php?logout">Logout</a>
  
  </div> 
<?php
}else{
  ?>
<div class="">
        <a class="btn btn-sm btn-dark" href="?login">Login</a>
        &nbsp;&nbsp;
        <a class="btn btn-sm btn-dark" href="?signup">Signup</a>
      </div>
  <?php
}
    ?>
  
  </div>
</nav>
