<?php include_once('core/Leave.php'); ?>
<?php
    $requireddata = [
      'leave_id',
      'declined_reason'
   ];


     if(!empty($data)){

        $validata = validaterequiredfields($data, $requireddata);

        if(!empty($validata)){

          retResponse('400','Error', false, $validata);

        }

        if($leave->if_exists($data['leave_id'])){

          $response = $leave->decline($data);

          if($response){
  
              retResponse('200','Leave Decline Successfully', true);
  
          }else{
  
              retResponse('400','Unable to Decline Leave, try later', false);
  
          }

        }else{
          retResponse('400','Leave ID Supplied Doesn\'t exists', false);
        }
        
        
      }else{

        retResponse('400','parameter not set', false);
        
      }
?>
