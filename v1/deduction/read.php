<?php include_once('core/Deduction.php'); ?>
<?php
    $deductionlist = $deduction->fetch_all();
    retResponse('200','All Deduction', true, $deductionlist);
?>
