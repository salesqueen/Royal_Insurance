<?php 

  error_reporting(0);

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Operator");

  //creating user object
  $user=new Operator();

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
                        <li class="nav-item active">
                            <a class="nav-link" href="menu_dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu_manage_user_agent.php">Manage User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu_policy.php">Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu_utilities_cheque_status.php">Cheque Status</a>
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
                        <p>
                            <?php 
                                $announcement_result_set=$user->read_announcement();
                                if($announcement_result_set){
                                    echo "\n".$announcement_result_set->fetch_assoc()[Announcement_Contract::get_table_columns()[0]];
                                }
                            ?>
                        </p>
                    </div>
                    <!--Count-->
                    <div class="flexda">

                        <div class="daitem">
                            <h2>Approved Policies <i class="fa fa-file-code-o" aria-hidden="true"></i></h2>
                            <div class="flotext">
                                <h6><?php echo $user->get_approved_policy_count();?></h6>
                            </div>
                        </div>

                        <div class="daitem">
                            <h2>User <i class="fa fa-address-book-o" aria-hidden="true"></i></h2>
                            <div class="flotext">
                                <h6><?php echo $user->get_agent_count_under_branch($_SESSION['id']);?></h6>
                            </div>
                        </div>

                    </div>
                    
                    <div class="flexda">

                        <div class="daitem">
                            <h2>Total Policy Premium <i class="fa fa-heart" aria-hidden="true"></i></h2>
                            <div class="flotext">
                                <h3 class="h3da"><span class="lspda"><?php echo $user->get_total_premium_this_year();?></span>This year</h3>
                                <h3 class="h4da">Last year <span class="rspda"><?php echo $user->get_total_premium_last_year();?></span></h3>
                            </div>
                        </div>

                        <div class="daitem">
                            <h2>Total Policy Premium <i class="fa fa-heart" aria-hidden="true"></i></h2>
                            <div class="flotext">
                                <h3 class="h3da"><span class="lspda"><?php echo $user->get_total_premium_this_month();?></span>This month</h3>
                                <h3 class="h4da">Last yr same month <span class="rspda"><?php echo $user->get_total_premium_last_year_same_month();?></span></h3>
                            </div>
                        </div>

                        <div class="daitem">
                            <h2>Total Policy <i class="fa fa-heart" aria-hidden="true"></i></h2>
                            <div class="flotext">
                                <h3 class="h3da"><span class="lspda"><?php echo $user->get_total_policy_count_this_year();?></span>This year</h3>
                                <h3 class="h4da">Last year <span class="rspda"><?php echo $user->get_total_policy_count_last_year();?></span></h3>
                            </div>
                        </div>

                        <div class="daitem">
                            <h2>Total Policy <i class="fa fa-heart" aria-hidden="true"></i></h2>
                            <div class="flotext">
                                <h3 class="h3da"><span class="lspda"><?php echo $user->get_total_policy_count_this_month();?></span>This month</h3>
                                <h3 class="h4da">Last yr same month <span class="rspda"><?php echo $user->get_policy_count_last_year_same_month();?></span></h3>
                            </div>
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

                        
              