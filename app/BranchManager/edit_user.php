<?php 

  error_reporting(0);

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Branch_Manager");

  //creating user object
  $user=new Branch_Manager();

  //fetching main
  $user_result_set=null;
  //branch manager
  if(strcasecmp($_GET['user_type'],'branch_manager')==0){
      $user_result_set=$user->read_one_branch_manager($_GET['id']);
  }
  //operator
  if(strcasecmp($_GET['user_type'],'operator')==0){
    $user_result_set=$user->read_one_operator($_GET['id']);
  }
  //accountant
  if(strcasecmp($_GET['user_type'],'accountant')==0){
    $user_result_set=$user->read_one_accountant($_GET['id']);
  }
  //agent
  if(strcasecmp($_GET['user_type'],'agent')==0){
    $user_result_set=$user->read_one_agent($_GET['id']);
  }
  $user_result=$user_result_set->fetch_assoc();

  //form handelling
  if(isset($_POST['submit'])){
    //branch manager
    if(strcasecmp($_GET['user_type'],'branch_manager')==0){
        $name_array=Branch_Manager_Contract::get_table_columns();
        array_splice($name_array,14,6);
        $user_result_set=$user->update_branch_manager($name_array,$_GET['id']);
        header('Location:menu_manage_user_branch_manager.php');
        exit();
    }
    //operator
    if(strcasecmp($_GET['user_type'],'operator')==0){
        $name_array=Operator_Contract::get_table_columns();
        array_splice($name_array,14,5);
        $user_result_set=$user->update_operator($name_array,$_GET['id']);
        header('Location:menu_manage_user_operator.php');
        exit();
    }
    //accountant
    if(strcasecmp($_GET['user_type'],'accountant')==0){
        $name_array=Accountant_Contract::get_table_columns();
        array_splice($name_array,14,5);
        $user_result_set=$user->update_accountant($name_array,$_GET['id']);
        header('Location:menu_manage_user_accountant.php');
        exit();
    }
    //agent
    if(strcasecmp($_GET['user_type'],'agent')==0){
        $name_array=Agent_Contract::get_table_columns();
        array_splice($name_array,14,6);
        //appending branch manager incase of branch change
        array_push($name_array,"branch_manager_id");
        $user_result_set=$user->update_agent($name_array,$_GET['id']);
        header('Location:menu_manage_user_agent.php');
        exit();
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>

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
                            <a class="nav-link" href="menu_manage_user_agent.php">Manage User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu_policy.php">Policy</a>
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
                        <h2>Edit User</h2>
                    </div>
                    <div class="col-md-6">
                        <a href="<?php  
                                        //printing link based on user_type
                                        if(strcasecmp($_GET['user_type'],'branch_manager')==0)
                                        {
                                            echo "menu_manage_user_branch_manager.php";
                                        }elseif(strcasecmp($_GET['user_type'],'accountant')==0){
                                            echo "menu_manage_user_accountant.php";
                                        }elseif(strcasecmp($_GET['user_type'],'operator')==0){
                                            echo "menu_manage_user_operator.php";
                                        }else{
                                            echo "menu_manage_user_agent.php";
                                        }
                        ?>" style="float:right"><Button>Back <i class="fa fa-arrow-right" aria-hidden="true"></i></button></a>
                    </div>
                </div>

                <div class="tab-content">
                    <div id="user" class="tab-pane fade show in active">
                        <form action="<?php echo $_SERVER['PHP_SELF'].'?id='.$_GET['id'].'&user_type='.$_GET['user_type'] ?>" method="POST" enctype="multipart/form-data">
                            <h4>Personal Details</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="name">Name</label>
                                    <input type="text" value="<?php echo $user_result['name'];?>" class="form-control" id="name" name="name" placeholder="Name" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="mobile">Mobile Number</label>
                                    <input type="number" value="<?php echo $user_result['mobile'];?>" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="email">Email</label>
                                    <input type="email" value="<?php echo $user_result['email'];?>" class="form-control" id="email" name="email" placeholder="Email" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="address">Address</label>
                                    <input type="text" value="<?php echo $user_result['address'];?>" class="form-control" id="address" name="address" placeholder="Address" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="aadhar_card_number">Aadhar Card Number</label>
                                    <input type="text" value="<?php echo $user_result['aadhar_card_number'];?>" class="form-control" id="aadhar_card_number" name="aadhar_card_number" placeholder="Aadhar Card Number">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="pan_card_number">Pan Card Number</label>
                                    <input type="text" value="<?php echo $user_result['pan_card_number'];?>" class="form-control" id="pan_card_number" name="pan_card_number" placeholder="Pan Card Number">
                                </div>
                            </div>

                            <hr>
                            <h4>Bank Details</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="bank_name">Bank Name</label>
                                    <input type="text" value="<?php echo $user_result['bank_name'];?>" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="bank_branch">Branch</label>
                                    <input type="text" value="<?php echo $user_result['bank_branch'];?>" class="form-control" id="bank_branch" name="bank_branch" placeholder="Branch">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="ifsc_code">IFSC Code</label>
                                    <input type="text" value="<?php echo $user_result['ifsc_code'];?>" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="micr_number">MICR Number</label>
                                    <input type="text" value="<?php echo $user_result['micr_number'];?>" class="form-control" id="micr_number" name="micr_number" placeholder="MICR Number">
                                </div>
                            </div>

                            <hr>
                            <h4>Wallet Details</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="phonepe_number">PhonePe Number</label>
                                    <input type="text" value="<?php echo $user_result['phonepe_number'];?>" class="form-control" id="phonepe_number" name="phonepe_number" placeholder="PhonePe Number">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="paytm_number">Paytm Number</label>
                                    <input type="text" value="<?php echo $user_result['paytm_number'];?>" class="form-control" id="paytm_number" name="paytm_number" placeholder="Paytm Number">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="google_pay_number">Google Pay Number</label>
                                    <input type="text" value="<?php echo $user_result['google_pay_number'];?>" class="form-control" id="google_pay_number" name="google_pay_number" placeholder="Google Pay Number">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="upi_id">UPI ID</label>
                                    <input type="text" value="<?php echo $user_result['upi_id'];?>" class="form-control" id="upi_id" name="upi_id" placeholder="UPI ID">
                                </div>
                            </div>
                            
                            <?php 
                            
                                //visible only for user
                                if(strcasecmp($_GET['user_type'],'agent')==0){
                                    $branch_manager_result_set=$user->read_all_branch_manager();
                                    ?>

                                    <hr>
                                    <h4>Branch</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="branch_manager_id">Branch</label>
                                            <select name="branch_manager_id" class="form-control" id="branch_manager_id" required="required">
                                                <option value="<?php echo $user_result['branch_manager_id'];?>"><?php echo $user->get_branch($user_result['id']);?></option>
                                                <?php 
                                                    if($branch_manager_result_set){
                                                        while($branch_manager_result=$branch_manager_result_set->fetch_assoc()){
                                                            echo '<option value="'.$branch_manager_result['id'].'">'.$branch_manager_result['branch'].'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                            <?php
                                }

                            ?>

                            <input type="submit" value="Submit" name="submit" class="btn btn-primary">
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
</body>
</html>

                        
              