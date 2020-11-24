<?php 

  //error_reporting(0);

  include '../Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Admin");
  //creating user object
  $user=new Admin();
  //deletion
  $user->delete_branch($_GET['id']); 
  header("Location:menu_manage_user_create_branch.php");

?>