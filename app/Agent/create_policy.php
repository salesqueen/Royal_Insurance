<?php 

    error_reporting(0);

    include '../Php/main.php';

    //session handelling
    $session=new Session();
    $session->check_session("Agent");
    
    //creating user object
    $user=new Agent();

    //fetching
    //fetching company result set
    $company_result_set=$user->read_all_company();
    //fetching policy type result set
    $policy_type_result_set=$user->read_all_policy_type();
    //fetching product result set
    $product_result_set=$user->read_all_product();
    //fetching policy period type result set
    $policy_period_result_set=$user->read_all_policy_period();
    

    //form handelling
    //create policy
    if(isset($_POST['submit'])){
        $user->insert_policy();
        header('Location:menu_policy.php');
        exit();
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Policy</title>

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
                        <h2>Create Policy</h2>
                    </div>
                    <div class="col-md-6">
                        <a href="menu_policy.php" style="float:right"><Button>Back <i class="fa fa-arrow-right" aria-hidden="true"></i></button></a>
                    </div>
                </div>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#policy" class="active">Create Policy</a></li>
                </ul>

                <div class="tab-content">
                    <div id="policy" class="tab-pane fade in show active">
                        <!--Create Transaction form-->
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                            <h4>Policy Details</h4>
                            <hr>
                            <div class="row">
                                <!--Form type based on payment type-->
                                <input type="hidden" id="policy_form_type" name="policy_form_type">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="issue_date">Issue Date</label>
                                    <input type="date" class="form-control" id="issue_date" name="issue_date" placeholder="Issue Date" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="company_name">Company Name</label>
                                    <select name="company_name" class="form-control" id="company_name" required="required">
                                        <option value="">Select Company</option>
                                        <?php 
                                            if($company_result_set){
                                                while($company_result=$company_result_set->fetch_assoc()){
                                                    echo '<option value="'.$company_result['company_name'].'">'.$company_result['company_name'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="policy_type">Policy Type</label>
                                    <select name="policy_type" class="form-control" id="policy_type" required="required">
                                        <option value="">Select Policy Type</option>
                                        <?php 
                                            if($policy_type_result_set){
                                                while($policy_type_result=$policy_type_result_set->fetch_assoc()){
                                                    echo '<option value="'.$policy_type_result['policy_type'].'">'.$policy_type_result['policy_type'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="product">Product</label>
                                    <select name="product" class="form-control" id="product" required="required">
                                        <option value="">Select Product</option>
                                        <?php 
                                            if($product_result_set){
                                                while($product_result=$product_result_set->fetch_assoc()){
                                                    echo '<option value="'.$product_result['product'].'">'.$product_result['product'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="policy_number">Policy Number <span id="policy_number_error" style="color:red"></span></label>
                                    <input type="text" onchange="check_policy_number_duplication()" class="form-control" id="policy_number" name="policy_number" placeholder="Policy Number" required="required">
                                </div>
                            </div>

                            <h4>Customer Details</h4>
                            <hr>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="customer_name">Customer Name</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Customer Name" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" maxlength="10" class="form-control" id="mobile" name="mobile" placeholder="Mobile">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                </div>
                            </div>

                            <h4>Vehicle Details</h4>
                            <hr>
                            <div class="row">
                            <!--Col-->
                                <div class="col-md-4">
                                    <label for="registration_number">Registration Number <span id="registration_number_error" style="color:red"></span></label>
                                    <input type="text" maxlength="14" onchange="check_registration_number_duplication()" class="form-control" id="registration_number" name="registration_number" placeholder="Registration Number" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="make_model">Make Model</label>
                                    <input type="text" class="form-control" id="make_model" name="make_model" placeholder="Make Model" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-1">
                                    <label for="cc">CC</label>
                                    <input type="number" class="form-control" id="cc" name="cc" placeholder="CC" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-1">
                                    <label for="gbw">GVW</label>
                                    <input type="number" class="form-control" id="gbw" name="gbw" placeholder="GVW" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-2">
                                    <label for="seating_capacity">Seating Capacity</label>
                                    <input type="number" maxlength="10" class="form-control" id="seating_capacity" name="seating_capacity" placeholder="Seating Capacity" required="required">
                                </div>
                            </div>

                            <h4>OD Policy Date</h4>
                            <hr>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="od_policy_start_date">OD Policy Start Date</label>
                                    <input type="date" onchange="update_od_policy_end_date()" class="form-control" id="od_policy_start_date" name="od_policy_start_date" placeholder="OD Policy Start Date" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="od_policy_period">OD Policy Period</label>
                                    <select onchange="update_od_policy_end_date()" name="od_policy_period" class="form-control" id="od_policy_period" required="required">
                                        <option value="">OD Policy Period</option>
                                        <?php 
                                            if($policy_period_result_set){
                                                $policy_period_array=array();
                                                $i=0;
                                                while($policy_period_result=$policy_period_result_set->fetch_assoc()){
                                                    $policy_period_array[$i]=$policy_period_result['policy_period'];
                                                    $i++;
                                                }
                                                sort($policy_period_array);
                                                for($j=0;$j<count($policy_period_array);$j++){
                                                    echo '<option value="'.$policy_period_array[$j].'">'.$policy_period_array[$j].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="od_policy_end_date">OD Policy End Date</label>
                                    <input type="date" class="form-control" id="od_policy_end_date" name="od_policy_end_date" placeholder="OD Policy End Date" required="required" readonly="true">
                                </div>
                            </div>

                            <h4>TP Policy Date</h4>
                            <hr>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="tp_policy_start_date">TP Policy Start Date</label>
                                    <input type="date" onchange="update_tp_policy_end_date()" class="form-control" id="tp_policy_start_date" name="tp_policy_start_date" placeholder="TP Policy Start Date" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="tp_policy_period">TP Policy Period</label>
                                    <select onchange="update_tp_policy_end_date()" name="tp_policy_period" class="form-control" id="tp_policy_period" required="required">
                                        <option value="">TP Policy Period</option>
                                        <?php 
                                            if($policy_period_result_set){
                                                for($j=0;$j<count($policy_period_array);$j++){
                                                    echo '<option value="'.$policy_period_array[$j].'">'.$policy_period_array[$j].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="tp_policy_end_date">TP Policy End Date</label>
                                    <input type="date" class="form-control" id="tp_policy_end_date" name="tp_policy_end_date" placeholder="TP Policy End Date" required="required" readonly="true">
                                </div>
                            </div>

                            <h4>Premium</h4>
                            <hr>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="od_disc">OD Disc(%)</label> 
                                    <input type="number" class="form-control" id="od_disc" name="od_disc" placeholder="OD Disc" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="od_premium">OD Premium</label>
                                    <input type="number" class="form-control" id="od_premium" name="od_premium" placeholder="OD Premium" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="tp_premium">TP Premium</label>
                                    <input type="number" class="form-control" id="tp_premium" name="tp_premium" placeholder="TP Premium" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="net_premium">NET Premium</label>
                                    <input type="number" class="form-control" id="net_premium" name="net_premium" placeholder="NET Premium" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="total_premium">Total Premium</label>
                                    <input type="number" class="form-control" id="total_premium" name="total_premium" placeholder="Total Premium" required="required">
                                </div>
                            </div>

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

                            <h4>Payment Details</h4>
                            <hr>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="payment_mode">Payment Mode</label>
                                    <select onchange="view_cheque_form()" name="payment_mode" class="form-control" id="payment_mode" required="required">
                                        <option value="">Select Payment Mode</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Online">Online</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="DD">DD</option>
                                    </select>
                                </div>
                                <!--Cheque-->
                                <!--Col-->
                                <div class="col-md-4 policy_cheque_data">
                                    <label for="cheque_number">Cheque Number</label>
                                    <input type="number" class="form-control policy_cheque_input" id="cheque_number" name="cheque_number" placeholder="Cheque Number">
                                </div>
                                <!--Col-->
                                <div class="col-md-4 policy_cheque_data">
                                    <label for="cheque_date">Cheque Date</label>
                                    <input type="date" class="form-control policy_cheque_input" id="cheque_date" name="cheque_date" placeholder="Cheque Date">
                                </div>
                                <!--Col-->
                                <div class="col-md-4 policy_cheque_data">
                                    <label for="bank_name">Bank Name</label>
                                    <input type="text" class="form-control policy_cheque_input" id="bank_name" name="bank_name" placeholder="Bank Name">
                                </div>
                            </div>
                            <input type="submit" value="Create" name="submit" class="btn btn-primary">
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

                        