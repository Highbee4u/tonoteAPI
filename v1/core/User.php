<?php  
// filename: user.php
if(!file_exists("database.php")){
    require_once 'database.php';
}

if(!class_exists('User')){
    class User {

        private $table = 'admin';
    
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
    
        /* for login process */
        public function login($postedval){
            
            $con = connection::getConnection();
            
            $user_data = array();

            $count_row = 0;
    
            $cleaned_request = $this->sanitize($postedval);

            $password = $this->myencrypt($cleaned_request['password']);

            $emailusername = $cleaned_request['email'];
    
            $sql="SELECT id, name, email, employeeid FROM `$this->table` WHERE email='$emailusername' AND password='$password'";
    
            $result = $con->query($sql);
    
            if($result){
               while($row = $result->fetch_assoc()){
                    $user_data[] = $row;
               }
                $count_row = $result->num_rows;
            }
    
            if (count($user_data) < 1 || empty($user_data)) {
                return  array('status'=> 0, 'data' => [], 'message' => 'User email and password not found');
            } else {
                return  array('status'=> 1, 'data' => $user_data, 'message' => 'Login Successful');
            }
        }
    
        public function register($data){

            $cleaned_request = $this->sanitize($data);
    
            $con = connection::getConnection();
            
            $password = $this->myencrypt($cleaned_request['password']);
    
            $sql = "INSERT INTO ".$this->table. "( name, email, password, employeeid) VALUE ( '".$cleaned_request['name']."', '".$cleaned_request['email']."', '".$password."', '".$cleaned_request['employeeid']."')";
    
            $result = $con->query($sql);
    
            return $result ? true : false;
    
        }

    
        public function fetch_all(){
            
            $data = array();
    
            $con = connection::getConnection();
    
            $sql = "SELECT id, name, email, employeeid FROM $this->table";
    
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
    
        public function get_user_name_by_email($email){
            $con = connection::getConnection();
    
            $sql = "SELECT name FROM $this->table WHERE  email = '".$email."'";
        
            $result = $con->query($sql);
            $name = $result->fetch_assoc()['name'];
        
            return !empty($name) ? $name : "";
        }
    
        public function delete_user($dataid){
            
            $con = connection::getConnection();
            
            $id = implode(',', $dataid);
    
            $query = "DELETE FROM ".$this->table ." WHERE id= '".$id."'";
    
    
            $result = $con->query($query);
    
            return $result ? true : false;
        }
    
        public function updateuserdetail($data){
            $con = connection::getConnection();
            
            $query = "UPDATE ".$this->table ." SET name = '".$data['name']."', email = '".$data['email']."', user_roleid = '".$data['user_roleid']."', departmentid = '".$data['departmentid']."' WHERE id= '".$data['id']."'";
    
    
            $result = $con->query($query);
    
            return $result ? true : false;
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
    
    $user = new User();
}
