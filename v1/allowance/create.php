<?php include_once('core/AllowanceType.php'); ?>
<?php include_once('core/Allowance.php'); ?>

<?php
    $requireddata = [
      'employeeid', 
      'allowancetypeid', 
      'amount', 
      'effective_date'
   ];

   $digitarray = [
      'amount'
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

         $validdate = validate_date($data['effective_date']);

         if(!$validdate){
           retResponse('400','Error: Effective date must be in \'Y-m-d\' format', false, []);
         }

         if($allowancetype->allowance_type_exists($data['allowancetypeid'])){
            
            $response = $allowance->create_employee_allowance($data);
            // retResponse('200','debug', true, $response);
            if($response){
                  retResponse('200','Allowance Created Successfully', true);
            }else{
                  retResponse('400','Unable to add Allowance, try later', false);
            }
         }else{
          retResponse('400','Error: Allowancetype ID Supplied Doesn\'t exists', false);
         }
        
        
        
      }else{
        retResponse('400','parameter not set', false);
      }
?>
