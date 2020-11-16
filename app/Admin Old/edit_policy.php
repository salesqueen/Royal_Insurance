<?php

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Admin");
  //creating user object
  $user=new Admin();
  //fetching the values
  $result_set=$user->read_one_policy($_GET['id']);
  $result=$result_set->fetch_assoc();
  //form handelling
  if(isset($_POST['submit'])){
      $user->update_policy(Policy_Contract::get_table_columns(),$_GET['id']); 
  }
  //fetching drop down objects
  //fetching company result set
    function get_company_result_set(){
        $company_result_set=$GLOBALS['user']->read_all_company();
        return $company_result_set;
    }
    //fetching policy type result set
    function get_policy_type_result_set(){
        $policy_type_result_set=$GLOBALS['user']->read_all_policy_type();
        return $policy_type_result_set;
    }
    //fetching product result set
    function get_product_result_set(){
        $product_result_set=$GLOBALS['user']->read_all_product();
        return $product_result_set;
    }
    //fetching policy period type result set
    function get_policy_period_result_set(){
        $policy_period_result_set=$GLOBALS['user']->read_all_policy_period();
        return $policy_period_result_set;
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

                <h2>Edit Policy</h2>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#policy" class="active">Policy</a></li>
                </ul>

                <div class="tab-content">
                    <div id="policy" class="tab-pane fade show in active">
                        <h4>Edit Policy</h4>
                        <form action="<?php echo $_SERVER['PHP_SELF'].'?id='.$_GET['id']; ?>" method="POST">
                            <div class="row">
                                <!--Form type based on payment type-->
                                <input type="hidden" id="form_type" name="form_type" value="cash">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="issue_date">Issue Date</label>
                                    <input type="date" class="form-control" id="issue_date" name="issue_date" placeholder="Issue Date" required="required" value="<?php echo $result['od_policy_start_date'];?>">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="company_name">Company Name</label>
                                    <select name="company_name" class="form-control" id="company_name" required="required">
                                        <option value="<?php echo $result['company_name'];?>"><?php echo $result['company_name'];?></option>
                                        <?php 
                                            $company_result_set=get_company_result_set();
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
                                        <option value="<?php echo $result['policy_type'];?>"><?php echo $result['policy_type'];?></option>
                                        <?php 
                                            $policy_type_result_set=get_policy_type_result_set();
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
                                        <option value="<?php echo $result['product'];?>"><?php echo $result['product'];?></option>
                                        <?php 
                                            $product_result_set=get_product_result_set();
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
                                    <label for="policy_number">Policy Number</label>
                                    <input type="number" value="<?php echo $result['policy_number'];?>" class="form-control" id="policy_number" name="policy_number" placeholder="Policy Number" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="customer_name">Customer Name</label>
                                    <input type="text" value="<?php echo $result['customer_name'];?>" class="form-control" id="customer_name" name="customer_name" placeholder="Customer Name" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="mobile">Mobile</label>
                                    <input type="number" value="<?php echo $result['mobile'];?>" class="form-control" id="mobile" name="mobile" placeholder="Mobile" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="email">Email</label>
                                    <input type="email" value="<?php echo $result['email'];?>" class="form-control" id="email" name="email" placeholder="Email" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="registration_number">Registration Number</label>
                                    <input type="text" value="<?php echo $result['registration_number'];?>" class="form-control" id="registration_number" name="registration_number" placeholder="Registration Number" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="make_model">Make Model</label>
                                    <input type="text" value="<?php echo $result['make_model'];?>" class="form-control" id="make_model" name="make_model" placeholder="Make Model" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="od_policy_start_date">OD Policy Start Date</label>
                                    <input type="date" value="<?php echo $result['od_policy_start_date'];?>" class="form-control" id="od_policy_start_date" name="od_policy_start_date" placeholder="OD Policy Start Date" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="od_policy_period">OD Policy Period</label>
                                    <select onchange="update_od_policy_end_date()" name="od_policy_period" class="form-control" id="od_policy_period" required="required">
                                        <option value="<?php echo $result['od_policy_period'];?>"><?php echo $result['od_policy_period'];?></option>
                                        <?php 
                                            $policy_period_result_set=get_policy_period_result_set();
                                            if($policy_period_result_set){
                                                while($policy_period_result=$policy_period_result_set->fetch_assoc()){
                                                    echo '<option value="'.$policy_period_result['policy_period'].'">'.$policy_period_result['policy_period'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="od_policy_end_date">OD Policy End Date</label>
                                    <input type="date" value="<?php echo $result['od_policy_end_date'];?>" class="form-control" id="od_policy_end_date" name="od_policy_end_date" placeholder="OD Policy End Date" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="tp_policy_start_date">TP Policy Start Date</label>
                                    <input type="date" value="<?php echo $result['tp_policy_start_date'];?>" class="form-control" id="tp_policy_start_date" name="tp_policy_start_date" placeholder="TP Policy Start Date" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="tp_policy_period">TP Policy Period</label>
                                    <select onchange="update_tp_policy_end_date()" name="tp_policy_period" class="form-control" id="tp_policy_period" required="required">
                                        <option value="<?php echo $result['tp_policy_period'];?>"><?php echo $result['tp_policy_period'];?></option>
                                        <?php 
                                            $policy_period_result_set=get_policy_period_result_set();
                                            if($policy_period_result_set){
                                                while($policy_period_result=$policy_period_result_set->fetch_assoc()){
                                                    echo '<option value="'.$policy_period_result['policy_period'].'">'.$policy_period_result['policy_period'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="tp_policy_end_date">TP Policy End Date</label>
                                    <input type="date" value="<?php echo $result['tp_policy_end_date'];?>" class="form-control" id="tp_policy_end_date" name="tp_policy_end_date" placeholder="TP Policy End Date" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="od_disc">OD Disc</label> 
                                    <input type="number" value="<?php echo $result['od_disc'];?>" class="form-control" id="od_disc" name="od_disc" placeholder="OD Disc" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="od_premium">OD Premium</label>
                                    <input type="number" value="<?php echo $result['od_premium'];?>" class="form-control" id="od_premium" name="od_premium" placeholder="OD Premium" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="tp_premium">TP Premium</label>
                                    <input type="number" value="<?php echo $result['tp_premium'];?>" class="form-control" id="tp_premium" name="tp_premium" placeholder="TP Premium" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="net_premium">NET Premium</label>
                                    <input type="number" value="<?php echo $result['net_premium'];?>" class="form-control" id="net_premium" name="net_premium" placeholder="NET Premium" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="total_premium">Total Premium</label>
                                    <input type="number" value="<?php echo $result['total_premium'];?>" class="form-control" id="total_premium" name="total_premium" placeholder="Total Premium" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="payment_mode">Payment Mode</label>
                                    <input type="text" value="<?php echo $result['payment_mode'];?>" class="form-control" id="payment_mode" name="payment_mode" readonly="true">
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
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <!--Font awesome-->
  <script src="https://kit.fontawesome.com/831f398f58.js" crossorigin="anonymous"></script>
  <!--Custom Javascript-->
  <script src="../scripts/policy.js"></script>
</body>
</html>