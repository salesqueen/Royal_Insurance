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
    //assigning filter
    //company name
    if(isset($_POST['company_name']) && $_POST['company_name']!=""){
        $constraint=$constraint." AND (company_name='".$_POST['company_name']."')";
    }
    //company code
    if(isset($_POST['company_code']) && $_POST['company_code']!=""){
        $constraint=$constraint." AND (company_code='".$_POST['company_code']."')";
    }
    //branch
    if(isset($_POST['branch']) && $_POST['branch']!=""){
        //fetching the branch manager id
        $branch_manager_id=$user->read_selective_branch_manager("WHERE branch='".$_POST['branch']."'")->fetch_assoc()['id'];
        //fetching the agent with the branch manager id
        $agent_result_set=$user->read_selective_agent("WHERE branch_manager_id=".$branch_manager_id);
        if($agent_result_set){
            $constraint=$constraint." AND (agent_id=".$agent_result_set->fetch_assoc()['id'];
            while($agent_result=$agent_result_set->fetch_assoc()){
                $constraint=$constraint." OR agent_id=".$agent_result['id'];
            }
            $constraint=$constraint.")";
        }else{
            $constraint=$constraint." AND (blue=0)";
        }
    }
    //agent
    if(isset($_POST['agent']) && $_POST['agent']!=""){
        $constraint=$constraint." AND (agent_id='".$_POST['agent']."')";
    }
    //filter date
    if(isset($_POST['filter_start_date']) && isset($_POST['filter_end_date']) && $_POST['filter_start_date']!="" && $_POST['filter_end_date']!=""){
        $constraint=$constraint." AND (issue_date BETWEEN '".$_POST['filter_start_date']."' AND '".$_POST['filter_end_date']."')";
    }else{
        //only start date is set
        if(isset($_POST['filter_start_date']) && $_POST['filter_start_date']!=""){
            $constraint=$constraint." AND (issue_date>='".$_POST['filter_start_date']."')";
        }
        if(isset($_POST['filter_end_date']) && $_POST['filter_end_date']!=""){
            $constraint=$constraint." AND (issue_date<='".$_POST['filter_end_date']."')";
        }
    }

    //fetching main
    //pending policy vai cash
    if($constraint==""){
        $pending_policy_result_set=$user->read_selective_policy('WHERE (my_comission_percentage=0 AND payment_mode="Cash") OR (my_comission_percentage=0 AND payment_mode="Online")');
    }else{
        $pending_policy_result_set=$user->read_selective_policy('WHERE ((my_comission_percentage=0 AND payment_mode="Cash") OR (my_comission_percentage=0 AND payment_mode="Online")) '.$constraint);
    }
    //pending policy via cheque
    $cleared_cheque_pending_policy_array=$user->get_cleared_cheque_pending_policy("my_comission_percentage",$_POST['company_name'],$_POST['company_code'],$_POST['branch'],$_POST['agent'],$_POST['filter_start_date'],$_POST['filter_end_date']);
    //approved policy
    if($constraint==""){
        $approved_policy_result_set=$user->read_selective_policy('WHERE NOT my_comission_percentage=0');
    }else{
        $approved_policy_result_set=$user->read_selective_policy('WHERE NOT my_comission_percentage=0 '.$constraint);
    }
    //company
    $company_result_set=$user->read_all_company();
    //company code
    $company_code_result_set=$user->read_all_company_code();
    //branch
    $branch_manager_result_set=$user->read_all_branch_manager();
    //agent
    $agent_result_set=$user->read_all_agent();

    //form handelling
    //approving policy
    if(isset($_POST['approve_submit'])){
        $user->update_policy(array('my_comission_percentage','my_comission_type'),$_POST['policy_id']);
        header("location:menu_utilities_comission_recivable.php");
    }

    //download
    if(isset($_POST['download_excel'])){
        $download=new Download();
        $download->comission_recivable($pending_policy_result_set,$cleared_cheque_pending_policy_array,$approved_policy_result_set);
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
                            <!--Company Name-->
                            <input type="hidden" name="company_name" value="<?php if(isset($_POST['company_name'])){echo $_POST['company_name'];}else{/*Do Nothing */}?>">
                            <!--Company Code-->
                            <input type="hidden" name="company_code" value="<?php if(isset($_POST['company_code'])){echo $_POST['company_code'];}else{/*Do Nothing */}?>">
                            <!--Branch-->
                            <input type="hidden" name="branch" value="<?php if(isset($_POST['branch'])){echo $_POST['branch'];}else{/*Do Nothing */}?>">
                             <!--Agent-->
                            <input type="hidden" name="agent" value="<?php if(isset($_POST['agent'])){echo $_POST['agent'];}else{/*Do Nothing */}?>">
                            <!--Date Filter-->
                            <input type="hidden" name="filter_start_date" value="<?php if(isset($_POST['filter_start_date'])){echo $_POST['filter_start_date'];}else{/*Do Nothing */}?>">
                            <input type="hidden" name="filter_end_date" value="<?php if(isset($_POST['filter_end_date'])){echo $_POST['filter_end_date'];}else{/*Do Nothing */}?>">
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
                            <div class="col-md-12">
                                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                                    <!--Company Name-->
                                    <input type="text" onfocus="this.value=''" name="company_name" id="company_name" list="company_names" placeholder="Company Name" value="<?php if(isset($_POST['company_name'])){echo $_POST['company_name'];}else{/*Do Nothing */}?>">
                                    <datalist id="company_names">
                                        <?php 
                                            while($company_result=$company_result_set->fetch_assoc()){
                                                echo '<option value="'.$company_result['company_name'].'">';
                                            }
                                        ?>
                                    </datalist>
                                    <!--Company Code-->
                                    <input type="text" onfocus="this.value=''" name="company_code" id="company_code" list="company_codes" placeholder="Company Code" value="<?php if(isset($_POST['company_code'])){echo $_POST['company_code'];}else{/*Do Nothing */}?>">
                                    <datalist id="company_codes">
                                        <?php 
                                            while($company_code_result=$company_code_result_set->fetch_assoc()){
                                                echo '<option value="'.$company_code_result['company_code'].'">';
                                            }
                                        ?>
                                    </datalist>
                                    <!--Branch-->
                                    <input type="text" onfocus="this.value=''" name="branch" id="branch" list="branches" placeholder="Branch" value="<?php if(isset($_POST['branch'])){echo $_POST['branch'];}else{/*Do Nothing */}?>">
                                    <datalist id="branches">
                                        <?php 
                                            while($branch_manager_result=$branch_manager_result_set->fetch_assoc()){
                                                echo '<option value="'.$branch_manager_result['branch'].'">';
                                            }
                                        ?>
                                    </datalist>
                                    <!--Agent-->
                                    <input type="text" onfocus="this.value=''" name="agent" id="agent" list="agents" placeholder="Agent" value="<?php if(isset($_POST['agent'])){echo $_POST['agent'];}else{/*Do Nothing */}?>">
                                    <datalist id="agents">
                                        <?php 
                                            while($agent_result=$agent_result_set->fetch_assoc()){
                                                echo '<option value="'.$agent_result['id'].'">'.$agent_result['name'].'-'.$agent_result['mobile'].'</option>';
                                            }
                                        ?>
                                    </datalist>
                                    <!--Date Filter-->
                                    <input type="date" onfocus="this.value=''" name="filter_start_date" id="filter_start_date" value="<?php if(isset($_POST['filter_start_date'])){echo $_POST['filter_start_date'];}else{/*Do Nothing */}?>">
                                    <input type="date" onfocus="this.value=''" name="filter_end_date" id="filter_end_date" value="<?php if(isset($_POST['filter_end_date'])){echo $_POST['filter_end_date'];}else{/*Do Nothing */}?>">
                                    <!--Filter Button-->
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
                                                echo '  <td>
                                                            <Button onclick="policy_open_overlay(this)" id="'.$pending_policy_result['id'].'">Approve</Button>
                                                            <a href="view_policy.php?id='.$pending_policy_result['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        </td>';
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
                                            echo '  <td>
                                                        <Button onclick="policy_open_overlay(this)" id="'.$cleared_cheque_pending_policy_array[$i]['id'].'">Approve</Button>
                                                        <a href="view_policy.php?id='.$cleared_cheque_pending_policy_array[$i]['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                    </td>';
                                            echo "</tr>";
                                        }
                                        //approved policy
                                        if($approved_policy_result_set){
                                            while($approved_policy_result=$approved_policy_result_set->fetch_assoc()){
                                                //comission calculation
                                                $comission=0;
                                                if($approved_policy_result['my_comission_type']=='OD'){
                                                    $comission=$approved_policy_result['od_premium']*($approved_policy_result['my_comission_percentage']/100);
                                                }
                                                if($approved_policy_result['my_comission_type']=='NP'){
                                                    $comission=$approved_policy_result['net_premium']*($approved_policy_result['my_comission_percentage']/100);
                                                }
                                                //elimating the transactioned amount
                                                $recivable_transaction_result_set=$user->read_selective_recivable_transaction("WHERE policy_id='".$approved_policy_result['id']."'");
                                                if($recivable_transaction_result_set){
                                                    $recived_amount=0;
                                                    while($recivable_transaction_result=$recivable_transaction_result_set->fetch_assoc()){
                                                        $recivable_amount+=$recivable_transaction_result['amount'];
                                                    }
                                                }
                                                $comission=$comission-$recivable_amount;
                                                echo "<tr>";
                                                echo "  <td>".$approved_policy_result['issue_date']."</td>";
                                                echo "  <td>".$approved_policy_result['company_name']."</td>";
                                                echo "  <td>".$approved_policy_result['policy_number']."</td>";
                                                echo "  <td>".$approved_policy_result['customer_name']."</td>";
                                                echo "  <td>".$approved_policy_result['registration_number']."</td>";
                                                echo "  <td>".$approved_policy_result['payment_mode']."</td>";
                                                
                                                //elimating already transactioned amount
                                                echo "  <td>".$approved_policy_result['my_comission_type']."</td>";
                                                echo "  <td>".$comission."</td>";
                                                echo "  <td>".$user->get_agent_name($approved_policy_result['agent_id'])."</td>";
                                                echo '  <td>
                                                            Approved <a href="view_policy.php?id='.$approved_policy_result['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                            <a href="create_recivable_transaction.php?company_name='.$approved_policy_result['company_name'].'&policy_id='.$approved_policy_result['id'].'"><i class="fa fa-credit-card" aria-hidden="true"></i></a>
                                                        </td>';
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
                        <label for="ajax_company_name">Company Name</label>
                        <input type="text" id="ajax_company_name" name="company_name" class="form-control" value="" required="required">
                    </div>
                    <div class="col-md-4">
                        <label for="ajax_company_code">Company Code</label>
                        <select id="ajax_company_code" name="company_code" class="form-control" required="required">
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
                        <label class="form-check-label" for="OD">OD Premium-<span id="od_premium"></span></label>
                        
                        <br>
                        <input class="form-check-input" onclick="update_agent_payout_amount()" type="radio" name="my_comission_type" id="NP" value="NP">
                        <label class="form-check-label" for="NP">NET Premium-<span id="net_premium"></span></label>
                    </div>
                    <!--Value not entered by admin-->
                    <input type="hidden" id="policy_id" name="policy_id" value="">    
            </div>
            <div class="row">
                    <div class="col-md-4">
                        <label for="comission_percentage">Agent Payout(%)</label>
                        <input type="text" onchange="update_agent_payout_amount()" id="comission_percentage"  name="my_comission_percentage" class="form-control" value="" required="required">
                    </div>
                    <div class="col-md-4">
                        <label for="comission_amount">Agent Payout Amount</label>
                        <input type="text" onchange="update_comission_percentage()" id="comission_amount" class="form-control" value="" required="required">
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
  <script src="https://use.fontawesome.com/793bc63e83.js"></script>
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

                        