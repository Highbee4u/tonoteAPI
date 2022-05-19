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

          if($leave->if_exists($data['leave_id'])){

            $response = $leave->fetch_by_criterial(array("leave_id" => $data['leave_id']));

            if($response){

              if($response[0]['status'] == 1 ){
                $status = "Approved";
              }else if($response[0]['status'] == -1){
                $status = "Declined";
              } else if($response[0]['status'] == 0){
                $status = "Awaiting Approval";
              }
                

              $formated_response = [
                  "Leave_id" => $response[0]['leave_id'],
                  "Status"=> $status,
                  "Approveddate" => ($status == "Approved" ?  $response[0]['approveddate'] : "Not Applicable"),
                  "Declined_reason" => ($status == "Declined" ?  $response[0]['declined_reason'] : "Not Applicable"),
                  "Start_date" => $response[0]['leave_startdate'],
                  "End_date" => $response[0]['leave_enddate']
              ];

              retResponse('200','Leave Detail', true, $formated_response);

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