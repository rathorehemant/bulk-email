<?php 
session_start();
include 'config/db_config.php';
if(!isset($_SESSION['email'])){
    $_SESSION['error'] = 'You must login for access any page';
    header("Location: ".site_url);
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
$current_page = basename($_SERVER['PHP_SELF']);
$title = '';
if($current_page == 'dashboard.php'){
    $title = 'Dashboard';
}if($current_page == 'send-mail.php'){
    $title = 'Send Email Page';
}
if($current_page == 'smtp-settings.php'){
    $title = 'Send Email Page';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$title?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="assest/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="assest/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assest/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!--  <div class="preloader flex-column justify-content-center align-items-center">-->
  <!--  <img class="animation__wobble" src="assest/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">-->
  <!--</div>-->
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     
    </ul>
  </nav>
  <!-- /.navbar -->
