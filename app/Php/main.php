<?php 

    error_reporting(0);

    include 'Util/session.php';
    include 'Util/form.php';
    include 'Util/Database/crud.php';
    include 'Util/Database/contract.php';
    include 'Util/export.php'; 

    trait Branch{
        public function insert_branch(){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=Branch_Contract::get_table_columns();
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Branch_Contract::get_table_name();
            //performing insertion
            $crud->insert($table_name,$form_name_array,$form_value_array);
        }
        public function update_branch($name_array,$id){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=$name_array;
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Branch_Contract::get_table_name();
            //performing updation
            $crud->update($table_name,$id,$form_name_array,$form_value_array);
        }
        public function read_one_branch($id){
            $crud=new Crud();
            $table_name=Branch_Contract::get_table_name();
            $result_set=$crud->select_one($table_name,$id);
            return $result_set;
        }
        public function read_selective_branch($constraint){
            //Initiallizing required variables
            $crud=new Crud();
            $table_name=Branch_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_contraint($table_name,$constraint);
            return $result_set;
        }
        public function read_all_branch(){
            //Initializing required variables
            $crud=new Crud();
            $table_name=Branch_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_all($table_name);
            return $result_set;
        }
        public function delete_branch($id){
            //Getting required varibles
            $crud=new Crud();
            $table_name=Branch_Contract::get_table_name();
            //deletion
            $crud->delete($table_name,$id);
        }
    }
    trait Policy_Files{
        public function insert_policy_files($insert_id){
            //uploading files
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //Initializing required variables
            $policy_form_file_table_name=Policy_Files_Contract::get_table_name();
            $policy_form_file_name_array=Policy_Files_Contract::get_table_columns();
            //getting form values
            $policy_form_file_form_value_array=$form->upload_files($policy_form_file_name_array,"\uploads\policy_documents");
            //forming database insertion variables
            array_push($policy_form_file_name_array,"policy_id");
            array_push($policy_form_file_form_value_array,$insert_id);
            //performing insertion
            $crud->insert($policy_form_file_table_name,$policy_form_file_name_array,$policy_form_file_form_value_array);
        }
        public function read_one_policy_files($id){
            $crud=new Crud();
            $table_name=Policy_Files_Contract::get_table_name();
            $result_set=$crud->select_one($table_name,$id);
            return $result_set;
        }
        public function read_selective_policy_files($constraint){
            //Initiallizing required variables
            $crud=new Crud();
            $table_name=Policy_Files_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_contraint($table_name,$constraint);
            return $result_set;
        }
        public function update_policy_document($policy_id){
            //getting id of the policy files table
            $id=$this->read_selective_policy_files("WHERE policy_id=".$policy_id)->fetch_assoc()['id'];
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //Initializing required variables
            $policy_form_file_table_name=Policy_Files_Contract::get_table_name();
            $policy_form_file_name_array=Policy_Files_Contract::get_table_columns();
            //getting form values
            $policy_form_file_form_value_array=$form->upload_files($policy_form_file_name_array,"\uploads\policy_documents");
            //Initiating new array for name and value
            $new_policy_file_name_array=array();
            $new_policy_file_value_array=array();
            $j=0;
            //eleminating null values
            for($i=0;$i<count($policy_form_file_name_array);$i++){
                if($policy_form_file_form_value_array[$i]=="Null"){
                    
                }else{
                    $new_policy_file_name_array[$j]=$policy_form_file_name_array[$i];
                    $new_policy_file_value_array[$j]=$policy_form_file_form_value_array[$i];
                    $j++;
                }
            }
            //updating values
            $crud->update($policy_form_file_table_name,$id,$new_policy_file_name_array,$new_policy_file_value_array);
        }
    }
    trait Company{
        public function insert_company(){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=Company_Contract::get_table_columns();
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Company_Contract::get_table_name();
            //performing insertion
            $crud->insert($table_name,$form_name_array,$form_value_array);
        }
        public function update_company($name_array,$id){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=$name_array;
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Company_Contract::get_table_name();
            //performing updation
            $crud->update($table_name,$id,$form_name_array,$form_value_array);
        }
        public function read_one_company($id){
            $crud=new Crud();
            $table_name=Company_Contract::get_table_name();
            $result_set=$crud->select_one($table_name,$id);
            return $result_set;
        }
        public function read_selective_company($constraint){
            //Initiallizing required variables
            $crud=new Crud();
            $table_name=Company_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_contraint($table_name,$constraint);
            return $result_set;
        }
        public function read_all_company(){
            //Initializing required variables
            $crud=new Crud();
            $table_name=Company_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_all($table_name);
            return $result_set;
        }
        public function delete_company($id){
            //Getting required varibles
            $crud=new Crud();
            $table_name=Company_Contract::get_table_name();
            //deletion
            $crud->delete($table_name,$id);
        }
    }
    trait Company_Code{
        public function insert_company_code(){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=Company_Code_Contract::get_table_columns();
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Company_Code_Contract::get_table_name();
            //performing insertion
            $crud->insert($table_name,$form_name_array,$form_value_array);
        }
        public function update_company_code($name_array,$id){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=$name_array;
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Company_Code_Contract::get_table_name();
            //performing updation
            $crud->update($table_name,$id,$form_name_array,$form_value_array);
        }
        public function read_one_company_code($id){
            $crud=new Crud();
            $table_name=Company_Code_Contract::get_table_name();
            $result_set=$crud->select_one($table_name,$id);
            return $result_set;
        }
        public function read_selective_company_code($constraint){
            //Initiallizing required variables
            $crud=new Crud();
            $table_name=Company_Code_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_contraint($table_name,$constraint);
            return $result_set;
        }
        public function read_all_company_code(){
            //Initializing required variables
            $crud=new Crud();
            $table_name=Company_Code_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_all($table_name);
            return $result_set;
        }
        public function delete_company_code($id){
            //Getting required varibles
            $crud=new Crud();
            $table_name=Company_Code_Contract::get_table_name();
            //deletion
            $crud->delete($table_name,$id);
        }
        public function get_company_code_result_set($company_name){
            //Getting required varibles
            $table_name=Company_Code_Contract::get_table_name();
            //fetching data
            $company_code_result_set=$this->read_selective_company_code("WHERE company_name='".$company_name."'");
            return $company_code_result_set;
        }
    }
    trait Policy_Period{
        public function insert_policy_period(){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=Policy_Period_Contract::get_table_columns();
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Policy_Period_Contract::get_table_name();
            //performing insertion
            $crud->insert($table_name,$form_name_array,$form_value_array);
        }
        public function update_policy_period($name_array,$id){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=$name_array;
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Policy_Period_Contract::get_table_name();
            //performing updation
            $crud->update($table_name,$id,$form_name_array,$form_value_array);
        }
        public function read_one_policy_period($id){
            $crud=new Crud();
            $table_name=Policy_Period_Contract::get_table_name();
            $result_set=$crud->select_one($table_name,$id);
            return $result_set;
        }
        public function read_selective_policy_period($constraint){
            //Initiallizing required variables
            $crud=new Crud();
            $table_name=Policy_Period_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_contraint($table_name,$constraint);
            return $result_set;
        }
        public function read_all_policy_period(){
            //Initializing required variables
            $crud=new Crud();
            $table_name=Policy_Period_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_all($table_name);
            return $result_set;
        }
        public function delete_policy_period($id){
            //Getting required varibles
            $crud=new Crud();
            $table_name=Policy_Period_Contract::get_table_name();
            //deletion
            $crud->delete($table_name,$id);
        }
    }
    trait Policy_Type{
        public function insert_policy_type(){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=Policy_Type_Contract::get_table_columns();
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Policy_Type_Contract::get_table_name();
            //performing insertion
            $crud->insert($table_name,$form_name_array,$form_value_array);
        }
        public function update_policy_type($name_array,$id){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=$name_array;
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Policy_Type_Contract::get_table_name();
            //performing updation
            $crud->update($table_name,$id,$form_name_array,$form_value_array);
        }
        public function read_one_policy_type($id){
            $crud=new Crud();
            $table_name=Policy_Type_Contract::get_table_name();
            $result_set=$crud->select_one($table_name,$id);
            return $result_set;
        }
        public function read_selective_policy_type($constraint){
            //Initiallizing required variables
            $crud=new Crud();
            $table_name=Policy_Type_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_contraint($table_name,$constraint);
            return $result_set;
        }
        public function read_all_policy_type(){
            //Initializing required variables
            $crud=new Crud();
            $table_name=Policy_Type_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_all($table_name);
            return $result_set;
        }
        public function delete_policy_type($id){
            //Getting required varibles
            $crud=new Crud();
            $table_name=Policy_Type_Contract::get_table_name();
            //deletion
            $crud->delete($table_name,$id);
        }
    }
    trait Product{
        public function insert_product(){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=Product_Contract::get_table_columns();
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Product_Contract::get_table_name();
            //performing insertion
            $crud->insert($table_name,$form_name_array,$form_value_array);
        }
        public function update_product($name_array,$id){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=$name_array;
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Product_Contract::get_table_name();
            //performing updation
            $crud->update($table_name,$id,$form_name_array,$form_value_array);
        }
        public function read_one_product($id){
            $crud=new Crud();
            $table_name=Product_Contract::get_table_name();
            $result_set=$crud->select_one($table_name,$id);
            return $result_set;
        }
        public function read_selective_product($constraint){
            //Initiallizing required variables
            $crud=new Crud();
            $table_name=Product_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_contraint($table_name,$constraint);
            return $result_set;
        }
        public function read_all_product(){
            //Initializing required variables
            $crud=new Crud();
            $table_name=Product_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_all($table_name);
            return $result_set;
        }
        public function delete_product($id){
            //Getting required varibles
            $crud=new Crud();
            $table_name=Product_Contract::get_table_name();
            //deletion
            $crud->delete($table_name,$id);
        }
    }
    class Cheque{
        public function insert_cheque($insert_id){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=Cheque_Contract::get_table_columns();
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Cheque_Contract::get_table_name();
            array_push($form_name_array,"policy_id");
            array_push($form_value_array,$insert_id);
            //performing insertion
            $crud->insert($table_name,$form_name_array,$form_value_array);
        }
        public function clear_cheque($id){
            //Initiallizing required variables
            $crud=new Crud();
            //forming database update variables
            $table_name=Cheque_Contract::get_table_name();
            //performing updation
            $crud->update($table_name,$id,array('cheque_cleared_date','cheque_status'),array(date('Y-m-d'),'Cleared'));
        }
        public function reject_cheque($id){
            //Initiallizing required variables
            $crud=new Crud();
            //forming database update variables
            $table_name=Cheque_Contract::get_table_name();
            //performing updation
            $crud->update($table_name,$id,array('cheque_status'),array('Rejected'));
        }
        public function suspend_cheque($id){
            //Initiallizing required variables
            $crud=new Crud();
            //forming database update variables
            $table_name=Cheque_Contract::get_table_name();
            //performing updation
            $crud->update($table_name,$id,array('cheque_status'),array('Pending'));
        }
        public function update_cheque($id){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=Cheque_Contract::get_table_columns();
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database update variables
            $table_name=Cheque_Contract::get_table_name();
            //performing updation
            $crud->update($table_name,$id,$form_name_array,$form_value_array);
        }
        public function read_one_cheque($id){
            $crud=new Crud();
            $table_name=Cheque_Contract::get_table_name();
            $result_set=$crud->select_one($table_name,$id);
            return $result_set;
        }
        public function read_selective_cheque($constraint){
            //Initiallizing required variables
            $crud=new Crud();
            $table_name=Cheque_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_contraint($table_name,$constraint);
            return $result_set;
        }
        public function read_all_cheque(){
            //Initializing required variables
            $crud=new Crud();
            $table_name=Cheque_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_all($table_name);
            return $result_set;
        }
        public function delete_cheque($id){
            //Initializing required variables
            $crud=new Crud();
            $table_name=Cheque_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->delete($table_name,$id);
            return null;
        }
        public function read_custom($sql){
            //Initializing required variables
            $crud=new Crud(); 
            $result_set=$crud->select_custom($sql); 
            return $result_set;
        }
        public function get_cheque_status($policy_id){
            //Initializing required variables
            $crud=new Crud(); 
            $result_set=$this->read_selective_cheque("WHERE policy_id=".$policy_id); 
            return $result_set->fetch_assoc()['cheque_status'];
        }
    }
    trait Transaction{ 
        public function insert_transaction(){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=Transaction_Contract::get_table_columns();
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Transaction_Contract::get_table_name();
            array_push($form_name_array,"date");
            array_push($form_value_array,date("Y-m-d"));
            //performing insertion
            $crud->insert($table_name,$form_name_array,$form_value_array);
        }
        public function read_one_transaction($id){
            $crud=new Crud();
            $table_name=Transaction_Contract::get_table_name();
            $result_set=$crud->select_one($table_name,$id);
            return $result_set;
        }
        public function read_selective_transaction($constraint){
            //Initiallizing required variables
            $crud=new Crud();
            $table_name=Transaction_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_contraint($table_name,$constraint);
            return $result_set;
        }
        public function read_all_transaction(){
            $crud=new Crud();
            $table_name=Transaction_Contract::get_table_name();
            $result_set=$crud->select_all($table_name);
            return $result_set;
        }
        public function delete_transaction($id){
            $crud=new Crud();
            $table_name=Transaction_Contract::get_table_name();
            $result=$crud->delete($table_name,$id);
            return $result;
        }
    }
    trait Recivable_Transaction{
        public function insert_recivable_transaction(){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=Recivable_Transaction_Contract::get_table_columns();
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Recivable_Transaction_Contract::get_table_name();
            //performing insertion
            $crud->insert($table_name,$form_name_array,$form_value_array);
        }
        public function read_one_recivable_transaction($id){
            $crud=new Crud();
            $table_name=Recivable_Transaction_Contract::get_table_name();
            $result_set=$crud->select_one($table_name,$id);
            return $result_set;
        }
        public function read_selective_recivable_transaction($constraint){
            //Initiallizing required variables
            $crud=new Crud();
            $table_name=Recivable_Transaction_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_contraint($table_name,$constraint);
            return $result_set;
        }
        public function read_all_recivable_transaction(){
            $crud=new Crud();
            $table_name=Recivable_Transaction_Contract::get_table_name();
            $result_set=$crud->select_all($table_name);
            return $result_set;
        }
    }
    class Policy extends Cheque{
        use Transaction;
        use Policy_Files;
        use Export;
        use Branch;
        use Company_Code;
        public function insert_policy(){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=Policy_Contract::get_table_columns();
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Policy_Contract::get_table_name();
            //adding the creator of the policy
            if($_SESSION['user_type']=='Agent'){
                array_push($form_name_array,"agent_id");
                array_push($form_value_array,$_SESSION['id']);
            }else{
                array_push($form_name_array,"agent_id");
                array_push($form_value_array,$_POST['agent_id']);
            }
            //performing insertion
            $insert_id=$crud->insert($table_name,$form_name_array,$form_value_array);

            //uploading files
            $this->insert_policy_files($insert_id);
            
            //additional opertion based on payment mode
            if($_POST['policy_form_type']=='cash'){
                //Do nothing
            }else{
                parent::insert_cheque($insert_id);
            }
        }
        public function update_policy($name_array,$id){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=$name_array;
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Policy_Contract::get_table_name();
            //performing updation
            $crud->update($table_name,$id,$form_name_array,$form_value_array);
            //cheque deletion if conversion from cheque to cash or online
            if($_POST['previous_payment_mode']=='Cheque' || $_POST['previous_payment_mode'] == 'DD'){
                //fetching cheque id from policy id
                $cheque_id=$this->read_selective_cheque("WHERE policy_id='".$id."'")->fetch_assoc()['id'];
                if($_POST['payment_mode']=='Cash' || $_POST['payment_mode']=='Online'){
                    //deleting the cheque
                    $this->delete_cheque($cheque_id);
                    //overriding deletion successfull message
                    $_SESSION['message']='Updation Successfull';
                }else{
                    $this->update_cheque($cheque_id);
                }
            }
            //cheque insertion if conversion from cash or online to cheque
            elseif(($_POST['previous_payment_mode']=='Cash' || $_POST['previous_payment_mode'] == 'Online') && ($_POST['payment_mode']=='Cheque' || $_POST['payment_mode']=='DD')){
                //inserting cheque
                parent::insert_cheque($id);
                //overriding insertion successfull message
                $_SESSION['message']='Updation Successfull';
            }
        }
        public function read_one_policy($id){
            $crud=new Crud();
            $table_name=Policy_Contract::get_table_name();
            $result_set=$crud->select_one($table_name,$id);
            return $result_set;
        }
        public function read_selective_policy($constraint){
            //Initiallizing required variables
            $crud=new Crud();
            $table_name=Policy_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_contraint($table_name,$constraint);
            return $result_set;
        }
        public function read_all_policy(){
            //Initiallizing required variables
            $crud=new Crud();
            $table_name=Policy_Contract::get_table_name();
            //fetching data
            $result_set=$crud->select_all($table_name);
            return $result_set;
        }
        public function get_policy_count(){
            //initiallizing required variables
            $crud=new Crud();
            //fetching policy count
            $policy_count_result_set=$crud->select_custom("SELECT count(*) AS count_value FROM ".Policy_Contract::get_table_name());
            if($policy_count_result_set){
                $policy_count=$policy_count_result_set->fetch_assoc()['count_value'];
            }else{
                $policy_count=0;
            }
            return $policy_count;
        }
        public function get_agent_policy_count($agent_id){
            //initiallizing required variables
            $crud=new Crud();
            //fetching policy count
            $policy_count_result_set=$crud->select_custom("SELECT count(*) AS count_value FROM ".Policy_Contract::get_table_name()." WHERE agent_id=".$agent_id);
            if($policy_count_result_set){
                $policy_count=$policy_count_result_set->fetch_assoc()['count_value'];
            }else{
                $policy_count=0;
            }
            return $policy_count;
        }
    }
    class Agent extends Policy{
        use Company;
        use Policy_Period;
        use Policy_Type; 
        use Product;

        public function insert_agent(){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=Agent_Contract::get_table_columns();
            $form_value_array=$form->get_form_values($form_name_array);
            //upolading documents and adding it to the array
            $uploaded_file_name_array=$form->upload_files(array("photo","address_proof","id_proof","educational_proof","pan_card"),"\uploads\agent");
            array_splice($form_value_array,14,5,$uploaded_file_name_array);
            //forming database insertion variables
            $table_name=Agent_Contract::get_table_name();
            //getting and adding the branch manager id based on the user
            if($_SESSION['user_type']=='Admin' || $_SESSION['user_type']=='Accountant' || $_SESSION['user_type']=='Operator'){
                array_push($form_name_array,"branch_manager_id"); 
                array_push($form_value_array,$_POST['branch_manager_id']);
            }
            if($_SESSION['user_type']=='Branch_Manager'){
                array_push($form_name_array,"branch_manager_id"); 
                array_push($form_value_array,$_SESSION['id']);
            }
            //performing insertion
            $crud->insert($table_name,$form_name_array,$form_value_array);
        }
        public function update_agent($name_array,$id){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=$name_array;
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Agent_Contract::get_table_name();
            //performing updation
            $crud->update($table_name,$id,$form_name_array,$form_value_array);
        }
        public function read_one_agent($id){
            $crud=new Crud();
            $table_name=Agent_Contract::get_table_name();
            $result_set=$crud->select_one($table_name,$id);
            return $result_set;
        }
        public function read_selective_agent($constraint){
            //Initiallizing required variables
            $crud=new Crud();
            $table_name=Agent_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_contraint($table_name,$constraint);
            return $result_set;
        }
        public function read_all_agent(){
            $crud=new Crud();
            $table_name=Agent_Contract::get_table_name();
            $result_set=$crud->select_all($table_name);
            return $result_set;
        }
        public function get_agent_count(){
            //initiallizing required variables
            $crud=new Crud();
            //fetching policy count
            $agent_result_set=$crud->select_custom("SELECT count(*) AS count_value FROM ".Agent_Contract::get_table_name());
            if($agent_result_set){
                $agent_count=$agent_result_set->fetch_assoc()['count_value'];
            }else{
                $agent_count=0;
            }
            return $agent_count;
        }
        public function get_agent_name($agent_id){
            $agent_result_set=$this->read_one_agent($agent_id);
            $agent_result=$agent_result_set->fetch_assoc();
            return $agent_result['name'];
        }
        function get_wallet_amount($agent_id){
            $wallet_amount=0;
            //getting policy result set
            $policy_result_set=$this->read_selective_policy("WHERE NOT comission_percentage=0 AND agent_id=".$agent_id);
            if($policy_result_set){
                //calculating amount based on comission recivable and payable
                while($policy_result=$policy_result_set->fetch_assoc()){
                    if($policy_result['payment_mode']=='Cash'){
                        //calculating comission amount
                        if($policy_result['comission_type']=='OD'){
                            $comission=$policy_result['od_premium']*($policy_result['comission_percentage']/100);
                            $wallet_amount+=$policy_result['total_premium']-$comission;
                        }
                        if($policy_result['comission_type']=='NP'){
                            $comission=$policy_result['net_premium']*($policy_result['comission_percentage']/100);
                            $wallet_amount+=$policy_result['total_premium']-$comission;
                        }
                    }else{
                        //calculating comission amount
                        if($policy_result['comission_type']=='OD'){
                            $comission=$policy_result['od_premium']*($policy_result['comission_percentage']/100);
                            $wallet_amount-=$comission;
                        }
                        if($policy_result['comission_type']=='NP'){
                            $comission=$policy_result['net_premium']*($policy_result['comission_percentage']/100);
                            $wallet_amount-=$comission;
                        }
                    }
                }
            }
            //calculating wallet amount based on transaction
            $transaction_result_set=$this->read_selective_transaction("WHERE agent_id=".$agent_id);
            //fetching transaction of the user
            if($transaction_result_set){
                while($transaction_result=$transaction_result_set->fetch_assoc()){
                    if($transaction_result['payment']=='Recived'){
                        $wallet_amount-=$transaction_result['amount'];
                    }elseif($transaction_result['payment']=='Paid'){
                        $wallet_amount+=$transaction_result['amount'];
                    }elseif($transaction_result['payment']=='Office_Expenses'){
                        $wallet_amount-=$transaction_result['amount'];
                    }
                }
            }
            return $wallet_amount;
        }
        public function get_agent_cash($payment,$agent_id){
            $amount=0;
            $transaction_result_set=$this->read_selective_transaction("WHERE payment='".$payment."' AND agent_id=".$agent_id);
            if($transaction_result_set){
                while($transaction_result=$transaction_result_set->fetch_assoc()){
                    $amount+=$transaction_result['amount'];
                }
            }
            return $amount;
        }
        function get_cleared_cheque_pending_policy_agent($comission_percentage,$company_name,$company_code,$filter_date_one,$filter_date_two,$agent_id){
            //forming cleared cheque pending policy
            $cleared_cheque_pending_policy_array=array();
            $cleared_cheque_result_set=$this->read_selective_cheque("WHERE cheque_status='Cleared'");
            if($cleared_cheque_result_set){
                $i=0;
                while($cleared_cheque_result=$cleared_cheque_result_set->fetch_assoc()){
                    //filter variable
                    $passed=0;
                    $cleared_cheque_pending_policy_result_set=$this->read_one_policy($cleared_cheque_result['policy_id']);
                    if($cleared_cheque_pending_policy_result_set){
                        $cleared_cheque_pending_policy_result=$cleared_cheque_pending_policy_result_set->fetch_assoc();
                        //checking for agent
                        if($agent_id==$cleared_cheque_pending_policy_result['agent_id']){
                            //echo $agent_id."-".$cleared_cheque_pending_policy_result['agent_id'];
                            $passed++;
                        }
                        //applying filter
                        //company name
                        if($company_name!=""){
                            if(strcasecmp($company_name,$cleared_cheque_pending_policy_result['company_name'])==0){
                                $passed++;
                            }else{
                                continue;
                            }
                        }else{
                            $passed++;
                        }
                        //Booking Code
                        if($company_code!=""){
                            if(strcasecmp($company_code,$cleared_cheque_pending_policy_result['company_code'])==0){
                                $passed++;
                            }else{
                                continue;
                            }
                        }else{
                            $passed++;
                        }
                        //filtering based on date and comission percentage
                        if($filter_date_one!="" && $filter_date_two!=""){
                            //checking whether the issue date is between two dates
                            if($cleared_cheque_pending_policy_result['issue_date']>=$filter_date_one && $cleared_cheque_pending_policy_result['issue_date']<=$filter_date_two){
                                $passed++;
                            }else{
                                continue;
                            }
                        }else{
                            //checking whether issue date is greater than filter one date
                            if($filter_date_one!=""){
                                if($cleared_cheque_pending_policy_result['issue_date']>=$filter_date_one){
                                    $passed++;
                                }else{
                                    continue;
                                }
                            }elseif($filter_date_one!=""){
                                if($cleared_cheque_pending_policy_result['issue_date']<=$filter_date_two){
                                    $passed++;
                                }else{
                                    continue;
                                }
                            }else{
                                $passed++;
                            }
                        }
                        //checking for comission percentage
                        if($cleared_cheque_pending_policy_result[$comission_percentage]==0){
                            $passed++;
                        }
                        //checking whether the data passes all the condition
                        if($passed==5){
                            $cleared_cheque_pending_policy_array[$i]=$cleared_cheque_pending_policy_result;
                            $i++;
                        }
                    }
                }
            }
            return $cleared_cheque_pending_policy_array;
        }
    }
    class Branch_Manager extends Agent{
        public function insert_branch_manager(){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=Branch_Manager_Contract::get_table_columns();
            $form_value_array=$form->get_form_values($form_name_array);
            //upolading documents and adding it to the array
            $uploaded_file_name_array=$form->upload_files(array("photo","address_proof","id_proof","educational_proof","pan_card"),"\uploads\branch_manager");
            array_splice($form_value_array,14,5,$uploaded_file_name_array);
            //forming database insertion variables
            $table_name=Branch_Manager_Contract::get_table_name();
            //performing insertion
            $crud->insert($table_name,$form_name_array,$form_value_array);     
        }
        public function update_branch_manager($name_array,$id){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=$name_array;
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Branch_Manager_Contract::get_table_name();
            //performing updation
            $crud->update($table_name,$id,$form_name_array,$form_value_array);
        }
        public function read_one_branch_manager($id){
            $crud=new Crud();
            $table_name=Branch_Manager_Contract::get_table_name();
            $result_set=$crud->select_one($table_name,$id);
            return $result_set;
        }
        public function read_selective_branch_manager($constraint){
            //Initiallizing required variables
            $crud=new Crud();
            $table_name=Branch_Manager_Contract::get_table_name();
            //Getting database values
            $result_set=$crud->select_contraint($table_name,$constraint);
            return $result_set;
        }
        public function read_all_branch_manager(){
            $crud=new Crud();
            $table_name=Branch_Manager_Contract::get_table_name();
            $result_set=$crud->select_all($table_name);
            return $result_set;
        }
        public function get_branch_manager_policy_count(){
            $agent_result_set=$this->read_selective_agent("WHERE branch_manager_id=".$_SESSION['id']);
            $policy_count=0;
            while($agent_result=$agent_result_set->fetch_assoc()){
                $policy_count+=$this->get_agent_policy_count($agent_result['id']);
            }
            return $policy_count;
        }
        public function get_branch_manager_agent_count(){
            $crud=new Crud();
            $agent_result_set=$crud->select_custom("SELECT COUNT(*) AS agent_count FROM ".Agent_Contract::get_table_name()." WHERE branch_manager_id=".$_SESSION['id']);
            if($agent_result_set){
                $agent_count=$agent_result_set->fetch_assoc()['agent_count'];
            }else{
                $agent_count=0;
            }
            return $agent_count;
        }
        public function get_branch_manager_count(){
            //initiallizing required variables
            $crud=new Crud();
            //fetching policy count
            $policy_count_result_set=$crud->select_custom("SELECT count(*) AS count_value FROM ".Branch_Manager_Contract::get_table_name());
            return $policy_count_result_set->fetch_assoc()['count_value'];
        }
        function get_branch($agent_id){
            $agent_result_set=$this->read_one_agent($agent_id);
            $branch_manager_result_set=$this->read_one_branch_manager($agent_result_set->fetch_assoc()['branch_manager_id']);
            return $branch_manager_result_set->fetch_assoc()['branch'];
        }
        function get_cleared_cheque_pending_policy($comission_percentage,$company_name,$company_code,$branch,$agent,$filter_date_one,$filter_date_two){
            //forming cleared cheque pending policy
            $cleared_cheque_pending_policy_array=array();
            $cleared_cheque_result_set=$this->read_selective_cheque("WHERE cheque_status='Cleared'");
            if($cleared_cheque_result_set){
                //reading all the users under a branch
                $branch_agent_id_array=array();
                if($branch!=""){
                    $branch_manager_id=$this->read_selective_branch_manager("WHERE branch='".$branch."'")->fetch_assoc()['id'];
                    $agent_result_set=$this->read_selective_agent("WHERE branch_manager_id=".$branch_manager_id);
                    if($agent_result_set){
                        //has match for selected branch
                        $i=0;
                        while($agent_result=$agent_result_set->fetch_assoc()){
                            $branch_agent_id_array[$i]=$agent_result['id'];
                            $i++;
                        }
                    }else{
                        //No match for the selected branch
                        return $cleared_cheque_pending_policy_array;
                    }
                }
                //array variable
                $i=0;
                while($cleared_cheque_result=$cleared_cheque_result_set->fetch_assoc()){
                    //filter variable
                    $passed=0;
                    $cleared_cheque_pending_policy_result_set=$this->read_one_policy($cleared_cheque_result['policy_id']);
                    if($cleared_cheque_pending_policy_result_set){
                        $cleared_cheque_pending_policy_result=$cleared_cheque_pending_policy_result_set->fetch_assoc();
                        //applying filter
                        //company name
                        if($company_name!=""){
                            if(strcasecmp($company_name,$cleared_cheque_pending_policy_result['company_name'])==0){
                                $passed++;
                            }else{
                                continue;
                            }
                        }else{
                            $passed++;
                        }
                        //Booking Code
                        if($company_code!=""){
                            if(strcasecmp($company_code,$cleared_cheque_pending_policy_result['company_code'])==0){
                                $passed++;
                            }else{
                                continue;
                            }
                        }else{
                            $passed++;
                        }
                        //branch
                        if($branch!=""){
                            //need to run fully
                            foreach($branch_agent_id_array as $branch_agent_id){
                                if($cleared_cheque_pending_policy_result['agent_id']==$branch_agent_id){
                                    $passed++;
                                    break;
                                }
                            }
                        }else{
                            $passed++;
                        }
                        //agent
                        if($agent!=""){
                            if(strcasecmp($agent,$cleared_cheque_pending_policy_result['agent_id'])==0){
                                $passed++;
                            }else{
                                continue;
                            }
                        }else{
                            $passed++;
                        }
                        //filtering based on date and comission percentage
                        if($filter_date_one!="" && $filter_date_two!=""){
                            //checking whether the issue date is between two dates
                            if($cleared_cheque_pending_policy_result['issue_date']>=$filter_date_one && $cleared_cheque_pending_policy_result['issue_date']<=$filter_date_two){
                                $passed++;
                            }else{
                                continue;
                            }
                        }else{
                            //checking whether issue date is greater than filter one date
                            if($filter_date_one!=""){
                                if($cleared_cheque_pending_policy_result['issue_date']>=$filter_date_one){
                                    $passed++;
                                }else{
                                    continue;
                                }
                            }elseif($filter_date_one!=""){
                                if($cleared_cheque_pending_policy_result['issue_date']<=$filter_date_two){
                                    $passed++;
                                }else{
                                    continue;
                                }
                            }else{
                                $passed++;
                            }
                        }
                        //checking for comission percentage
                        if($cleared_cheque_pending_policy_result[$comission_percentage]==0){
                            $passed++;
                        }
                        //checking whether the data passes all the condition
                        if($passed==6){
                            $cleared_cheque_pending_policy_array[$i]=$cleared_cheque_pending_policy_result;
                            $i++;
                        }
                    }
                }
            }
            return $cleared_cheque_pending_policy_array;
        }
    }
    class Operator extends Branch_Manager{
        public function insert_operator(){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=Operator_Contract::get_table_columns();
            $form_value_array=$form->get_form_values($form_name_array);
            //upolading documents and adding it to the array
            $uploaded_file_name_array=$form->upload_files(array("photo","address_proof","id_proof","educational_proof","pan_card"),"\uploads\operator");
            array_splice($form_value_array,14,5,$uploaded_file_name_array);
            //forming database insertion variables
            $table_name=Operator_Contract::get_table_name();
            //performing insertion
            $crud->insert($table_name,$form_name_array,$form_value_array);     
        }
        public function update_operator($name_array,$id){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=$name_array;
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Operator_Contract::get_table_name();
            //performing updation
            $crud->update($table_name,$id,$form_name_array,$form_value_array);
        }
        public function read_one_operator($id){
            $crud=new Crud();
            $table_name=Operator_Contract::get_table_name();
            $result_set=$crud->select_one($table_name,$id);
            return $result_set;
        }
        public function read_all_operator(){
            $crud=new Crud();
            $table_name=Operator_Contract::get_table_name();
            $result_set=$crud->select_all($table_name);
            return $result_set;
        }
    }
    class Accountant extends Operator{
        public function insert_accountant(){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=Accountant_Contract::get_table_columns();
            $form_value_array=$form->get_form_values($form_name_array);
            //upolading documents and adding it to the array
            $uploaded_file_name_array=$form->upload_files(array("photo","address_proof","id_proof","educational_proof","pan_card"),"\uploads\accountant");
            array_splice($form_value_array,14,5,$uploaded_file_name_array);
            //forming database insertion variables
            $table_name=Accountant_Contract::get_table_name();
            //performing insertion
            $crud->insert($table_name,$form_name_array,$form_value_array);     
        }
        public function update_accountant($name_array,$id){
            //Initiallizing required variables
            $crud=new Crud();
            $form=new Form();
            //getting form values
            $form_name_array=$name_array;
            $form_value_array=$form->get_form_values($form_name_array);
            //forming database insertion variables
            $table_name=Accountant_Contract::get_table_name();
            //performing updation
            $crud->update($table_name,$id,$form_name_array,$form_value_array);
        }
        public function read_one_accountant($id){
            $crud=new Crud();
            $table_name=Accountant_Contract::get_table_name();
            $result_set=$crud->select_one($table_name,$id);
            return $result_set;
        }
        public function read_all_accountant(){
            $crud=new Crud();
            $table_name=Accountant_Contract::get_table_name();
            $result_set=$crud->select_all($table_name);
            return $result_set;
        }
        public function get_admin_cash($payment){
            $amount=0;
            $transaction_result_set=$this->read_selective_transaction("WHERE payment='".$payment."'");
            if($transaction_result_set){
                while($transaction_result=$transaction_result_set->fetch_assoc()){
                    $amount+=$transaction_result['amount'];
                }
            }
            return $amount;
        }
        public function get_admin_wallet_amount(){
            $amount=0;
            $user_result_set=$this->read_all_agent();
            if($user_result_set){
                while($user_result=$user_result_set->fetch_assoc()){
                    $amount+=$this->get_wallet_amount($user_result['id']);
                }
            }
            return $amount;
        }
    }
    class Admin extends Accountant{
        use Recivable_Transaction;
        public function insert_admin(){

        }
        public function update_admin(){

        }
        public function read_one_admin(){

        }
        public function read_selective_admin(){

        }
        public function read_all_admin(){

        }
        public function delete_admin(){

        }
    }
    //document download option
    class Download extends Branch_Manager{
        public function policy($pending_policy_result_set,$approved_policy_result_set){
            //preparing value array
            $values_array=array();
            $policy_result_set=$this->read_all_policy();
            $i=0;
            if($pending_policy_result_set){
                while($pending_policy_result=$pending_policy_result_set->fetch_assoc()){
                    $values_array[$i]=array(
                        $pending_policy_result['issue_date'],
                        $pending_policy_result['policy_type'],
                        $pending_policy_result['product'],
                        $pending_policy_result['company_name'],
                        "'".$pending_policy_result['policy_number'],
                        $pending_policy_result['customer_name'],
                        $pending_policy_result['registration_number'],
                        $pending_policy_result['make_model'],
                        $pending_policy_result['od_policy_start_date'],
                        $pending_policy_result['od_policy_end_date'],
                        $pending_policy_result['tp_policy_start_date'],
                        $pending_policy_result['tp_policy_end_date'],
                        $pending_policy_result['od_disc'],
                        $pending_policy_result['od_premium'],
                        $pending_policy_result['tp_premium'],
                        $pending_policy_result['net_premium'],
                        $pending_policy_result['total_premium'],
                        $this->get_agent_name($pending_policy_result['agent_id']),
                        $this->get_branch($pending_policy_result['agent_id'])
                    );
                    $i++;
                }
            }
            if($approved_policy_result_set){
                while($approved_policy_result=$approved_policy_result_set->fetch_assoc()){
                    $values_array[$i]=array(
                        $approved_policy_result['issue_date'],
                        $approved_policy_result['policy_type'],
                        $approved_policy_result['product'],
                        $approved_policy_result['company_name'],
                        "'".$approved_policy_result['policy_number'],
                        $approved_policy_result['customer_name'],
                        $approved_policy_result['registration_number'],
                        $approved_policy_result['make_model'],
                        $approved_policy_result['od_policy_start_date'],
                        $approved_policy_result['od_policy_end_date'],
                        $approved_policy_result['tp_policy_start_date'],
                        $approved_policy_result['tp_policy_end_date'],
                        $approved_policy_result['od_disc'],
                        $approved_policy_result['od_premium'],
                        $approved_policy_result['tp_premium'],
                        $approved_policy_result['net_premium'],
                        $approved_policy_result['total_premium'],
                        $this->get_agent_name($approved_policy_result['agent_id']),
                        $this->get_branch($approved_policy_result['agent_id'])
                    );
                    $i++;
                }
            }
            //call to download excel
            $this->excel(array("Policy Date","Policy Type","Product","Company","Policy Number","Customer Name","Registration Number",
            "Make Model","Od Policy Start Date","Od Policy End Date","TP Policy Start Date","TP Policy End Date","OD Disc","OD Premium","TP Premium",
            "NET Premium","Total Premium","Agent Name","Branch"),$values_array);
        }
        public function comission_recivable($pending_policy_result_set,$cheque_cleared_pending_policy_array,$approved_policy_result_set){
            //preparing value array
            $values_array=array();
            $i=0;
            //adding pending policy
            //adding pending policy via cash
            if($pending_policy_result_set){
                while($pending_policy_result=$pending_policy_result_set->fetch_assoc()){
                    $values_array[$i]=array(
                        $pending_policy_result['issue_date'],
                        "'".$pending_policy_result['policy_number'],
                        $pending_policy_result['policy_type'],
                        $pending_policy_result['product'],
                        $pending_policy_result['company_name'],
                        $pending_policy_result['company_code'],
                        $pending_policy_result['customer_name'],
                        $pending_policy_result['registration_number'],
                        "",//only has value after approved
                        "",//only has value after approved
                        "",//only has value after approved
                        $this->get_branch($pending_policy_result['agent_id']),
                        $this->get_agent_name($pending_policy_result['agent_id'])
                    );
                    $i++;
                }
            }
            //adding pending policy via cheque
            for($j=0;$j<count($cheque_cleared_pending_policy_array);$j++){
                $values_array[$i]=array(
                    $cheque_cleared_pending_policy_array[$j]['issue_date'],
                    "'".$cheque_cleared_pending_policy_array[$j]['policy_number'],
                    $cheque_cleared_pending_policy_array[$j]['policy_type'],
                    $cheque_cleared_pending_policy_array[$j]['product'],
                    $cheque_cleared_pending_policy_array[$j]['company_name'],
                    $cheque_cleared_pending_policy_array[$j]['company_code'],
                    $cheque_cleared_pending_policy_array[$j]['customer_name'],
                    $cheque_cleared_pending_policy_array[$j]['registration_number'],
                    "",//only has value after approved
                    "",//only has value after approved
                    "",//only has value after approved
                    $this->get_branch($cheque_cleared_pending_policy_array[$j]['agent_id']),
                    $this->get_agent_name($cheque_cleared_pending_policy_array[$j]['agent_id'])
                );
                $i++;
            }
            //adding approved policy
            if($approved_policy_result_set){
                while($approved_policy_result=$approved_policy_result_set->fetch_assoc()){
                    //calculating comission
                    $comission=0;
                    if($approved_policy_result['comission_type']=='OD'){
                        $comission=$approved_policy_result['od_premium']*($approved_policy_result['my_comission_percentage']/100);
                    }
                    if($approved_policy_result['comission_type']=='NP'){
                        $comission=$approved_policy_result['net_premium']*($approved_policy_result['my_comission_percentage']/100);
                    }
                    $values_array[$i]=array(
                        $approved_policy_result['issue_date'],
                        "'".$approved_policy_result['policy_number'],
                        $approved_policy_result['policy_type'],
                        $approved_policy_result['product'],
                        $approved_policy_result['company_name'],
                        $approved_policy_result['company_code'],
                        $approved_policy_result['customer_name'],
                        $approved_policy_result['registration_number'],
                        $approved_policy_result['my_comission_type'],
                        $approved_policy_result['my_comission_percentage'],
                        $comission,
                        $this->get_branch($approved_policy_result['agent_id']),
                        $this->get_agent_name($approved_policy_result['agent_id'])
                    );
                    $i++;
                }
            }
            //call to download excel
            $this->excel(array("Policy Date","Policy Number","Policy Type","Product","Company","Booking Code","Customer Name","Registration Number","Recivable From",
            "Recivable%","Recivable Amount","branch","agent_name"),$values_array);
            header("Location:menu_utilities_comission_recivable.php");
        }
        public function comission_payable($pending_policy_result_set,$cheque_cleared_pending_policy_array,$approved_policy_result_set){
            //preparing value array
            $values_array=array();
            $i=0;
            //adding pending policy
            //adding pending policy via cash
            if($pending_policy_result_set){
                while($pending_policy_result=$pending_policy_result_set->fetch_assoc()){
                    $values_array[$i]=array(
                        $pending_policy_result['issue_date'],
                        "'".$pending_policy_result['policy_number'],
                        $pending_policy_result['policy_type'],
                        $pending_policy_result['product'],
                        $pending_policy_result['company_name'],
                        $pending_policy_result['company_code'],
                        $pending_policy_result['customer_name'],
                        $pending_policy_result['registration_number'],
                        "",//only has value after approved
                        "",//only has value after approved
                        $pending_policy_result['payment_mode'],
                        $this->get_branch($pending_policy_result['agent_id']),
                        $this->get_agent_name($pending_policy_result['agent_id'])
                    );
                    $i++;
                }
            }
            //adding pending policy via cheque
            for($j=0;$j<count($cheque_cleared_pending_policy_array);$j++){
                $values_array[$i]=array(
                    $cheque_cleared_pending_policy_array[$j]['issue_date'],
                    "'".$cheque_cleared_pending_policy_array[$j]['policy_number'],
                    $cheque_cleared_pending_policy_array[$j]['policy_type'],
                    $cheque_cleared_pending_policy_array[$j]['product'],
                    $cheque_cleared_pending_policy_array[$j]['company_name'],
                    $cheque_cleared_pending_policy_array[$j]['company_code'],
                    $cheque_cleared_pending_policy_array[$j]['customer_name'],
                    $cheque_cleared_pending_policy_array[$j]['registration_number'],
                    "",//only has value after approved
                    "",//only has value after approved
                    $cheque_cleared_pending_policy_array[$j]['payment_mode'],
                    $this->get_branch($cheque_cleared_pending_policy_array[$j]['agent_id']),
                    $this->get_agent_name($cheque_cleared_pending_policy_array[$j]['agent_id'])
                );
                $i++;
            }
            //adding approved policy
            if($approved_policy_result_set){
                while($approved_policy_result=$approved_policy_result_set->fetch_assoc()){
                    //calculating comission
                    $comission=0;
                    if($approved_policy_result['comission_type']=='OD'){
                        $comission=$approved_policy_result['od_premium']*($approved_policy_result['comission_percentage']/100);
                    }
                    if($approved_policy_result['comission_type']=='NP'){
                        $comission=$approved_policy_result['net_premium']*($approved_policy_result['comission_percentage']/100);
                    }
                    $values_array[$i]=array(
                        $approved_policy_result['issue_date'],
                        "'".$approved_policy_result['policy_number'],
                        $approved_policy_result['policy_type'],
                        $approved_policy_result['product'],
                        $approved_policy_result['company_name'],
                        $approved_policy_result['company_code'],
                        $approved_policy_result['customer_name'],
                        $approved_policy_result['registration_number'],
                        $approved_policy_result['comission_type'],
                        $comission,
                        $approved_policy_result['payment_mode'],
                        $this->get_branch($approved_policy_result['agent_id']),
                        $this->get_agent_name($approved_policy_result['agent_id'])
                    );
                    $i++;
                }
            }
            //call to download excel
            $this->excel(array("Policy Date","Policy Number","Policy Type","Product","Company","Booking Code","Customer Name","Registration Number","Payable From",
            "Payable Amount","Payment_mode","branch","agent_name"),$values_array);
            header("Location:menu_utilities_comission_payable.php");
        }
        public function cheque_status($pending_cheque_array,$cleared_cheque_array){
            //merging array
            $cheque_array=array_merge($pending_cheque_array,$cleared_cheque_array);
            //forming value array
            $values_array=array();
            $i=0;
            foreach($cheque_array as $cheque){
                $values_array[$i]=array(
                    $cheque[1]['issue_date'],
                    "'".$cheque[1]['policy_number'],
                    $cheque[1]['policy_type'],
                    $cheque[1]['product'],
                    $cheque[1]['company_name'],
                    $cheque[1]['customer_name'],
                    $cheque[1]['registration_number'],
                    $cheque[0]['cheque_number'],
                    $cheque[0]['bank_name'],
                    $cheque[0]['cheque_status'],
                    $this->get_agent_name($cheque[1]['agent_id']),
                    $this->get_branch($cheque[1]['agent_id'])
                );
                $i++;
            }
            //call to download excel
            $this->excel(array("Policy Date","Policy Number","Policy Type","Product","Company","Customer Name","Registration Number",
            "Cheque Number","Cheque Bank","Cheque Status","Agent Name","Branch"),$values_array);
            header("Location:menu_utilities_cheque_status.php");
        }
        //for cash recived and cash paid
        public function cash($transaction_result_set){
            //preparing value array
            $values_array=array();
            $i=0;
            if($transaction_result_set){
                while($transaction_result=$transaction_result_set->fetch_assoc()){
                    $values_array[$i]=array(
                        $transaction_result['date'],
                        $this->get_agent_name($transaction_result['agent_id']),
                        $transaction_result['remark'],
                        $transaction_result['amount']
                    );
                    $i++;
                }
            }
            //call to download excel
            $GLOBALS['user']->excel(array("Date","Agent Name","Remark","Amount"),$values_array);
            header($_SERVER['HTTP_REFERER']);
        }
    }

?>