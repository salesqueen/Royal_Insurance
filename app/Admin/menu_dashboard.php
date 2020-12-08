<?php 

  error_reporting(0);

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Admin");

  //creating user object
  $user=new Admin();

  //form handelling
  if($_POST['announce']){
      $user->announce();
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
                            <a class="nav-link active" href="menu_dashboard.php">Dashboard</a>
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
                                <a class="dropdown-item" href="menu_utilities_comission_recivable_approved.php">Comission Recivable Approved</a>
                                <a class="dropdown-item" href="menu_utilities_comission_payable.php">Comission Payable</a>
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
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                            <textarea name="announcement" id="announcement" row="2" class="form-control" placeholder="Announcement"></textarea>
                            <input name="announce" type="submit" value="Announce">
                        </form>
                    </div>
                    <!--Count-->
                    <div class="row">
                        <div class="col-md-4 card">
                            <h2><i class="fa fa-file-powerpoint-o" aria-hidden="true"></i> <?php echo $user->get_approved_policy_count();?></h2>
                            <p>Approved Policies</p>
                        </div>
                        <div class="col-md-4 card">
                            <h2><i class="fa fa-bookmark-o" aria-hidden="true"></i> <?php echo $user->get_branch_manager_count();?></h2>
                            <p>Branch Manager</p>
                        </div>
                        <div class="col-md-4 card">
                            <h2><i class="fa fa-user-o" aria-hidden="true"></i> <?php echo $user->get_agent_count();?></h2>
                            <p>User</p>
                        </div>
                    </div>
                    <div class="row payment-details">
                        <div class="col-md-4">
                            <h2><i class="fa fa-file-powerpoint-o" aria-hidden="true"></i> <?php echo $user->get_recivable();?></h2>
                            <p>Payment Recivable</p>
                        </div>
                        <div class="col-md-4">
                            <h2><i class="fa fa-bookmark-o" aria-hidden="true"></i> <?php echo $user->get_payable();?></h2>
                            <p>Payment Payable</p>
                        </div>
                        <div class="col-md-4">
                            <h2><i class="fa fa-user-o" aria-hidden="true"></i> <?php echo $user->get_cleared_cheque_count();?></h2>
                            <p>Cheque Status Cleared</p>
                        </div>
                        <div class="col-md-4">
                            <h2><i class="fa fa-file-powerpoint-o" aria-hidden="true"></i> <?php echo $user->get_recivable_pending_policy_count();?></h2>
                            <p>Approval Pending Recivable</p>
                        </div>
                        <div class="col-md-4">
                            <h2><i class="fa fa-bookmark-o" aria-hidden="true"></i> <?php echo $user->get_payable_pending_policy_count();?></h2>
                            <p>Approval Pending Payable</p>
                        </div>
                        <div class="col-md-4">
                            <h2><i class="fa fa-user-o" aria-hidden="true"></i> <?php echo $user->get_pending_cheque_count();?></h2>
                            <p>Approval Pending Cheque</p>
                        </div>
                    </div>
                    <div class="row policy-details">
                        <div class="col-md-3">
                            <h2><i class="fa fa-file-powerpoint-o" aria-hidden="true"></i> <?php echo $user->get_total_premium_this_year();?></h2>
                            <p>Total Policy Premium this year</p>
                        </div>
                        <div class="col-md-3">
                            <h2><i class="fa fa-bookmark-o" aria-hidden="true"></i> <?php echo $user->get_total_premium_last_year();?></h2>
                            <p>Total Policy Premium Last Year</p>
                        </div>
                        <div class="col-md-3">
                            <h2><i class="fa fa-user-o" aria-hidden="true"></i> <?php echo $user->get_total_premium_this_month();?></h2>
                            <p>Total Policy Premium this Month</p>
                        </div>
                        <div class="col-md-3">
                            <h2><i class="fa fa-file-powerpoint-o" aria-hidden="true"></i> <?php echo $user->get_total_premium_last_year_same_month();?></h2>
                            <p>Total Policy Last year same Month</p>
                        </div>
                        <div class="col-md-3">
                            <h2><i class="fa fa-bookmark-o" aria-hidden="true"></i> <?php echo $user->get_total_policy_count_this_year();?></h2>
                            <p>Total Policy Count this Year</p>
                        </div>
                        <div class="col-md-3">
                            <h2><i class="fa fa-user-o" aria-hidden="true"></i> <?php echo $user->get_total_policy_count_last_year();?></h2>
                            <p>Total Policy Count Last Year</p>
                        </div>
                        <div class="col-md-3">
                            <h2><i class="fa fa-user-o" aria-hidden="true"></i> <?php echo $user->get_total_policy_count_this_month();?></h2>
                            <p>Policy Count This Month</p>
                        </div>
                        <div class="col-md-3">
                            <h2><i class="fa fa-user-o" aria-hidden="true"></i> <?php echo $user->get_policy_count_last_year_same_month();?></h2>
                            <p>Policy Count Last Year Same Month</p>
                        </div>
                    </div>
                    
                </div>
                <!--Calendar-->
                <div class="col-md-4">
                  <?php include 'calander.php';?>
                </div>
            </div>
        </div>
    </section>
    <footer>

    
    </footer>
    <!--Message-->
    <div class="alert hide">
        <span class="fas fa-exclamation-circle"></span>
        <span class="msg" id="message"></span>
        <div class="close-btn">
          <span class="fa fa-times"></span>
        </div>
    </div>
    

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
  <!--Custom javascript-->
  <script src="../scripts/main.js"></script>
  <?php 
    //Message handelling
    if(isset($_SESSION['message'])){
        echo "<script>
                $('.alert').addClass('show');
                $('#message').text('".$_SESSION['message']."');
                $('.alert').removeClass('hide');
                $('.alert').addClass('showAlert');
                $('.alert').css('opacity','1');
                setTimeout(function(){
                    $('.alert').removeClass('show');
                    $('.alert').addClass('hide');
                    $('.alert').css('opacity','0');
                },5000);
            </script>";
        unset($_SESSION['message']);
    }else{
        echo $_SESSION['message'];
    }
  ?>
</body>
</html>

                        
              