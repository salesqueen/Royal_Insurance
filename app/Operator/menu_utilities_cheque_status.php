<?php 
  
  error_reporting(0);

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Operator");
  //creating user object
  $user=new Operator();

  //filtering
  $constraint="";
  //filter assigning
  if(isset($_GET['filter_start_date']) && isset($_GET['filter_end_date'])){
      $constraint="AND issue_date BETWEEN '".$_GET['filter_start_date']."' AND '".$_GET['filter_end_date']."'";
  }

  //fetching main
  //fetching pending cheque
  function get_pending_cheque_array(){
    $pending_cheque_array=array();
    //fetching pending cheque result set
    $pending_cheque_result_set=$GLOBALS['user']->read_selective_cheque('WHERE cheque_status="Pending"');
    if($pending_cheque_result_set){
      $i=0;
      while($pending_cheque_result=$pending_cheque_result_set->fetch_assoc()){
          //getching policy result set
          $policy_result_set=$GLOBALS['user']->read_one_policy($pending_cheque_result['policy_id']);
          $policy_result=$policy_result_set->fetch_assoc();
          //checking for filter
          if($GLOBALS['constraint']==""){
                //appending both values
                $pending_cheque_array[$i]=array($pending_cheque_result,$policy_result);
                $i++;
          }else{
                if($policy_result['issue_date']>=$_GET['filter_start_date'] && $policy_result['issue_date']<=$_GET['filter_end_date']){
                    //appending both values
                    $pending_cheque_array[$i]=array($pending_cheque_result,$policy_result);
                    $i++;
                }
          }
      }
    }
    return $pending_cheque_array;
  }
  //fetching cleared cheque
  function get_cleared_cheque_array(){
      $cleared_cheque_array=array();
      //fetching cleared cheque result set
      $cleared_cheque_result_set=$GLOBALS['user']->read_selective_cheque('WHERE NOT cheque_status="Pending"');
      if($cleared_cheque_result_set){
        $i=0;
        while($cleared_cheque_result=$cleared_cheque_result_set->fetch_assoc()){
            $policy_result_set=$GLOBALS['user']->read_one_policy($cleared_cheque_result['policy_id']);
            $policy_result=$policy_result_set->fetch_assoc();
            //checking filter
            if($GLOBALS['constraint']==""){
                //appending both values
                $cleared_cheque_array[$i]=array($cleared_cheque_result,$policy_result);
                $i++;
            }else{
                if($policy_result['issue_date']>=$_GET['filter_start_date'] && $policy_result['issue_date']<=$_GET['filter_end_date']){
                    //appending both values
                    $cleared_cheque_array[$i]=array($cleared_cheque_result,$policy_result);
                    $i++;
                }
            }
        }
      }
      return $cleared_cheque_array;
  }

  //form handelling
  //clearance of cheque
  if(isset($_POST['clear_submit'])){
    $user->clear_cheque($_POST['cheque_id']);
    header("Location:menu_utilities_cheque_status.php");
  }
  //rejection of cheque
  if(isset($_POST['reject_submit'])){
    $user->reject_cheque($_POST['cheque_id']);
    header("Location:menu_utilities_cheque_status.php");
  }
  //make cheque pending
  if(isset($_POST['suspend_submit'])){
    $user->suspend_cheque($_POST['cheque_id_suspend']);
    //header("Location:menu_utilities_cheque_status.php");
  }
  if(isset($_POST['download_excel'])){
      $download=new Download();
      $download->cheque_status(get_pending_cheque_array(),get_cleared_cheque_array());
      header("Location:menu_utilities_cheque_status.php");
  }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cheque Status</title>

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
                        <li class="nav-item">
                            <a class="nav-link" href="menu_manage_user_agent.php">Manage User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu_policy.php">Policy</a>
                        </li>
                        <li class="nav-item active">
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
        <div class="form-container"> 
          <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-6">
                        <h2>Cheque Status</h2>
                    </div>
                    <div class="col-md-6">
                        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" style="float:right">
                            <input type="submit" name="download_excel" value="Download Excel">
                        </form>
                    </div>
                </div>

                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#cheque_status" class="active">Cheque Status</a></li>
                </ul>

                <div class="tab-content">
                    <div id="cheque_status" class="tab-pane fade show active">
                        <!--Filter-->
                        <div class="row filter">
                            <div class="col-md-4">
                                <div class="search-container">
                                    <form action="" method="POST">
                                        <input id="search_1" type="text" placeholder="Search" name="search">
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="GET">
                                    <input type="date" name="filter_start_date" id="filter_start_date" required="required">
                                    <input type="date" name="filter_end_date" id="filter_end_date" placeholder="" required="required">
                                    <button type="submit" name="filter_submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="table-scroll">
                            <table id="table_1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Policy Date</th>
                                        <th>Company Name</th>
                                        <th>Policy Number</th>
                                        <th>Customer Name</th>
                                        <th>Registration Number</th>
                                        <th>Cheque Number</th>
                                        <th>Bank Name</th>
                                        <th>User Name</th>
                                        <th>Branch</th>
                                        <!--Action-->
                                        <th>Clear</th>
                                        <th>Reject</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $pending_cheque_array=get_pending_cheque_array();
                                        $cleared_cheque_array=get_cleared_cheque_array();
                                        if(count($pending_cheque_array)>0 || count($cleared_cheque_array)>0){
                                            if(count($pending_cheque_array)>0){
                                                for($i=0;$i<count($pending_cheque_array);$i++){
                                                    echo "<tr>";
                                                    echo "  <td>".$pending_cheque_array[$i][1]['issue_date']."</td>";
                                                    echo "  <td>".$pending_cheque_array[$i][1]['company_name']."</td>";
                                                    echo "  <td>".$pending_cheque_array[$i][1]['policy_number']."</td>";
                                                    echo "  <td>".$pending_cheque_array[$i][1]['customer_name']."</td>";
                                                    echo "  <td>".$pending_cheque_array[$i][1]['registration_number']."</td>";
                                                    echo "  <td>".$pending_cheque_array[$i][0]['cheque_number']."</td>";
                                                    echo "  <td>".$pending_cheque_array[$i][0]['bank_name']."</td>";
                                                    echo "  <td>".$user->get_agent_name($pending_cheque_array[$i][1]['agent_id'])."</td>";
                                                    echo "  <td>".$user->get_branch($pending_cheque_array[$i][1]['agent_id'])."</td>";
                                                    //action
                                                    echo '  <td>';
                                                    echo '      <form action="'.$_SERVER['PHP_SELF'].'" method="POST">';
                                                    echo '          <input type="hidden" name="cheque_id" value="'.$pending_cheque_array[$i][0]['id'].'">';
                                                    echo '          <input type="submit" name="clear_submit" value="Clear">';
                                                    echo '      </form>';
                                                    echo '   </td>';
                                                    echo '  <td>';
                                                    echo '      <form action="'.$_SERVER['PHP_SELF'].'" method="POST">';
                                                    echo '          <input type="hidden" name="cheque_id" value="'.$pending_cheque_array[$i][0]['id'].'">';
                                                    echo '          <input type="submit" name="reject_submit" value="Reject" style="background:red">';
                                                    echo '      </form>';
                                                    echo '   </td>';
                                                    echo "</tr>";
                                                }
                                            }
                                            if(count($cleared_cheque_array)>0){
                                                for($i=0;$i<count($cleared_cheque_array);$i++){
                                                    echo "<tr>";
                                                    echo "  <td>".$cleared_cheque_array[$i][1]['issue_date']."</td>";
                                                    echo "  <td>".$cleared_cheque_array[$i][1]['company_name']."</td>";
                                                    echo "  <td>".$cleared_cheque_array[$i][1]['policy_number']."</td>";
                                                    echo "  <td>".$cleared_cheque_array[$i][1]['customer_name']."</td>";
                                                    echo "  <td>".$cleared_cheque_array[$i][1]['registration_number']."</td>";
                                                    echo "  <td>".$cleared_cheque_array[$i][0]['cheque_number']."</td>";
                                                    echo "  <td>".$cleared_cheque_array[$i][0]['bank_name']."</td>";
                                                    echo "  <td>".$user->get_agent_name($cleared_cheque_array[$i][1]['agent_id'])."</td>";
                                                    echo "  <td>".$user->get_branch($cleared_cheque_array[$i][1]['agent_id'])."</td>";
                                                    //action
                                                    echo "  <td>".$cleared_cheque_array[$i][0]['cheque_status']."</td>";
                                                    echo '  <td>';
                                                    echo '      <form action="'.$_SERVER['PHP_SELF'].'" method="POST">';
                                                    echo '          <input type="hidden" name="cheque_id_suspend" value="'.$cleared_cheque_array[$i][0]['id'].'">';
                                                    echo '          <input type="submit" name="suspend_submit" value="Suspend" style="background:orange">';
                                                    echo '      </form>';
                                                    echo '   </td>';
                                                    echo "</tr>";
                                                }
                                            }
                                        }else{
                                            echo "No records found";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
  
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
  <!--Custom script-->
  <script src="../scripts/search.js"></script>
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

                        