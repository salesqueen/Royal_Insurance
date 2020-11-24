<?php

    //error_reporting(0);

    include "../Php/main.php";
    //json generator
    function generate_json_response($key,$value){
        $policy=new Policy();
        $json="{";
        for($i=0;$i<count($key)-1;$i++){
            $json=$json.'"'.$key[$i].'":'.'"'.$value[$i].'",';
        } 
        //removing last comma
        $json=substr($json,0,-1);
        $json=$json."}";
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
    function agent($id){
        $agent=new Agent();
        $agent_result_set=$agent->read_one_agent($id);
        $agent_result=$agent_result_set->fetch_assoc();
        return $agent_result;
    }
    function send_policy_data(){
        $result=agent($_POST['agent_id']);
        $key=Agent_Contract::get_table_columns();
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