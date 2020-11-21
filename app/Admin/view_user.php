<?php 

  error_reporting(0);

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Admin");
  //creating user object
  $user=new Admin();

  //fetching main
  //branch manager
  if($_GET['user_type']=='branch_manager'){
      $user_type='Branch Manager';
      $user_result_set=$user->read_one_branch_manager($_GET['id']);
      $user_result=$user_result_set->fetch_assoc();
  }
  //operator
  if($_GET['user_type']=='operator'){
    $user_type='Operator';
    $user_result_set=$user->read_one_operator($_GET['id']);
    $user_result=$user_result_set->fetch_assoc();
  }
  //accountant
  if($_GET['user_type']=='accountant'){
    $user_type='Accountant';
    $user_result_set=$user->read_one_accountant($_GET['id']);
    $user_result=$user_result_set->fetch_assoc();
  }
  //agent
  if($_GET['user_type']=='agent'){
    $user_type='Agent';
    $user_result_set=$user->read_one_agent($_GET['id']);
    $user_result=$user_result_set->fetch_assoc();
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View User</title>

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
                            <a class="nav-link" href="menu_dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Master</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="menu_master_company.php">Company</a>
                                <a class="dropdown-item" href="menu_master_company_code.php">Booking Code</a>
                                <a class="dropdown-item" href="menu_master_policy_period.php">Policy Period</a>
                                <a class="dropdown-item" href="menu_master_policy_type.php">Policy Type</a>
                                <a class="dropdown-item" href="menu_master_product.php">Product</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Manage User</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="menu_manage_user_branch_manager.php">Branch Manager</a>
                                <a class="dropdown-item" href="menu_manage_user_operator.php">Operator</a>
                                <a class="dropdown-item" href="menu_manage_user_accountant.php">Accoutant</a>
                                <a class="dropdown-item" href="menu_manage_user_agent.php">User</a>
                                <a class="dropdown-item" href="menu_manage_user_create_branch.php">Create Branch</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu_policy.php">Policy</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Utilities</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="menu_utilities_comission_recivable.php">Comission Recivable</a>
                                <a class="dropdown-item" href="menu_utilities_comission_payable.php">Comission Payable</a>
                                <a class="dropdown-item" href="menu_utilities_cheque_status.php">Cheque Status</a>
                                <a class="dropdown-item" href="menu_utilities_cash_recived.php">Cash Recived</a>
                                <a class="dropdown-item" href="menu_utilities_cash_paid.php">Cash Paid</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu_office_expenses.php">Office Expenses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu_wallet.php">Wallet</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../logout.php" id="logout-link">Logout</a>
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

                <div class="row">
                    <div class="col-md-6">
                        <h2>View User</h2>
                    </div>
                    <div class="col-md-6">
                        <a href="javascript:history.go(-1)" style="float:right"><Button>Back <i class="fa fa-arrow-right" aria-hidden="true"></i></button></a>
                    </div>
                </div>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#user" class="active">View User</a></li>
                </ul>

                <div class="tab-content">
                    <div id="user" class="tab-pane fade show in active">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                            <h4>User Type</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <img style="width:200px;height:200px" src="<?php if($user_result['photo']!='Null'){echo '../Php/Util/'.$user_type.'/'.$user_result['photo'];}?>" alt="No Profile Picture">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="user_type">User Type</label>
                                    <p><b><?php echo $user_type?></b></p>
                                </div>
                                <?php 
                                
                                    if($_GET['user_type']=='branch_manager'){

                                ?>
                                <!--Col-->
                                <div class="col-md-4" id="branch_column">
                                    <label for="branch">Branch</label>
                                    <p><b><?php echo $user_result['branch'];?></b></p>
                                </div>
                                <?php 
                                
                                    }
                                
                                ?>
                            </div>

                            <hr>
                            <h4>Personal Details</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="name">Name</label>
                                    <p><b><?php echo $user_result['name'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="mobile">Mobile Number</label>
                                    <p><b><?php echo $user_result['mobile'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="email">Email</label>
                                    <p><b><?php echo $user_result['email'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="address">Address</label>
                                    <p><b><?php echo $user_result['address'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="aadhar_card_number">Aadhar Card Number</label>
                                    <p><b><?php echo $user_result['aadhar_card_number'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="pan_card_number">Pan Card Number</label>
                                    <p><b><?php echo $user_result['pan_card_number'];?></b></p>
                                </div>
                            </div>

                            <hr>
                            <h4>Bank Details</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="bank_name">Bank Name</label>
                                    <p><b><?php echo $user_result['bank_name'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="bank_branch">Branch</label>
                                    <p><b><?php echo $user_result['bank_branch'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="ifsc_code">IFSC Code</label>
                                    <p><b><?php echo $user_result['ifsc_code'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="micr_number">MICR Number</label>
                                    <p><b><?php echo $user_result['micr_number'];?></b></p>
                                </div>
                            </div>

                            <hr>
                            <h4>Wallet Details</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="phonepe_number">PhonePe Number</label>
                                    <p><b><?php echo $user_result['phonepe_number'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="paytm_number">Paytm Number</label>
                                    <p><b><?php echo $user_result['paytm_number'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="google_pay_number">Google Pay Number</label>
                                    <p><b><?php echo $user_result['google_pay_number'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="upi_id">UPI ID</label>
                                    <p><b><?php echo $user_result['upi_id'];?></b></p>
                                </div>
                            </div>

                            <hr>
                            <h4>Attachments</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="address_proof">Attachments</label>
                                    <p><b><a href="view_user_attachments.php?id=<?php echo $user_result['id'].'&user_type='.$_GET['user_type']?>">View Attachments</a></b></p>
                                </div>
                            </div>

                            <input type="submit" value="submit" name="user_form_submit" class="btn btn-primary">
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
  <script src="https://use.fontawesome.com/793bc63e83.js"></script>
  <style>
    .fa{
        font:normal normal normal 20px/1 FontAwesome;
    }
  </style>
  <!--Custom script-->
  <script src="../scripts/policy.js"></script>
</body>
</html>

                        
              