<?php 

  error_reporting(0);

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Branch_Manager");

  //creating user object
  $user=new Branch_Manager();

  //fetching main
  $branch_manager_result_set=$user->read_all_branch_manager();

  //form handelling
  if(isset($_POST['user_form_submit'])){
    $user->insert_agent();
    header('Location:menu_manage_user_agent.php');
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create User</title>

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
                        <li class="nav-item">
                            <a class="nav-link" href="menu_manage_user_agent.php">Manage User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu_policy.php">Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../reset_password.php" id="logout-link">Reset Password</a>
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
                        <h2>Create User</h2>
                    </div>
                    <div class="col-md-6">
                        <a href="javascript:history.go(-2)" style="float:right"><Button>Back <i class="fa fa-arrow-right" aria-hidden="true"></i></button></a>
                    </div>
                </div>
                
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#user" class="active">Create User</a></li>
                </ul>

                <div class="tab-content">
                    <div id="user" class="tab-pane fade show in active">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                            <h4>Personal Details</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="mobile">Mobile Number <span id="mobile_error" style="color:red"></span></label>
                                    <input type="text" onchange="check_mobile_duplication()" maxlength="10" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="email">Email <span id="email_error" style="color:red"></span></label>
                                    <input type="email" onchange="check_email_duplication()" class="form-control" id="email" name="email" placeholder="Email" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" required="required">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="aadhar_card_number">Aadhar Card Number</label>
                                    <input type="text" class="form-control" id="aadhar_card_number" name="aadhar_card_number" placeholder="Aadhar Card Number">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="pan_card_number">Pan Card Number</label>
                                    <input type="text" class="form-control" id="pan_card_number" name="pan_card_number" placeholder="Pan Card Number">
                                </div>
                            </div>

                            <hr>
                            <h4>Bank Details</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="bank_name">Bank Name</label>
                                    <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="bank_branch">Branch</label>
                                    <input type="text" class="form-control" id="bank_branch" name="bank_branch" placeholder="Branch">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="ifsc_code">IFSC Code</label>
                                    <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="micr_number">MICR Number</label>
                                    <input type="text" class="form-control" id="micr_number" name="micr_number" placeholder="MICR Number">
                                </div>
                            </div>

                            <hr>
                            <h4>Wallet Details</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="phonepe_number">PhonePe Number</label>
                                    <input type="number" class="form-control" id="phonepe_number" name="phonepe_number" placeholder="PhonePe Number">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="paytm_number">Paytm Number</label>
                                    <input type="number" class="form-control" id="paytm_number" name="paytm_number" placeholder="Paytm Number">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="google_pay_number">Google Pay Number</label>
                                    <input type="number" class="form-control" id="google_pay_number" name="google_pay_number" placeholder="Google Pay Number">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="upi_id">UPI ID</label>
                                    <input type="number" class="form-control" id="upi_id" name="upi_id" placeholder="UPI ID">
                                </div>
                            </div>

                            <hr>
                            <h4>Attachments</h4>
                            <div class="row">
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="photo">Photo</label>
                                    <input type="file" class="form-control" id="photo" name="photo" placeholder="Photo" accept="image/*">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="address_proof">Address Proof</label>
                                    <input type="file" class="form-control" id="address_proof" name="address_proof" placeholder="Address Proof">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="id_proof">ID Proof</label>
                                    <input type="file" class="form-control" id="id_proof" name="id_proof" placeholder="ID Proof">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="pan_card">PAN Card</label>
                                    <input type="file" class="form-control" id="pan_card" name="pan_card" placeholder="PAN Card">
                                </div>
                                <!--Col-->
                                <div class="col-md-4">
                                    <label for="educational_proof">Educational Proof</label>
                                    <input type="file" class="form-control" id="educational_proof" name="educational_proof" placeholder="Educational Proof">
                                </div>
                            </div>

                            <input type="submit" value="Create" name="user_form_submit" class="btn btn-primary">
                        </form>
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
  <!--Custom script-->
  <script>
    //displaying fields based on user type
    function view_hidden_field(){ 
        var user_type=$('#user_type').val();
        if(user_type == 'agent'){
            $('#branch_manager_id_column').css('visibility','visible');
            $('#branch_manager_id').attr('required',"required");
            $('#branch_column').css('visibility','hidden');
            $('#branch').removeAttr('required');
        }elseif(user_type == 'branch_manager'){
            $('#branch_column').css('visibility','visible');
            $('#branch').attr('required',"required");
            $('#branch_manager_id_column').css('visibility','hidden');
            $('#branch_manager_id').removeAttr('required');
        }else{
            $('#branch_manager_id_column').css('visibility','hidden');
            $('#branch_manager_id').removeAttr('required');
            $('#branch_column').css('visibility','hidden');
            $('#branch').removeAttr('required');
        }
    }
    //ajax function for checking duplication of phone number and email
    function ajax_call() {
        $.ajax({
            url:"ajax_users_contact.php",
            type:"post",
            success:function(response){
                ajax_content.set_content(response);
            }
        });
    }
    var ajax_content={
        content:"",
        set_content:function(content){
            this.content=content;
        },
        get_content:function(){
            return this.content;
        }
    };
    function check_mobile_duplication(){
        var isDuplicate=false;
        var entered_mobile=$('#mobile').val();
        var json=JSON.parse(ajax_content.get_content());
        //checking for branch manager
        for(mobile of json['branch_manager']['mobile']){
            if(mobile.localeCompare(entered_mobile)==0){
                isDuplicate=true;
                break;
            }
        }
        //checking for operator
        for(mobile of json['operator']['mobile']){
            if(mobile.localeCompare(entered_mobile)==0){
                isDuplicate=true;
                break;
            }
        }
        //checking for accountant
        for(mobile of json['accountant']['mobile']){
            if(mobile.localeCompare(entered_mobile)==0){
                isDuplicate=true;
                break;
            }
        }
        //checking for agent
        for(mobile of json['agent']['mobile']){
            if(mobile.localeCompare(entered_mobile)==0){
                isDuplicate=true;
                break;
            }
        }
        //action on duplicate entry
        if(isDuplicate){
            //displaying error
            $('#mobile_error').text('(Number Already exists)');
            //clearing existing value
            $('#mobile').val('');
        }else{
            $('#mobile_error').text('');
        }
    }
    function check_email_duplication(){
        var isDuplicate=false;
        var entered_email=$('#email').val();
        var json=JSON.parse(ajax_content.get_content());
        //checking for branch manager
        for(email of json['branch_manager']['email']){
            if(email.localeCompare(entered_email)==0){
                isDuplicate=true;
                break;
            }
        }
        //checking for operator
        for(email of json['operator']['email']){
            if(email.localeCompare(entered_email)==0){
                isDuplicate=true;
                break;
            }
        }
        //checking for accountant
        for(email of json['accountant']['email']){
            if(email.localeCompare(entered_email)==0){
                isDuplicate=true;
                break;
            }
        }
        //checking for agent
        for(email of json['agent']['email']){
            if(email.localeCompare(entered_email)==0){
                isDuplicate=true;
                break;
            }
        }
        //action on duplicate entry
        if(isDuplicate){
            //displaying error
            $('#email_error').text('(Email Already exists)');
            //clearing existing value
            $('#email').val('');
        }else{
            $('#email_error').text('');
        }
    }
    ajax_call();
  </script>
</body>
</html>

                        
              