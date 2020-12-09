<?php 

    include 'main.php';

    function get_approved_policy_result_set($agent_id){
        $user=new Policy();
        $approved_policy_result_set=$user->read_selective_policy("WHERE NOT comission_percentage=0 AND agent_id=".$agent_id);
        return $approved_policy_result_set;
    }
    //fetching transaction history of a particular agent
    function get_transaction_result_set($agent_id){
        $user=new Policy();
        $transaction_result_set=$user->read_selective_transaction("WHERE agent_id=".$agent_id);
        return $transaction_result_set; 
    }

    function generate_message($agent_id){
        $user=new Agent();
        $approved_policy_result_set=get_approved_policy_result_set($agent_id);
        $transaction_result_set=get_transaction_result_set($agent_id);
        $sort=false;
        //checking whether is to sort or not
        if($transaction_result_set && $approved_policy_result_set){
            $sort=true;
        }

        $message="";

        $message=$message."<html>";
        $message=$message."<body>";
        $message=$message."<table>";

        //attaching header of the table
        $message=$message."<tr style=\"background:greenyellow\">
        <th style=\"border:1px solid black\">Policy Date</th>
        <th style=\"border:1px solid black\">Company Name</th>
        <th style=\"border:1px solid black\">Policy Number</th>
        <th style=\"border:1px solid black\">Registration Number</th>
        <th style=\"border:1px solid black\">Product</th>
        <th style=\"border:1px solid black\">Customer Name</th>
        <th style=\"border:1px solid black\">Payment Mode</th>
        <th style=\"border:1px solid black\">Total Premium</th>
        <th style=\"border:1px solid black\">Balance</th>
        </tr>";

        //sorting
        if($sort){
            //sorting and viewing based on date
            $sorted_array_of_policy_and_transaction_array=array();
            //initilizing two arrays
            $approved_policy_array=array();
            $transaction_array=array();
            //adding policy result to the array
            $i=0;
            while($approved_policy_result=$approved_policy_result_set->fetch_assoc()){
                $approved_policy_array[$i]=array('Policy',$approved_policy_result);
                $i++;
            }
            //adding transaction result to the array
            $i=0;
            while( $transaction_result= $transaction_result_set->fetch_assoc()){
                $transaction_array[$i]=array('Transaction',$transaction_result);
                $i++;
            }
            //sorting arrays based on dates
            $approved_policy_array_index=0;
            $transaction_array_index=0;
            $sorted_array_of_policy_and_transaction_array_index=0;

            while(true){
                //base condition
                if(($approved_policy_array_index>=count($approved_policy_array) && $transaction_array_index>=count($transaction_array))){
                    break;
                }else{
                    //checking condition for displaying only 10 transactions
                    if($sorted_array_of_policy_and_transaction_array_index>=11){
                        break;
                    }
                    //iteration
                    //if one has array has been empty
                    //approved policy array is over
                    if($approved_policy_array_index>=count($approved_policy_array)){
                        //copying value of non empty array to the sorted array
                        for($i=$transaction_array_index;$i<count($transaction_array);$i++){
                            $sorted_array_of_policy_and_transaction_array[ $sorted_array_of_policy_and_transaction_array_index]=$transaction_array[$transaction_array_index];
                            $sorted_array_of_policy_and_transaction_array_index++;
                            $transaction_array_index++;
                            //checking condition for displaying only 10 transactions
                            if($sorted_array_of_policy_and_transaction_array_index>=11){
                                break;
                            }
                        }
                    }
                    //transaction array is over
                    elseif($transaction_array_index>=count($transaction_array)){
                        //copying value of non empty array to the sorted array
                        for($i=$approved_policy_array_index;$i<count($approved_policy_array);$i++){
                            $sorted_array_of_policy_and_transaction_array[ $sorted_array_of_policy_and_transaction_array_index]=$approved_policy_array[$approved_policy_array_index];
                            $sorted_array_of_policy_and_transaction_array_index++;
                            $approved_policy_array_index++;
                            //checking condition for displaying only 10 transactions
                            if($sorted_array_of_policy_and_transaction_array_index>=11){
                                break;
                            }
                        }
                    }else{
                        //if both has values
                        if($approved_policy_array[$approved_policy_array_index][1]['od_policy_start_date']>$transaction_array[$transaction_array_index][1]['date']){
                            $sorted_array_of_policy_and_transaction_array[$sorted_array_of_policy_and_transaction_array_index]=$approved_policy_array[$approved_policy_array_index];
                            $sorted_array_of_policy_and_transaction_array_index++;
                            $approved_policy_array_index++;
                        }else{
                            $sorted_array_of_policy_and_transaction_array[$sorted_array_of_policy_and_transaction_array_index]=$transaction_array[$transaction_array_index];
                            $sorted_array_of_policy_and_transaction_array_index++;
                            $transaction_array_index++;
                        }
                    }
                }
            }

            //displaying the sorted content
            for($i=0;$i<count($sorted_array_of_policy_and_transaction_array);$i++){
                if(strcasecmp($sorted_array_of_policy_and_transaction_array[$i][0],'Transaction')==0){
                    if(strcasecmp($sorted_array_of_policy_and_transaction_array[$i][1]['payment'],'Office_Expenses_Request')!=0){
                        $message=$message."<tr>";
                        $message=$message."  <td style=\"border:1px solid black\">".$sorted_array_of_policy_and_transaction_array[$i][1]['date']."</td>";
                        $message=$message."  <td style=\"border:1px solid black\">".$sorted_array_of_policy_and_transaction_array[$i][1]['payment']."</td>";
                        $message=$message."  <td style=\"border:1px solid black\">".$sorted_array_of_policy_and_transaction_array[$i][1]['remark']."</td>";
                        $message=$message."  <td style=\"border:1px solid black\"></td>";
                        $message=$message."  <td style=\"border:1px solid black\"></td>";
                        $message=$message."  <td style=\"border:1px solid black\"></td>";
                        $message=$message."  <td style=\"border:1px solid black\"></td>";
                        $message=$message."  <td style=\"border:1px solid black\"></td>";
                        if(strcasecmp($sorted_array_of_policy_and_transaction_array[$i][1]['payment'],'Recived')==0){
                            $message=$message."  <td style=\"border:1px solid black\">+".$sorted_array_of_policy_and_transaction_array[$i][1]['amount']."</td>";
                        }elseif(strcasecmp($sorted_array_of_policy_and_transaction_array[$i][1]['payment'],'Paid')==0){
                            $message=$message."  <td style=\"border:1px solid black\">-".$sorted_array_of_policy_and_transaction_array[$i][1]['amount']."</td>";
                        }elseif(strcasecmp($sorted_array_of_policy_and_transaction_array[$i][1]['payment'],'Office_Expenses')==0){
                            $message=$message."  <td style=\"border:1px solid black\">+".$sorted_array_of_policy_and_transaction_array[$i][1]['amount']."</td>";
                        }
                        $message=$message."</tr>";
                    }
                }else{
                    $message=$message."<tr>";
                    $message=$message."  <td style=\"border:1px solid black\">".$sorted_array_of_policy_and_transaction_array[$i][1]['issue_date']."</td>";
                    $message=$message."  <td style=\"border:1px solid black\">".$sorted_array_of_policy_and_transaction_array[$i][1]['company_name']."</td>";
                    $message=$message."  <td style=\"border:1px solid black\">".$sorted_array_of_policy_and_transaction_array[$i][1]['policy_number']."</td>";
                    $message=$message."  <td style=\"border:1px solid black\">".$sorted_array_of_policy_and_transaction_array[$i][1]['registration_number']."</td>";
                    $message=$message."  <td style=\"border:1px solid black\">".$sorted_array_of_policy_and_transaction_array[$i][1]['product']."</td>";
                    $message=$message."  <td style=\"border:1px solid black\">".$sorted_array_of_policy_and_transaction_array[$i][1]['customer_name']."</td>";
                    $message=$message."  <td style=\"border:1px solid black\">".$sorted_array_of_policy_and_transaction_array[$i][1]['payment_mode']."</td>";
                    $message=$message."  <td style=\"border:1px solid black\">".$sorted_array_of_policy_and_transaction_array[$i][1]['total_premium']."</td>";
                    //calculating comission
                    $comission=0;
                    if($sorted_array_of_policy_and_transaction_array[$i][1]['comission_type']=="OD"){
                        $comission=$sorted_array_of_policy_and_transaction_array[$i][1]['od_premium']*($sorted_array_of_policy_and_transaction_array[$i][1]['comission_percentage']/100);
                    }
                    if($sorted_array_of_policy_and_transaction_array[$i][1]['comission_type']=="NP"){
                        $comission=$sorted_array_of_policy_and_transaction_array[$i][1]['net_premium']*($sorted_array_of_policy_and_transaction_array[$i][1]['comission_percentage']/100);
                    }
                    //displaying balance
                    if(strcasecmp($sorted_array_of_policy_and_transaction_array[$i][1]['payment_mode'],'Cash')==0){
                        $message=$message."  <td style=\"border:1px solid black\">-".($sorted_array_of_policy_and_transaction_array[$i][1]['total_premium']-$comission)."</td>";
                    }else{
                        $message=$message."  <td style=\"border:1px solid black\">+".$comission."</td>";
                    }
                    $message=$message."</tr>";
                }
            }
            //displaying balance
            $message=$message."<tr style=\"background:yellow\">";
            $message=$message."  <td style=\"border:1px solid black\">".date('Y-m-d')."</td>";
            $message=$message."  <td style=\"border:1px solid black\"><b>Balance</b></td>";
            $message=$message."  <td style=\"border:1px solid black\"></td>";
            $message=$message."  <td style=\"border:1px solid black\"></td>";
            $message=$message."  <td style=\"border:1px solid black\"></td>";
            $message=$message."  <td style=\"border:1px solid black\"></td>";
            $message=$message."  <td style=\"border:1px solid black\"></td>";
            $message=$message."  <td style=\"border:1px solid black\"></td>";
            $message=$message."  <td style=\"border:1px solid black\">".(-1)*$user->get_wallet_amount($agent_id)."</td>";
            $message=$message."</tr>";
        }else{
            //no sorting required
            if($transaction_result_set || $approved_policy_result_set){
                if($approved_policy_result_set){
                    while($approved_policy_result=$approved_policy_result_set->fetch_assoc()){
                        $message=$message."<tr>";
                        $message=$message."  <td style=\"border:1px solid black\">".$approved_policy_result['issue_date']."</td>";
                        $message=$message."  <td style=\"border:1px solid black\">".$approved_policy_result['company_name']."</td>";
                        $message=$message."  <td style=\"border:1px solid black\">".$approved_policy_result['policy_number']."</td>";
                        $message=$message."  <td style=\"border:1px solid black\">".$approved_policy_result['registration_number']."</td>";
                        $message=$message."  <td style=\"border:1px solid black\">".$approved_policy_result['product']."</td>";
                        $message=$message."  <td style=\"border:1px solid black\">".$approved_policy_result['customer_name']."</td>";
                        $message=$message."  <td style=\"border:1px solid black\">".$approved_policy_result['payment_mode']."</td>";
                        $message=$message."  <td style=\"border:1px solid black\">".$approved_policy_result['total_premium']."</td>";
                        //calculating comission
                        $comission=0;
                        if($approved_policy_result['comission_type']=='OD'){
                            $comission=$approved_policy_result['od_premium']*($approved_policy_result['comission_percentage']/100);
                        }
                        if($approved_policy_result['comission_type']=='NP'){
                            $comission=$approved_policy_result['net_premium']*($approved_policy_result['comission_percentage']/100);
                        }
                        //balance
                        if(strcasecmp($approved_policy_result['payment_mode'],'Cash')==0){
                            $message=$message."  <td style=\"border:1px solid black\">-".($approved_policy_result['total_premium']-$comission)."</td>";
                        }else{
                            $message=$message."  <td style=\"border:1px solid black\">+".$comission."</td>";
                        }
                        $message=$message."</tr>";
                    }

                    //displaying balance
                    $message=$message."<tr style=\"background:yellow\">";
                    $message=$message."  <td style=\"border:1px solid black\">".date('Y-m-d')."</td>";
                    $message=$message."  <td style=\"border:1px solid black\"><b>Balance</b></td>";
                    $message=$message."  <td style=\"border:1px solid black\"></td>";
                    $message=$message."  <td style=\"border:1px solid black\"></td>";
                    $message=$message."  <td style=\"border:1px solid black\"></td>";
                    $message=$message."  <td style=\"border:1px solid black\"></td>";
                    $message=$message."  <td style=\"border:1px solid black\"></td>";
                    $message=$message."  <td style=\"border:1px solid black\"></td>";
                    $message=$message."  <td style=\"border:1px solid black\">".(-1)*$user->get_wallet_amount($agent_id)."</td>";
                    $message=$message."</tr>";
                }
                if($transaction_result_set){
                    while($transaction_result=$transaction_result_set->fetch_assoc()){
                        if(strcasecmp($transaction_result['payment'],'Office_Expenses_Request')!=0){
                            $message=$message."<tr>";
                            $message=$message."  <td style=\"border:1px solid black\">".$transaction_result['date']."</td>";
                            $message=$message."  <td style=\"border:1px solid black\">".$transaction_result['payment']."</td>";
                            $message=$message."  <td style=\"border:1px solid black\">".$transaction_result['remark']."</td>";
                            $message=$message."  <td style=\"border:1px solid black\"></td>";
                            $message=$message."  <td style=\"border:1px solid black\"></td>";
                            $message=$message."  <td style=\"border:1px solid black\"></td>";
                            $message=$message."  <td style=\"border:1px solid black\"></td>";
                            $message=$message."  <td style=\"border:1px solid black\"></td>";
                            if(strcasecmp($transaction_result['payment'],'Recived')==0){
                                $message=$message."  <td style=\"border:1px solid black\">+".$transaction_result['amount']."</td>";
                            }elseif(strcasecmp($transaction_result['payment'],'Paid')==0){
                                $message=$message."  <td style=\"border:1px solid black\">-".$transaction_result['amount']."</td>";
                            }elseif(strcasecmp($transaction_result['payment'],'Office_Expenses')==0){
                                $message=$message."  <td style=\"border:1px solid black\">+".$transaction_result['amount']."</td>";
                            }
                            $message=$message."</tr>";
                        }
                    }

                    //displaying balance
                    $message=$message."<tr style=\"background:yellow\">";
                    $message=$message."  <td style=\"border:1px solid black\">".date('Y-m-d')."</td>";
                    $message=$message."  <td style=\"border:1px solid black\"><b>Balance</b></td>";
                    $message=$message."  <td style=\"border:1px solid black\"></td>";
                    $message=$message."  <td style=\"border:1px solid black\"></td>";
                    $message=$message."  <td style=\"border:1px solid black\"></td>";
                    $message=$message."  <td style=\"border:1px solid black\"></td>";
                    $message=$message."  <td style=\"border:1px solid black\"></td>";
                    $message=$message."  <td style=\"border:1px solid black\"></td>";
                    $message=$message."  <td style=\"border:1px solid black\">".(-1)*$user->get_wallet_amount($agent_id)."</td>";
                    $message=$message."</tr>";
                }
            }else{
                $message=$message."<tr>No records found</tr>";
            }
        }
        $message=$message."</table>";
        $message=$message."</body>";
        $message=$message."</html>";

        return $message;
    }

    function crone(){
        $user=new Admin();
        $agent_result_set=$user->read_all_agent();
        if($agent_result_set){
            while($agent_result=$agent_result_set->fetch_assoc()){
                $wallet_amount=$user->get_wallet_amount($agent_result['id']);
                if($wallet_amount!=0){
                    if(send($agent_result['email'],"Wallet",generate_message($agent_result['id']))){
                        echo "sent";
                    }else{
                        echo "not sent";
                    }
                }
            }
        }
    }

    crone();

?>