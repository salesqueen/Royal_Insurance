<?php 
  
  error_reporting(0);

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Agent");
  //creating user object
  $user=new Agent();

  //fetching main
  //comission recivable 
  //fetching pending comission recivable result set
  //pending
  $pending_policy_result_set_comission_recivable=$user->read_selective_policy('WHERE my_comission_percentage=0 AND payment_mode="Cash" OR payment_mode="Online"');
  //pending policy via cheque
  function get_cleared_cheque_pending_policy_comission_recivable(){
    //forming cleared cheque pending policy
    $cleared_cheque_pending_policy_array=array();
    $cleared_cheque_result_set=$GLOBALS['user']->read_selective_cheque("WHERE cheque_status='Cleared'");
    if($cleared_cheque_result_set){
        $i=0;
        while($cleared_cheque_result=$cleared_cheque_result_set->fetch_assoc()){
            $cleared_cheque_pending_policy_result_set=$GLOBALS['user']->read_one_policy($cleared_cheque_result['policy_id']);
            if($cleared_cheque_pending_policy_result_set){
                $cleared_cheque_pending_policy_result=$cleared_cheque_pending_policy_result_set->fetch_assoc();
                if($cleared_cheque_pending_policy_result['my_comission_percentage']==0){
                    $cleared_cheque_pending_policy_array[$i]=$cleared_cheque_pending_policy_result;
                    $i++;
                }
            }
        }
    }
    return $cleared_cheque_pending_policy_array;
  }
  //pending policy via cash
  $pending_policy_result_set=$user->read_selective_policy('WHERE comission_percentage=0 AND payment_mode="Cash" OR payment_mode="Online"');
  //pending policy via cheque
  function get_cleared_cheque_pending_policy(){
    //forming cleared cheque pending policy
    $cleared_cheque_pending_policy_array=array();
    $cleared_cheque_result_set=$GLOBALS['user']->read_selective_cheque("WHERE cheque_status='Cleared'");
    if($cleared_cheque_result_set){
        $i=0;
        while($cleared_cheque_result=$cleared_cheque_result_set->fetch_assoc()){
            $cleared_cheque_pending_policy_result_set=$GLOBALS['user']->read_one_policy($cleared_cheque_result['policy_id']);
            if($cleared_cheque_pending_policy_result_set){
                $cleared_cheque_pending_policy_result=$cleared_cheque_pending_policy_result_set->fetch_assoc();
                if($cleared_cheque_pending_policy_result['comission_percentage']==0){
                    $cleared_cheque_pending_policy_array[$i]=$cleared_cheque_pending_policy_result;
                    $i++;
                }
            }
        }
    }
    return $cleared_cheque_pending_policy_array;
  }
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
          //appending both values
          $pending_cheque_array[$i]=array($pending_cheque_result,$policy_result_set->fetch_assoc());
          $i++;
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
            $cleared_cheque_array[$i]=array($cleared_cheque_result,$policy_result_set->fetch_assoc());
            $i++;
        }
      }
      return $cleared_cheque_array;
  }
  //fetching recieved amount array
  function get_cash_recived_array(){
      $cash_recived_array=array();
      //fetching agent result set
      $agent_result_set=$GLOBALS['user']->read_all_agent();
      if($agent_result_set){
          $i=0;
          while($agent_result=$agent_result_set->fetch_assoc()){
              //calculating cash recieved amount based on transaction of each user
              $cash_recived=0;
              $transaction_result_set=$GLOBALS['user']->read_selective_transaction("WHERE agent_id=".$agent_result['id']." AND payment='Recived'");
              if($transaction_result_set){
                  while($transaction_result=$transaction_result_set->fetch_assoc()){
                      $cash_recived+=$transaction_result['amount'];
                  }
              }
              $cash_recived_array[$i]=array($agent_result,$cash_recived);
              $i++;
          }
      }
      return $cash_recived_array;
  }
  //fetching paid amount array
  function get_cash_paid_array(){
    $cash_paid_array=array();
    //fetching agent result set
    $agent_result_set=$GLOBALS['user']->read_all_agent();
    if($agent_result_set){
        $i=0;
        while($agent_result=$agent_result_set->fetch_assoc()){
            //calculating cash paid amount based on transaction of each user
            $cash_paid=0;
            $transaction_result_set=$GLOBALS['user']->read_selective_transaction("WHERE agent_id=".$agent_result['id']." AND payment='Paid'");
            if($transaction_result_set){
                while($transaction_result=$transaction_result_set->fetch_assoc()){
                    $cash_paid+=$transaction_result['amount'];
                }
            }
            $cash_paid_array[$i]=array($agent_result,$cash_paid);
            $i++;
        }
    }
    return $cash_paid_array;
  }

  //fetching substitute
  //fetching agent name
  function get_agent_name($id){
    $agent_result_set=$GLOBALS['user']->read_one_agent($id);
    $agent_result=$agent_result_set->fetch_assoc();
    return $agent_result['name'];
  }
  //fetching branch name
  function get_branch($agent_id){
    $agent_result_set=$GLOBALS['user']->read_one_agent($agent_id);
    $branch_manager_result_set=$GLOBALS['user']->read_one_branch_manager($agent_result_set->fetch_assoc()['branch_manager_id']);
    return $branch_manager_result_set->fetch_assoc()['branch'];
  }

  //form handelling
  //clearance of cheque
  if(isset($_POST['clear_submit'])){
    $GLOBALS['user']->clear_cheque($_POST['cheque_id']);
  }
  //rejection of cheque
  if(isset($_POST['reject_submit'])){
    $GLOBALS['user']->reject_cheque($_POST['cheque_id']);
  }
  //approving policy
  if(isset($_POST['approve_submit'])){
    $user->update_policy(array('policy_number','company_code','product','comission_percentage','comission_type'),$_POST['policy_id']);
  }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Utility</title>

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
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Utilities</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="menu_utilities_comission_payable.php">Comission</a>
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

                <h2>Utility</h2>
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#comission-recivable" class="active">Comission Recivable</a></li>
                    <li><a data-toggle="tab" href="#comission-payable">Comission Payable</a></li>
                    <li><a data-toggle="tab" href="#cheque_status">Cheque Status</a></li>
                    <li><a data-toggle="tab" href="#cash_recived">Cash Recived</a></li>
                    <li><a data-toggle="tab" href="#cash_paid">Cash Paid</a></li>
                </ul>

                <div class="tab-content"> 
                    <a href="create_transaction.php" style="float:right"><button>New Transaction</button></a>
                    <div id="comission-recivable" class="tab-pane fade show in active">
                        <h4>Comission Recivable</h4>
                        <div class="row filter">
                            <div class="col-sm-6">
                                <div class="search-container">
                                    <form action="" method="POST">
                                        <input id="search_1" type="text" placeholder="Search" name="search">
                                    </form>
                                </div>
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
                                        if($pending_policy_result_set_comission_recivable){
                                            while($pending_policy_result_comission_recivable=$pending_policy_result_set_comission_recivable->fetch_assoc()){
                                                echo "<tr>";
                                                echo "  <td>".$pending_policy_result_comission_recivable['od_policy_start_date']."</td>";
                                                echo "  <td>".$pending_policy_result_comission_recivable['company_name']."</td>";
                                                echo "  <td>".$pending_policy_result_comission_recivable['policy_number']."</td>";
                                                echo "  <td>".$pending_policy_result_comission_recivable['customer_name']."</td>";
                                                echo "  <td>".$pending_policy_result_comission_recivable['registration_number']."</td>";
                                                echo "  <td>".$pending_policy_result_comission_recivable['payment_mode']."</td>";
                                                echo "  <td></td>";
                                                echo "  <td></td>";
                                                echo "  <td>".get_agent_name($pending_policy_result_comission_recivable['agent_id'])."</td>";
                                                echo '  <td><Button onclick="policy_open_overlay(this)" id="'.$pending_policy_result_comission_recivable['id'].'">Approve</Button></td>';
                                                echo "</tr>";
                                            }
                                        }
                                        $cleared_cheque_pending_policy_array_comission_recivable=get_cleared_cheque_pending_policy_comission_recivable();
                                        for($i=0;$i<count($cleared_cheque_pending_policy_array_comission_recivable);$i++){
                                            echo "<tr>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array_comission_recivable[$i]['od_policy_start_date']."</td>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array_comission_recivable[$i]['company_name']."</td>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array_comission_recivable[$i]['policy_number']."</td>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array_comission_recivable[$i]['customer_name']."</td>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array_comission_recivable[$i]['registration_number']."</td>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array_comission_recivable[$i]['payment_mode']."</td>";
                                            echo "  <td></td>";
                                            echo "  <td></td>";
                                            echo "  <td>".get_agent_name($cleared_cheque_pending_policy_array_comission_recivable[$i]['agent_id'])."</td>";
                                            echo '  <td><Button onclick="policy_open_overlay(this)" id="'.$cleared_cheque_pending_policy_array_comission_recivable[$i]['id'].'">Approve</Button></td>';
                                            echo "</tr>";
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
                    <div id="comission-payable" class="tab-pane fade">
                        <h4>Comission Payable</h4>
                        <div class="row filter">
                            <div class="col-sm-6">
                                <div class="search-container">
                                    <form action="" method="POST">
                                        <input id="search_2" type="text" placeholder="Search" name="search">
                                    </form>
                                </div>
                            </div>   
                            
                        </div>
                        <div class="table-scroll">
                            <table id="table_2" class="table table-bordered">
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
                                        <th>Approve</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($pending_policy_result_set){
                                            while($pending_policy_result=$pending_policy_result_set->fetch_assoc()){
                                                echo "<tr>";
                                                echo "  <td>".$pending_policy_result['od_policy_start_date']."</td>";
                                                echo "  <td>".$pending_policy_result['company_name']."</td>";
                                                echo "  <td>".$pending_policy_result['policy_number']."</td>";
                                                echo "  <td>".$pending_policy_result['customer_name']."</td>";
                                                echo "  <td>".$pending_policy_result['registration_number']."</td>";
                                                echo "  <td>".$pending_policy_result['payment_mode']."</td>";
                                                echo "  <td></td>";
                                                echo "  <td></td>";
                                                echo "  <td>".get_agent_name($pending_policy_result['agent_id'])."</td>";
                                                echo '  <td><Button onclick="policy_open_overlay(this)" id="'.$pending_policy_result['id'].'">Approve</Button></td>';
                                                echo "</tr>";
                                            }
                                        }
                                        $cleared_cheque_pending_policy_array=get_cleared_cheque_pending_policy();
                                        for($i=0;$i<count($cleared_cheque_pending_policy_array);$i++){
                                            echo "<tr>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array[$i]['od_policy_start_date']."</td>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array[$i]['company_name']."</td>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array[$i]['policy_number']."</td>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array[$i]['customer_name']."</td>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array[$i]['registration_number']."</td>";
                                            echo "  <td>".$cleared_cheque_pending_policy_array[$i]['payment_mode']."</td>";
                                            echo "  <td></td>";
                                            echo "  <td></td>";
                                            echo "  <td>".get_agent_name($cleared_cheque_pending_policy_array[$i]['agent_id'])."</td>";
                                            echo '  <td><Button onclick="policy_open_overlay(this)" id="'.$cleared_cheque_pending_policy_array[$i]['id'].'">Approve</Button></td>';
                                            echo "</tr>";
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
                    <div id="cheque_status" class="tab-pane fade">
                        <h4>Cheque Status</h4>
                        <div class="row filter">
                            <div class="col-sm-6">
                                <div class="search-container">
                                    <form>
                                        <input type="text" id="search_3" placeholder="Search" name="search">
                                    </form>
                                </div>
                            </div>   
                            
                        </div>
                        <div class="table-scroll">
                            <table id="table_3" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Policy Date</th>
                                        <th>Company Name</th>
                                        <th>Policy Number</th>
                                        <th>Customer Name</th>
                                        <th>Registration Number</th>
                                        <th>Cheque Number</th>
                                        <th>Bank Name</th>
                                        <th>Agent Name</th>
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
                                                    echo "  <td>".$pending_cheque_array[$i][1]['od_policy_start_date']."</td>";
                                                    echo "  <td>".$pending_cheque_array[$i][1]['company_name']."</td>";
                                                    echo "  <td>".$pending_cheque_array[$i][1]['policy_number']."</td>";
                                                    echo "  <td>".$pending_cheque_array[$i][1]['customer_name']."</td>";
                                                    echo "  <td>".$pending_cheque_array[$i][1]['registration_number']."</td>";
                                                    echo "  <td>".$pending_cheque_array[$i][0]['cheque_number']."</td>";
                                                    echo "  <td>".$pending_cheque_array[$i][0]['bank_name']."</td>";
                                                    echo "  <td>".get_agent_name($pending_cheque_array[$i][1]['agent_id'])."</td>";
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
                                                    echo "  <td>".$cleared_cheque_array[$i][1]['od_policy_start_date']."</td>";
                                                    echo "  <td>".$cleared_cheque_array[$i][1]['company_name']."</td>";
                                                    echo "  <td>".$cleared_cheque_array[$i][1]['policy_number']."</td>";
                                                    echo "  <td>".$cleared_cheque_array[$i][1]['customer_name']."</td>";
                                                    echo "  <td>".$cleared_cheque_array[$i][1]['registration_number']."</td>";
                                                    echo "  <td>".$cleared_cheque_array[$i][0]['cheque_number']."</td>";
                                                    echo "  <td>".$cleared_cheque_array[$i][0]['bank_name']."</td>";
                                                    echo "  <td>".get_agent_name($cleared_cheque_array[$i][1]['agent_id'])."</td>";
                                                    //action
                                                    echo "  <td>".$cleared_cheque_array[$i][0]['cheque_status']."</td>";
                                                    echo "  <td>".$cleared_cheque_array[$i][0]['cheque_status']."</td>";
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
                    <div id="cash_recived" class="tab-pane fade">
                        <h4>Cash Recived</h4>
                        <div class="row filter">
                            <div class="col-sm-6">
                                <div class="search-container">
                                    <form action="" method="POST">
                                        <input id="search_4" type="text" placeholder="Search" name="search">
                                    </form>
                                </div>
                            </div>   
                            
                        </div>
                        <div class="table-scroll">
                            <table id="table_4" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Agent Name</th>
                                        <th>Branch</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $cash_recived_array=get_cash_recived_array();
                                        if(count($cash_recived_array)>0){
                                            for($i=0;$i<count($cash_recived_array);$i++){
                                                echo "<tr>";
                                                echo "  <td>".get_agent_name($cash_recived_array[$i][0]['id'])."</td>";
                                                echo "  <td>".get_branch($cash_recived_array[$i][0]['id'])."</td>";
                                                echo "  <td>".$cash_recived_array[$i][1]."</td>";
                                                echo "</tr>";
                                            }
                                        }else{
                                            echo "No Records Found";
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
                    <div id="cash_paid" class="tab-pane fade">
                        <h4>Cash Paid</h4>
                        <div class="row filter">
                            <div class="col-sm-6">
                                <div class="search-container">
                                    <form action="" method="POST">
                                        <input id="search_5" type="text" placeholder="Search" name="search">
                                    </form>
                                </div>
                            </div>   
                            
                        </div>
                        <div class="table-scroll">
                            <table id="table_5" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Agent Name</th>
                                        <th>Branch</th>
                                        <th>Amount</th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $cash_paid_array=get_cash_paid_array();
                                        if(count($cash_paid_array)>0){
                                            for($i=0;$i<count($cash_paid_array);$i++){
                                                echo "<tr>";
                                                echo "  <td>".get_agent_name($cash_paid_array[$i][0]['id'])."</td>";
                                                echo "  <td>".get_branch($cash_paid_array[$i][0]['id'])."</td>";
                                                echo "  <td>".$cash_paid_array[$i][1]."</td>";
                                                echo "</tr>";
                                            }
                                        }else{
                                            echo "No Records Found";
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
                <span class="fa fa-times" onclick="close_overlay()"></span>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="" id="view_policy_document_link">View Policy Documents</a>
                </div>
            </div>
            <div class="row">
                    <input type="hidden" id="od_premium" name="od_premium" class="form-control" value="" required="required">
                    <input type="hidden" id="net_premium" name="net_premium" class="form-control" value="" required="required">
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
                        <input type="text" id="company_code" name="company_code" class="form-control" value="" required="required">
                    </div>
                    <div class="col-md-4">
                        <label for="product">Product</label>
                        <input type="text" id="product"  name="product" class="form-control" value="" required="required">
                    </div>
                    <div class="col-md-4">
                        <label for="exampleRadios">Comsission Type</label>
                        <br>
                        <input class="form-check-input" onclick="update_agent_payout_amount()" type="radio" name="comission_type" id="OD" value="OD" checked>
                        <label class="form-check-label" for="OD">OD Premium</label>
                        <br>
                        <input class="form-check-input" onclick="update_agent_payout_amount()" type="radio" name="comission_type" id="NP" value="NP">
                        <label class="form-check-label" for="NP">NET Premium</label>
                    </div>
                    <!--Value not entered by admin-->
                    <input type="hidden" id="policy_id" name="policy_id" value="">    
            </div>
            <div class="row">
                    <div class="col-md-4">
                        <label for="comission_percentage">Agent Payout</label>
                        <input type="text" onchange="update_agent_payout_amount()" id="comission_percentage"  name="comission_percentage" class="form-control" value="" required="required">
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

                        