<?php 

    //error_reporting(0);

    //branch
    class Branch_Contract{
        private static $table_name="branch";
        private static $table_columns=array("branch","address","city","pincode","user_id","source_id","auth_token","remark");
        public static function get_table_name(){
            return self::$table_name;
        }
        public static function get_table_columns(){
            return self::$table_columns;
        }
    }
    //company 
    class Company_Contract{
        private static $table_name="company";
        private static $table_columns=array("company_name","remark");
        public static function get_table_name(){
            return self::$table_name;
        }
        public static function get_table_columns(){
            return self::$table_columns;
        }
    }
    //company code
    class Company_Code_Contract{
        private static $table_name="company_code";
        private static $table_columns=array("company_name","company_code","remark");
        public static function get_table_name(){
            return self::$table_name;
        }
        public static function get_table_columns(){
            return self::$table_columns;
        }
    }
    //policy period
    class Policy_Period_Contract{
        private static $table_name="policy_period";
        private static $table_columns=array("policy_period","remark");
        public static function get_table_name(){
            return self::$table_name;
        }
        public static function get_table_columns(){
            return self::$table_columns;
        }
    }
    //policy type
    class Policy_Type_Contract{
        private static $table_name="policy_type";
        private static $table_columns=array("policy_type","remark");
        public static function get_table_name(){
            return self::$table_name;
        }
        public static function get_table_columns(){
            return self::$table_columns;
        }
    }
    //product 
    class Product_Contract{
        private static $table_name="product";
        private static $table_columns=array("product","remark");
        public static function get_table_name(){
            return self::$table_name;
        }
        public static function get_table_columns(){
            return self::$table_columns;
        }
    }
    //cheque
    class Cheque_Contract{
        private static $table_name="cheque";
        private static $table_columns=array("cheque_number","cheque_date","bank_name");
        public static function get_table_name(){
            return self::$table_name;
        }
        public static function get_table_columns(){
            return self::$table_columns;
        }
    }
    //transaction
    class Transaction_Contract{
        private static $table_name="transaction";
        private static $table_columns=array("amount","payment","agent_id","remark");
        public static function get_table_name(){
            return self::$table_name;
        }
        public static function get_table_columns(){
            return self::$table_columns;
        }
    }
    //policy
    class Policy_Contract{
        private static $table_name="policy";
        private static $table_columns=array("issue_date","company_name","policy_type","product",
                                    "policy_number","customer_name","mobile","email","registration_number",
                                    "make_model","od_policy_start_date","od_policy_period","od_policy_end_date",
                                    "tp_policy_start_date","tp_policy_period","tp_policy_end_date","od_disc",
                                    "od_premium","tp_premium","net_premium","total_premium","payment_mode");
        public static function get_table_name(){
            return self::$table_name;
        }
        public static function get_table_columns(){
            return self::$table_columns;
        }
    }
    //policy files
    class Policy_Files_Contract{
        private static $table_name="policy_files";
        private static $table_columns=array("file_1","file_2","file_3","file_4");
        public static function get_table_name(){
            return self::$table_name;
        }
        public static function get_table_columns(){
            return self::$table_columns;
        } 
    }
    //agent
    class Agent_Contract{
        private static $table_name="agent";
        private static $table_columns=array("name","mobile","email","address","pan_card_number","aadhar_card_number","bank_name","bank_branch","ifsc_code","micr_number","phonepe_number","paytm_number","google_pay_number","upi_id","photo","address_proof","id_proof","educational_proof","pan_card");
        public static function get_table_name(){
            return self::$table_name;
        }
        public static function get_table_columns(){
            return self::$table_columns;
        }
    }
    //branch manager
    class Branch_Manager_Contract{
        private static $table_name="branch_manager";
        private static $table_columns=array("name","mobile","email","address","pan_card_number","aadhar_card_number","bank_name","bank_branch","ifsc_code","micr_number","phonepe_number","paytm_number","google_pay_number","upi_id","photo","address_proof","id_proof","educational_proof","pan_card","branch");
        public static function get_table_name(){
            return self::$table_name;
        }
        public static function get_table_columns(){
            return self::$table_columns;
        }
    }
    //operator
    class Operator_Contract{
        private static $table_name="operator";
        private static $table_columns=array("name","mobile","email","address","pan_card_number","aadhar_card_number","bank_name","bank_branch","ifsc_code","micr_number","phonepe_number","paytm_number","google_pay_number","upi_id","photo","address_proof","id_proof","educational_proof","pan_card");
        public static function get_table_name(){
            return self::$table_name;
        }
        public static function get_table_columns(){
            return self::$table_columns;
        }
    }
    //accountant
    class Accountant_Contract{
        private static $table_name="accountant";
        private static $table_columns=array("name","mobile","email","address","pan_card_number","aadhar_card_number","bank_name","bank_branch","ifsc_code","micr_number","phonepe_number","paytm_number","google_pay_number","upi_id","photo","address_proof","id_proof","educational_proof","pan_card");
        public static function get_table_name(){
            return self::$table_name;
        }
        public static function get_table_columns(){
            return self::$table_columns;
        }
    }

?>