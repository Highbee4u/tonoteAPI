<?php include_once('core/AllowanceType.php'); ?>

<?php
    $requireddata = [
      'allowance_name', 
      'description'
   ];

     if(!empty($data)){
        $validata = validaterequiredfields($data, $requireddata);
         if(!empty($validata)){
            retResponse('400','Error', false, $validata);
         }

         $response = $allowancetype->create($data);

         if($response){
               retResponse('200','Allowance Type Created Successfully', true);
         }else{
               retResponse('400','Unable to add Allowancetype, try later', false);
         }
        
        
      }else{
        retResponse('400','parameter not set', false);
      }
?>
