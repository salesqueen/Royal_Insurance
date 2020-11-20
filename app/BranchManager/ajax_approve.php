<?php

    error_reporting(0);

    include "../Php/main.php";
    //json generator
    function generate_json_response($key,$value){
        $policy=new Policy();
        $json="{";
        for($i=0;$i<count($key)-1;$i++){
            $json=$json.'"'.$key[$i].'":'.'"'.$value[$i].'",';
        } 
        //appending company code array
        $json=$json.'"company_code":[';
        $company_code_result_set=$policy->get_company_code_result_set($value[1]);
        if($company_code_result_set){
            while($company_code_result=$company_code_result_set->fetch_assoc()){
                $json=$json.'"'.$company_code_result['company_code'].'",';
            }
            $json=substr($json,0,-1);
        }
        $json=$json."]}";
        return $json;
    } 
    //function generate values array
    function generate_value_array($key,$result){
        $value=array();
        for($i=0;$i<count($key);$i++){
            $value[$i]=$result[$key[$i]];
        }
        return $value;
    }
    //function for retriving policy data
    function policy($id){
        $policy=new Policy();
        $policy_result_set=$policy->read_one_policy($id);
        $policy_result=$policy_result_set->fetch_assoc();
        return $policy_result;
    }
    function send_policy_data(){
        $result=policy($_POST['policy_id']);
        $key=Policy_Contract::get_table_columns();
        //genarating value array
        $value=array();
        for($i=0;$i<count($key);$i++){
            $value[$i]=$result[$key[$i]];
        }
        $json=generate_json_response($key,$value);
        echo $json;
    }
    send_policy_data();

?>