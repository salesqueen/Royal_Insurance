<?php 

  //error_reporting(0);

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Admin");

  //creating user object
  $user=new Admin();

  //fetching main
  $branch_result_set=$user->read_all_branch();

  //form handelling
  if(isset($_POST['user_form_submit'])){
    //checking user is branch manager
    if($_POST['user_type']=='branch_manager'){
        $user->insert_branch_manager();
        header('Location:menu_manage_user_branch_manager.php');
    }
    //checking user is operator
    if($_POST['user_type']=='operator'){
        $user->insert_operator();
        header('Location:menu_manage_user_operator.php');
    }
    //checking user is accountant
    if($_POST['user_type']=='accountant'){
        $user->insert_accountant();
        header('Location:menu_manage_user_accountant.php');
    }
    //checking user is agent
    if($_POST['user_type']=='agent'){
        $user->insert_agent();
        header('Location:menu_manage_user_agent.php');
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create User</title>

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
                                <a class="dropdown-item" href="menu_master_company_code.php">Company Code</a>
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
                        <h2>Create User</h2>
                    </div>
                    <div class="col-md-6">
                        <a href="javascript:history.go(-2)" style="float:right"><Button>Back <span class="fas fa-arrow-right"></span></button></a>
                    </div>
                </div>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#user" class="active">Create User</a></li>
                </ul>

                <div class="tab-content">
                    <div id="user" class="tab-pane fade show in active">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                            <h4>User Type</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="user_type">User Type</label>
                                    <select onchange="view_hidden_field()" name="user_type" class="form-control" id="user_type" required="required">
                                        <option value="">Select User Type</option>
                                        <option value="branch_manager">Branch Manager</option>
                                        <option value="operator">Operator</option>
                                        <option value="accountant">Accountant</option>
                                        <option value="agent">Agent</option>
                                    </select>
                                </div>
                                <!--Col-->
                                <div class="col-md-4" id="branch_column">
                                    <label for="branch">Branch</label>
                                    <select name="branch" class="form-control" id="branch">
                                        <option value="">Select Branch</option>
                                        <?php 
                                            if($branch_result_set){
                                                while($branch_result=$branch_result_set->fetch_assoc()){
                                                    echo '<option value="'.$branch_result['branch'].'">'.$branch_result['branch'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <!--Col-->
                                <div class="col-md-4" id="branch_manager_id_column">
                                    <label for="branch_manager_id">Branch Manager</label>
                                    <select name="branch_manager_id" class="form-control" id="branch_manager_id" required="required">
                                        <option value="">Select Branch Manager</option>
                                        <?php 
                                            $branch_manager_result_set=$user->read_all_branch_manager();
                                            if($branch_manager_result_set){
                                                while($branch_manager_result=$branch_manager_result_set->fetch_assoc()){
                                                    echo '<option value="'.$branch_manager_result['id'].'">'.$branch_manager_result['name'].'-'.$branch_manager_result['mobile'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <hr>
                            <h4>Personal Details</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="mobile">Mobile Number</label>
                                    <input type="text" maxlength="10" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="aadhar_card_number">Aadhar Card Number</label>
                                    <input type="text" class="form-control" id="aadhar_card_number" name="aadhar_card_number" placeholder="Aadhar Card Number">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="pan_card_number">Pan Card Number</label>
                                    <input type="text" class="form-control" id="pan_card_number" name="pan_card_number" placeholder="Pan Card Number">
                                </div>
                            </div>

                            <hr>
                            <h4>Bank Details</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="bank_name">Bank Name</label>
                                    <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="bank_branch">Branch</label>
                                    <input type="text" class="form-control" id="bank_branch" name="bank_branch" placeholder="Branch">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="ifsc_code">IFSC Code</label>
                                    <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="micr_number">MICR Number</label>
                                    <input type="text" class="form-control" id="micr_number" name="micr_number" placeholder="MICR Number">
                                </div>
                            </div>

                            <hr>
                            <h4>Wallet Details</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="phonepe_number">PhonePe Number</label>
                                    <input type="number" class="form-control" id="phonepe_number" name="phonepe_number" placeholder="PhonePe Number">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="paytm_number">Paytm Number</label>
                                    <input type="number" class="form-control" id="paytm_number" name="paytm_number" placeholder="Paytm Number">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="google_pay_number">Google Pay Number</label>
                                    <input type="number" class="form-control" id="google_pay_number" name="google_pay_number" placeholder="Google Pay Number">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="upi_id">UPI ID</label>
                                    <input type="number" class="form-control" id="upi_id" name="upi_id" placeholder="UPI ID">
                                </div>
                            </div>

                            <hr>
                            <h4>Attachments</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="photo">Photo</label>
                                    <input type="file" class="form-control" id="photo" name="photo" placeholder="Photo" accept="image/*">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="address_proof">Address Proof</label>
                                    <input type="file" class="form-control" id="address_proof" name="address_proof" placeholder="Address Proof">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="id_proof">ID Proof</label>
                                    <input type="file" class="form-control" id="id_proof" name="id_proof" placeholder="ID Proof">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="pan_card">PAN Card</label>
                                    <input type="file" class="form-control" id="pan_card" name="pan_card" placeholder="PAN Card">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="educational_proof">Educational Proof</label>
                                    <input type="file" class="form-control" id="educational_proof" name="educational_proof" placeholder="Educational Proof">
                                </div>
                            </div>

                            <input type="submit" value="Create" name="user_form_submit" class="btn btn-primary">
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
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <!--Font awesome-->
  <script src="https://kit.fontawesome.com/831f398f58.js" crossorigin="anonymous"></script>
  <!--Custom script-->
  <script>
    //displaying fields based on user type
    function view_hidden_field(){ 
        var user_type=$('#user_type').val();
        if(user_type == 'agent'){
            $('#branch_manager_id_column').css('visibility','visible');
            $('#branch_manager_id').attr('required',"required");
            $('#branch_column').css('visibility','hidden');
            $('#branch').removeAttr('required');
        }else if(user_type == 'branch_manager'){
            $('#branch_column').css('visibility','visible');
            $('#branch').attr('required',"required");
            $('#branch_manager_id_column').css('visibility','hidden');
            $('#branch_manager_id').removeAttr('required');
        }else{
            $('#branch_manager_id_column').css('visibility','hidden');
            $('#branch_manager_id').removeAttr('required');
            $('#branch_column').css('visibility','hidden');
            $('#branch').removeAttr('required');
        }
    }
  </script>
</body>
</html>

                        
              