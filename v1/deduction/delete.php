<?php include_once('core/Deduction.php'); ?>

<?php
    $requireddata = [
      'id'
    ];
    
    if(!empty($data)){

      $validata = validaterequiredfields($data, $requireddata);

        if(!empty($validata)){

          retResponse('400','Error', false, $validata);

        }else{

          if($deduction->deduction_exists($data['id'])){

            $response = $deduction->delete_deduction($data['id']);

            if($response){

              retResponse('200','deduction Deleted Sucessfully', true, []);

            }else{

              retResponse('400','Unable to delete deduction, try later', true, []);

            }
            
          }else{

            retResponse('404','deduction ID Supplied Doesn\'t exist', false, []);

          }

        }

    }else{

      retResponse('400','parameter not set', false);
      
    }