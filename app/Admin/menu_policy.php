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
    //Booking Code
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
    //fetching pending policy details for cash
    if($constraint==""){
        $pending_policy_result_set=$user->read_selective_policy("WHERE comission_percentage=0");
    }else{
        $pending_policy_result_set=$user->read_selective_policy("WHERE comission_percentage=0 ".$constraint);
    }
    //fetching approved policy details
    if($constraint==""){
        $approved_policy_result_set=$user->read_selective_policy("WHERE NOT comission_percentage=0"); 
    }else{
        $approved_policy_result_set=$user->read_selective_policy("WHERE NOT comission_percentage=0 ".$constraint);
    }
    //company
    $company_result_set=$user->read_all_company();
    //Booking Code
    $company_code_result_set=$user->read_all_company_code();
    //branch
    $branch_manager_result_set=$user->read_all_branch_manager();
    //agent
    $agent_result_set=$user->read_all_agent();

  //form action
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
  <title>Policy</title>

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
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Master</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="menu_master_company.php">Company</a>
                                <a class="dropdown-item" href="menu_master_company_code.php">Booking Code</a>
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
                            <a class="nav-link active" href="menu_policy.php">Policy</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Utilities</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="menu_utilities_comission_recivable.php">Comission Recivable</a>
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
                        <h2>Policy</h2>
                    </div>
                    <div class="col-md-6">
                        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" style="float:right">
                            <input type="hidden" name="constraint" value="<?php echo $constraint?>">
                            <input type="submit" name="download_excel" value="Download Excel">
                        </form>
                    </div>
                </div>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#policy" class="active">Policy</a></li>
                </ul>

                <div class="tab-content">
                    <div id="policy" class="tab-pane fade in active show">
                        <div class="row filter">
                            <div class="col-md-11">
                                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                                    <!--Company Name-->
                                    <input type="text" onfocus="this.value=''" name="company_name" id="company_name" list="company_names" placeholder="Company Name" value="<?php if(isset($_POST['company_name'])){echo $_POST['company_name'];}else{/*Do Nothing */}?>">
                                    <datalist id="company_names">
                                        <?php
                                            if($company_result_set){
                                                while($company_result=$company_result_set->fetch_assoc()){
                                                    echo '<option value="'.$company_result['company_name'].'">';
                                                }
                                            } 
                                        ?>
                                    </datalist>
                                    <!--Booking Code-->
                                    <input type="text" onfocus="this.value=''" name="company_code" id="company_code" list="company_codes" placeholder="Booking Code" value="<?php if(isset($_POST['company_code'])){echo $_POST['company_code'];}else{/*Do Nothing */}?>">
                                    <datalist id="company_codes">
                                        <?php 
                                            if($company_code_result_set){
                                                while($company_code_result=$company_code_result_set->fetch_assoc()){
                                                    echo '<option value="'.$company_code_result['company_code'].'">';
                                                }
                                            }
                                        ?>
                                    </datalist>
                                    <!--Branch-->
                                    <input type="text" onfocus="this.value=''" name="branch" id="branch" list="branches" placeholder="Branch" value="<?php if(isset($_POST['branch'])){echo $_POST['branch'];}else{/*Do Nothing */}?>">
                                    <datalist id="branches">
                                        <?php 
                                            if($branch_manager_result_set){
                                                while($branch_manager_result=$branch_manager_result_set->fetch_assoc()){
                                                    echo '<option value="'.$branch_manager_result['branch'].'">';
                                                }
                                            }
                                        ?>
                                    </datalist>
                                    <!--Agent-->
                                    <input type="text" onfocus="this.value=''" name="agent" id="agent" list="agents" placeholder="Agent" value="<?php if(isset($_POST['agent'])){echo $_POST['agent'];}else{/*Do Nothing */}?>">
                                    <datalist id="agents">
                                        <?php 
                                            if($agent_result_set){
                                                while($agent_result=$agent_result_set->fetch_assoc()){
                                                    echo '<option value="'.$agent_result['id'].'">'.$agent_result['name'].'-'.$agent_result['mobile'].'</option>';
                                                }
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
                            <div class="col-md-1">
                                <a href="create_policy.php" style="float:right"><Button>Create</button></a>
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
                                        <th>OD Premium</th>
                                        <th>Net Premium</th>
                                        <th>Total Premium</th>
                                        <th>User Name</th>
                                        <th>Policy Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($approved_policy_result_set || $pending_policy_result_set){
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
                                                    echo "  <td>".$pending_policy_result['od_premium']."</td>";
                                                    echo "  <td>".$pending_policy_result['net_premium']."</td>";
                                                    echo "  <td>".$pending_policy_result['total_premium']."</td>";
                                                    echo "  <td>".$user->get_agent_name($pending_policy_result['agent_id'])."</td>";
                                                    if($pending_policy_result['payment_mode']=='Cash' || $pending_policy_result['payment_mode']=='Online'){
                                                        echo "  <td>Pending</td>";
                                                    }else{
                                                        if($user->get_cheque_status($pending_policy_result['id'])=='Rejected'){
                                                            echo "  <td>Rejected</td>";
                                                        }else{
                                                            echo "  <td>Pending</td>";
                                                        }
                                                    }
                                                    echo '  <td>
                                                                <a href="view_policy.php?id='.$pending_policy_result['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                                <a href="edit_policy.php?id='.$pending_policy_result['id'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                                <a href="upload_document_policy.php?id='.$pending_policy_result['id'].'"><i class="fa fa-upload" aria-hidden="true"></i></a>
                                                            </td>';
                                                    echo "</tr>";
                                                }
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
                                                    echo "  <td>".$approved_policy_result['od_premium']."</td>";
                                                    echo "  <td>".$approved_policy_result['net_premium']."</td>";
                                                    echo "  <td>".$approved_policy_result['total_premium']."</td>";
                                                    echo "  <td>".$user->get_agent_name($approved_policy_result['agent_id'])."</td>";
                                                    echo "  <td>Approved</td>";
                                                    echo '  <td>
                                                                <a href="view_policy.php?id='.$approved_policy_result['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                                <a href="upload_document_policy.php?id='.$approved_policy_result['id'].'"><i class="fa fa-upload" aria-hidden="true"></i></a>
                                                            </td>';
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
  <script src="../scripts/overlay.js"></script>
  <!--<script src="../scripts/search.js"></script>-->
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
        //Do Nothing
    }
  ?>
</body>
</html>

                        
              