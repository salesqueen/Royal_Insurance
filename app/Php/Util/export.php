<?php 

    trait Export{
        function excel($heading_array,$values_array) {
            $timestamp = time();
            $filename = 'Excel_' . $timestamp . '.xls';
            
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            
            echo '<table border="1">';
            //heading
            echo '  <tr>';
            foreach($heading_array as $heading){
                echo '<th>'.$heading.'</th>';
            }
            echo '</tr>';

            //body
            foreach($values_array as $value_array){
                echo '<tr>';
                foreach($value_array as $column){
                    echo '<td>'.$column.'</td>';
                }
                echo '</tr>';
            }

            echo '</table>';
            exit();
        }
    }
?>