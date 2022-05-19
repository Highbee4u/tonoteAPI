<?php include_once('core/Employee.php'); ?>
<?php include_once('core/SalaryType.php'); ?>
<?php
    $requireddata = [
       'employeeid',
       'first_name',
       'last_name',
       'gender',
       'age',
       'contact_address',
       'phone',
       'salary_groupid'
   ];

     if(!empty($data)){
        $validata = validaterequiredfields($data, $requireddata);
         if(!empty($validata)){
            retResponse('400','Error', false, $validata);
         }

         if(key_exists('email', $data)){
            if(!validateEmail($data['email'])){
              retResponse('400','Error: Email Enter is not valid', false, []);
            }
         }
         
         if(key_exists('phone', $data)){
            if(!validate_phone_number($data['phone'])){
              retResponse('400','Error: Enter a valid Nigeria Number eg: 2347023456789', false, []);
            }
          }

         if(key_exists('salary_groupid', $data)){
            if(!$salary->group_exists($data['salary_groupid'])){
               retResponse('400','Error: Salary group ID Supplied doesn\'t exist', false);
            }
         }  
            $response = $employee->update($data);
            // retResponse('200','debug', true, $response);
            if($response){
                retResponse('200','Employee Detail Updated Successfully', true);
            }else{
                retResponse('400','Unable to Update Employee detail,  try later', false);
            }
        
      }else{
        retResponse('400','parameter not set', false);
      }
?>
