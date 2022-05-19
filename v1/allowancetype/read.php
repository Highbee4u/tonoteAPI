<?php include_once('core/AllowanceType.php'); ?>
<?php
    $allowancelist = $allowancetype->fetch_all();
    retResponse('200','All Allowance Type', true, $allowancelist);
?>
