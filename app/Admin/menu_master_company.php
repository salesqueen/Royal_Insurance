<?php 

error_reporting(0);

include '../Php/main.php';

//session handelling
$session=new Session();
$session->check_session("Admin");

//creating user object
$user=new Admin();

//fetching main
//fetching company result set
$company_result_set=$user->read_all_company();

//form handelling
//company
if(isset($_POST['company_form_submit'])){
    $user->insert_company();
    header("location:menu_master_company.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Master</title>

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
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Master</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item active" href="menu_master_company.php">Company</a>
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
            
            <h2>Company</h2>

            <ul class="nav nav-tabs">
                <li><a data-toggle="tab" href="#company" class="active">Company</a></li>
            </ul>

            <div class="tab-content"> 
                <div id="company" class="tab-pane fade active show">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                        <div class="row">
                            <!--Col-->
                            <div class="col-md-4">
                                <label for="company_name">Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name" required="required">
                            </div>
                            <!--Col-->
                            <div class="col-md-4">
                                <label for="remark">Remark</label>
                                <input type="text" class="form-control" id="remark" name="remark" placeholder="Remark" required="required">
                            </div>
                            <!--Col-->
                            <div class="col-md-4">
                                <br>
                                <input type="submit" value="Create" name="company_form_submit" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
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
                                    <th>Company Name</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($company_result_set){
                                        while($company_result=$company_result_set->fetch_assoc()){
                                            echo "<tr>";
                                            echo "  <td>".$company_result['company_name']."</td>";
                                            echo "  <td>".$company_result['remark']."</td>";
                                            echo '  <td>
                                                        <a href="edit_company.php?id='.$company_result['id'].'"><span class="fas fa-edit action_button"></span></a>
                                                        <a href="delete_company.php?id='.$company_result['id'].'"><span class="fas fa-trash-alt action_button"></span></a>
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
<script src="../scripts/main.js"></script>
<script src="../scripts/search.js"></script>
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

                    