<?php include_once('core/SalaryType.php'); ?>

<?php
    $requireddata = [
      'salary_id'
    ];
    
    if(!empty($data)){

      $validata = validaterequiredfields($data, $requireddata);

        if(!empty($validata)){

          retResponse('400','Error', false, $validata);

        }else{

          if($salary->if_exists($data['salary_id'])){

            $response = $salary->fetch_by_criterial(array("salary_id" => $data['salary_id']));

            if($response){

              retResponse('200','Salary Detail', true, $response);

            }else{

              retResponse('400','Unable to retrive data, try later', true, []);

            }
            
          }else{

            retResponse('404','Salary ID Supplied Doesn\'t exist', false, []);

          }

        }

    }else{

      retResponse('400','parameter not set', false);
      
    }