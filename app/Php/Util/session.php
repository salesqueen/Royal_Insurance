<?php 

error_reporting(0);

class Session{
    public function initiate_session($key,$value){
        session_start();
        for($i=0;$i<count($key);$i++){
            $_SESSION[$key[$i]]=$value[$i];
        }
    }
    public function check_session($user_type){
        session_start();
        if($_SESSION['id'] != "" && $_SESSION['id'] != null && $_SESSION['user_type']==$user_type){
            return true;
        }else{
            header("location:../sign_in.php");
        }
    }
} 

?>