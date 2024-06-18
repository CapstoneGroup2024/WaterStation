  </main>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/smooth-scrollbar.min.js"></script>
    <!-- Alertify JS -->
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

  <script>
  <?php
    if(isset($_SESSION['message'])){ // CHECK IF SESSION MESSAGE VARIABLE IS SET
  ?>
  alertify.set('notifier','position', 'top-right');
  alertify.success('<?= $_SESSION['message']?>'); // DISPLAY MESSAGE NOTIF
  <?php
    unset($_SESSION['message']); // UNSET THE SESSION MESSAGE VARIABLE
  }
  ?>
  </script>

  </body>
</html>
<?php
ob_end_flush(); // Flush the output buffer and turn off output buffering
?>