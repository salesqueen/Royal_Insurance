<?php 

  error_reporting(0);

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Admin");
  //creating user object
  $user=new Admin();
  //deletion
  $user->delete_policy_type($_GET['id']); 
  header("Location:menu_master_policy_type.php");

?>