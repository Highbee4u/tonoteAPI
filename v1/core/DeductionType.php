
<?php  
// filename: user.php
if(!file_exists("database.php")){
    require_once 'database.php';
}

if(!class_exists('Deductiontype')){

    class Deductiontype {

        private $table = 'deductiontype';
        
    
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
    
            $sql = "INSERT INTO ".$this->table. "( `name`, `description`) VALUE ( '".$cleaned_request['deduction_name']."', '".$cleaned_request['description']."')";
    
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
    
        public function delete($id){
            
            $con = connection::getConnection();
    
            $query = "DELETE FROM ".$this->table ." WHERE id= '".$id."'";
    
    
            $result = $con->query($query);
    
            return $result ? true : false;
        }

        public function deduction_type_exists($id){

          $isexists = false;
  
          $check = $this->fetch_by_criterial(array('id'=>$id));
  
          if(!empty($check)){
              $isexists = true;
          }
  
          return $isexists;
  
        }

        public function get_deduction_type_name_by_id($deductionid){
          $con = connection::getConnection();
  
          $sql = "SELECT name FROM $this->table WHERE  id = '".$deductionid."'";
      
          $result = $con->query($sql);
          $name = $result->fetch_assoc()['name'];
      
          return !empty($name) ? $name : "";
      }

        public function update(){

        }
    
    }
    
    $deductiontype = new Deductiontype();
}
