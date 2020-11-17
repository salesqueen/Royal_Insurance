<?php 

  include 'Php/Util/authenticator.php';

  if(isset($_POST['submit'])){
    $authenticator=new Authenticator();
    $authenticator->authenticate(); 
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In Form</title>

  <!-- CSS -->
  <!--Bootstrap-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <!--Google fonts-->
  <!--Roboto-->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;900&display=swap" rel="stylesheet">
  <!--Open Sans-->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
  <!--Montserrat-->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400&display=swap" rel="stylesheet">

  <!--Custom style sheet-->
  <link rel="stylesheet" href="styles/main.css">
  <link rel="stylesheet" href="styles/sign_in.css">
</head>
<body>
  <section id="sign_in_container">
      <div class="row">
        <div class="col-md-4" id="sign_in_form">
          <div class="brand">
            <img src="images/logo-crop.png" alt="Rayal Brokers India Pvt Ltd">
          </div>
          <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
            <h2>Welcome Back! </h2>
            <h5>Login to access account</h5>
            <label for="id">User ID</label>
            <input type="text" class="form-control" id="id" name="id" placeholder="User ID" required="required">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="required">
            <input type="submit" value="Log in" name="submit" class="btn btn-primary">
          </form>
        </div>
        <div class="col-md-8" id="sign_in_side">
            <h2>Welcome Back! </h2>
            <h5>Login to access account</h5>
        </div>
    </div>
  </section>

  <!-- jQuery and JS bundle w/ Popper.js -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
