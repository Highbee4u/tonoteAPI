<?php include_once('core/Employee.php'); ?>
<?php include_once('core/SalaryType.php'); ?>
<?php
    $requireddata = [
       'first_name',
       'last_name',
       'gender',
       'age',
       'contact_address',
       'email',
       'password',
       'phone',
       'salary_groupid'
   ];

     if(!empty($data)){
        $validata = validaterequiredfields($data, $requireddata);
         if(!empty($validata)){
            retResponse('400','Error', false, $validata);
         }

         if(!validateEmail($data['email'])){
          retResponse('400','Error: Email Enter is not valid', false, []);
         }

         if(!validate_phone_number($data['phone'])){
          retResponse('400','Error: Enter a valid Nigeria Number eg: 2347023456789', false, []);
         }

         if($salary->group_exists($data['salary_groupid'])){
            $response = $employee->register($data);
            // retResponse('200','debug', true, $response);
            if($response){
                retResponse('200','Employee Created Successfully', true);
            }else{
                retResponse('400','Unable to add Employee, try later', false);
            }
         }else{
          retResponse('400','Error: Salary Group ID Supplied doesnot Exist', false);
         }
        
        
      }else{
        retResponse('400','parameter not set', false);
      }
?>
