<?php

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Admin");
  //creating user object
  $user=new Admin();
  //fetching the values
  $result_set=$user->read_one_accountant($_GET['id']);
  $result=$result_set->fetch_assoc();
  //form handelling
  if(isset($_POST['submit'])){
      $name_array=Accountant_Contract::get_table_columns();
      array_shift($name_array);
      $user->update_accountant($name_array,$_GET['id']); 
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>

  <!-- CSS -->
  <!--Bootstrap-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  
  <!--Fonts-->
  <!--Roboto-->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;900&display=swap" rel="stylesheet">
  <!--Open Sans-->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
  <!--Montserrat-->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400&display=swap" rel="stylesheet">

  <!--Custom style sheet-->
  <link rel="stylesheet" href="../styles/main.css">
  <link rel="stylesheet" href="../styles/policy.css">
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-dark justify-content-between">
                <a class="navbar-brand">ROYAL BROKERS</a>
                <div id="account">
                    <p><?php echo $_SESSION['name']?></p>
                    <div id="account-menu">
                        <img src="../images/sign_in_side.jpg" alt="">
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <section id="navbar">
        <div class="container"> 
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="master.php"><span class="fas fa-plus"></span>Master</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_user.php">Manage User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="policy.php">Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="utility.php">Utility</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="comission.php">Comission</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="wallet.php">Wallet</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cash.php">Cash</a>
                        </li>
                    </ul>
                </div>
          </nav>
        </div>
    </section>
    <section id="main-container">
      <div class="container">
        <div class="form-container">
          <div class="row">
            <div class="col-md-12"> 

                <h2>Edit Accountant</h2>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#operator" class="active">Accountant</a></li>
                </ul>

                <div class="tab-content">
                    <div id="operator" class="tab-pane fade show in active">
                        <h4>Edit Accountant</h4>
                        <form action="<?php echo $_SERVER['PHP_SELF'].'?id='.$_GET['id']; ?>" method="POST">
                        <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="name">Name</label>
                                    <input type="text" value="<?php echo $result['name']; ?>" class="form-control" id="name" name="name" placeholder="Name" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="mobile">Mobile Number</label>
                                    <input type="number" value="<?php echo $result['mobile']; ?>" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="email">Email</label>
                                    <input type="email" value="<?php echo $result['email']; ?>" class="form-control" id="email" name="email" placeholder="Email" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="pan">Pan</label>
                                    <input type="text" value="<?php echo $result['pan']; ?>" class="form-control" id="pan" name="pan" placeholder="Pan" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="address">Address</label>
                                    <input type="text" value="<?php echo $result['address']; ?>" class="form-control" id="address" name="address" placeholder="Address" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="aadhar">Aadhar Number</label>
                                    <input type="text" value="<?php echo $result['aadhar']; ?>" class="form-control" id="aadhar" name="aadhar" placeholder="Aadhar" required="required">
                                </div>
                            </div>
                            <input type="submit" value="Update" name="submit" class="btn btn-primary">
                        </form>
                    </div>
                </div>
  
          </div>
        </div>
      </div>
    </section>
    <footer>

    
    </footer>

  <!-- jQuery and JS bundle w/ Popper.js -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <!--Font awesome-->
  <script src="https://use.fontawesome.com/793bc63e83.js"></script><style>.fa{font:normal normal normal 20px/1 FontAwesome;}</style>
</body>
</html>