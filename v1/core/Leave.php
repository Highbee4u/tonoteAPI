<?php  
// filename: user.php
if(!file_exists("database.php")){
    require_once 'database.php';
}

if(!class_exists('Leave')){

    class Leave {

        private $table = 'leavedetail';
        
    
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
    
            $sql = "INSERT INTO ".$this->table. "( employee_id, leave_startdate, leave_enddate, reason) VALUE ( '".$cleaned_request['employee_id']."', '".$cleaned_request['leave_startdate']."', '".$cleaned_request['leave_enddate']."', '".$cleaned_request['reason']."')";
    
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
    
        public function approve($data){

            $con = connection::getConnection();
    
            $cleaned_request = $this->sanitize($data);

            $id = implode(',', $cleaned_request);
    
            $query = "UPDATE $this->table SET status = 1, approveddate = '".date('Y-m-d h:i:s', time())."', reason = '' WHERE leave_id = '".$id."'";
    
            $result = $con->query($query);
    
            return $result ? true : false;
        }

        public function decline($data){

          $con = connection::getConnection();
  
          $cleaned_request = $this->sanitize($data);
  
          $query = "UPDATE `$this->table` SET `status` = -1, `declined_date` = '".date('Y-m-d h:i:s', time())."', `declined_reason`= '".$cleaned_request['declined_reason']."' WHERE leave_id = '".$cleaned_request['leave_id']."'";
  
          $result = $con->query($query);
  
          return $result ? true : false;
      }
    
        public function delete($dataid){
            
            $con = connection::getConnection();
            
            $id = implode(',', $dataid);
    
            $query = "DELETE FROM ".$this->table ." WHERE id= '".$id."'";
    
    
            $result = $con->query($query);
    
            return $result ? true : false;
        }

        public function if_exists($id){

          $isexists = false;
  
          $check = $this->fetch_by_criterial(array('leave_id'=>$id));
  
          if(!empty($check)){
              $isexists = true;
          }
  
          return $isexists;
  
      }
    
    }
    
    $leave = new Leave();
}
