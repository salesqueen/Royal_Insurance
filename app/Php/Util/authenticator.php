<?php 

    error_reporting(0);

    include 'form.php';
    include 'session.php';
    include 'Database/connection.php';

    class Authenticator{
        function isValid($result_set){
            if($result_set->num_rows>0){
                return true;
            }else{
                return false;
            }
        }
        function authentication($authentication_variables){
            $authentication=false;//True-Valid User False-Invalid User
            //checking whether the id is email or mobile
            if(strpos($authentication_variables[0],'@')){
                //comparing data with database
                //checking for agent
                $sql="SELECT * FROM agent WHERE email='".$authentication_variables[0]."' AND password='".$authentication_variables[1]."';";
                $result_set=$GLOBALS['connection']->query($sql);
                if($this->isValid($result_set)){
                    $this->agent_session($result_set);
                    $authentication=true;
                }
                //checking for branch manager
                $sql="SELECT * FROM branch_manager WHERE email='".$authentication_variables[0]."' AND password='".$authentication_variables[1]."';";
                $result_set=$GLOBALS['connection']->query($sql);
                if($this->isValid($result_set)){
                    $this->branch_manager_session($result_set);
                    $authentication=true;
                }
                //checking for admin
                $sql="SELECT * FROM admin WHERE email='".$authentication_variables[0]."' AND password='".$authentication_variables[1]."';";
                $result_set=$GLOBALS['connection']->query($sql);
                if($this->isValid($result_set)){
                    $this->admin_session($result_set);
                    $authentication=true;
                }
            }else{
                //comparing data with database
                //checking for agent
                $sql="SELECT * FROM agent WHERE phone='".$authentication_variables[0]."' AND password='".$authentication_variables[1]."';";
                $result_set=$GLOBALS['connection']->query($sql);
                if($this->isValid($result_set)){
                    $this->agent_session($result_set);
                    $authentication=true;
                }
                //checking for branch manager
                $sql="SELECT * FROM branch_manager WHERE phone='".$authentication_variables[0]."' AND password='".$authentication_variables[1]."';";
                $result_set=$GLOBALS['connection']->query($sql);
                if($this->isValid($result_set)){
                    $this->branch_manager_session($result_set);
                    $authentication=true;
                }
                //checking for admin
                $sql="SELECT * FROM admin WHERE phone='".$authentication_variables[0]."' AND password='".$authentication_variables[1]."';";
                $result_set=$GLOBALS['connection']->query($sql);
                if($this->isValid($result_set)){
                    $this->admin_session($result_set);
                    $authentication=true;
                }
            }
            return $authentication;
        }
        function session_call($key,$value){
            //initiating session
            $session=new Session();
            for($i=0;$i<count($key);$i++){
                $session->initiate_session($key,$value);
            }
        }
        function agent_session($result_set){
            $result=$result_set->fetch_assoc();
            $key=array("name","id","user_type","photo");
            $value=array($result['name'],$result['id'],"Agent",$result['photo']);
            $this->session_call($key,$value);
            //redirecting to dashboard
            header("location:Agent/menu_dashboard.php");
        }
        function branch_manager_session($result_set){
            $result=$result_set->fetch_assoc();
            $key=array("name","id","user_type","photo");
            $value=array($result['name'],$result['id'],"Branch_Manager",$result['photo']);
            $this->session_call($key,$value);
            //redirecting to dashboard
            header("location:BranchManager/menu_dashboard.php");
        }
        function admin_session($result_set){
            $result=$result_set->fetch_assoc();
            $key=array("name","id","user_type","photo");
            $value=array($result['name'],$result['id'],"Admin",$result['photo']);
            $this->session_call($key,$value);
            //redirecting to dashboard
            header("location:Admin/menu_dashboard.php");
        }
        function authenticate(){
            //getting form values
            $form=new Form();
            $form_values=$form->get_form_values(array("id","password"));
            //validating user
            $authentication=$this->authentication($form_values);
            if($authentication){
                return 0;
            }else{
                echo "Invalid data";
            }
        }
    }

?>