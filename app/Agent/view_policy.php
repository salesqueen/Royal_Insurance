<?php 

  error_reporting(0);

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Agent");
  //creating user object
  $user=new Agent();

  //fetching main
  $policy_result_set=$user->read_one_policy($_GET['id']);
  $policy_result=$policy_result_set->fetch_assoc();

  //fetch sub
  function get_cheque_id($policy_id){
      $cheque_result_set=$GLOBALS['user']->read_selective_cheque('WHERE policy_id='.$policy_id);
      return $cheque_result_set->fetch_assoc()['id'];
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Policy</title>

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
                        <a href="edit_profile.php"><img src="<?php if(strcasecmp($_SESSION['photo'],'Null')!=0){
                            //agent
                            if(strcasecmp($_SESSION['user_type'],'Agent')==0){
                                echo "../agent/".$_SESSION['photo'];
                            }
                            //branch manager
                            if(strcasecmp($_SESSION['branch_manager'],'Branch_Manager')==0){
                                echo "../branch_manager/".$_SESSION['photo'];
                            }
                            //opertor
                            if(strcasecmp($_SESSION['user_type'],'Operator')==0){
                                echo "../operator/".$_SESSION['photo'];
                            }
                            //accountant
                            if(strcasecmp($_SESSION['user_type'],'Accountant')==0){
                                echo "../accountant/".$_SESSION['photo'];
                            }
                            //admin
                            if(strcasecmp($_SESSION['user_type'],'Admin')==0){
                                echo "../admin/".$_SESSION['photo'];
                            }
                        }
                        else{
                            echo "../images/sign_in_side.jpg";
                        }?>" alt=""></a>
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
                        <li class="nav-item">
                            <a class="nav-link" href="menu_policy.php">Policy</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Utilities</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="menu_utilities_comission_payable.php">Comission</a>
                                <a class="dropdown-item" href="menu_utilities_cheque_status.php">Cheque Status</a>
                                <a class="dropdown-item" href="menu_utilities_cash_recived.php">Cash Recived</a>
                                <a class="dropdown-item" href="menu_utilities_cash_paid.php">Cash Paid</a>
                                <a class="dropdown-item" href="menu_utilities_office_expenses.php">Office Expenses</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu_wallet.php">Wallet</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../reset_password.php" id="logout-link">Reset Password</a>
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
                        <h2>View Policy</h2>
                    </div>
                    <div class="col-md-6">
                        <a href="javascript:history.go(-1)" style="float:right"><Button>Back <i class="fa fa-arrow-right" aria-hidden="true"></i></button></a>
                    </div>
                </div>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#policy" class="active">View Policy</a></li>
                </ul>

                <div class="tab-content">
                    <div id="policy" class="tab-pane fade in show active">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                            <h4>Policy Details</h4>
                            <hr>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="issue_date">Issue Date</label>
                                    <p><b><?php echo $policy_result['issue_date'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="company_name">Company Name</label>
                                    <p><b><?php echo $policy_result['company_name'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="policy_type">Policy Type</label>
                                    <p><b><?php echo $policy_result['policy_type'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="product">Product</label>
                                    <p><b><?php echo $policy_result['product'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="policy_number">Policy Number</label>
                                    <p><b><?php echo $policy_result['policy_number'];?></b></p>
                                </div>
                            </div>

                            <h4>Customer Details</h4>
                            <hr>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="customer_name">Customer Name</label>
                                    <p><b><?php echo $policy_result['customer_name'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="mobile">Mobile</label>
                                    <p><b><?php echo $policy_result['mobile'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="email">Email</label>
                                    <p><b><?php echo $policy_result['email'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="registration_number">Registration Number</label>
                                    <p><b><?php echo $policy_result['registration_number'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="make_model">Make Model</label>
                                    <p><b><?php echo $policy_result['make_model'];?></b></p>
                                </div>
                            </div>

                            <h4>Vehicle Details</h4>
                            <hr>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="cc">CC</label>
                                    <p><b><?php echo $policy_result['cc'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="seating_capacity">Seating Capacity</label>
                                    <p><b><?php echo $policy_result['seating_capacity'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="gbw">GVW</label>
                                    <p><b><?php echo $policy_result['gbw'];?></b></p>
                                </div>
                            </div>

                            <h4>OD Policy Date</h4>
                            <hr>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="od_policy_start_date">OD Policy Start Date</label>
                                    <p><b><?php echo $policy_result['od_policy_start_date'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="od_policy_period">OD Policy Period</label>
                                    <p><b><?php echo $policy_result['od_policy_period'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="od_policy_end_date">OD Policy End Date</label>
                                    <p><b><?php echo $policy_result['od_policy_end_date'];?></b></p>
                                </div>
                            </div>

                            <h4>TP Policy Date</h4>
                            <hr>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="tp_policy_start_date">TP Policy Start Date</label>
                                    <p><b><?php echo $policy_result['tp_policy_start_date'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="tp_policy_period">TP Policy Period</label>
                                    <p><b><?php echo $policy_result['tp_policy_period'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="tp_policy_end_date">TP Policy End Date</label>
                                    <p><b><?php echo $policy_result['tp_policy_end_date'];?></b></p>
                                </div>
                            </div>

                            <h4>Premium</h4>
                            <hr>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="od_disc">OD Disc</label> 
                                    <p><b><?php echo $policy_result['od_disc'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="od_premium">OD Premium</label>
                                    <p><b><?php echo $policy_result['od_premium'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="tp_premium">TP Premium</label>
                                    <p><b><?php echo $policy_result['tp_premium'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="net_premium">NET Premium</label>
                                    <p><b><?php echo $policy_result['net_premium'];?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="total_premium">Total Premium</label>
                                    <p><b><?php echo $policy_result['total_premium'];?></b></p>
                                </div>
                            </div>

                            <h4>Files</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Policy Files</label>
                                    <p><b><a href="view_policy_files.php?id=<?php echo $_GET['id'];?>">View Policy Files</a></b></p>
                                </div>
                            </div>

                            <h4>Payment Details</h4>
                            <hr>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="payment_mode">Payment Mode</label>
                                    <p><b><?php echo $policy_result['payment_mode'];?></b></p>
                                </div>
                                <!--Cheque-->
                                <?php 
                                
                                    if(strcasecmp($policy_result['payment_mode'],'Cash')!=0 && strcasecmp($policy_result['payment_mode'],'Online')!=0){
                                        $cheque_result_set=$user->read_one_cheque(get_cheque_id($_GET['id']));
                                        $cheque_result=$cheque_result_set->fetch_assoc();
                                ?>
                                <!--Col-->
                                <div class="col-md-4 policy_cheque_data">
                                    <label for="cheque_number">Cheque Number</label>
                                    <p><b><?php echo $cheque_result['cheque_number']?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4 policy_cheque_data">
                                    <label for="cheque_date">Cheque Date</label>
                                    <p><b><?php echo $cheque_result['cheque_date']?></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4 policy_cheque_data">
                                    <label for="bank_name">Bank Name</label>
                                    <p><b><?php echo $cheque_result['bank_name']?></b></p>
                                </div>
                                <?php 
                                    }
                                ?>
                            </div>
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

                        