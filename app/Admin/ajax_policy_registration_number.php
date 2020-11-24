<?php

    //error_reporting(0);

    include "../Php/main.php";
    //json generator
    function generate_json_response($policy_number_value,$registration_number_value){
        $json="{";
        //APPENDING POLICY NUMBER
        $json=$json.'"policy_number":[';
        foreach($policy_number_value as $policy_number){
            $json=$json.'"'.$policy_number.'",';
        }
        //condition for removing last comma
        if(count($policy_number_value)>0){
            $json=substr($json,0,-1);
        }
        //ending policy number
        $json=$json.'],';
        //APPENDING REGISTRATION NUMBER
        $json=$json.'"registration_number":[';
        foreach($registration_number_value as $registration_number){
            $json=$json.'"'.$registration_number.'",';
        }
        //condition for removing last comma
        if(count($registration_number_value)>0){
            $json=substr($json,0,-1);
        }
        //ending policy number
        $json=$json.']';
        //ending json
        $json=$json."}";
        return $json;
    } 
    //function for retriving policy data
    function policy(){
        $policy=new Policy();
        return $policy->read_all_policy($id);
    }
    function send_data(){
        $result_set=policy($_POST['policy_id']);
        $key=Policy_Contract::get_table_columns();
        //genarating value array
        $policy_number_value=array();
        $registration_number_value=array();
        $i=0;
        if($result_set){
            while($result=$result_set->fetch_assoc()){
                $policy_number_value[$i]=$result['policy_number'];
                $registration_number_value[$i]=$result['registration_number'];
                $i++;
            }
        }
        $json=generate_json_response($policy_number_value,$registration_number_value);
        echo $json;
    }
    send_data();

?>