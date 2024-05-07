<!--------------- INCLUDES --------------->
<?php 
  include('includes/header.php');
  include('includes/navbar.php');
?>
<!--------------- CSS --------------->
<link rel="stylesheet" href="assets/css/homepage.css">   
<!--------------- HOME PAGE --------------->
<section class="home bg-Primary  p-5 p-lg-0 pt-lg-5 text-center text-sm-start" id="Home">
    <div class="quote">
        <div class="d-sm-flex align-items-center justify-content-between">
          <div>
            <h1 class="aquaflow" style="margin-top: -40px;">AquaFlow </h1>
            <div class="water_drop" style="margin-left: 40px; margin-top: 40px;">
                <h2 class="order"><a href="order.php" class="btn text-black" id="ordernow_btn">Order Now</a></h2>
            </div>
          </div>
          <img class="img-fluid d-none d-sm-block" src="assets/images/pic.png" alt="Homepage Image"/>
        </div>
    </div>
</section>
<!--------------- SERVICES --------------->
<section class="Services pt-lg-5 text-center text-sm-start" id="Services">
    <div class="ser">
        <div class="row">
            <div class="contact-left">
                <h1 class="services">Services</h1>
            <div class="row row-cols-1 row-cols-md-3 g-5">
                <div class="col h-100" id="img">
                    <div class="card h-100">
                        <img src="assets/images/Quality.webp" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Quality</h5>
                                <p class="card-text">Improved ordering experience with
                                    required supplier certification checks
                                    that provide you with high-quality 
                                    water that complies with government
                                    regulations..</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100" id="imgs">
                            <img src="assets/images/paymenttt.png" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Payment</h5>
                                    <p class="card-text">There's no need to worry about COD or 
                                    waiting for deliveries anymore. Through 
                                    the app, GCash, Maya, and Grab the three 
                                    most popular online payment methods are accepted.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100" id="imgss">
                            <img src="assets/images/Hassle free.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Hassle free</h5>
                                <p class="card-text">This is a wider card with supporting text below as 
                                    a natural lead-in to additional content. This card has even longer content 
                                    than the first to show that equal height action.</p>
                        </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</section>
<!--------------- ABOUT US --------------->
<section class="pt-lg-3" id="AboutUs">
    <div class="wrapper">
        <header>
            <h1 class="About">About Us</h1>
        </header>
        <div class="columns">
            <div class="column" id="column1">
                <h2>Aquaflow:</h2>
                <p >Welcome to AquaFlow  Water Delivery, your trusted source for premium quality water delivered straight to your doorstep. At PureFlow, we understand the importance of clean and refreshing water in your daily life, which is why we are dedicated to providing you with the highest quality water delivery service.</p>
            </div>
            <div class="column" id="column2">
                <h2>Our Mission:</h2>
                <p>At PureFlow, our mission is simple: to deliver pure, clean, and refreshing water to our customers with convenience and reliability. We aim to exceed customer expectations by providing exceptional service, superior quality water, and sustainable solutions.</p>
            </div>
            <div class="column" id="column3">
                <h2>Our Commitment to Quality:</h2>
                <p>Quality is at the heart of everything we do. Our water undergoes rigorous filtration and purification processes to ensure it meets the highest industry standards. We are committed to delivering water that is not only safe to drink but also tastes great, providing you with the refreshing hydration you deserve.</p>
            </div>
        </div>
    </div>
</section>
<!--------------- CONTACT --------------->
<section class="contacts p-5 p-lg-0 pt-lg-5 text-center text-sm-start"  id="contacts">
    <footer class="p-5">
      <div class="first-container" >
        <div class="d-sm-flex align-items-center justify-content-between" id="contact-container-box">
          <div class="row">
            <span class="contact-title d-flex justify-content-center">CONTACT</span>
              <div class="col-md-3 col-lg-6 text-left pl-lg-5" id="contact-items-container">
                <h4 class="contact-text" id="contact-header">Drop Me a Message</h4>
                <p class="contact-text lead my-4" id="paragraph-text">
                  Message us for more inquiries. Contact us below! We are happy to help and respond to your concern.
                </p>
                <ul class="contact-ul">
                  <li>
                    <a href="tel: 09814377193" target="_blank" class="contact-link">
                    <div class="svg-container">
                      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                      </svg>
                    </div>
                    </a>
                    <p class="contact-text" id="contact-info-text">++639 814377193</p>
                  </li>
                  <li>
                    <a href="..." target="_blank" class="contact-link">
                    <div class="svg-container">
                      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                      </svg>
                    </div>
                    </a>
                    <p class="contact-text" id="contact-info-text">AquaflowStation@gmail.com</p>
                  </li>
                  <li>
                    <a href="..." target="_blank" class="contact-link">
                    <div class="svg-container">
                      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                      </svg>
                    </div>
                    </a>
                    <p class="contact-text" id="contact-info-text">Aquaflow Water Station</p>
                  </li>
                </ul>
            </div>
                <div class="form-container">
                  <form>
                    <div class="input-box">
                      <input type="text" placeholder="Name" id="username" name="username" required>
                    </div>
                    <div class="input-box">
                      <input type="email" placeholder="Email" id="email" name="useremail" required>
                    </div>
                    <div class="input-box">
                      <input type="text" placeholder="Subject" id="subject" name="usersubject" required>
                    </div>
                    <div class="input-box">
                      <textarea placeholder="Message" id="message" name="usermessage" required></textarea>
                    </div>
                      <input type="submit" value="Send" id="loginbtn">
                  </form>
                </div>
              </div>
          </div>
      </div>
      <hr>
      <div class="d-flex justify-content-between align-items-center" id="footer-container">
            <div class="footer-logo">
                <p>Aquaflow</p>
            </div>
            <div class="icon-container">
                <div class="footer-svg-container">
                    <a href="..." target="_blank" class="footer-svg-container">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                        </svg>
                    </a>
                </div>
                <div class="footer-svg-container">
                    <a href="..." target="_blank" class="footer-svg-container">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                        <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
                        </svg>
                    </a>
                </div>
                <div class="footer-svg-container">
                    <a href="..." target="_blank" class="footer-svg-container">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-tiktok" viewBox="0 0 16 16">
                        <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</section>
<!--------------- COPYRIGHT --------------->
<div class="copyright">
      <p>Copyright ©Aquaflow by <i class="fa-solid fa-dragon"></i> Aquaflow Water Station</p>
</div>
<!--------------- BOOTSTRAP JS --------------->
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/passwordCheck.js"></script>
<!--------------- ALERTIFY JS --------------->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
<?php
  if(isset($_SESSION['message'])){ // CHECK IF SESSION MESSAGE VARIABLE IS SET
?>
    alertify.set('notifier','position', 'top-center');
    var notification = alertify.success('<i class="fas fa-check animated-check"></i> <?= $_SESSION['message']?>'); // DISPLAY MESSAGE NOTIF with animated check icon
    notification.getElementsByClassName('animated-check')[0].addEventListener('animationend', function() {
    this.classList.remove('animated-check');
  }); // Remove animation class after animation ends
<?php
    unset($_SESSION['message']); // UNSET THE SESSION MESSAGE VARIABLE
  }
?>
</script>
<!--------------- FOOTER --------------->
<?php include('includes/footer.php');?>