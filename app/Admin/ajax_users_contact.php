<?php

    error_reporting(0);

    include '../Php/main.php';
    //json generator
    function generate_json_response($branch_manager_mobile_email_array,$operator_mobile_email_array,$accountant_mobile_email_array,$agent_mobile_email_array){
        $json='{';
        //APPENDING BRANCH MANAGER
        $json=$json.'"branch_manager":{';
        //branch manager mobile
        $json=$json.'"mobile":[';
        foreach($branch_manager_mobile_email_array[0] as $branch_manager_mobile){
            $json=$json.'"'.$branch_manager_mobile.'",';
        }
        //condition for empty array
        if(count($branch_manager_mobile_email_array[0])>0){
            $json=substr($json,0,-1);
        }
        $json=$json."],";
        //branch manager email
        $json=$json.'"email":[';
        foreach($branch_manager_mobile_email_array[1] as $branch_manager_email){
            $json=$json.'"'.$branch_manager_email.'",';
        }
        //condition for empty array
        if(count($branch_manager_mobile_email_array[1])>0){
            $json=substr($json,0,-1);
        }
        $json=$json."]";
        //ending branch manger
        $json=$json.'},';
        //APPENDING OPERATOR
        $json=$json.'"operator":{';
        //branch manager mobile
        $json=$json.'"mobile":[';
        foreach($operator_mobile_email_array[0] as $operator_mobile){
            $json=$json.'"'.$operator_mobile.'",';
        }
        //condition for empty array
        if(count($operator_mobile_email_array[0])>0){
            $json=substr($json,0,-1);
        }
        $json=$json."],";
        //branch manager email
        $json=$json.'"email":[';
        foreach($operator_mobile_email_array[1] as $operator_email){
            $json=$json.'"'.$operator_email.'",';
        }
        //condition for empty array
        if(count($operator_mobile_email_array[1])>0){
            $json=substr($json,0,-1);
        }
        $json=$json."]";
        //ending branch manger
        $json=$json.'},';
        //APPENDING ACCOUNTANT
        $json=$json.'"accountant":{';
        //branch manager mobile
        $json=$json.'"mobile":[';
        foreach($accountant_mobile_email_array[0] as $accountant_mobile){
            $json=$json.'"'.$accountant_mobile.'",';
        }
        //condition for empty array
        if(count($accountant_mobile_email_array[0])>0){
            $json=substr($json,0,-1);
        }
        $json=$json."],";
        //branch manager email
        $json=$json.'"email":[';
        foreach($accountant_mobile_email_array[1] as $accountant_email){
            $json=$json.'"'.$accountant_email.'",';
        }
        //condition for empty array
        if(count($accountant_mobile_email_array[1])>0){
            $json=substr($json,0,-1);
        }
        $json=$json."]";
        //ending branch manger
        $json=$json.'},';
        //APPENDING ACCOUNTANT
        $json=$json.'"agent":{';
        //branch manager mobile
        $json=$json.'"mobile":[';
        foreach($agent_mobile_email_array[0] as $agent_mobile){
            $json=$json.'"'.$agent_mobile.'",';
        }
        //condition for empty array
        if(count($agent_mobile_email_array[0])>0){
            $json=substr($json,0,-1);
        }
        $json=$json."],";
        //branch manager email
        $json=$json.'"email":[';
        foreach($agent_mobile_email_array[1] as $agent_email){
            $json=$json.'"'.$agent_email.'",';
        }
        //condition for empty array
        if(count($agent_mobile_email_array[1])>0){
            $json=substr($json,0,-1);
        }
        $json=$json."]";
        //ending branch manger
        $json=$json.'}';
        //ending json
        $json=$json.'}';
        return $json;
    }
    //fetching funtions
    //fetching branch manager
    function branch_manager(){
        $user=new Branch_Manager();
        return $user->read_all_branch_manager();
    }
    //fetching operator
    function operator(){
        $user=new Operator();
        return $user->read_all_operator();
    }
    //fetching accountant
    function accountant(){
        $user=new Accountant();
        return $user->read_all_accountant();
    }
    //fetching agent
    function agent(){
        $user=new Agent();
        return $user->read_all_agent();
    }
    //spliting function 
    function split_mobile_email($result_set){
        $mobile_array=array();
        $email_array=array();
        $i=0;
        if($result_set){
            while($result=$result_set->fetch_assoc()){
                $mobile_array[$i]=$result["mobile"];
                $email_array[$i]=$result["email"];
                $i++;
            }
        }
        return array($mobile_array,$email_array);
    }
    //init function
    function send_policy_data(){
        //fetching all user data
        $branch_manager_result_set=branch_manager();
        $operator_result_set=operator();
        $accountant_result_set=accountant();
        $agent_result_set=agent();
        //call to split mobile numbers and email
        $branch_manager_mobile_email_array=split_mobile_email($branch_manager_result_set);
        $operator_mobile_email_array=split_mobile_email($operator_result_set);
        $accountant_mobile_email_array=split_mobile_email($accountant_result_set);
        $agent_mobile_email_array=split_mobile_email($agent_result_set);
        //json generation
        $json=generate_json_response($branch_manager_mobile_email_array,$operator_mobile_email_array,$accountant_mobile_email_array,$agent_mobile_email_array);
        echo $json;
    }
    send_policy_data();

?>