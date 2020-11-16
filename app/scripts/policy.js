    function view_cheque_form(){
        var payment_type=document.getElementById('payment_mode').value;
        var addition_form_elements=document.getElementsByClassName('policy_cheque_data');
        var addition_form_elements_input=document.getElementsByClassName('policy_cheque_input');
        if(payment_type=='Cheque' || payment_type=='DD'){
            //setting form type
            document.getElementById('policy_form_type').value="cheque";
            //Showing cheque form
            for(var i=0;i<addition_form_elements.length;i++){
                addition_form_elements[i].style.visibility="visible";
                addition_form_elements_input[i].setAttribute("required","required");
            }
        }else{
            //setting form type 
            document.getElementById('policy_form_type').value="cash";
            //Hidding cheque form
            for(var i=0;i<addition_form_elements.length;i++){
                addition_form_elements[i].style.visibility="hidden";
                addition_form_elements_input[i].removeAttribute("required");
            }
        }
    }
    //auto calculation for end date of OD 
    function update_od_policy_end_date(){
        var od_policy_start_date=new Date($('#od_policy_start_date').val());
        //setting same value to tp policy
        var day = ("0" + od_policy_start_date.getDate()).slice(-2);
        var month = ("0" + (od_policy_start_date.getMonth() + 1)).slice(-2);
        var od_policy_end_date_formatted = od_policy_start_date.getFullYear()+"-"+(month)+"-"+(day) ;
        $('#tp_policy_start_date').val(od_policy_end_date_formatted);
        //getting policy period
        var od_policy_period=$('#od_policy_period').val();
        //setting same value for tp period
        $('#tp_policy_period').val(od_policy_period);
        //reducing date by 1
        od_policy_start_date.setDate(od_policy_start_date.getDate()-1);
        //adding year abd period
        od_policy_start_date.setFullYear(od_policy_start_date.getFullYear()+parseInt(od_policy_period));
        //forming date in input type format
        var day = ("0" + od_policy_start_date.getDate()).slice(-2);
        var month = ("0" + (od_policy_start_date.getMonth() + 1)).slice(-2);
        var update_od_policy_end_date_formatted = od_policy_start_date.getFullYear()+"-"+(month)+"-"+(day) ;
        //setting the end date
        $('#od_policy_end_date').val(update_od_policy_end_date_formatted);
        //setting same date to the tp policy
        $('#tp_policy_end_date').val(update_od_policy_end_date_formatted);
    } 
    //auto calculation for end date of TP
    function update_tp_policy_end_date(){
        var tp_policy_start_date=new Date($('#tp_policy_start_date').val());
        var tp_policy_period=$('#tp_policy_period').val();
        //reducing date by 1
        tp_policy_start_date.setDate(tp_policy_start_date.getDate()-1);
        //adding year abd period
        tp_policy_start_date.setFullYear(tp_policy_start_date.getFullYear()+parseInt(tp_policy_period));
        //forming date in input type format
        var day = ("0" + tp_policy_start_date.getDate()).slice(-2);
        var month = ("0" + (tp_policy_start_date.getMonth() + 1)).slice(-2);
        var update_tp_policy_end_date_formatted = tp_policy_start_date.getFullYear()+"-"+(month)+"-"+(day) ;
        //setting the end date
        $('#tp_policy_end_date').val(update_tp_policy_end_date_formatted);
    } 
    
