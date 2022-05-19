<?php include_once('core/Allowance.php'); ?>
<?php
    $allowancelist = $allowance->fetch_all();
    retResponse('200','All Allowance', true, $allowancelist);
?>
