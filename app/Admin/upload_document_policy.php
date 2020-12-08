<?php 

    error_reporting(0);

    include '../Php/main.php';

    //session handelling
    $session=new Session();
    $session->check_session("Admin");
    
    //creating user object
    $user=new Admin();

    //fetching
    //fetching company result set
    $company_result_set=$user->read_all_company();
    //fetching policy type result set
    $policy_type_result_set=$user->read_all_policy_type();
    //fetching product result set
    $product_result_set=$user->read_all_product();
    //fetching policy period type result set
    $policy_period_result_set=$user->read_all_policy_period();
    //fetching branch manager result set
    $branch_manager_result_set=$user->read_all_branch_manager();
    

    //form handelling
    //create policy
    if(isset($_POST['submit'])){
        $user->update_policy_document($_GET['id']);
        header('Location:menu_policy.php');
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Policy</title>

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
        <div class="form-container">
          <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-6">
                        <h2>Upload Policy Documents</h2>
                    </div>
                    <div class="col-md-6">
                        <a href="menu_policy.php" style="float:right"><Button>Back <i class="fa fa-arrow-right" aria-hidden="true"></i></button></a>
                    </div>
                </div>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#policy" class="active">Upload Policy Documents</a></li>
                </ul>

                <div class="tab-content">
                    <div id="policy" class="tab-pane fade in show active">
                        <!--Select branch form-->
                        <form action="<?php echo $_SERVER['PHP_SELF']."?id=".$_GET['id'];?>" method="POST" enctype="multipart/form-data">
                            <h4>Files</h4>
                            <hr>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="file_1">File 1</label>
                                    <input type="file" class="form-control" id="file_1" name="file_1" placeholder="File 1" accept="application/pdf" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="file_2">File 2</label>
                                    <input type="file" class="form-control" id="file_2" name="file_2" placeholder="File 2" accept="application/pdf">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="file_3">File 3</label>
                                    <input type="file" class="form-control" id="file_3" name="file_3" placeholder="File 3" accept="application/pdf">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="file_4">File 4</label>
                                    <input type="file" class="form-control" id="file_4" name="file_4" placeholder="File 4" accept="application/pdf">
                                </div>
                            </div>
                            <input type="submit" value="Upload" name="submit" class="btn btn-primary">
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

                        