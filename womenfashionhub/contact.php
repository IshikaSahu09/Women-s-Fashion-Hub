<?php include('./common/header.php'); ?>

<?php

if (isset($_POST['contact_form'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $message = $_POST['message'];


    $sql = "INSERT INTO contact(name,email, contact, message, created_at) VALUES(:name, :email, :mobile, :message, now())";
    $query = $db->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $db->lastInsertId();
 
    if ($lastInsertId) {
      $msg = '<div id="msg" class="alert alert-success"><strong>Contact Submitted</strong></div>';
    } else {
      $msg = '<div id="msg" class="alert alert-danger"><strong>Unable To Add</strong></div>';
    }
    // echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
} else {
}
?>
            <!-- contact head -->
            <div class="bg-contact">
                <div class="row">
                    <h4 class="cart_content display-4 text-light">
                        Contact Us
                    </h4>
                </div>
            </div>
                <!-- contact to -->
    <div class="container text-center my-5 py-5">
        <div class="row">
            <div class="col-md-4 border p-3 mr-1">
                <h5><i class="fas fa-map-marker-alt"></i></h5>
                <p class="ps-4 "><a href="https://maps.google.com/?q=123 Main Street, City, Country" target="_blank" class="text-dark text-decoration-none">Jabalpur, Madhya Pradesh </a></p>
            </div>
            <div class="col-md-4 border p-3 mr-1">
                <h5><i class="far fa-envelope"></i></h5>
                <p><a href="mailto:mahimajohn2605@gmail.com" class="text-dark text-decoration-none">mahimajohn2605@gmail.com</a></p>
            </div>
            <div class="col-md-4 border p-3  ">
                <h5><i class="fas fa-phone"></i></h5>
                <p><a href="tel:+91-7828392489" class="text-dark text-decoration-none">+91-7828392489</a></p>
            </div>
        </div>
    </div>
      <!-- contact form -->
      <div class="container-fluid p-5 my-5 py-5">
          <div class="row ">
              <div class="col-md-6 text-center">
                  <img src="https://iotnews.com/wp-content/uploads/2020/02/iot-contact_us.jpg" alt="aboutsection" width="700" class="img-fluid mb-3" />
                  <h3>"Got questions? We're here to help!</h3>
              </div>
              <div class="col-md-6">
                  <h4 class="pb-1">Get in Touch!</h4>
                  <p>Reach out to us and start the conversation</p>
                  <form class="row g-3 pt-2" method="post">
                      <div class="col-md-12">
                          <input type="name" name="name" class="form-control" id="inputEmail4" placeholder="enter your name">
                      </div>
                      <div class="col-md-12">
                          <input type="email" name="email" class="form-control" id="inputPassword4"
                              placeholder="enter your email">
                      </div>
                      <div class="col-12">
                          <input type="number" name="mobile" class="form-control" id="inputphone" placeholder="enter your phone">
                      </div>
                      <div class="col-md-12">
                          <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="4"></textarea>
                      </div>
                      <div class="col-md-12 pt-4">
                          <button type="submit" name="contact_form" class="btn btn-primary  border-0"> Send Message </button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
      <!-- map -->
      <div class="container-fluid ">
          <div class="row">
              <div class="col-md-12">
                  <iframe
                      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d113370.70389770872!2d79.89059597347035!3d23.17850309915857!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3981ae1a0fb6a97d%3A0x44020616bc43e3b9!2sJabalpur%2C%20Madhya%20Pradesh!5e0!3m2!1sen!2sin!4v1711531146829!5m2!1sen!2sin"
                      width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                      referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
          </div>
      </div>
          <!-- footer -->
          <?php include('./common/footer.php');?>
    </body>
    </html>