<?php 

    include 'main.php';

    function crone(){
        $user=new Admin();
        $agent_result_set=$user->read_all_agent();
        if($agent_result_set){
            while($agent_result=$agent_result_set->fetch_assoc()){
                $wallet_amount=$user->get_wallet_amount($agent_result['id']);
                if($wallet_amount<-50){
                    $message="";
                    //send($agent_result['email'],'','');
                }
            }
        }
    }

    crone();

?>