<?php 

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Agent");
  //creating user object
  $user=new Agent();
  //fetching comission
  //fetching recivable policy details
  function get_payable_policy_result_set(){
    $payable_policy_result_set=$GLOBALS['user']->read_selective_policy("WHERE NOT comission_percentage=0 AND NOT payment_mode='Cash' AND payment='Unpaid'");
    return $payable_policy_result_set;
  }
  //fetching approved policy details
  function get_recivable_policy_result_set(){
    $recivable_policy_result_set=$GLOBALS['user']->read_selective_policy("WHERE NOT comission_percentage=0 AND payment_mode='Cash' AND payment='Unpaid'");
    return $recivable_policy_result_set;
  }
  //fetching cash id
  function get_cash_id($policy_id){
    $cash_result_set=$GLOBALS['user']->read_selective_cash("WHERE policy_id=".$policy_id);
    $cash_result=$cash_result_set->fetch_assoc();
    return $cash_result['id'];
  }
  //fetching cheques
  //fetching pending cheques
  function get_pending_cheque(){
    $pending_cheque_result_set=$GLOBALS['user']->read_selective_cheque("WHERE cheque_status='Pending'");
    return $pending_cheque_result_set;
  }
  //fetching cleared cheques
  function get_cleared_cheque(){
    $cleared_cheque_result_set=$GLOBALS['user']->read_selective_cheque("WHERE NOT cheque_status='Pending'");
    return $cleared_cheque_result_set;
  }
  //fetching policy details
  function get_policy_result($id){
    $policy_result_set=$GLOBALS['user']->read_one_policy($id);
    return $policy_result_set->fetch_assoc();
  }
  //fetching agent name
  function get_agent_name($id){
    $agent_result_set=$GLOBALS['user']->read_one_agent($id);
    $agent_result=$agent_result_set->fetch_assoc();
    return $agent_result['name'];
  }

  //form action
  if(isset($_POST['clear_submit'])){
    $GLOBALS['user']->clear_cheque($_POST['cheque_id']);
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

                <h2>Utility</h2>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#comission_recivable" class="active">Comission Recivable</a></li>
                    <li><a data-toggle="tab" href="#comission_payable">Comission Payable</a></li>
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
                    <div id="comission_recivable" class="tab-pane fade show in active">
                        <h4>Pending</h4>
                        <div class="row filter">
                            <div class="col-sm-6">
                                <div class="search-container">
                                    <form>
                                        <input type="text" id="search_1" placeholder="Search" name="search">
                                    </form>
                                </div>
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
                                        <th>Agent Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $pending_cheque_result_set=get_pending_cheque();
                                        if($pending_cheque_result_set){
                                            while($pending_cheque_result=$pending_cheque_result_set->fetch_assoc()){
                                                echo "<tr>";
                                                //policy details
                                                $policy_result=get_policy_result($pending_cheque_result['policy_id']);
                                                echo "  <td>".$policy_result['od_policy_start_date']."</td>";
                                                echo "  <td>".$policy_result['company_name']."</td>";
                                                echo "  <td>".$policy_result['policy_number']."</td>";
                                                echo "  <td>".$policy_result['customer_name']."</td>";
                                                echo "  <td>".$policy_result['registration_number']."</td>";
                                                //cheque details
                                                echo "  <td>".$pending_cheque_result['cheque_number']."</td>";
                                                echo "  <td>".$pending_cheque_result['bank_name']."</td>";
                                                //agent details
                                                echo "  <td>".get_agent_name($policy_result['agent_id'])."</td>";
                                                //actions
                                                //c
                                                echo '  <td>';
                                                echo '      <form action="'.$_SERVER['PHP_SELF'].'" method="POST">';
                                                echo '          <input type="hidden" name="cheque_id" value="'.$pending_cheque_result['id'].'">';
                                                echo '          <input type="submit" name="clear_submit" value="Clear">';
                                                echo '      </form>';
                                                echo '   </td>';
                                                echo '  <td>';
                                                echo '      <form action="'.$_SERVER['PHP_SELF'].'" method="POST">';
                                                echo '          <input type="hidden" name="cheque_id" value="'.$pending_cheque_result['id'].'">';
                                                echo '          <input type="submit" name="clear_submit" value="Clear">';
                                                echo '      </form>';
                                                echo '   </td>';
                                                echo "</tr>";
                                            }
                                        }else{
                                            echo "<tr>No records found</tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="Page navigation">
                        <?php 
                            //calculating page numbers
                            /*$sql="SELECT COUNT(*) AS count FROM cheque WHERE cheque_status='Pending';";
                            $count=1;
                            $count_result_set=$user->read_custom($sql);
                            if($count_result_set){
                                $count_result=$count_result_set->fetch_assoc();
                                $count=$count_result['count'];
                            }
                            $number_of_pages=($count/10)+1;
                            //displaying button based on data
                            if($number_of_pages>=2){
                                echo '<nav aria-label="Page navigation">';
                                echo '  <ul class="pagination">';
                                for($i=1;$i<=$number_of_pages;$i++){
                                    echo '<li class="page-item"><a class="page-link active" onclick="data(this)">'.$i.'</a></li>';
                                }
                                echo '  </ul>';
                                echo '</nav>';
                            }else{
                                echo '<nav aria-label="Page navigation">';
                                echo '  <ul class="pagination">';
                                echo '      <li class="page-item"><a class="page-link page" onclick="data(this)">1</a></li>';
                                echo '  </ul>';
                                echo '</nav>';
                            }*/
                        ?>
                        </nav>
                    </div>
                    
                    <div id="cleared" class="tab-pane fade">
                        <h4>Cleared</h4>
                        <div class="row filter">
                            <div class="col-sm-6">
                                <div class="search-container">
                                    <form>
                                        <input type="text" id="search_2" placeholder="Search" name="search">
                                    </form>
                                </div>
                            </div>   
                            
                        </div>
                        <div class="table-scroll">
                            <table id="table_2" class="table table-bordered table-hover">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $cleared_cheque_result_set=get_cleared_cheque();
                                        if($cleared_cheque_result_set){
                                            while($cleared_cheque_result=$cleared_cheque_result_set->fetch_assoc()){
                                                echo "<tr>";
                                                //policy details
                                                $policy_result=get_policy_result($cleared_cheque_result['policy_id']);
                                                echo "  <td>".$policy_result['od_policy_start_date']."</td>";
                                                echo "  <td>".$policy_result['company_name']."</td>";
                                                echo "  <td>".$policy_result['policy_number']."</td>";
                                                echo "  <td>".$policy_result['customer_name']."</td>";
                                                echo "  <td>".$policy_result['registration_number']."</td>";
                                                //cheque details
                                                echo "  <td>".$cleared_cheque_result['cheque_number']."</td>";
                                                echo "  <td>".$cleared_cheque_result['bank_name']."</td>";
                                                //agent details
                                                echo "  <td>".get_agent_name($policy_result['agent_id'])."</td>";
                                                echo "</tr>";
                                            }
                                        }else{
                                            echo "<tr>No records found</tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="Page navigation">
                        <?php 
                            //calculating page numbers
                            /*$sql="SELECT COUNT(*) AS count FROM cheque WHERE NOT cheque_status='Pending';";
                            $count=1;
                            $count_result_set=$user->read_custom($sql);
                            if($count_result_set){
                                $count_result=$count_result_set->fetch_assoc();
                                $count=$count_result['count'];
                            }
                            $number_of_pages=($count/10)+1;
                            //displaying button based on data
                            if($number_of_pages>=2){
                                echo '<nav aria-label="Page navigation">';
                                echo '  <ul class="pagination">';
                                for($i=1;$i<=$number_of_pages;$i++){
                                    echo '<li class="page-item"><a class="page-link active" onclick="paginate_cleared_cheque(this)">'.$i.'</a></li>';
                                }
                                echo '  </ul>';
                                echo '</nav>';
                            }else{
                                echo '<nav aria-label="Page navigation">';
                                echo '  <ul class="pagination">';
                                echo '      <li class="page-item"><a class="page-link page" onclick="paginate_cleared_cheque(this)">1</a></li>';
                                echo '  </ul>';
                                echo '</nav>';
                            }*/
                        ?>
                        </nav>
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
  <!--Custom javascript-->
  <script src="../scripts/search.js"></script>
  <script>
        

    //pagination for pending cheque
    /*function pagination_ajax_call_for_pending_cheque(input_page_number) {
        $.ajax({
            url:"ajax.php",
            type:"post",
            data: {function_name: "paginate_pending_cheque_status", page_number: input_page_number},
            success:function(response){
                var i=0;
                var json=JSON.parse(response);
                $html='';
                console.log(response);
                while(json.hasOwnProperty(i)){
                    $html=$html+
                    '<tr>'+
                    '   <td>'+json[i]['od_policy_start_date']+'</td>'+
                    '   <td>'+json[i]['company_name']+'</td>'+
                    '   <td>'+json[i]['policy_number']+'</td>'+
                    '   <td>'+json[i]['customer_name']+'</td>'+
                    '   <td>'+json[i]['registration_number']+'</td>'+
                    '   <td>'+json[i]['cheque_number']+'</td>'+
                    '   <td>'+json[i]['bank_name']+'</td>'+
                    '   <td>'+json[i]['agent_name']+'</td>'+
                    '  <td>'+
                    '      <form action="'+<?php echo "'".$_SERVER['PHP_SELF']."'";?>+'" method="POST">'+
                    '          <input type="hidden" name="cheque_id" value="'+json[i]['id']+'">'+
                    '          <input type="submit" name="clear_submit" value="Clear">'+
                    '      </form>'+
                    '   </td>'+
                    '</tr>';
                    i++;
                }
                $('#cheque_status_table_1 tbody').html($html);
            }
        });
    }*/
    function data(element){
        console.log(element.innerText);
        data_retrive(element.innerText);
    }
    //pagination for cleared cheques
    function data_retrive(input_page_number) {
        $.ajax({
            url:"ajax.php",
            type:"post",
            data: {function_name: "data", page_number: input_page_number},
            success:function(response){
                console.log(response);
                /*var i=0;
                var json=JSON.parse(response);
                $html='';
                console.log(response);
                while(json.hasOwnProperty(i)){
                    $html=$html+
                    '<tr>'+
                    '   <td>'+json[i]['od_policy_start_date']+'</td>'+
                    '   <td>'+json[i]['company_name']+'</td>'+
                    '   <td>'+json[i]['policy_number']+'</td>'+
                    '   <td>'+json[i]['customer_name']+'</td>'+
                    '   <td>'+json[i]['registration_number']+'</td>'+
                    '   <td>'+json[i]['cheque_number']+'</td>'+
                    '   <td>'+json[i]['bank_name']+'</td>'+
                    '   <td>'+json[i]['agent_name']+'</td>'+
                    '  <td>'+
                    '      <form action="'+<?php echo "'".$_SERVER['PHP_SELF']."'";?>+'" method="POST">'+
                    '          <input type="hidden" name="cheque_id" value="'+json[i]['id']+'">'+
                    '          <input type="submit" name="clear_submit" value="Clear">'+
                    '      </form>'+
                    '   </td>'+
                    '</tr>';
                    i++;
                }
                $('#cheque_status_table_2 tbody').html($html);*/
            }
        });
    }
    function paginate_cleared_cheque(element){
        pagination_ajax_call_for_cleared_cheque(element.innerText);
    }
    </script>
</body>
</html>

                        