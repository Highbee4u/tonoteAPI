<?php  
// filename: user.php
if(!file_exists("database.php")){
    require_once 'database.php';
}

if(!class_exists('Deduction')){

    class Deduction {

        private $table = 'employee_deduction';
        
    
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
    
        public function create_employee_deduction($data){
          $cleaned_request = $this->sanitize($data);
  
          $con = connection::getConnection();
  
          $sql = "INSERT INTO ".$this->table. "( employeeid, deductiontypeid, amount, effective_date ) VALUE ('".$cleaned_request['employeeid']."', '".$cleaned_request['deductiontypeid']."',  '".$cleaned_request['amount']."',  '".$cleaned_request['effective_date']."')";

        //   return $sql;
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
    
        public function fetch_by_criterial($conditions = array()){
            
            $data = array();
            $con = connection::getConnection();
    
            $filter = '';
            foreach($conditions as $col=>$colval){
                $filter .= "`".$col."` = '".$colval."' AND";
            }
    
            $filters = substr($filter,0, -3);
    
            $sql = 'SELECT * FROM '.$this->table.' WHERE '.$filters;
    
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
        
        
        public function update_password($data){
            $con = connection::getConnection();
            
            $user_data = array();
          
    
            $cleaned_request = $this->sanitize($data);
    
            $password = $this->myencrypt($cleaned_request['password']);
    
            $query = "UPDATE $this->table SET password = '".$password."', login_attempt = 1 WHERE id = '".$cleaned_request['userid']."' AND email = '".$cleaned_request['email']."'";
    
            $result = $con->query($query);
    
            return $result ? true : false;
        }
    
        public function delete_deduction($deductionid){
            
            $con = connection::getConnection();
    
            $query = "DELETE FROM ".$this->table ." WHERE id= '".$deductionid."'";
    
    
            $result = $con->query($query);
    
            return $result ? true : false;
        }

        public function deduction_exists($id){

            $isexists = false;
    
            $check = $this->fetch_by_criterial(array('id'=>$id));
    
            if(!empty($check)){
                $isexists = true;
            }
    
            return $isexists;
    
        }

        public function get_employee_total_deduction($employeeid, $date){
            $con = connection::getConnection();
    
            $query = "SELECT SUM(IFNULL(amount, 0)) total_deduction FROM ".$this->table ." WHERE employeeid = '".$employeeid."' AND effective_date = '".$date."' GROUP BY employeeid, effective_date";
    
    
            $result = $con->query($query);

            $total = $result->fetch_assoc()['total_deduction'];
    
            return !empty($total) ? $total : "";
    
            return $result;
        }
    }
    
    $deduction = new Deduction();
}

?>
