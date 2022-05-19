<?php include_once('core/SalaryType.php'); ?>
<?php
    $requireddata = [
       'salary_id'
   ];

   $digitarray = [
    'monthly_bonus', 
    'group_id', 
    'monthly_gross', 
    'annual_gross',
    'annual_bonus', 
    'daily_pay',
    'daily_bonus'
   ];

     if(!empty($data)){

      $validata = validaterequiredfields($data, $requireddata);

      if(!empty($validata)){
        retResponse('400','Error', false, $validata);
      }

      if($salary->if_exists($data['salary_id'])){

        $validdigit = validatenumber($digitarray, $data);

        if(!empty($validdigit)){
          retResponse('400','Error', false, $validdigit);
        }
        
        $salarydetail = $salary->update($data);


        if($salarydetail){
            retResponse('200','Salary detail Updated Successfully', true);
        }else{
            retResponse('400','Unable to Update Salary detail, try later', false);
        }
      }else{
        retResponse('404','Salary ID Supply doesn\'t exists', false);
      }
        
      }else{
        retResponse('400','parameter not set', false);
      }
?>
