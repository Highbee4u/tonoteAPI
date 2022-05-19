<?php include_once('core/User.php'); ?>
<?php
    $requireddata = [
       'name',
       'email',
       'password',
       'employeeid'
   ];

     if(!empty($data)){
        $validata = validaterequiredfields($data, $requireddata);
         if(!empty($validata)){
            retResponse('400','Error', false, $validata);
         }else{
            $userdata = $user->register($data);
            if($userdata){
               retResponse('200','Admin Created Successfully', true);
            }else{
               retResponse('400','Unable to add Admin, try later', false);
            }
            
         }
        
      }else{
        retResponse('400','parameter not set', false);
      }
?>
