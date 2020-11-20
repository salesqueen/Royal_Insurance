<?php 

  include 'Php/main.php';

  //session handelling
  $session=new Session();
  $session->check_session("Agent");
  //destroying session
  session_destroy();
  //redirecting to sign in page
  header("Location:sign_in.php");

?>