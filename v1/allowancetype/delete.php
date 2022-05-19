<?php include_once('core/AllowanceType.php'); ?>

<?php
    $requireddata = [
      'id'
    ];
    
    if(!empty($data)){

      $validata = validaterequiredfields($data, $requireddata);

        if(!empty($validata)){

          retResponse('400','Error', false, $validata);

        }else{

          if($allowancetype->allowance_type_exists($data['id'])){

            $response = $allowancetype->delete($data['id']);

            if($response){

              retResponse('200','Allowance Type Deleted Sucessfully', true, []);

            }else{

              retResponse('400','Unable to delete Allowance type, try later', true, []);

            }
            
          }else{

            retResponse('404','Allowance ID Supplied Doesn\'t exist', false, []);

          }

        }

    }else{

      retResponse('400','parameter not set', false);
      
    }