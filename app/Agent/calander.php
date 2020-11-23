<?php

    //session handelling
    $session=new Session();
    $session->check_session("Agent");

    // Set your timezone
    date_default_timezone_set('Asia/Tokyo');

    // Get prev & next month
    if (isset($_GET['ym'])) {
        $ym = $_GET['ym'];
    } else {
        // This month
        $ym = date('Y-m');
    }

    // Check format
    $timestamp = strtotime($ym . '-01');
    if ($timestamp === false) {
        $ym = date('Y-m');
        $timestamp = strtotime($ym . '-01');
    }

    // Today
    $today = date('Y-m-j', time());

    // For H3 title
    $html_title = date('Y / m', $timestamp);

    // Create prev & next month link     mktime(hour,minute,second,month,day,year)
    $prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
    $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));
    // You can also use strtotime!
    // $prev = date('Y-m', strtotime('-1 month', $timestamp));
    // $next = date('Y-m', strtotime('+1 month', $timestamp));

    // Number of days in the month
    $day_count = date('t', $timestamp);
    
    // 0:Sun 1:Mon 2:Tue ...
    $str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
    //$str = date('w', $timestamp);


    // Create Calendar!!
    $weeks = array();
    $week = '';

    // Add empty cell
    $week .= str_repeat('<td></td>', $str);

    //fetching expiry dates
    $expiry_dates_array=array();
    $approved_policy_result_set=$user->read_selective_policy("WHERE NOT comission_percentage='0' AND agent_id=".$_SESSION['id']);
    $i=0;
    if($approved_policy_result_set){
        while($approved_policy_result=$approved_policy_result_set->fetch_assoc()){
            $expiry_dates_array[$i]=$approved_policy_result['od_policy_end_date'];
            $i++;
        }
    }

    for ( $day = 1; $day <= $day_count; $day++, $str++) {
        
        $date = $ym . '-' . $day;
        //checking for expiry date
        $expiry_date_matches=false;
        $expiry_date='';
        for($i=0;$i<count($expiry_dates_array);$i++){
            if(strtotime($date)==strtotime($expiry_dates_array[$i])){
                $expiry_date_matches=true;
                $expiry_date=$expiry_dates_array[$i];
                break;
            }
        }
        if($expiry_date_matches){
            $week .= '<td class="expiry"><form action="menu_policy.php" method="POST"><input type="hidden" name="expiry_date" value="'.$expiry_date.'"/><button class="expiry">' . $day.'</button></form>';
        }elseif ($today == $date) {
            $week .= '<td class="today">' . $day;
        } 
        else {
            $week .= '<td>' . $day;
        }
        $week .= '</td>';
        
        // End of the week OR End of the month
        if ($str % 7 == 6 || $day == $day_count) {

            if ($day == $day_count) {
                // Add empty cell
                $week .= str_repeat('<td></td>', 6 - ($str % 7));
            }

            $weeks[] = '<tr>' . $week . '</tr>';

            // Prepare for new week
            $week = '';
        }

    }
?>
 
<style>
    h3 {
        margin-bottom: 30px;
    }
    tr{
        margin-top: 0;
    }
    th {
        color:#02274A ;
        letter-spacing: 2px;
        font-weight:600;
        text-transform:uppercase;
        height: 45px;
        font-size:small;
        text-align: center;
        font-style:var(--sans);
    }
    td {
        height: 45px;
        width:45px;
        margin:10px;
        text-align:center;
        font-style: var(--monserrat);
        font-size:small;
        border-radius: 22.5px;
    }
    .expiry{
        background:rgb(255,0,0);
        color: white;
    }
    .today {
        background:rgba(0, 140, 0,.8) ;
        color: white;
    }
    .calender{
        width: max-content;
        overflow:hidden;
        font-family: 'Noto Sans', sans-serif;
        border-radius:5px;
        box-shadow:2px 5px 20px -5px rgba(0,0,0,0.4);
    }
    .flexcal{
        top:0%;
        left:0%;
        width:100%;
        height: 100px;
        z-index:2;
        background-color:rgba(22, 74, 2 ,0.4);
        position:absolute;
        display:flex;
        z-index:100;
        padding:30px 0px;
        flex-wrap:wrap;
        justify-content:space-around;
            
    }
    .calback{
        position:relative;
        height:100px;
        background-image:url('https://cdn.britannica.com/26/152026-050-41D137DE/Sunshine-leaves-beech-tree.jpg');
        background-position:center;
        background-attachment:scroll;
        background-repeat:no-repeat;
        background-size:cover;
    }
    .cal-item{
        display:block;
        margin:auto;
        background-color:red;
        width:30%;
    }
    .calcal:hover{
        font-size:27px;
        color:white;
    }
    .calcal{
        text-align:center;
        color:white;
        font-size:25px;
    }
    .itemcal{
        font-size:20px;
        font-weight:800;
        color:white;
        letter-spacing:1px;
    }
    .tabtab{
        margin: 10px;
    }
    @media only screen and (max-width: 380px) {
        .calender{
            background:green;
            width: 100%;
        }
    }
</style>
    <div class="calender">
        <div class="calback">
        <div class="flexcal">
            <div class="calitem">
                <a class="calcal" href="?ym=<?php echo $prev; ?>"><i class="fa fa-angle-left " aria-hidden="true"></i></a>
            </div>
            <!-----cal item----->
              <div class="calitem itemcal">
                 <?php echo $html_title; ?>
            </div>
            <!-----cal item----->
              <div class="calitem">
                 <a class="calcal" href="?ym=<?php echo $next; ?>"><i class="fa fa-angle-right " aria-hidden="true"></i></a>
            </div>
            <!-----cal item----->
        </div>
        <!--End of flex--->
        </div>
        <table class="tabtab">
            <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
            </tr>
            <?php
                foreach ($weeks as $week) {
                    echo $week;
                }
            ?>
        </table>
    </div>