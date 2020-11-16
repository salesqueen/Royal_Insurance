<?php

    error_reporting(0);

    //Packages
    include 'connection.php';

    class Crud{
        //Insertion
        public function insert($table,$columns,$values){
            //sql statement
            $sql="INSERT INTO ".$table." (";
            //forming column within ()
            $sql=$sql.$columns[0];
            for($i=1;$i<count($columns);$i++){
                $sql=$sql.",".$columns[$i];
            }
            //forming values within ()
            $sql=$sql.") VALUES (";
            $sql=$sql."'".$values[0]."'";
            for($i=1;$i<count($values);$i++){
                $sql=$sql.",'".$values[$i]."'";
            }
            $sql=$sql.");";
            if($GLOBALS['connection']->query($sql)){
                //Insertion successfull
                $_SESSION['message']="Insertion successfull";;
                return $GLOBALS['connection']->insert_id;
            }else{
                //something went wrong
                $_SESSION['message']="Insertion failed!";
            }
        }
        //Updation
        public function update($table,$id,$columns,$values){
            //sql statement
            $sql="UPDATE ".$table." SET ";
            //forming key value pair
            $iteration=count($values);
            for($i=0;$i<$iteration-1;$i++){
                $sql=$sql.$columns[$i]."='".$values[$i]."',";
            }
            $sql=$sql.$columns[$iteration-1]."='".$values[$iteration-1]."' WHERE id='".$id."';";
            if($GLOBALS['connection']->query($sql)){
                //Updation successfull
                $_SESSION['message']="Update successfull";
            }else{
                //something went wrong
                $_SESSION['message']="Updation Failed! ";
            }
        }
        //Deletion
        public function delete($table,$id){
            $sql="DELETE FROM ".$table." WHERE id=".$id;
            if($GLOBALS['connection']->query($sql)){
                //Deletion successfull
                $_SESSION['message']="Deletion successfull";
            }else{
                //something went wrong
                $_SESSION['message']="Deletion Failed!";
            }
        }
        //Read
        //One
        public function select_one($table,$id){
            $sql="SELECT * FROM ".$table." WHERE id=".$id.";";
            $result=$GLOBALS['connection']->query($sql);
            if($result->num_rows>0){
                return $result;
            }else{
                //no data available
                return false;
            }
        }
        //All
        public function select_all($table){
            $sql="SELECT * FROM ".$table." ORDER BY id DESC;";
            $result=$GLOBALS['connection']->query($sql);
            if($result->num_rows>0){
                return $result;
            }else{
                //no data available
                return false;
            } 
        }
        //Contraint
        public function select_contraint($table,$constraint){
            $sql="SELECT * FROM ".$table." ".$constraint." ORDER BY id DESC;";
            $result=$GLOBALS['connection']->query($sql);
            if($result->num_rows>0){
                return $result;
            }else{
                //no data available
                return false;
            }
        }
        //own
        public function select_custom($sql){
            $result=$GLOBALS['connection']->query($sql);
            if($result->num_rows>0){
                return $result;
            }else{
                //no data available
                return false;
            }
        }
        //custom query
        public function custom_query($sql){
            $result=$GLOBALS['connection']->query($sql);
            if($result){
                $_SESSION['message']="Executed successfully";
                return true;
            }else{
                //no data available
                return false;
            }
        }
    }

?>