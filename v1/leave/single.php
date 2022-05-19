<?php include_once('core/Leave.php'); ?>

<?php
    $requireddata = [
      'leave_id'
    ];
    
    if(!empty($data)){

      $validata = validaterequiredfields($data, $requireddata);

        if(!empty($validata)){

          retResponse('400','Error', false, $validata);

        }else{

          if($salary->if_exists($data['leave_id'])){

            $response = $salary->fetch_by_criterial(array("leave_id" => $data['leave_id']));

            if($response){

              retResponse('200','Leave Detail', true, $response);

            }else{

              retResponse('400','Unable to retrive data, try later', true, []);

            }
            
          }else{

            retResponse('404','Leave ID Supplied Doesn\'t exist', false, []);

          }

        }

    }else{

      retResponse('400','parameter not set', false);
      
    }