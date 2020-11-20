<?php 

  error_reporting(0);

  include '../Php/main.php';

  //checking session
  $session=new Session();
  $session->check_session("admin");
  //creating admin object
  $admin=new Admin();
  //fetching pending policy details for cash
  function get_pending_policy_result_set(){
      $pending_policy_result_set=$GLOBALS['admin']->read_selective_policy("WHERE comission_percentage=0 AND payment_mode='Cash'");
      return $pending_policy_result_set;
  }
  //fetching data with cleared cheque and pending policy
  //fetching one policy
  function get_one_policy($id){
      $policy_result_set=$GLOBALS['admin']->read_one_policy($id);
      $policy_result=$policy_result_set->fetch_assoc();
      if($policy_result['comission_percentage']==0){
          return $policy_result;
      }else{
          return false;
      }
  }
  //fetching cheque cleared
  function get_cleared_cheque_pending_policy(){
    //forming cleared cheque pending policy
    $cleared_cheque_pending_policy_array=array();
    $cleared_cheque_result_set=$GLOBALS['admin']->read_selective_cheque("WHERE cheque_status='Cleared'");
    if($cleared_cheque_result_set){
        $i=0;
        while($cleared_cheque_result=$cleared_cheque_result_set->fetch_assoc()){
            $cleared_cheque_pending_policy=get_one_policy($cleared_cheque_result['policy_id']);
            if($cleared_cheque_pending_policy){
                $cleared_cheque_pending_policy_array[$i]=$cleared_cheque_pending_policy;
                $i++;
            }
        }
    }
    return $cleared_cheque_pending_policy_array;
  }
  //fetching approved policy details
  function get_approved_policy_result_set(){
    $approved_policy_result_set=$GLOBALS['admin']->read_selective_policy("WHERE NOT comission_percentage=0");
    return $approved_policy_result_set;
  }
  //fetching agent name
  function get_agent_name($id){
    $agent_result_set=$GLOBALS['admin']->read_one_agent($id);
    $agent_result=$agent_result_set->fetch_assoc();
    return $agent_result['name'];
  }
  //getting one policy result
  function get_policy_result($policy_id){
      $policy_result_set=$_GLOBALS['admin']->read_one_policy($policy_id);
      $policy_result=$policy_result_set->fetch_assoc();
      return $policy_result;
  }
  //form action
  if(isset($_POST['approve_submit'])){
      $GLOBALS['admin']->update_policy(array('policy_number','company_code','product','comission_percentage'),$_POST['policy_id']);
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
                    <p>Name</p>
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

                <h2>Policy</h2>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#pending" class="active">Pending</a></li>
                    <li><a data-toggle="tab" href="#approved">Approved</a></li>
                </ul>

                <div class="tab-content">
                    <div id="pending" class="tab-pane fade show in active">
                        <h4>Policy</h4>
                        <div class="row filter">
                            <div class="col-sm-6">
                                <div class="search-container">
                                    <form action="" method="POST">
                                        <input type="text" placeholder="Search" name="search">
                                        <button type="submit"><i class="fa fa-search"></i></button>
                                    </form>
                                </div>
                            </div>   
                            
                        </div>
                        <div class="table-scroll">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Policy Date</th>
                                        <th>Company Name</th>
                                        <th>Policy Number</th>
                                        <th>Customer Name</th>
                                        <th>Registration Number</th>
                                        <th>Recivable From</th>
                                        <th>Agent Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $pending_policy_result_set=get_pending_policy_result_set();
                                        if($pending_policy_result_set){
                                            while($pending_policy_result=$pending_policy_result_set->fetch_assoc()){
                                                echo "<tr>";
                                                echo "  <td>".$pending_policy_result['od_policy_start_date']."</td>";
                                                echo "  <td>".$pending_policy_result['company_name']."</td>";
                                                echo "  <td>".$pending_policy_result['policy_number']."</td>";
                                                echo "  <td>".$pending_policy_result['customer_name']."</td>";
                                                echo "  <td>".$pending_policy_result['registration_number']."</td>";
                                                echo "  <td>".$pending_policy_result['payment_mode']."</td>";
                                                echo "  <td>".get_agent_name($pending_policy_result['agent_id'])."</td>";
                                                echo '  <td><button onclick="policy_open_overlay(this);" id="'.$pending_policy_result['id'].'">Approve</button></td>';
                                                echo "</tr>";
                                                //cheque cleared pending policy
                                                $cheque_cleared_pending_policy_result_array=get_cleared_cheque_pending_policy();
                                                for($i=0;$i<count($cheque_cleared_pending_policy_result_array);$i++){
                                                    echo "<tr>";
                                                    echo "  <td>".$cheque_cleared_pending_policy_result_array[$i]['od_policy_start_date']."</td>";
                                                    echo "  <td>".$cheque_cleared_pending_policy_result_array[$i]['company_name']."</td>";
                                                    echo "  <td>".$cheque_cleared_pending_policy_result_array[$i]['policy_number']."</td>";
                                                    echo "  <td>".$cheque_cleared_pending_policy_result_array[$i]['customer_name']."</td>";
                                                    echo "  <td>".$cheque_cleared_pending_policy_result_array[$i]['registration_number']."</td>";
                                                    echo "  <td>".$cheque_cleared_pending_policy_result_array[$i]['payment_mode']."</td>";
                                                    echo "  <td>".get_agent_name($cheque_cleared_pending_policy_result_array[$i]['agent_id'])."</td>";
                                                    echo '  <td><button onclick="policy_open_overlay(this);" id="'.$cheque_cleared_pending_policy_result_array[$i]['id'].'">Approve</button></td>';
                                                    echo "</tr>";
                                                }
                                            }
                                        }else{
                                            //cheque cleared pending policy
                                            $cheque_cleared_pending_policy_result_array=get_cleared_cheque_pending_policy();
                                            for($i=0;$i<count($cheque_cleared_pending_policy_result_array);$i++){
                                                echo "<tr>";
                                                echo "  <td>".$cheque_cleared_pending_policy_result_array[$i]['od_policy_start_date']."</td>";
                                                echo "  <td>".$cheque_cleared_pending_policy_result_array[$i]['company_name']."</td>";
                                                echo "  <td>".$cheque_cleared_pending_policy_result_array[$i]['policy_number']."</td>";
                                                echo "  <td>".$cheque_cleared_pending_policy_result_array[$i]['customer_name']."</td>";
                                                echo "  <td>".$cheque_cleared_pending_policy_result_array[$i]['registration_number']."</td>";
                                                echo "  <td>".$cheque_cleared_pending_policy_result_array[$i]['payment_mode']."</td>";
                                                echo "  <td>".get_agent_name($cheque_cleared_pending_policy_result_array[$i]['agent_id'])."</td>";
                                                echo '  <td><button onclick="policy_open_overlay(this);" id="'.$cheque_cleared_pending_policy_result_array[$i]['id'].'">Approve</button></td>';
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
                    <div id="approved" class="tab-pane fade">
                        <h4>Policy</h4>
                        <div class="row filter">
                            <div class="col-sm-6">
                                <div class="search-container">
                                    <form action="" method="POST">
                                        <input type="text" placeholder="Search" name="search">
                                        <button type="submit"><i class="fa fa-search"></i></button>
                                    </form>
                                </div>
                            </div>   
                            
                        </div>
                        <div class="table-scroll">
                            <table class="table table-bordered">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $approved_policy_result_set=get_approved_policy_result_set();
                                        while($approved_policy_result=$approved_policy_result_set->fetch_assoc()){
                                            echo "<tr>";
                                            echo "  <td>".$approved_policy_result['od_policy_start_date']."</td>";
                                            echo "  <td>".$approved_policy_result['company_name']."</td>";
                                            echo "  <td>".$approved_policy_result['policy_number']."</td>";
                                            echo "  <td>".$approved_policy_result['customer_name']."</td>";
                                            echo "  <td>".$approved_policy_result['registration_number']."</td>";
                                            echo "  <td>".$approved_policy_result['payment_mode']."</td>";
                                            //calculating recivable amount
                                            if($approved_policy_result['comission_type']=='NP'){
                                                $comission_amount=$approved_policy_result['net_premium']*($approved_policy_result['comission_percentage']/100);
                                                $recivable_amount=$approved_policy_result['net_premium']-$comission_amount;
                                            }else{
                                                $comission_amount=$approved_policy_result['od_premium']*($approved_policy_result['comission_percentage']/100);
                                                $recivable_amount=$approved_policy_result['od_premium']-$comission_amount;
                                            }
                                            echo "  <td>".$recivable_amount."</td>";
                                            echo "  <td>".get_agent_name($approved_policy_result['agent_id'])."</td>";
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
                        <label for="comission_percentage">Agent Payout</label>
                        <input type="text" id="comission_percentage"  name="comission_percentage" class="form-control" value="" required="required">
                    </div>
                    <!--<div class="col-md-4">
                        <label for="comission_amount">Agent Payout Amount</label>
                        <input type="text" id="comission_amount" class="form-control" value="" required="required">
                    </div>-->
                    <!--Value not entered by admin-->
                    <input type="hidden" id="policy_id" name="policy_id" value="">    
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
  <!--Ajax-->
  
  <!--Custom script-->
  <script src="../scripts/overlay.js"></script>
</body>
</html>

                        
              