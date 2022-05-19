<?php  
// filename: user.php
if(!file_exists("database.php")){
    require_once 'database.php';
}

if(!class_exists('SalaryType')){
    class SalaryType {

        private $table = 'salary';
        public $salary_id;
        public $group_id;
        public $monthly_gross;
        public $annual_gross;
        public $daily_pay;
    
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
    
        public function create($data){

            $cleaned_request = $this->sanitize($data);
    
            $con = connection::getConnection();
    
            $sql = "INSERT INTO ".$this->table. "( group_id, monthly_gross, annual_gross, daily_pay) VALUE ( '".$cleaned_request['group_id']."', '".$cleaned_request['monthly_gross']."', '".$cleaned_request['annual_gross']."', '".$cleaned_request['daily_pay']."')";
    
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
    
        public function get_user_name_by_id($userid){
            $con = connection::getConnection();
    
            $sql = "SELECT name FROM $this->table WHERE  id = '".$userid."'";
        
            $result = $con->query($sql);
            $name = $result->fetch_assoc()['name'];
        
            return !empty($name) ? $name : "";
        }
    
        public function delete($dataid){
            
            $con = connection::getConnection();
            
            $id = implode(',', $dataid);
    
            $query = "DELETE FROM ".$this->table ." WHERE salary_id= '".$id."'";
    
    
            $result = $con->query($query);
    
            return $result ? true : false;
        }
    
        public function update($posteddata){

            $con = connection::getConnection();

            $salarydetail = $this->fetch_by_criterial(array('salary_id'=>$posteddata['salary_id']));

            $data = $this->sanitize($posteddata);


            $this->salary_id = $data['salary_id'];
            $this->group_id = empty($data['group_id']) ? $salarydetail[0]['group_id'] : $data['group_id'];
            $this->monthly_gross = empty($data['monthly_gross']) ? $salarydetail[0]['monthly_gross'] : $data['monthly_gross'];
            $this->annual_gross = empty($data['annual_gross']) ? $salarydetail[0]['annual_gross'] : $data['annual_gross'];
            $this->daily_pay = empty($data['daily_pay']) ? $salarydetail[0]['daily_pay'] : $data['daily_pay'];
            
            $query = "UPDATE ".$this->table ." SET group_id = '".$this->group_id."', monthly_gross = '".$this->monthly_gross."', annual_gross = '". $this->annual_gross."', daily_pay = '". $this->daily_pay."' WHERE salary_id= '".$data['salary_id']."'";

            $result = $con->query($query);
    
            return $result ? true : false;
        }

        public function if_exists($id){

            $isexists = false;
    
            $check = $this->fetch_by_criterial(array('salary_id'=>$id));
    
            if(!empty($check)){
                $isexists = true;
            }
    
            return $isexists;
    
        }

        public function group_exists($id){
            $isexists = false;
    
            $check = $this->fetch_by_criterial(array('group_id'=>$id));
    
            if(!empty($check)){
                $isexists = true;
            }
    
            return $isexists;
    
        }
    
        // implements later, to check if user is been assigned to approve or delete and if true, prevent delete
    
        // public function is_assigned($column, $userid){
        //     $con = connection::getConnection();
            
        //     $query = "SELECT count(*) as assign FROM $this->table WHERE $column = '$userid'";
    
        //     $result = $con->query($query);
    
        //     if($result){
        //         $count = $result->fetch_assoc()['assign'];
        //     }
    
        //     return $count > 0 ? true : false;
        // }
        
    }
    
    $salary = new SalaryType();
}
