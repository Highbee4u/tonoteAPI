<?php include_once('core/DeductionType.php'); ?>

<?php
    $requireddata = [
      'id'
    ];
    
    if(!empty($data)){

      $validata = validaterequiredfields($data, $requireddata);

        if(!empty($validata)){

          retResponse('400','Error', false, $validata);

        }else{

          if($deductiontype->deduction_type_exists($data['id'])){

            $response = $deductiontype->delete($data['id']);

            if($response){

              retResponse('200','Deduction Type Deleted Sucessfully', true, []);

            }else{

              retResponse('400','Unable to delete Deduction type, try later', true, []);

            }
            
          }else{

            retResponse('404','Deduction ID Supplied Doesn\'t exist', false, []);

          }

        }

    }else{

      retResponse('400','parameter not set', false);
      
    }