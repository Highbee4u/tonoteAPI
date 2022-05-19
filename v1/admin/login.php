<?php include_once('core/User.php'); ?>
<?php
      $requireddata = ['email','password'];

      if(!empty($data)){
         $validata = validaterequiredfields($data, $requireddata);
          if(!empty($validata)){
             retResponse('400','Error', false, $validata);
          }else{
             $response = $user->login($data);
             retResponse('200',$response['message'], ($response['status'] == 1 ? true : false), $response['data']);
          }
         
       }else{
         retResponse('400','parameter not set', false);
       }
