<?php 

  error_reporting(0);

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Accountant");
  //creating user object
  $user=new Accountant();

  //filtering
  $constraint="";
  //filter assigning
  if(isset($_GET['filter_start_date']) && isset($_GET['filter_end_date'])){
      $constraint="AND issue_date BETWEEN '".$_GET['filter_start_date']."' AND '".$_GET['filter_end_date']."'";
  }

  //fetching main
  //fetching approved policy result set of a particular agent
  function get_approved_policy_result_set($agent_id){
    if($GLOBALS['constraint']==""){
      $approved_policy_result_set=$GLOBALS['user']->read_selective_policy("WHERE NOT comission_percentage=0 AND agent_id=".$agent_id);
    }else{
      $approved_policy_result_set=$GLOBALS['user']->read_selective_policy("WHERE NOT comission_percentage=0 AND agent_id=".$agent_id." ".$GLOBALS['constraint']);
    }
    return $approved_policy_result_set;
  }
  //fetching transaction history of a particular agent
  function get_transaction_result_set($agent_id){
    if($GLOBALS['constraint']==""){
      $transaction_result_set=$GLOBALS['user']->read_selective_transaction("WHERE agent_id=".$agent_id);
    }else{
      $transaction_result_set=$GLOBALS['user']->read_selective_transaction("WHERE agent_id=".$agent_id." AND date BETWEEN '".$_GET['filter_start_date']."' AND '".$_GET['filter_end_date']."'");
    }
    return $transaction_result_set; 
  }
  
  //fetching sub
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Transaction</title>

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
                        <h2>Transactions of <?php echo get_agent_name($_GET['agent_id']);?></h2>
                    </div>
                    <div class="col-md-6">
                        <a href="menu_wallet.php" style="float:right"><Button>Back <i class="fa fa-arrow-right" aria-hidden="true"></i></button></a>
                    </div>
                </div>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#wallet" class="active">Transaction</a></li>
                </ul>

                <div class="tab-content">
                    <div id="wallet" class="tab-pane fade show in active">
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
                                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET">
                                    <input type="date" name="filter_start_date" id="filter_start_date" required="required">
                                    <input type="date" name="filter_end_date" id="filter_end_date" placeholder="" required="required">
                                    <input type="hidden" name="agent_id" value="<?php echo $_GET['agent_id'];?>" required="required">
                                    <button type="submit" name="filter_submit"><i class="fa fa-sort" aria-hidden="true"></i></button>
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
                                        <th>Registration Number</th>
                                        <th>Product</th>
                                        <th>Customer Name</th>
                                        <th>Payment Mode</th>
                                        <th>Total Premium</th>
                                        <th>Payable</th>
                                        <th>Recivable</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $approved_policy_result_set=get_approved_policy_result_set($_GET['agent_id']);
                                        $transaction_result_set=get_transaction_result_set($_GET['agent_id']);
                                        $sort=false;
                                        //checking whether is to sort or not
                                        if($transaction_result_set && $approved_policy_result_set){
                                            $sort=true;
                                        }
                                        //sorting
                                        if($sort){
                                            //sorting and viewing based on date
                                            $sorted_array_of_policy_and_transaction_array=array();
                                            //initilizing two arrays
                                            $approved_policy_array=array();
                                            $transaction_array=array();
                                            //adding policy result to the array
                                            $i=0;
                                            while($approved_policy_result=$approved_policy_result_set->fetch_assoc()){
                                                $approved_policy_array[$i]=array('Policy',$approved_policy_result);
                                                $i++;
                                            }
                                            //adding transaction result to the array
                                            $i=0;
                                            while( $transaction_result= $transaction_result_set->fetch_assoc()){
                                                $transaction_array[$i]=array('Transaction',$transaction_result);
                                                $i++;
                                            }
                                            //sorting arrays based on dates
                                            $approved_policy_array_index=0;
                                            $transaction_array_index=0;
                                            $sorted_array_of_policy_and_transaction_array_index=0;

                                            while(true){
                                                //base condition
                                                if($approved_policy_array_index>=count($approved_policy_array) && $transaction_array_index>=count($transaction_array)){
                                                    break;
                                                }else{
                                                    //iteration
                                                    //if one has array has been empty
                                                    //approved policy array is over
                                                    if($approved_policy_array_index>=count($approved_policy_array)){
                                                        //copying value of non empty array to the sorted array
                                                        for($i=$transaction_array_index;$i<count($transaction_array);$i++){
                                                            $sorted_array_of_policy_and_transaction_array[ $sorted_array_of_policy_and_transaction_array_index]=$transaction_array[$transaction_array_index];
                                                            $sorted_array_of_policy_and_transaction_array_index++;
                                                            $transaction_array_index++;
                                                        }
                                                    }
                                                    //transaction array is over
                                                    else if($transaction_array_index>=count($transaction_array)){
                                                        //copying value of non empty array to the sorted array
                                                        for($i=$approved_policy_array_index;$i<count($approved_policy_array);$i++){
                                                            $sorted_array_of_policy_and_transaction_array[ $sorted_array_of_policy_and_transaction_array_index]=$approved_policy_array[$approved_policy_array_index];
                                                            $sorted_array_of_policy_and_transaction_array_index++;
                                                            $approved_policy_array_index++;
                                                        }
                                                    }else{
                                                        //if both has values
                                                        if($approved_policy_array[$approved_policy_array_index][1]['od_policy_start_date']>$transaction_array[$transaction_array_index][1]['date']){
                                                            $sorted_array_of_policy_and_transaction_array[$sorted_array_of_policy_and_transaction_array_index]=$approved_policy_array[$approved_policy_array_index];
                                                            $sorted_array_of_policy_and_transaction_array_index++;
                                                            $approved_policy_array_index++;
                                                        }else{
                                                            $sorted_array_of_policy_and_transaction_array[$sorted_array_of_policy_and_transaction_array_index]=$transaction_array[$transaction_array_index];
                                                            $sorted_array_of_policy_and_transaction_array_index++;
                                                            $transaction_array_index++;
                                                        }
                                                    }
                                                }
                                            }
                                            //displaying the sorted content
                                            for($i=0;$i<count($sorted_array_of_policy_and_transaction_array);$i++){
                                                if($sorted_array_of_policy_and_transaction_array[$i][0]=='Transaction'){
                                                    if($transaction_result['payment']!='Office_Expenses_Request'){
                                                            echo "<tr>";
                                                            echo "  <td>".$transaction_result['date']."</td>";
                                                            echo "  <td>".$transaction_result['payment']."</td>";
                                                            echo "  <td>".$transaction_result['remark']."</td>";
                                                            echo "  <td></td>";
                                                            echo "  <td></td>";
                                                            echo "  <td></td>";
                                                            echo "  <td></td>";
                                                            echo "  <td></td>";
                                                            echo "  <td></td>";
                                                            echo "  <td></td>";
                                                            if($transaction_result['payment']=='Recived'){
                                                                echo "  <td>-".$transaction_result['amount']."</td>";
                                                            }elseif($transaction_result['payment']=='Paid'){
                                                                echo "  <td>+".$transaction_result['amount']."</td>";
                                                            }elseif($transaction_result['payment']=='Office_Expenses'){
                                                                echo "  <td>-".$transaction_result['amount']."</td>";
                                                            }
                                                            echo "</tr>";
                                                        }
                                                }else{
                                                    echo "<tr>";
                                                    echo "  <td>".$sorted_array_of_policy_and_transaction_array[$i][1]['issue_date']."</td>";
                                                    echo "  <td>".$sorted_array_of_policy_and_transaction_array[$i][1]['company_name']."</td>";
                                                    echo "  <td>".$sorted_array_of_policy_and_transaction_array[$i][1]['policy_number']."</td>";
                                                    echo "  <td>".$sorted_array_of_policy_and_transaction_array[$i][1]['registration_number']."</td>";
                                                    echo "  <td>".$sorted_array_of_policy_and_transaction_array[$i][1]['product']."</td>";
                                                    echo "  <td>".$sorted_array_of_policy_and_transaction_array[$i][1]['customer_name']."</td>";
                                                    echo "  <td>".$sorted_array_of_policy_and_transaction_array[$i][1]['payment_mode']."</td>";
                                                    echo "  <td>".$sorted_array_of_policy_and_transaction_array[$i][1]['total_premium']."</td>";
                                                    //calculating comission
                                                    $comission=0;
                                                    if($sorted_array_of_policy_and_transaction_array[$i][1]['comission_type']=="OD"){
                                                        $comission=$sorted_array_of_policy_and_transaction_array[$i][1]['od_premium']*($sorted_array_of_policy_and_transaction_array[$i][1]['comission_percentage']/100);
                                                    }
                                                    if($sorted_array_of_policy_and_transaction_array[$i][1]['comission_type']=="NP"){
                                                        $comission=$sorted_array_of_policy_and_transaction_array[$i][1]['net_premium']*($sorted_array_of_policy_and_transaction_array[$i][1]['comission_percentage']/100);
                                                    }
                                                    echo "  <td>".$comission."</td>";
                                                    //only displaying recivable for cash
                                                    if($sorted_array_of_policy_and_transaction_array[$i][1]['payment_mode']=='Cash'){
                                                        echo "  <td>".($sorted_array_of_policy_and_transaction_array[$i][1]['total_premium']-$comission)."</td>";
                                                    }else{
                                                        echo "  <td>0</td>";
                                                    }
                                                    //displaying balance
                                                    if($sorted_array_of_policy_and_transaction_array[$i][1]['payment_mode']=='Cash'){
                                                        echo "  <td>+".($sorted_array_of_policy_and_transaction_array[$i][1]['total_premium']-$comission)."</td>";
                                                    }else{
                                                        echo "  <td>-".$comission."</td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                            }
                                            //displaying balance
                                            echo "<tr>";
                                            echo "  <td>".date('Y-m-d')."</td>";
                                            echo "  <td><b>Balance</b></td>";
                                            echo "  <td></td>";
                                            echo "  <td></td>";
                                            echo "  <td></td>";
                                            echo "  <td></td>";
                                            echo "  <td></td>";
                                            echo "  <td></td>";
                                            echo "  <td></td>";
                                            echo "  <td></td>";
                                            echo "  <td>".$user->get_wallet_amount($_GET['agent_id'])."</td>";
                                            echo "</tr>";
                                        }else{
                                            //no sorting required
                                            if($transaction_result_set || $approved_policy_result_set){
                                                if($approved_policy_result_set){
                                                    while($approved_policy_result=$approved_policy_result_set->fetch_assoc()){
                                                        echo "<tr>";
                                                        echo "  <td>".$approved_policy_result['issue_date']."</td>";
                                                        echo "  <td>".$approved_policy_result['company_name']."</td>";
                                                        echo "  <td>".$approved_policy_result['policy_number']."</td>";
                                                        echo "  <td>".$approved_policy_result['registration_number']."</td>";
                                                        echo "  <td>".$approved_policy_result['product']."</td>";
                                                        echo "  <td>".$approved_policy_result['customer_name']."</td>";
                                                        echo "  <td>".$approved_policy_result['payment_mode']."</td>";
                                                        echo "  <td>".$approved_policy_result['total_premium']."</td>";
                                                        //calculating comission
                                                        $comission=0;
                                                        if($approved_policy_result['comission_type']=='OD'){
                                                            $comission=$approved_policy_result['od_premium']*($approved_policy_result['comission_percentage']/100);
                                                        }
                                                        if($approved_policy_result['comission_type']=='NP'){
                                                            $comission=$approved_policy_result['net_premium']*($approved_policy_result['comission_percentage']/100);
                                                        }
                                                        echo "  <td>".$comission."</td>";
                                                        //only showing recivable for cash                                                                          
                                                        if($approved_policy_result['payment_mode']=="Cash"){
                                                            echo "  <td>".($approved_policy_result['total_premium']-$comission)."</td>";
                                                        }else{
                                                            echo "  <td>0</td>";
                                                        }
                                                        //balance
                                                        if($approved_policy_result['payment_mode']=='Cash'){
                                                            echo "  <td>+".($approved_policy_result['total_premium']-$comission)."</td>";
                                                        }else{
                                                            echo "  <td>-".$comission."</td>";
                                                        }
                                                        echo "</tr>";
                                                    }

                                                    //displaying balance
                                                    echo "<tr>";
                                                    echo "  <td>".date('Y-m-d')."</td>";
                                                    echo "  <td><b>Balance</b></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td>".$user->get_wallet_amount($_GET['agent_id'])."</td>";
                                                    echo "</tr>";
                                                }
                                                if($transaction_result_set){
                                                    while($transaction_result=$transaction_result_set->fetch_assoc()){
                                                        if($transaction_result['payment']!='Office_Expenses_Request'){
                                                            echo "<tr>";
                                                            echo "  <td>".$transaction_result['date']."</td>";
                                                            echo "  <td>".$transaction_result['payment']."</td>";
                                                            echo "  <td>".$transaction_result['remark']."</td>";
                                                            echo "  <td></td>";
                                                            echo "  <td></td>";
                                                            echo "  <td></td>";
                                                            echo "  <td></td>";
                                                            echo "  <td></td>";
                                                            echo "  <td></td>";
                                                            echo "  <td></td>";
                                                            if($transaction_result['payment']=='Recived'){
                                                                echo "  <td>-".$transaction_result['amount']."</td>";
                                                            }elseif($transaction_result['payment']=='Paid'){
                                                                echo "  <td>+".$transaction_result['amount']."</td>";
                                                            }elseif($transaction_result['payment']=='Office_Expenses'){
                                                                echo "  <td>-".$transaction_result['amount']."</td>";
                                                            }
                                                            echo "</tr>";
                                                        }
                                                    }

                                                    //displaying balance
                                                    echo "<tr>";
                                                    echo "  <td>".date('Y-m-d')."</td>";
                                                    echo "  <td><b>Balance</b></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td></td>";
                                                    echo "  <td>".$user->get_wallet_amount($_GET['agent_id'])."</td>";
                                                    echo "</tr>";
                                                }
                                            }else{
                                                echo "<tr>No records found</tr>";
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
                <span class="fa fa-times" onclick="close_overlay()"></span>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="agent_name">Agent</label>
                    <select onchange="update_tp_policy_end_date()" name="tp_policy_period" class="form-control" id="tp_policy_period" required="required">
                        <option value="<?php echo $result['tp_policy_period'];?>"><?php echo $result['tp_policy_period'];?></option>
                    </select>
                    <input type="text" id="agent_name" name="agent_name" placeholder="Agent Name" class="form-control" value="" required="required">
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
  <script src="../scripts/overlay.js"></script>
</body>
</html>

                        


                        