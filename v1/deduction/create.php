<?php include_once('core/DeductionType.php'); ?>
<?php include_once('core/Deduction.php'); ?>

<?php
    $requireddata = [
      'employeeid', 
      'deductiontypeid', 
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

         if($deductiontype->deduction_type_exists($data['deductiontypeid'])){
            
            $response = $deduction->create_employee_deduction($data);
            // retResponse('200','debug', true, $response);
            if($response){
                  retResponse('200','deduction Created Successfully', true);
            }else{
                  retResponse('400','Unable to add deduction, try later', false);
            }
         }else{
          retResponse('400','Error: deductiontype ID Supplied Doesn\'t exists', false);
         }
        
        
        
      }else{
        retResponse('400','parameter not set', false);
      }
?>
