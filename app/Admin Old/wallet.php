<?php 

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Admin");
  //creating user object
  $user=new Admin();
  //cash recived
  //fetching recived cash data
  function get_cash_recived_result_set(){
    $cash_recived_from_cheque_result_set=$GLOBALS['user']->read_selective_policy("WHERE NOT payment_mode='Cash' AND payment='Paid'");
    return $cash_recived_from_cheque_result_set;
  }
  //cash paid
  //fetching paid cash data through cash for cash
  function get_cash_paid_result_set(){
    $cash_paid_for_cash_result_set=$GLOBALS['user']->read_selective_policy("WHERE payment_mode='Cash' AND payment='Paid'");
    return  $cash_paid_for_cash_result_set;
  }
  //fetching agent name
  function get_agent_name($policy_id){
    $policy_result_set=$GLOBALS['user']->read_one_policy($policy_id);
    $policy_result=$policy_result_set->fetch_assoc();
    $agent_id=$policy_result['agent_id'];
    $agent_result_set=$GLOBALS['user']->read_one_agent($agent_id);
    $agent_result=$agent_result_set->fetch_assoc();
    return $agent_result['name'];
  }

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
                            <a class="nav-link" href="master.php"><span class="fas fa-plus"></span>Master</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_user.php">Manage User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="policy.php">Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="utility.php">Utility</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="comission.php">Comission</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="wallet.php">Wallet</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="cash.php">Cash</a>
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

                <h2>Cash</h2>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#wallet" class="active">Wallet</a></li>
                </ul>

                <div class="tab-content">
                    <div id="wallet" class="tab-pane fade show in active">
                        <h4>Cash Recived</h4>
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
                                        <th>Product</th>
                                        <th>Customer Name</th>
                                        <th>Recieved</th>
                                        <th>Comission Paid</th>
                                        <th>Total</th>
                                        <th>Agent Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $cash_recived_result_set=get_cash_recived_result_set();
                                        $cash_paid_result_set=get_cash_paid_result_set();
                                        if($cash_recived_result_set || $cash_paid_result_set){
                                            //result of cash recived for cash
                                            if($cash_recived_result_set){
                                                while($cash_recived_result=$cash_recived_result_set->fetch_assoc()){
                                                    echo "<tr>";
                                                    echo "  <td>".$cash_recived_result['od_policy_start_date']."</td>";
                                                    echo "  <td>".$cash_recived_result['company_name']."</td>";
                                                    echo "  <td>".$cash_recived_result['policy_number']."</td>";
                                                    echo "  <td>".$cash_recived_result['product']."</td>";
                                                    echo "  <td>".$cash_recived_result['customer_name']."</td>";
                                                    //comission paid and recieved calculation
                                                    if($cash_recived_result['comission_type']=='OD'){
                                                        $comission=$cash_recived_result['od_premium']*($cash_recived_result['comission_percentage']/100);
                                                        echo "  <td>".($cash_recived_result['od_premium']-$comission)."</td>";
                                                        echo "  <td>".$comission."</td>";
                                                    }else{
                                                        $comission=$cash_recived_result['net_premium']*($cash_recived_result['comission_percentage']/100);
                                                        echo "  <td>".($cash_recived_result['net_premium']-$comission)."</td>";
                                                        echo "  <td>".$comission."</td>";
                                                    }
                                                    //cash total
                                                    if($cash_recived_result['comission_type']=='OD'){
                                                        echo "  <td>".$cash_recived_result['od_premium']."</td>";
                                                    }else{
                                                        echo "  <td>".$cash_recived_result['net_premium']."</td>";
                                                    }
                                                    echo "  <td>".get_agent_name($cash_recived_result['id'])."</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                            if($cash_paid_result_set){
                                                
                                            }
                                        }else{
                                            echo "<tr>No records found</tr>";
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
                    <div id="cash-paid" class="tab-pane fade">
                        <h4>Cash Paid</h4>
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
                                        <th>Date</th>
                                        <th>Agent Name</th>
                                        <th>Remarks</th>
                                        <th>Amount</th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $cash_paid_for_cash_result_set=get_cash_paid_for_cash_result_set();
                                        $cash_paid_for_cheque_result_set=get_cash_paid_for_cheque_result_set();
                                        if($cash_paid_for_cash_result_set || $cash_paid_for_cheque_result_set){
                                            //result of cash recived
                                            if($cash_paid_for_cash_result_set){
                                                while($cash_paid_for_cash_result=$cash_paid_for_cash_result_set->fetch_assoc()){
                                                    $cash_result=get_one_cash(get_cash_id($cash_paid_for_cash_result['id']));
                                                    echo "<tr>";
                                                    echo "  <td>".$cash_result['transaction_date']."</td>";
                                                    echo "  <td>".get_agent_name($cash_result['policy_id'])."</td>";
                                                    echo "  <td>".$cash_result['remark']."</td>";
                                                    if($cash_paid_for_cash_result['comission_type']=='OD'){
                                                        echo "  <td>".$cash_paid_for_cash_result['od_premium']*($cash_paid_for_cash_result['comission_percentage']/100)."</td>";
                                                    }else{
                                                        echo "  <td>".$cash_paid_for_cash_result['net_premium']*($cash_paid_for_cash_result['comission_percentage']/100)."</td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                            }
                                            if($cash_paid_for_cheque_result_set){
                                                while($cash_paid_for_cheque_result=$cash_paid_for_cheque_result_set->fetch_assoc()){
                                                    $policy_result=get_one_policy_result($cash_paid_for_cheque_result['policy_id']);
                                                    echo "<tr>";
                                                    echo "  <td>".$cash_paid_for_cheque_result['transaction_date']."</td>";
                                                    echo "  <td>".get_agent_name($cash_paid_for_cheque_result['policy_id'])."</td>";
                                                    echo "  <td>".$cash_paid_for_cheque_result['remark']."</td>";
                                                    if($policy_result['comission_type']=='OD'){
                                                        echo "  <td>".$policy_result['od_premium']*($policy_result['comission_percentage']/100)."</td>";
                                                    }else{
                                                        echo "  <td>".$policy_result['net_premium']*($policy_result['comission_percentage']/100)."</td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                            }
                                        }else{
                                            echo "<tr>No records found</tr>";
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

    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!--Font awesome-->
    <script src="https://use.fontawesome.com/793bc63e83.js"></script><style>.fa{font:normal normal normal 20px/1 FontAwesome;}</style>
    <!--Custom script-->
    <script src="../scripts/search.js"></script>
</body>
</html>

                        


                        