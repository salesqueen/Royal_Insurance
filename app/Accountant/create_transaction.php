<?php 

  error_reporting(0);

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Accountant");

  //creating user object
  $user=new Accountant();

  //fetching main
  //fetching branch manager result set
  $branch_manager_result_set=$user->read_all_branch_manager();

  //form handelling
  //inserting transaction
  if(isset($_POST['submit'])){
    $user->insert_transaction();
    header('Location:menu_wallet.php');
    exit();
  }
  //fetching agent 
  if(isset($_POST['fetch_agent_submit'])){
    $branch_manager_id=$_POST['branch_manager'];
    //fetching agent result set
    $agent_result_set=$user->read_selective_agent("WHERE branch_manager_id=".$branch_manager_id);
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Make Transaction</title>

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
                                <a class="nav-link" href="menu_manage_user_agent.php">Manage User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu_policy.php">Policy</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Utilities</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
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
                        <h2>Make Transaction</h2>
                    </div>
                    <div class="col-md-6">
                        <a href="<?php if(isset($_GET['transaction_type'])){if(strcasecmp($_GET['transaction_type'],'Recived')==0){echo "menu_utilities_cash_recived.php";}else{echo "menu_utilities_cash_paid.php";}}else{echo "menu_wallet.php";}?>" style="float:right"><Button>Back <i class="fa fa-arrow-right" aria-hidden="true"></i></button></a>
                    </div>
                </div>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#transaction" class="active">Make Transaction</a></li>
                </ul>

                <div class="tab-content">
                    <div id="transaction" class="tab-pane fade in show active">
                        <!--Select branch form-->
                        <form action="<?php if(isset($_GET['transaction_type'])){echo $_SERVER['PHP_SELF']."?transaction_type=".$_GET['transaction_type'];}else{echo $_SERVER['PHP_SELF'];}?>" method="POST">
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="branch_manager">Branch</label>
                                    <select name="branch_manager" class="form-control" id="branch_manager" required="required">
                                        <option value=""><?php 
                                                            //showing previously entered data
                                                            if($_POST['branch_manager']){
                                                                $one_branch_manager_result_set=$user->read_one_branch_manager($_POST['branch_manager']);
                                                                $one_branch_manager_result=$one_branch_manager_result_set->fetch_assoc();
                                                                echo $one_branch_manager_result['name']."-".$one_branch_manager_result['mobile'];
                                                            }else{
                                                                echo "select branch manager";
                                                            }
                                                        ?></option>
                                        <?php 
                                            if($branch_manager_result_set){
                                                while($branch_manager_result=$branch_manager_result_set->fetch_assoc()){
                                                    echo '<option value="'.$branch_manager_result['id'].'">'.$branch_manager_result['name'].'-'.$branch_manager_result['mobile'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <br>
                                    <input type="submit" value="Fetch" name="fetch_agent_submit">
                                </div>
                            </form>
                            <!--Create Transaction form-->
                            <!--Col-->
                            <div class="col-md-4">
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <label for="agent_id">User</label>
                                    <select onchange="fetch_agent_detail()" name="agent_id" class="form-control" id="agent_id" required="required">
                                        <option value="">Select User</option>
                                        <?php 
                                            if($agent_result_set){
                                                while($agent_result=$agent_result_set->fetch_assoc()){
                                                    echo '<option value="'.$agent_result['id'].'">'.$agent_result['name'].'-'.$agent_result['mobile'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="payment">Payment</label>
                                    <input type="text" value="<?php if(isset($_GET['transaction_type'])){echo $_GET['transaction_type'];}else{echo "";}?>" class="form-control" id="payment" name="payment" placeholder="Payment" required="required" readonly="true">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="remark">Remark</label>
                                    <input type="text" class="form-control" id="remark" name="remark" placeholder="Remark">
                                </div>
                            </div>
                            <input type="submit" value="submit" name="submit" class="btn btn-primary">
                        </form>
                        <br>
                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">View Details</a>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                            <h4>Bank Details</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="bank_name">Bank Name</label>
                                    <p><b id="bank_name"></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="bank_branch">Branch</label>
                                    <p><b id="bank_branch"></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="ifsc_code">IFSC Code</label>
                                    <p><b id="ifsc_code"></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="micr_number">MICR Number</label>
                                    <p><b id="micr_number"></b></p>
                                </div>
                            </div>

                            <hr>
                            <h4>Wallet Details</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="phonepe_number">PhonePe Number</label>
                                    <p><b id="phonepe_number"></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="paytm_number">Paytm Number</label>
                                    <p><b id="paytm_number"></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="google_pay_number">Google Pay Number</label>
                                    <p><b id="google_pay_number"></b></p>
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="upi_id">UPI ID</label>
                                    <p><b id="upi_id"></b></p>
                                </div>
                            </div>
                            </div>
                        </div>
          
          
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

                        


                        