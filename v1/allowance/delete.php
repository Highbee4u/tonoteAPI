<?php include_once('core/Allowance.php'); ?>

<?php
    $requireddata = [
      'id'
    ];
    
    if(!empty($data)){

      $validata = validaterequiredfields($data, $requireddata);

        if(!empty($validata)){

          retResponse('400','Error', false, $validata);

        }else{

          if($allowance->allowance_exists($data['id'])){

            $response = $allowance->delete_allowance($data['id']);

            if($response){

              retResponse('200','Allowance Deleted Sucessfully', true, []);

            }else{

              retResponse('400','Unable to delete Allowance, try later', true, []);

            }
            
          }else{

            retResponse('404','Allowance ID Supplied Doesn\'t exist', false, []);

          }

        }

    }else{

      retResponse('400','parameter not set', false);
      
    }