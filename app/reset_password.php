<?php 

    error_reporting(0);

    include 'Php/main.php';

    //session handelling
    $session=new Session();
    session_start();

    //form handelling
    //update password
    if(isset($_POST['submit'])){
        //admin
        if($_SESSION['user_type']=='Admin'){
            $user=new Admin();
            //checking for old password is correct
            $user_result_set=$user->read_one_admin($_SESSION['id']);
            if($user_result_set){
                if(strcasecmp($user_result_set->fetch_assoc()['password'],$_POST['old_password'])==0){
                    $user->update_password($_SESSION['id']);
                    $_SESSION['message']='Password has been changed successfully';
                    header('Location:Admin/menu_dashboard.php');
                    exit();
                }else{
                    $_SESSION['message']='Incorrect password';
                    header('Location:Admin/menu_dashboard.php');
                    exit();
                }
            }else{
                $_SESSION['message']=='User does not Exists';
                header('Location:Admin/menu_dashboard.php');
                exit();
            }
        }
        //accountant
        if($_SESSION['user_type']=='Accountant'){
            $user=new Accountant();
            //checking for old password is correct
            $user_result_set=$user->read_one_accountant($_SESSION['id']);
            if($user_result_set){
                if(strcasecmp($user_result_set->fetch_assoc()['password'],$_POST['old_password'])==0){
                    $user->update_password($_SESSION['id']);
                    $_SESSION['message']='Password has been changed successfully';
                    header('Location:Accountant/menu_dashboard.php');
                    exit();
                }else{
                    $_SESSION['message']='Incorrect password';
                    header('Location:Accountant/menu_dashboard.php');
                    exit();
                }
            }else{
                $_SESSION['message']=='User does not Exists';
                header('Location:Accountant/menu_dashboard.php');
                exit();
            }
        }
        //branch manager
        if($_SESSION['user_type']=='Branch_Manager'){
            $user=new Branch_Manager();
            //checking for old password is correct
            $user_result_set=$user->read_one_branch_manager($_SESSION['id']);
            if($user_result_set){
                if(strcasecmp($user_result_set->fetch_assoc()['password'],$_POST['old_password'])==0){
                    $user->update_password($_SESSION['id']);
                    $_SESSION['message']='Password has been changed successfully';
                    header('Location:BranchManager/menu_dashboard.php');
                    exit();
                }else{
                    $_SESSION['message']='Incorrect password';
                    header('Location:BranchManager/menu_dashboard.php');
                    exit();
                }
            }else{
                $_SESSION['message']=='User does not Exists';
                header('Location:BranchManager/menu_dashboard.php');
                exit();
            }
        }
        //operator
        if($_SESSION['user_type']=='Operator'){
            $user=new Operator();
            //checking for old password is correct
            $user_result_set=$user->read_one_operator($_SESSION['id']);
            if($user_result_set){
                if(strcasecmp($user_result_set->fetch_assoc()['password'],$_POST['old_password'])==0){
                    $user->update_password($_SESSION['id']);
                    $_SESSION['message']='Password has been changed successfully';
                    header('Location:Operator/menu_dashboard.php');
                    exit();
                }else{
                    $_SESSION['message']='Incorrect password';
                    header('Location:Operator/menu_dashboard.php');
                    exit();
                }
            }else{
                $_SESSION['message']=='User does not Exists';
                header('Location:Operator/menu_dashboard.php');
                exit();
            }
        }
        //agent
        if($_SESSION['user_type']=='Agent'){
            $user=new Agent();
            //checking for old password is correct
            $user_result_set=$user->read_one_agent($_SESSION['id']);
            if($user_result_set){
                if(strcasecmp($user_result_set->fetch_assoc()['password'],$_POST['old_password'])==0){
                    $user->update_password($_SESSION['id']);
                    $_SESSION['message']='Password has been changed successfully';
                    header('Location:Agent/menu_dashboard.php');
                    exit();
                }else{
                    $_SESSION['message']='Incorrect password';
                    header('Location:Agent/menu_dashboard.php');
                    exit();
                }
            }else{
                $_SESSION['message']=='User does not Exists';
                header('Location:Agent/menu_dashboard.php');
                exit();
            }
        }
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>

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
  <link rel="stylesheet" href="styles/main.css">
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
    <section id="main-container">
      <div class="container">
        <div class="form-container">
          <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-6">
                        <h2>Reset Password</h2>
                    </div>
                    <div class="col-md-6">
                        <a href="javascript:history.back()" style="float:right"><Button>Back <i class="fa fa-arrow-right" aria-hidden="true"></i></button></a>
                    </div>
                </div>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#policy" class="active">Create Policy</a></li>
                </ul>

                <div class="tab-content">
                    <div id="policy" class="tab-pane fade in show active">
                        <!--Create Transaction form-->
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                            <h4>Reset Password</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="old_password">Old Password</label>
                                    <input type="text" class="form-control" name="old_password" id="old_password">
                                </div>
                                <div class="col-md-4">
                                    <label for="new_password">New Password</label>
                                    <input type="text" class="form-control" name="new_password" id="new_password">
                                </div>
                            </div>
                            <input type="submit" value="Reset" name="submit" class="btn btn-primary">
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

                        