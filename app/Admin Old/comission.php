<?php 

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Admin");
  //creating user object
  $user=new Admin();
  
  
  //fetching cash id
  function get_cash_id($policy_id){
    $cash_result_set=$GLOBALS['user']->read_selective_cash("WHERE policy_id=".$policy_id);
    $cash_result=$cash_result_set->fetch_assoc();
    return $cash_result['id'];
  }
  //form handelling
  //updating recieved cash
  if(isset($_POST['recived_submit'])){
      $user->update_cash(get_cash_id($_POST['policy_id']),$_POST['amount']);
      $user->custom_query("UPDATE policy SET payment='Paid' WHERE id=".$_POST['policy_id']);
  }
  //updating paid cash
  if(isset($_POST['paid_submit'])){
    $user->update_cash(get_cash_id($_POST['policy_id']),$_POST['amount']);
    $user->custom_query("UPDATE policy SET payment='Paid' WHERE id=".$_POST['policy_id']);
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
                            <a class="nav-link active" href="create.php"><span class="fas fa-plus"></span>Create</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage.php">Manage</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="policy.php">Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cheque.php">Cheque</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="comission.php">Comission</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="wallet.php">Wallet</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cash.php">Cash</a>
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

                <h2>Comission</h2>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#comission-recivable" class="active">Comission Recivable</a></li>
                    <li><a data-toggle="tab" href="#comission-payable">Comission Payable</a></li>
                </ul>

                <div class="tab-content">
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
                                        <th>Recivable From</th>
                                        <th>Recivable Amount</th>
                                        <th>Agent Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $recivable_policy_result_set=get_recivable_policy_result_set();
                                        if($recivable_policy_result_set){
                                            while($recivable_policy_result=$recivable_policy_result_set->fetch_assoc()){
                                                echo "<tr>";
                                                echo "  <td>".$recivable_policy_result['od_policy_start_date']."</td>";
                                                echo "  <td>".$recivable_policy_result['company_name']."</td>";
                                                echo "  <td>".$recivable_policy_result['policy_number']."</td>";
                                                echo "  <td>".$recivable_policy_result['customer_name']."</td>";
                                                echo "  <td>".$recivable_policy_result['registration_number']."</td>";
                                                echo "  <td>".$recivable_policy_result['payment_mode']."</td>";
                                                //calculating recievable amount
                                                if($recivable_policy_result['comission_type']=='NP'){
                                                    $comission_amount=$recivable_policy_result['net_premium']*($recivable_policy_result['comission_percentage']/100);
                                                    $recivable_amount=$recivable_policy_result['net_premium']-$comission_amount;
                                                }else{
                                                    $comission_amount=$recivable_policy_result['od_premium']*($recivable_policy_result['comission_percentage']/100);
                                                    $recivable_amount=$recivable_policy_result['od_premium']-$comission_amount;
                                                }
                                                echo "  <td>".$recivable_amount."</td>";
                                                echo "  <td>".get_agent_name($recivable_policy_result['agent_id'])."</td>";  
                                                //actions
                                                echo '  <td>';
                                                echo '      <form action="'.$_SERVER['PHP_SELF'].'" method="POST">';
                                                echo '          <input type="hidden" name="amount" value="'.$recivable_amount.'">';
                                                echo '          <input type="hidden" name="policy_id" value="'.$recivable_policy_result['id'].'">';
                                                echo '          <input type="submit" name="recived_submit" value="Recived">';
                                                echo '      </form>';
                                                echo '   </td>';
                                                echo '  </tr>';
                                            }
                                        }else{
                                            echo "No records found";
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
                                        <th>Recivable From</th>
                                        <th>Payable Amount</th>
                                        <th>Agent Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $payable_policy_result_set=get_payable_policy_result_set();
                                        if($payable_policy_result_set){
                                            while($payable_policy_result=$payable_policy_result_set->fetch_assoc()){
                                                echo "<tr>";
                                                echo "  <td>".$payable_policy_result['od_policy_start_date']."</td>";
                                                echo "  <td>".$payable_policy_result['company_name']."</td>";
                                                echo "  <td>".$payable_policy_result['policy_number']."</td>";
                                                echo "  <td>".$payable_policy_result['customer_name']."</td>";
                                                echo "  <td>".$payable_policy_result['registration_number']."</td>";
                                                echo "  <td>".$payable_policy_result['payment_mode']."</td>";
                                                //calculating payable amount
                                                if($payable_policy_result['comission_type']=='NP'){
                                                    $comission_amount=$payable_policy_result['net_premium']*($payable_policy_result['comission_percentage']/100);
                                                }else{
                                                    $comission_amount=$payable_policy_result['od_premium']*($payable_policy_result['comission_percentage']/100);
                                                }
                                                echo "  <td>".$comission_amount."</td>";
                                                echo "  <td>".get_agent_name($payable_policy_result['agent_id'])."</td>";
                                                //actions
                                                echo '  <td>';
                                                echo '      <form action="'.$_SERVER['PHP_SELF'].'" method="POST">';
                                                echo '          <input type="hidden" name="amount" value="'.$comission_amount.'">';
                                                echo '          <input type="hidden" name="policy_id" value="'.$payable_policy_result['id'].'">';
                                                echo '          <input type="submit" name="paid_submit" value="Paid">';
                                                echo '      </form>';
                                                echo '   </td>';
                                                echo "</tr>";
                                            }
                                        }else{
                                            echo "No records found";
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
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <!--Font awesome-->
  <script src="https://kit.fontawesome.com/831f398f58.js" crossorigin="anonymous"></script>
  <!--Custom javascript-->
  <script src="../scripts/search.js"></script>
</body>
</html>

                        