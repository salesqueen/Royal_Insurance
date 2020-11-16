//function for opening overlay in menu policy page
function policy_open_overlay(called_element){
    document.getElementById('overlay').style.right="0";
    ajax_call(called_element.id);
}
//function for opening overlay for menu wallet page
function wallet_open_overlay(){
    document.getElementById('overlay').style.right="0";
}
function close_overlay(){
    document.getElementById('overlay').style.right="-4000px";
}
function set_policy_values(json,id){
    var policy_object=JSON.parse(json);
    document.getElementById('policy_number').value=policy_object.policy_number;
    document.getElementById('company_name').value=policy_object.company_name;
    document.getElementById('product').value=policy_object.product;
    document.getElementById('od_premium').value=policy_object.od_premium;
    document.getElementById('net_premium').value=policy_object.net_premium;
    //appending company code 
    for(i in policy_object.company_code){
        console.log(policy_object.company_code[i]);
        $('#company_code').append('<option value="'+policy_object.company_code[i]+'">'+policy_object.company_code[i]+'</option>');
    }
    document.getElementById('policy_id').value=id;
    document.getElementById('view_policy_document_link').setAttribute("href","view_policy_files.php?id="+id);
}
function ajax_call(id) {
    $.ajax({
        url:"ajax_approve.php",
        type:"post",
        data: {policy_id: id},
        success:function(response){
            set_policy_values(response,id);
        }
    });
}

//autocalculation of the agent payout while approving the policy
function update_agent_payout_amount(){
    var comission_percentage=$('#comission_percentage').val();
    var comission_amount=0;
    if($('#OD').is(':checked')){
        comission_amount=$('#od_premium').val()*(comission_percentage/100);
        comission_amount=comission_amount.toFixed(2);
    }
    if($('#NP').is(':checked')){
        comission_amount=$('#net_premium').val()*(comission_percentage/100);
        comission_amount=comission_amount.toFixed(2);
    }
    $('#comission_amount').val(comission_amount);
}