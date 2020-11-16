<?php 
  include '../Php/main.php';

  //checking session
  $session=new Session();
  $session->check_session();
  //getting values of the policy
  $agent=new Agent();
  $result_set=$agent->read_one_policy($_GET['id'])->fetch_assoc();
  $columns=Policy_Contract::get_table_columns();
  //updating policy
  if(isset($_POST['submit'])){
    $agent->update_policy($_POST['policy_id']);
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Form</title>
    <!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

</head>
<body>
    <section id="table-content">
      <div class="container">
        <div class="table-conatiner">
          <div class="row">
            <div class="col-md-12">
              <form action="<?php echo $_SERVER['PHP_SELF']."?id=".$_GET['id'] ?>" method="POST">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Signifier</th>
                      <th scope="col">Input</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!--setting hidden id variable for passing to update-->
                    <input type="hidden" value="<?php echo $_GET['id'];?>" name="policy_id">
                    <!--Row-->
                    <tr>
                      <th scope="row">1</th>
                      <div class="form-group">
                        <td><label for="issue_date">Issue Date</label></td>
                        <td><input type="date" class="form-control" id="issue_date" value="<?php echo $result_set[$columns[0]] ?>" name="issue_date" placeholder="Issue Date" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">2</th>
                      <div class="form-group">
                        <td><label for="company_name">Company Name</label></td>
                        <td><input type="text" class="form-control" id="company_name" value="<?php echo $result_set[$columns[1]] ?>" name="company_name" placeholder="Company Name" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">3</th>
                      <div class="form-group">
                        <td><label for="policy_type">Policy Type</label></td>
                        <td><input type="text" class="form-control" id="policy_type" value="<?php echo $result_set[$columns[2]] ?>" name="policy_type" placeholder="Policy Type" required="required"></td>
                      </div>
                    </tr> 
                    <!--Row-->
                    <tr>
                      <th scope="row">4</th>
                      <div class="form-group">
                        <td><label for="product">Product</label></td>
                        <td><input type="text" class="form-control" id="product" value="<?php echo $result_set[$columns[3]] ?>" name="product" placeholder="Product" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">5</th>
                      <div class="form-group">
                        <td><label for="policy_number">Policy Number</label></td>
                        <td><input type="number" class="form-control" id="policy_number" value="<?php echo $result_set[$columns[4]] ?>" name="policy_number" placeholder="Policy Number" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">6</th>
                      <div class="form-group">
                        <td><label for="customer_name">Customer Name</label></td>
                        <td><input type="text" class="form-control" id="customer_name" value="<?php echo $result_set[$columns[5]] ?>" name="customer_name" placeholder="Customer Name" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">7</th>
                      <div class="form-group">
                        <td><label for="mobile">Mobile</label></td>
                        <td><input type="number" class="form-control" id="mobile" value="<?php echo $result_set[$columns[6]] ?>" name="mobile" placeholder="Mobile" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">8</th>
                      <div class="form-group">
                        <td><label for="email">Email</label></td>
                        <td><input type="email" class="form-control" id="email" value="<?php echo $result_set[$columns[7]] ?>" name="email" placeholder="Email" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">9</th>
                      <div class="form-group">
                        <td><label for="registration_number">Registration Number</label></td>
                        <td><input type="text" class="form-control" id="registration_number" value="<?php echo $result_set[$columns[8]] ?>" name="registration_number" placeholder="Registration Number" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">10</th>
                      <div class="form-group">
                        <td><label for="make_model">Make Model</label></td>
                        <td><input type="text" class="form-control" id="make_model" value="<?php echo $result_set[$columns[9]] ?>" name="make_model" placeholder="Make Model" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">11</th>
                      <div class="form-group">
                        <td><label for="od_policy_start_date">OD Policy Start Date</label></td>
                        <td><input type="date" class="form-control" id="od_policy_start_date" value="<?php echo $result_set[$columns[10]] ?>" name="od_policy_start_date" placeholder="OD Policy Start Date" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">12</th>
                      <div class="form-group">
                        <td><label for="od_policy_period">OD Policy Period</label></td>
                        <td><input type="number" class="form-control" id="od_policy_period" value="<?php echo $result_set[$columns[11]] ?>" name="od_policy_period" placeholder="OD Policy Period" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">13</th>
                      <div class="form-group">
                        <td><label for="od_policy_end_date">OD Policy End Date</label></td>
                        <td><input type="date" class="form-control" id="od_policy_end_date" value="<?php echo $result_set[$columns[12]] ?>" name="od_policy_end_date" placeholder="OD Policy End Date" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">14</th>
                      <div class="form-group">
                        <td><label for="tp_policy_start_date">TP Policy Start Date</label></td>
                        <td><input type="date" class="form-control" id="tp_policy_start_date" value="<?php echo $result_set[$columns[13]] ?>" name="tp_policy_start_date" placeholder="TP Policy Start Date" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">15</th>
                      <div class="form-group">
                        <td><label for="tp_policy_period">TP Policy Period</label></td>
                        <td><input type="number" class="form-control" id="tp_policy_period" value="<?php echo $result_set[$columns[14]] ?>" name="tp_policy_period" placeholder="TP Policy Period" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">16</th>
                      <div class="form-group">
                        <td><label for="tp_policy_end_date">TP Policy End Date</label></td>
                        <td><input type="date" class="form-control" id="tp_policy_end_date" value="<?php echo $result_set[$columns[15]] ?>" name="tp_policy_end_date" placeholder="TP Policy End Date" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">17</th>
                      <div class="form-group">
                        <td><label for="od_disc">OD Disc</label></td> 
                        <td><input type="text" class="form-control" id="od_disc" value="<?php echo $result_set[$columns[16]] ?>" name="od_disc" placeholder="OD Disc" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">18</th>
                      <div class="form-group">
                        <td><label for="od_premium">OD Premium</label></td>
                        <td><input type="text" class="form-control" id="od_premium" value="<?php echo $result_set[$columns[17]] ?>" name="od_premium" placeholder="OD Premium" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">19</th>
                      <div class="form-group">
                        <td><label for="tp_premium">TP Premium</label></td>
                        <td><input type="text" class="form-control" id="tp_premium" value="<?php echo $result_set[$columns[18]] ?>" name="tp_premium" placeholder="TP Premium" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">20</th>
                      <div class="form-group">
                        <td><label for="net_premium">NET Premium</label></td>
                        <td><input type="text" class="form-control" id="net_premium" value="<?php echo $result_set[$columns[19]] ?>" name="net_premium" placeholder="NET Premium" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">21</th>
                      <div class="form-group">
                        <td><label for="total_premium">Total Premium</label></td>
                        <td><input type="text" class="form-control" id="total_premium" value="<?php echo $result_set[$columns[20]] ?>" name="total_premium" placeholder="Total Premium" required="required"></td>
                      </div>
                    </tr>
                    <!--Row-->
                    <tr>
                      <th scope="row">22</th>
                      <div class="form-group">
                        <td><label for="payment_mode">Payment Mode</label></td>
                        <td>
                          <select name="payment_mode" id="payment_mode" value="<?php echo $result_set[$columns[21]] ?>" required="required">
                            <option value="Cash">Cash</option>
                            <option value="Cheque">Cheque</option>
                            <option value="DD">DD</option>
                          </select>
                        </td>
                      </div>
                    </tr>
                  </tbody>
                </table>
                <input type="submit" value="Update" name="submit" class="btn btn-primary">
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>