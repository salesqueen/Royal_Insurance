<?php 
  
    error_reporting(0);

    include '../Php/main.php';

    //session handelling
    $session=new Session();
    $session->check_session("Admin");
    //creating user object
    $user=new Admin();

    //filtering
    $constraint="";
    $filter_date_one="";
    $filter_date_two="";
    //filter assigning
    if(isset($_GET['filter_start_date']) && isset($_GET['filter_end_date'])){
        $constraint="AND issue_date BETWEEN '".$_GET['filter_start_date']."' AND '".$_GET['filter_end_date']."'";
        $filter_date_one=$_GET['filter_start_date'];
        $filter_date_two=$_GET['filter_end_date'];
    }

    //fetching main
    //pending policy vai cash
    if($constraint==""){
        $pending_policy_result_set=$user->read_selective_policy('WHERE my_comission_percentage=0 AND (payment_mode="Cash" OR payment_mode="Online")');
    }else{
        $pending_policy_result_set=$user->read_selective_policy('WHERE my_comission_percentage=0 AND (payment_mode="Cash" OR payment_mode="Online") '.$constraint);
    }
    //pending policy via cheque
    $cleared_cheque_pending_policy_array=$user->get_cleared_cheque_pending_policy("my_comission_percentage",$filter_date_one,$filter_date_two);
    //approved policy
    if($constraint==""){
        $approved_policy_result_set=$user->read_selective_policy('WHERE NOT my_comission_percentage=0');
    }else{
        $approved_policy_result_set=$user->read_selective_policy('WHERE NOT my_comission_percentage=0 '.$constraint);
    }

    //form handelling
    //approving policy
    if(isset($_POST['approve_submit'])){
        $user->update_policy(array('my_comission_percentage','my_comission_type'),$_POST['policy_id']);
        header("location:menu_utilities_comission_recivable.php");
    }

    //search submit
    if(isset($_POST['search_submit'])){
        $branch_result_set=$user->read_selective_branch_manager("WHERE branch='".$_POST['search']."'");
        if($branch_result_set){
        $agent_result_set=$user->read_selective_agent('WHERE branch_manager_id='.$branch_result_set->fetch_assoc()['id']); 
        if($agent_result_set){
            $constraint="AND (agent_id=".$agent_result_set->fetch_assoc()['id'];
            while($agent_result=$agent_result_set->fetch_assoc()){
                $constraint=$constraint." OR agent_id=".$agent_result['id'];
            }
            $constraint=$constraint.")";
            $pending_policy_result_set=$user->read_selective_policy("WHERE comission_percentage=0 ".$constraint);
            $approved_policy_result_set=$user->read_selective_policy("WHERE NOT comission_percentage=0 ".$constraint);
        }else{
            $_SESSION['message']='No Results Found';
        }
        }else{
            $constraint="AND (company_code='".$_POST['search']."' OR company_name='".$_POST['search']."')";
            $pending_policy_result_set=$user->read_selective_policy("WHERE comission_percentage=0 ".$constraint);
            $approved_policy_result_set=$user->read_selective_policy("WHERE NOT comission_percentage=0 ".$constraint);
            if($pending_policy_result_set || $approved_policy_result_set){
                //Do nothing
            }else{
                $_SESSION['message']='No Results Found';
            }
        }
    }
    //download
    if(isset($_POST['download_excel'])){
        if(isset($_POST['constraint']) && $_POST['constraint'] !=""){
            $constraint=$_POST['constraint'];
            $pending_policy_result_set=$user->read_selective_policy("WHERE comission_percentage=0 ".$constraint);
            $approved_policy_result_set=$user->read_selective_policy("WHERE NOT comission_percentage=0 ".$constraint);
        }
        $download=new Download();
        $download->policy($pending_policy_result_set,$approved_policy_result_set);
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comission Recivable</title>

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
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Utilities</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item active" href="menu_utilities_comission_recivable.php">Comission Recivable</a>
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
                <!--Heading-->
                    <div class="col-md-6">
                        <h2>Comission Recivable</h2>
                    </div>
                    <div class="col-md-6">
                        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" style="float:right">
                            <input type="hidden" name="constraint" value="<?php echo $constraint?>">
                            <input type="submit" name="download_excel" value="Download Excel">
                        </form>
                    </div>
                </div>

                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#comission-recivable" class="active">Comission Recivable</a></li>
                </ul>

                <div class="tab-content"> 
                    <div id="comission-recivable" class="tab-pane fade show in active">
                        <!--Filter-->
                        <div class="row filter">
                            <div class="col-md-4">
                                <div class="search-container">
                                    <form action="" method="POST">
                                        <input id="search_1" type="text" placeholder="Search" name="search">
                                        <button type="submit" name="search_submit"><i class="fa fa-search"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="GET">
                                    <input type="date" name="filter_start_date" id="filter_start_date" required="required">
                                    <input type="date" name="filter_end_date" id="filter_end_date" placeholder="" required="required">
                                    <button type="submit" name="filter_submit"><i class="fas fa-sort"></i></button>
                                </form>
                            </div>
                        </div>

                        <div class="table-scroll">
                            <table id="table_1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Policy Date</th>
                                        <th>Company Name</th>
                                        <th>Policy Number</th>
                                        <th>Customer Name</th>
                                        <th>Registration Number</th>
                                        <th>Payment Mode</th>
                                        <th>Recivable From</th>
                                        <th>Recivable Amount</th>
                                        <th>Agent Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        //pending policy
                                        if($pending_policy_result_set){
                                            while($pending_policy_result=$pending_policy_result_set->fetch_assoc()){
                                                echo "<tr>";
                                                echo "  <td>".$pending_policy_result['issue_date']."</td>";
                                                echo "  <td>".$pending_policy_result['company_name']."</td>";
                                                echo "  <td>".$pending_policy_result['policy_number']."</td>";
                                                echo "  <td>".$pending_policy_result['customer_name']."</td>";
                                                echo "  <td>".$pending_policy_result['registration_number']."</td>";
                                                echo "  <td>".$pending_policy_result['payment_mode']."</td>";
                                                echo "  <td></td>";
                                                echo "  <td></td>";
                                                echo "  <td>".$user->get_agent_name($pending_policy_result['agent_id'])."</td>";
                                                echo '  <td><Button onclick="policy_open_overlay(this)" id="'.$pending_policy_result['id'].'">Approve</Button></td>';
                                                echo "</tr>";
                                            }
                                        }
                                        for($i=0;$i<count($cleared_cheque_pending_policy_array);$i++){
                                            echo "<tr>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array[$i]['issue_date']."</td>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array[$i]['company_name']."</td>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array[$i]['policy_number']."</td>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array[$i]['customer_name']."</td>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array[$i]['registration_number']."</td>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array[$i]['payment_mode']."</td>";
                                            echo "  <td></td>";
                                            echo "  <td></td>";
                                            echo "  <td>".$user->get_agent_name($cleared_cheque_pending_policy_array[$i]['agent_id'])."</td>";
                                            echo '  <td><Button onclick="policy_open_overlay(this)" id="'.$cleared_cheque_pending_policy_array[$i]['id'].'">Approve</Button></td>';
                                            echo "</tr>";
                                        }
                                        //approved policy
                                        if($approved_policy_result_set){
                                            while($approved_policy_result=$approved_policy_result_set->fetch_assoc()){
                                                echo "<tr>";
                                                echo "  <td>".$approved_policy_result['issue_date']."</td>";
                                                echo "  <td>".$approved_policy_result['company_name']."</td>";
                                                echo "  <td>".$approved_policy_result['policy_number']."</td>";
                                                echo "  <td>".$approved_policy_result['customer_name']."</td>";
                                                echo "  <td>".$approved_policy_result['registration_number']."</td>";
                                                echo "  <td>".$approved_policy_result['payment_mode']."</td>";
                                                //comission calculation
                                                $comission=0;
                                                if($approved_policy_result['my_comission_type']=='OD'){
                                                    $comission=$approved_policy_result['od_premium']*($approved_policy_result['my_comission_percentage']/100);
                                                }
                                                if($approved_policy_result['my_comission_type']=='NP'){
                                                    $comission=$approved_policy_result['net_premium']*($approved_policy_result['my_comission_percentage']/100);
                                                }
                                                echo "  <td>".$approved_policy_result['my_comission_type']."</td>";
                                                echo "  <td>".$comission."</td>";
                                                echo "  <td>".$user->get_agent_name($approved_policy_result['agent_id'])."</td>";
                                                echo '  <td>Approved <a href="view_policy.php?id='.$approved_policy_result['id'].'"><span class="fas fa-eye action_button"></span></a></td>';
                                                echo "</tr>";
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--<nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>-->
                    </div>
                </div>
  
          </div>
        </div>
      </div>
    </section>
    <footer>

    
    </footer>
    <div id='overlay'>
        <div class="container">
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="row close_container">
                <span class="fas fa-times" onclick="close_overlay()"></span>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="" id="view_policy_document_link">View Policy Documents</a>
                </div>
            </div>
            <div class="row">
                    <div class="col-md-4">
                        <label for="policy_number">Policy Number</label>
                        <input type="text" id="policy_number" name="policy_number" class="form-control" value="" required="required">
                    </div>
                    <div class="col-md-4">
                        <label for="company_name">Company Name</label>
                        <input type="text" id="company_name" name="company_name" class="form-control" value="" required="required">
                    </div>
                    <div class="col-md-4">
                        <label for="company_code">Company Code</label>
                        <select id="company_code" name="company_code" class="form-control" required="required">
                            <option value="">Select Company Code</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="product">Product</label>
                        <input type="text" id="product"  name="product" class="form-control" value="" required="required">
                    </div>
                    <div class="col-md-4">
                        <label for="exampleRadios">Comsission Type</label>
                        <br>
                        <input class="form-check-input" onclick="update_agent_payout_amount()" type="radio" name="my_comission_type" id="OD" value="OD" checked>
                        <label class="form-check-label" for="OD">OD Premium</label>
                        <input type="text" id="od_premium" name="od_premium" value="" required="required" readonly="true">
                        <br>
                        <input class="form-check-input" onclick="update_agent_payout_amount()" type="radio" name="my_comission_type" id="NP" value="NP">
                        <label class="form-check-label" for="NP">NET Premium</label>
                        <input type="text" id="net_premium" name="net_premium" value="" required="required" readonly="true">
                    </div>
                    <!--Value not entered by admin-->
                    <input type="hidden" id="policy_id" name="policy_id" value="">    
            </div>
            <div class="row">
                    <div class="col-md-4">
                        <label for="comission_percentage">Agent Payout</label>
                        <input type="number" onchange="update_agent_payout_amount()" id="comission_percentage"  name="my_comission_percentage" class="form-control" value="" required="required">
                    </div>
                    <div class="col-md-4">
                        <label for="comission_amount">Agent Payout Amount</label>
                        <input type="text" id="comission_amount" class="form-control" value="" required="required">
                    </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <input type="submit" value="Approve" name="approve_submit">
                </div>
            </div>
          </form>
        </div>
    </div>
    <!--Message-->
    <div class="alert hide">
        <span class="fas fa-exclamation-circle"></span>
        <span class="msg" id="message"></span>
        <div class="close-btn">
          <span class="fas fa-times"></span>
        </div>
    </div>

  <!-- jQuery and JS bundle w/ Popper.js -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <!--Font awesome-->
  <script src="https://kit.fontawesome.com/831f398f58.js" crossorigin="anonymous"></script>
  <!--Custom script-->
  <!--<script src="../scripts/search.js"></script>-->
  <script src="../scripts/main.js"></script>
  <script src="../scripts/overlay.js"></script>
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

                        