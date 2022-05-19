<?php include_once('core/User.php'); ?>
<?php
    $userslist = $user->fetch_all();
    retResponse('200','All Admin', true, $userslist);
?>
