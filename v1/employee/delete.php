<?php include_once('core/Employee.php'); ?>

<?php
    $requireddata = [
      'employeeid'
    ];
    
    if(!empty($data)){

      $validata = validaterequiredfields($data, $requireddata);

        if(!empty($validata)){

          retResponse('400','Error', false, $validata);

        }else{

          if($employee->employee_exists($data['employeeid'])){

            $response = $employee->delete($data['employeeid']);

            if($response){

              retResponse('200','Employee Deleted Sucessfully', true, []);

            }else{

              retResponse('400','Unable to delete employee detail, try later', true, []);

            }
            
          }else{

            retResponse('404','Employee ID Supplied Doesn\'t exist', false, []);

          }

        }

    }else{

      retResponse('400','parameter not set', false);
      
    }