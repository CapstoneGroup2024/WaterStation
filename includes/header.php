
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <!--------------- BOOTSTRAP CSS --------------->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!--------------- CSS FILES --------------->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css">

<!-- Include Alertify CSS file -->
<link rel="stylesheet" href="path/to/alertify.css">

<!-- Include Font Awesome for icon styling -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<style>
    /* Custom CSS to change the background color, border radius, and text color of the modal */
    .ajs-modal {
        border-radius: 20px;
        font-family: 'Poppins', sans-serif; /* Adjust the border radius as needed */
    }
    .ajs-content {
        color: black; /* Change the text color of the content as needed */
        font-family: 'Poppins', sans-serif;
    }
  .ajs-message.ajs-success {
    border-radius: 8px; /* Adjust border radius as needed */
    font-family: 'Poppins', sans-serif;
    font-size: 18px;
  }

  /* Define custom styles for the checkmark icon */
  .animated-check {
    animation: rotate-scale-up 0.5s ease forwards;
  }

  @keyframes rotate-scale-up {
    0% {
      transform: scale(0) rotate(0deg);
    }
    50% {
      transform: scale(1.5) rotate(180deg);
    }
    100% {
      transform: scale(1) rotate(360deg);
    }
  }
</style>
  </head>
  <body>
  