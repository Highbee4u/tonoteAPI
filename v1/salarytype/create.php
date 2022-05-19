<?php include_once('core/SalaryType.php'); ?>
<?php
    $requireddata = [
       'group_id',
       'monthly_gross',
       'annual_gross',
       'daily_pay'
   ];

   $digitarray = [
     'monthly_gross',
     'annual_gross',
     'daily_pay'
   ];

     if(!empty($data)){

        $validata = validaterequiredfields($data, $requireddata);

        if(!empty($validata)){
          retResponse('400','Error', false, $validata);
        }

        $validdigit = validatenumber($digitarray, $data);

        if(!empty($validdigit)){
          retResponse('400','Error', false, $validdigit);
        }
         
        $salarydetail = $salary->create($data);
      // retResponse('200','Debug', true, $salarydetail);
        if($salarydetail){
            retResponse('200','Salary detail Created Successfully', true);
        }else{
            retResponse('400','Unable to add Salary detail, try later', false);
        }
        
      }else{
        retResponse('400','parameter not set', false);
      }
?>
