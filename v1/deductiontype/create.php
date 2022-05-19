<?php include_once('core/DeductionType.php'); ?>

<?php
    $requireddata = [
      'deduction_name', 
      'description'
   ];

     if(!empty($data)){
        $validata = validaterequiredfields($data, $requireddata);
         if(!empty($validata)){
            retResponse('400','Error', false, $validata);
         }

         $response = $deductiontype->create($data);

         if($response){
               retResponse('200','Deduction Type Created Successfully', true);
         }else{
               retResponse('400','Unable to add Deductiontype, try later', false);
         }
        
        
      }else{
        retResponse('400','parameter not set', false);
      }
?>
