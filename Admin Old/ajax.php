<?php 
    error_reporting(0);
    include "../Php/main.php";
    //json generator
    function generate_json_response($key,$value){
        $json="{";
        for($i=0;$i<count($key)-1;$i++){
            $json=$json.'"'.$key[$i].'":'.'"'.$value[$i].'",';
        }
        $json=$json.'"'.$key[count($key)-1].'":'.'"'.$value[count($key)-1].'"';
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
    function policy($id){
        $policy=new Policy();
        $policy_result_set=$policy->read_one_policy($id);
        $policy_result=$policy_result_set->fetch_assoc();
        return $policy_result;
    }
    //function for pagination based contents general
    function data(){
        //initiating required variables
        $admin=new Admin();
        //forming key variables
        $cheque_key=Cheque_Contract::get_table_columns();
        $policy_key=Policy_Contract::get_table_columns();
        $agent_key=Agent_Contract::get_table_columns();
        //reading all agents
        $agent_result_set=$admin->read_all_agent();
        //checking whether has data
        if($agent_result_set){
            $json='{';
            $i=0;
            while($agent_result=$agent_result_set->fetch_assoc()){
                $json=$json.'"'.$i.'":{';
                    //forming agent details key value
                    $json=$json.'"agent":';
                    //forming json for the agent values
                    $agent_value=generate_value_array($agent_key,$agent_result);
                    $json=$json.generate_json_response($agent_key,$agent_value);
                    $json=$json.',';
                    $json=$json.'"policy":[';
                    //adding policy of the corresponding agent
                    $policy_result_set=$admin->read_selective_policy('WHERE agent_id='.$agent_result['id']);
                    if($policy_result_set){
                        while($policy_result=$policy_result_set->fetch_assoc()){
                            //forming json for the policy values
                            $policy_value=generate_value_array($policy_key,$policy_result);
                            //fetching the corresponding cheque data if available
                            if($policy_result['payment_mode']=='Cheque' || $policy_result['payment_mode']=='DD'){
                                $cheque_result_set=$admin->read_custom("SELECT * FROM cheque WHERE policy_id=".$policy_result['id']);
                                if($cheque_result_set){
                                    $cheque_result=$cheque_result_set->fetch_assoc();
                                    //forming the cheque value array
                                    $cheque_value=generate_value_array($cheque_key,$cheque_result);
                                    //adding the cheque to the policy 
                                    $policy_key=array_merge($policy_key,$cheque_key);
                                    $policy_value=array_merge($policy_value,$cheque_value);
                                }
                            }
                            $json=$json.generate_json_response($policy_key,$policy_value);
                            $json=$json.',';
                        }
                        //removing last comma
                        $json=substr($json,0,strlen($json)-1);
                    }
                    $json=$json.']';
                    $json=$json.'}';
                $i++;
            }
            //removing last comma
            $json=substr($json,0,strlen($json)-1);
            $json=$json.'}';
            $json=$json.'}';
            echo $json;
        }else{
            echo "";
        }
    }
    //pagination for pending cheque status
    /*function paginate_pending_cheque_status(){
        $cheque=new Cheque();
        $page_number=$_POST['page_number'];
        if($page_number>=2){
            $offset=$page_number=(($page_number-1)*10)-1;
            //getting cheque results
            $pending_cheque_result_set=$cheque->read_custom("SELECT * FROM cheque WHERE cheque_status='Pending' LIMIT 10 OFFSET ".$offset);
            if($pending_cheque_result_set){
                $i=0;
                $json='{';
                while($pending_cheque_result=$pending_cheque_result_set->fetch_assoc()){
                    //getting policy results of the corresponding cheque
                    $pending_policy_with_pending_cheque_result=policy($pending_cheque_result['policy_id']);
                    //generating values
                    $json=$json.'"'.$i.'":';
                    //generating policy array
                    $policy_key=Policy_Contract::get_table_columns();
                    $policy_value=array();
                    for($j=0;$j<count($policy_key);$j++){
                        $policy_value[$j]=$pending_policy_with_pending_cheque_result[$policy_key[$j]];
                    }
                    //generating cheque array
                    $cheque_key=Cheque_Contract::get_table_columns();
                    $cheque_value=array();
                    for($j=0;$j<count($cheque_key);$j++){
                        $cheque_value[$j]=$pending_cheque_result[$cheque_key[$j]];
                    }
                    //combining policy and cheque arrays
                    $key=array_merge($policy_key,$cheque_key);
                    $value=array_merge($policy_value,$cheque_value);
                    //adding agent name key and value
                    //extractring name of the agent
                    $agent=new Agent();
                    $agent_result_set=$agent->read_one_agent($pending_policy_with_pending_cheque_result['agent_id']);
                    $agent_result=$agent_result_set->fetch_assoc();
                    //adding agent name key value
                    array_push($key,"agent_name");
                    array_push($value,$agent_result['name']);
                    //adding value to json
                    $json=$json.generate_json_response($key,$value).',';
                    $i++;
                }
                //removing last inserted ,
                $json=substr($json, 0, -1);
                $json=$json.'}';
        
                echo $json;
            }
        }else{
            //getting cheque results
            $pending_cheque_result_set=$cheque->read_custom("SELECT * FROM cheque WHERE cheque_status='Pending' LIMIT 10");
            if($pending_cheque_result_set){
                $i=0;
                $json='{';
                while($pending_cheque_result=$pending_cheque_result_set->fetch_assoc()){
                    //getting policy results of the corresponding cheque
                    $pending_policy_with_pending_cheque_result=policy($pending_cheque_result['policy_id']);
                    //generating values
                    $json=$json.'"'.$i.'":';
                    //generating policy array
                    $policy_key=Policy_Contract::get_table_columns();
                    $policy_value=array();
                    for($j=0;$j<count($policy_key);$j++){
                        $policy_value[$j]=$pending_policy_with_pending_cheque_result[$policy_key[$j]];
                    }
                    //generating cheque array
                    $cheque_key=Cheque_Contract::get_table_columns();
                    $cheque_value=array();
                    for($j=0;$j<count($cheque_key);$j++){
                        $cheque_value[$j]=$pending_cheque_result[$cheque_key[$j]];
                    }
                    //combining policy and cheque arrays
                    $key=array_merge($policy_key,$cheque_key);
                    $value=array_merge($policy_value,$cheque_value);
                    //adding agent name key and value
                    //extractring name of the agent
                    $agent=new Agent();
                    $agent_result_set=$agent->read_one_agent($pending_policy_with_pending_cheque_result['agent_id']);
                    $agent_result=$agent_result_set->fetch_assoc();
                    //adding agent name key value
                    array_push($key,"agent_name");
                    array_push($value,$agent_result['name']);
                    //adding value to json
                    $json=$json.generate_json_response($key,$value).',';
                    $i++;
                }
                //removing last inserted ,
                $json=substr($json, 0, -1);
                $json=$json.'}';
        
                echo $json;
            }
        }
        
    }*/
    //pagination for cleared cheque status
    /*function paginate_pending_cheque_status(){
        $cheque=new Cheque();
        $page_number=$_POST['page_number'];
        if($page_number>=2){
            $offset=$page_number=(($page_number-1)*10)-1;
            //getting cheque results
            $cleared_cheque_result_set=$cheque->read_custom("SELECT * FROM cheque WHERE NOT cheque_status='Pending' LIMIT 10 OFFSET ".$offset);
            if($cleared_cheque_result_set){
                $i=0;
                $json='{';
                while($cleared_cheque_result=$cleared_cheque_result_set->fetch_assoc()){
                    //getting policy results of the corresponding cheque
                    $pending_policy_with_cleared_cheque_result=policy($cleared_cheque_result['policy_id']);
                    //generating values
                    $json=$json.'"'.$i.'":';
                    //generating policy array
                    $policy_key=Policy_Contract::get_table_columns();
                    $policy_value=array();
                    for($j=0;$j<count($policy_key);$j++){
                        $policy_value[$j]=$pending_policy_with_cleared_cheque_result[$policy_key[$j]];
                    }
                    //generating cheque array
                    $cheque_key=Cheque_Contract::get_table_columns();
                    $cheque_value=array();
                    for($j=0;$j<count($cheque_key);$j++){
                        $cheque_value[$j]=$cleared_cheque_result[$cheque_key[$j]];
                    }
                    //combining policy and cheque arrays
                    $key=array_merge($policy_key,$cheque_key);
                    $value=array_merge($policy_value,$cheque_value);
                    //adding agent name key and value
                    //extractring name of the agent
                    $agent=new Agent();
                    $agent_result_set=$agent->read_one_agent($pending_policy_with_cleared_cheque_result['agent_id']);
                    $agent_result=$agent_result_set->fetch_assoc();
                    //adding agent name key value
                    array_push($key,"agent_name");
                    array_push($value,$agent_result['name']);
                    //adding value to json
                    $json=$json.generate_json_response($key,$value).',';
                    $i++;
                }
                //removing last inserted ,
                $json=substr($json, 0, -1);
                $json=$json.'}';
        
                echo $json;
            }
        }else{
            //getting cheque results
            $pending_cheque_result_set=$cheque->read_custom("SELECT * FROM cheque WHERE cheque_status='Pending' LIMIT 10");
            if($pending_cheque_result_set){
                $i=0;
                $json='{';
                while($pending_cheque_result=$pending_cheque_result_set->fetch_assoc()){
                    //getting policy results of the corresponding cheque
                    $pending_policy_with_pending_cheque_result=policy($pending_cheque_result['policy_id']);
                    //generating values
                    $json=$json.'"'.$i.'":';
                    //generating policy array
                    $policy_key=Policy_Contract::get_table_columns();
                    $policy_value=array();
                    for($j=0;$j<count($policy_key);$j++){
                        $policy_value[$j]=$pending_policy_with_pending_cheque_result[$policy_key[$j]];
                    }
                    //generating cheque array
                    $cheque_key=Cheque_Contract::get_table_columns();
                    $cheque_value=array();
                    for($j=0;$j<count($cheque_key);$j++){
                        $cheque_value[$j]=$pending_cheque_result[$cheque_key[$j]];
                    }
                    //combining policy and cheque arrays
                    $key=array_merge($policy_key,$cheque_key);
                    $value=array_merge($policy_value,$cheque_value);
                    //adding agent name key and value
                    //extractring name of the agent
                    $agent=new Agent();
                    $agent_result_set=$agent->read_one_agent($pending_policy_with_pending_cheque_result['agent_id']);
                    $agent_result=$agent_result_set->fetch_assoc();
                    //adding agent name key value
                    array_push($key,"agent_name");
                    array_push($value,$agent_result['name']);
                    //adding value to json
                    $json=$json.generate_json_response($key,$value).',';
                    $i++;
                }
                //removing last inserted ,
                $json=substr($json, 0, -1);
                $json=$json.'}';
        
                echo $json;
            }
        }
        
    }*/
    function check_function($function_name){
        if($function_name=="policy"){
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
        if($function_name=="paginate_pending_cheque_status"){
            paginate_pending_cheque_status();
        }
        if($function_name=='data'){
            data();
        }
    }
    check_function($_POST['function_name']);

?>