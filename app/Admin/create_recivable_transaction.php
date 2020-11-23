<?php 

  error_reporting(0);

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Admin");

  //creating user object
  $user=new Admin();

  //fetching main
  //fetching branch manager result set
  $branch_manager_result_set=$user->read_all_branch_manager();

  //form handelling
  //inserting transaction
  if(isset($_POST['submit'])){
    $user->insert_recivable_transaction();
    header('Location:menu_utilities_comission_recivable.php');
    exit();
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Make Recivable Transaction</title>

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
                                <a class="dropdown-item" href="menu_utilities_office_expenses.php">Office Expenses</a>
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
                        <h2>Make Recivable Transaction</h2>
                    </div>
                    <div class="col-md-6">
                        <a href="<?php if(isset($_GET['transaction_type'])){if(strcasecmp($_GET['transaction_type'],'Recived')==0){echo "menu_utilities_cash_recived.php";}else{echo "menu_utilities_cash_paid.php";}}else{echo "menu_wallet.php";}?>" style="float:right"><Button>Back <i class="fa fa-arrow-right" aria-hidden="true"></i></button></a>
                    </div>
                </div>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#transaction" class="active">Make Recivable Transaction</a></li>
                </ul>

                <div class="tab-content">
                    <div id="transaction" class="tab-pane fade in show active">
                        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                            <div class="row">
                                <input type="hidden" name="policy_id" value="<?php echo $_GET['policy_id'];?>">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" value="<?php echo $_GET['company_name'];?>" class="form-control" id="company_name" name="company_name" placeholder="Company Name" required="required" readonly="true">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="company_code">Company Code</label>
                                    <input type="text" value="<?php echo $_GET['company_code'];?>" class="form-control" id="company_code" name="company_code" placeholder="Company Code" required="required" readonly="true">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="policy_number">Policy Number</label>
                                    <input type="text" value="<?php echo $_GET['policy_number'];?>" class="form-control" id="policy_number" name="policy_number" placeholder="Policy Number" required="required" readonly="true">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="remark">Remark</label>
                                    <input type="text" class="form-control" id="remark" name="remark" placeholder="Remark">
                                </div>
                            </div>
                            <input type="submit" value="submit" name="submit" class="btn btn-primary">
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
    <script>
        function set_agent_detail(json){
            let agent_object=JSON.parse(json);

            $('#bank_name').text(agent_object['bank_name']);
            $('#bank_branch').text(agent_object['bank_branch']);
            $('#ifsc_code').text(agent_object['ifsc_code']);
            $('#micr_number').text(agent_object['micr_number']);

            $('#phonepe_number').text(agent_object['phonepe_number']);
            $('#paytm_number').text(agent_object['paytm_number']);
            $('#google_pay_number').text(agent_object['google_pay_number']);
            $('#upi_id').text(agent_object['upi_id']);
        }
        function ajax_call(id) {
            $.ajax({
                url:"ajax_transaction.php",
                type:"post",
                data: {agent_id: id},
                success:function(response){
                    set_agent_detail(response);
                }
            });
        }
        function fetch_agent_detail(){
            ajax_call($('#agent_id').val()); 
        }
    </script>
</body>
</html>

                        


                        