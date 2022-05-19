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

            $response = $deduction->fetch_by_criterial(array("id" => $data['id']));

            if($response){

              retResponse('200','Deduction Detail', true, $response);

            }else{

              retResponse('400','Unable to retrive data, try later', true, []);

            }
            
          }else{

            retResponse('404','Deduction ID Supplied Doesn\'t exist', false, []);

          }

        }

    }else{

      retResponse('400','parameter not set', false);
      
    }