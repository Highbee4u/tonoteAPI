<?php include_once('core/Leave.php'); ?>
<?php
    $requireddata = [
      'employee_id',
      'leave_startdate',
      'leave_enddate',
      'reason'
   ];


     if(!empty($data)){

        $validata = validaterequiredfields($data, $requireddata);

        if(!empty($validata)){

          retResponse('400','Error', false, $validata);

        }

        if(datechecker($data['leave_startdate'])){
          retResponse('400','Error: Leave Startdate can\'t be less than current date', false, []);
        }

        if(datechecker($data['leave_enddate'])){
          retResponse('400','Error: Leave Enddate can\'t be less than current date', false, []);
        }

        if(date_format($data['leave_enddate'], 'Y-m-d h:i:s') <= date_format($data['leave_startdate'], 'Y-m-d h:i:s')){
          retResponse('400','Error: Leave Enddate can\'t be less than or equal to Leave start date', false, []);
        }

        $response = $leave->create($data);

        if($response){

            retResponse('200','Leave Created Successfully', true);

        }else{

            retResponse('400','Unable to create Leave, try later', false);

        }
        
      }else{

        retResponse('400','parameter not set', false);

      }
?>
