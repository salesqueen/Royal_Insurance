<?php 

  error_reporting(0);

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Agent");

  //creating user object
  $user=new Agent();

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
    <style>
        .card{
            padding:20px 34px;
            background: rgba(0,0,0,.04);
            border: 0;
            border: 1px solid rgba(0,0,0,.1);
        }
        .wallet{
            background: rgba(0,255,255,.02);
            border-radius: 5px;
            padding:10px 34px;
            border: 1px solid rgba(0,100,255,.2);
            display: flex;
            margin-top: 10px;
            margin-bottom: 10px;
            justify-content: center;
        }
        .wallet h1{
            font-size: 60px;
        }
        .wallet h2{
            font-size: 60px;
            font-family: var(--monserrat);
            margin-top:5px;
        }
        
        .wallet div{
            margin-right:20px;
            text-align:center;
        }
        .cash{
            background: rgba(0,0,255,.06);
            padding: 10px 34px;
            border-radius: 5px;
            border: 1px solid rgba(0,0,255,.1);
        }
        .cash h1{
            margin-top:14px;
            font-size:24px;
        }
        .comission{
            background: rgba(0,0,255,.06);
            padding: 10px 34px;
            border-radius: 5px;
            border: 1px solid rgba(0,0,255,.1);
        }
        .comission h1{
            margin-top:14px;
            font-size:24px;
        }
    </style>
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
                    <div class="row">
                        <div class="col-md-12 card">
                            <h2><i class="fa fa-file-powerpoint-o" aria-hidden="true"></i> <?php echo $user->get_approved_policy_count();?></h2>
                            <p>Approved Policies</p>
                        </div>
                    </div>
                    <div class="row policy-details">
                        <div class="col-md-3">
                            <p>Total Policy Premium this year</p>
                            <h4><b><?php echo $user->get_total_premium_this_year();?></b></h4>
                            <div class="d-flex">
                                <div class="bg-primary p-1 rounded mr-3 text-light"><?php echo $user->get_total_policy_count_this_year();?></div><span>Policy</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <p>Total Policy Premium Last year</p>
                            <h4><b><?php echo $user->get_total_premium_last_year();?></b></h4>
                            <div class="d-flex">
                                <div class="bg-primary p-1 rounded mr-3 text-light"><?php echo $user->get_total_policy_count_last_year();?></div><span>Policy</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <p>Total Policy Premium this Month</p>
                            <h4><b><?php echo $user->get_total_premium_this_month();?></b></h4>
                            <div class="d-flex">
                                <div class="bg-primary p-1 rounded mr-3 text-light"><?php echo $user->get_total_policy_count_this_month();?></div><span>Policy</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <p>Total Policy Last year same Month</p>
                            <h4><b><?php echo $user->get_total_premium_last_year_same_month();?></b></h4>
                            <div class="d-flex">
                                <div class="bg-primary p-1 rounded mr-3 text-light"><?php echo $user->get_policy_count_last_year_same_month();?></div><span>Policy</span>
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

                        
              