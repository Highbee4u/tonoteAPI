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

            $response = $allowancetype->fetch_by_criterial(array("id" => $data['id']));

            if($response){

              retResponse('200','Allowancetype Detail', true, $response);

            }else{

              retResponse('400','Unable to retrive data, try later', true, []);

            }
            
          }else{

            retResponse('404','Allowance Type ID Supplied Doesn\'t exist', false, []);

          }

        }

    }else{

      retResponse('400','parameter not set', false);
      
    }