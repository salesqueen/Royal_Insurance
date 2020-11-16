<?php 

    error_reporting(0);

    class Form{
        public function get_form_values($input_name_list){
            $input_value_list=array();
            for($i=0;$i<count($input_name_list);$i++){
                $input_value_list[$i]=$_POST[$input_name_list[$i]];
                if($_POST[$input_name_list[$i]]==""){
                    $input_value_list[$i]="null";
                }  
            }
            return $input_value_list;
        }
        public function upload_files($file_name_list,$destination){
            define ('SITE_ROOT', realpath(dirname(__FILE__)));
            $file_value_list=array();
            for($i=0;$i<count($file_name_list);$i++){
                if (!isset($_FILES[$file_name_list[$i]]) || !file_exists($_FILES[$file_name_list[$i]]['tmp_name']) || !is_uploaded_file($_FILES[$file_name_list[$i]]['tmp_name'])) 
                {
                    $file_value_list[$i]="Null";
                }
                else
                {
                    $file_name=$_FILES[$file_name_list[$i]]['name'];
                    $new_file_name=rand(0,1000)."_document_".rand(0,1000);
                    $file_type = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
                    $target_file = $destination."/".$new_file_name.".".$file_type;
                    if (move_uploaded_file($_FILES[$file_name_list[$i]]['tmp_name'], SITE_ROOT.$target_file)) {
                        $file_value_list[$i]=$new_file_name.".".$file_type;
                    } else {
                        $file_value_list[$i]="Null";
                    }   
                }
            }
            return $file_value_list;
        }
    }

?>