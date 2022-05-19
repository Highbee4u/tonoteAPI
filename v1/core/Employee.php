<?php  
// filename: user.php
if(!file_exists("database.php")){
    require_once 'database.php';
}

if(!class_exists('Employee')){

    class Employee {

        private $table = 'employeedetail';
        private $deduction_table = 'employee_deduction';
        private $allowance_table = 'employee_allowance';
        private $salary_type = 'salary';

    
        public function myencrypt($str){
            return md5($str);
        }
    
        public function sanitize($array) {

            $con = connection::getConnection();

            foreach($array as $key=>$value) {

                if(is_array($value)) { 

                    $this->sanitize($value); 

                }else { 

                    $array[$key] = mysqli_real_escape_string($con, $value); 

                }
           }
           return $array;
        }
    
        public function register($data){
          
            $cleaned_request = $this->sanitize($data);
    
            $con = connection::getConnection();
            
            $employeeid = "EMP/".rand(0001, 9802);
    
            $sql = "INSERT INTO ".$this->table. "( employeeid, first_name, last_name, gender, age, contact_address, email, salary_groupid, phone, password) VALUE ('".$employeeid."', '".$cleaned_request['first_name']."', '".$cleaned_request['last_name']."',  '".$cleaned_request['gender']."', '".$cleaned_request['age']."', '".$cleaned_request['contact_address']."' ,'".$cleaned_request['email']."',  '".$cleaned_request['salary_groupid']."',  '".$cleaned_request['phone']."',  '".$this->myencrypt($cleaned_request['password'])."')";
    
            // return $sql;

            $result = $con->query($sql);
    
            return $result ? true : false;
    
        }
    
        public function fetch_all(){
            
            $data = array();
    
            $con = connection::getConnection();
    
            $sql = "SELECT * FROM $this->table";
    
            $result = $con->query($sql);
    
            if($result){
    
                while($row = $result->fetch_assoc()){
    
                    $data[] = $row;
    
                }
            }
    
            return $data;
        }
    
        public function fetch_by_criterial($table_name, $conditions = array()){
            
            $data = array();
            $con = connection::getConnection();
    
            $filter = '';
            foreach($conditions as $col=>$colval){
                $filter .= "`".$col."` = '".$colval."' AND";
            }
    
            $filters = substr($filter,0, -3);
    
            $sql = 'SELECT * FROM '.$table_name.' WHERE '.$filters;
    
            $user_data = array();
            $count_row = 0;
    
            $result = $con->query($sql);
            
            if($result){
                $count_row = $result->num_rows;
            }
    
            if($count_row > 0){
                while($row = $result->fetch_assoc()){
                    $user_data[] = $row;
                }
            }
            return $user_data;
        }
        
        public function get_user_name_by_id($userid){
            $con = connection::getConnection();
    
            $sql = "SELECT name FROM $this->table WHERE  id = '".$userid."'";
        
            $result = $con->query($sql);
            $name = $result->fetch_assoc()['name'];
        
            return !empty($name) ? $name : "";
        }
    
        public function get_user_name_by_email($email){
            $con = connection::getConnection();
    
            $sql = "SELECT name FROM $this->table WHERE  email = '".$email."'";
        
            $result = $con->query($sql);
            $name = $result->fetch_assoc()['name'];
        
            return !empty($name) ? $name : "";
        }

        public function delete_employee_deduction($employeeid){
            
            $con = connection::getConnection();

            $query = "DELETE FROM ".$this->deduction_table ." WHERE employeeid = '".$employeeid."'";

            $result = $con->query($query);

            return $result ? true : false;
        }

        public function delete_employee_allowance($employeeid){
            
            $con = connection::getConnection();

            $query = "DELETE FROM ".$this->allowance_table ." WHERE employeeid = '".$employeeid."'";

            $result = $con->query($query);

            return $result ? true : false;
        }

        public function delete_employee($employeeid){
            
            $con = connection::getConnection();

            $query = "DELETE FROM ".$this->table ." WHERE employeeid = '".$employeeid."'";

            $result = $con->query($query);

            return $result ? true : false;
        }

        public function delete($employeeid){

            $con = connection::getConnection();

            mysqli_begin_transaction($con);

            try {

                $this->delete_employee_allowance($employeeid);

                $this->delete_employee_deduction($employeeid);

                $this->delete_employee($employeeid);

                return mysqli_commit($con) ? true : false;

            } catch (\Throwable $exception) {
                mysqli_rollback($con);

                return false;
            }
        }
       
        public function employee_exists($id){

            $isexists = false;
    
            $check = $this->fetch_by_criterial($this->table, array('employeeid'=>$id));
    
            if(!empty($check)){
                $isexists = true;
            }
    
            return $isexists;
    
        }
    
        public function update($data){
            $con = connection::getConnection();

            $response = $this->fetch_by_criterial($this->table, array('employeeid'=>$data['employeeid']));

            $first_name = empty($data['first_name']) ? $response[0]['first_name'] : $data['first_name'];
            $last_name = empty($data['last_name']) ? $response[0]['last_name'] : $data['last_name'];
            $gender = empty($data['gender']) ? $response[0]['gender'] : $data['gender'];
            $email = empty($data['email']) ? $response[0]['email'] : $data['email'];
            $status = empty($data['status']) ? $response[0]['status'] : $data['status'];
            $age = empty($data['age']) ? $response[0]['age'] : $data['age'];
            $contact_address = empty($data['contact_address']) ? $response[0]['contact_address'] : $data['contact_address'];
            $salary_groupid = empty($data['salary_groupid']) ? $response[0]['salary_groupid'] : $data['salary_groupid'];
            $phone = empty($data['phone']) ? $response[0]['phone'] : $data['phone'];
            $password = empty($data['password']) ? $response[0]['password'] : $this->myencrypt($data['password']);


            $query = "UPDATE ".$this->table ." SET first_name = '".$first_name."',last_name = '".$last_name."', gender = '".$gender."', email = '".$email."', status = '".$status."',  age = '".$age."', contact_address = '".$contact_address."', salary_groupid = '".$salary_groupid."', password = '".$password."', salary_groupid = '".$salary_groupid."', phone = '".$phone."' WHERE employeeid = '".$data['employeeid']."'";
    
    
            $result = $con->query($query);
    
            return $result ? true : false;
        }  

        public function fetch_employeedetail($employeeid){
            $con = connection::getConnection();

            $basic_info = $this->fetch_by_criterial($this->table, array('employeeid'=>$employeeid));
            if(!empty($basic_info)){
                $salary_info = $this->fetch_by_criterial($this->salary_type, array('group_id'=>$basic_info[0]['salary_groupid']));
            }
            $allowancce_info= $this->fetch_by_criterial($this->allowance_table, array('employeeid'=>$employeeid), 'effective_date');
            $deduction_info= $this->fetch_by_criterial($this->deduction_table, array('employeeid'=>$employeeid), 'effective_date');


            $response = [
                "EmployeeInfo" => $basic_info,
                "SalaryDetail" => $salary_info,
                "DeductionDetail" => $deduction_info,
                "AllowanceDetail" => $allowancce_info,
            ];

            return $response;
        }

        public function fetch_employeedetail_by_date($employeeid, $effectivedate){
            $con = connection::getConnection();

            $basic_info = $this->fetch_by_criterial($this->table, array('employeeid'=>$employeeid, 'effective_date'=>$effectivedate));
            if(!empty($basic_info)){
                $salary_info = $this->fetch_by_criterial($this->salary_type, array('group_id'=>$basic_info[0]['salary_groupid']));
            }
            $allowancce_info= $this->fetch_by_criterial($this->allowance_table, array('employeeid'=>$employeeid, 'effective_date'=>$effectivedate));
            $deduction_info= $this->fetch_by_criterial($this->deduction_table, array('employeeid'=>$employeeid, 'effective_date', 'effective_date'=>$effectivedate));


            $response = [
                "EmployeeInfo" => $basic_info,
                "SalaryDetail" => $salary_info,
                "DeductionDetail" => $deduction_info,
                "AllowanceDetail" => $allowancce_info,
            ];

            return $response;
        }
    }
    
    $employee = new Employee();
}
