<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    PHP Ecommerce
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Suez+One&display=swap">
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/material-dashboard.min copy.css" rel="stylesheet" />
  <!-- Alertify JS -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

  <style>
    /* --------------- ADD CATEGORY ---------------*/
    .form-control{
        border: 1px solid #6A6A66 !important;
        padding: 8px 10px;
        background-color: #DEEFF5 !important;
        border-radius: 8px;
        margin-bottom: 5px;
    }
    .form-select{
        border: 1px solid #6A6A66 !important;
        padding: 8px 10px;
        background-color: #DEEFF5 !important;
        border-radius: 8px;
        margin-bottom: 5px;
    }
    .addCategSave{
        color: red;
    }
    h4{
      margin-bottom: -20px;
    }
    #side-bar-title{
      color: #013D67;
      font-family: 'Suez One', sans-serif; 
      font-size: 18px;
    }
    
    #side-bar-sub-title{
      color: #6A6A66;
      font-weight: bold;
      font-size: 12px;
      font-family: 'Poppins', sans-serif;
    }
    #side-bar-icon{
      font-size: 22px;
    }
    #side-bar-link-box:hover{
      background-color: #6DB9F0; 
      transition: color 0.3s;
    }
    .offcanvas-body .navbar-nav #side-bar-link-box {
    position: relative;
    text-decoration: none;
    color: #013D67;
    transition: color 0.3s;
    }

    .offcanvas-body .navbar-nav #side-bar-link-box::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: #013D67;
        transition: width 0.3s ease-out;
    }

    .offcanvas-body .navbar-nav #side-bar-link-box:hover {
        background-color: #6DB9F0;
        color: white; /* Optional: Change text color on hover */
    }

    .offcanvas-body .navbar-nav #side-bar-link-box:hover::after {
        width: 100%;
    }

    /* Active link styles (optional) */
    .offcanvas-body .navbar-nav #side-bar-link-box.active {
        color: #013D67;
    }

    .offcanvas-body .navbar-nav #side-bar-link-box.active::after {
        width: 100%;
    }

  </style>
</head>

<body class="g-sidenav-show  bg-gray-200">
    <?php include('sidebar.php');?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">