<?php include_once('core/DeductionType.php'); ?>
<?php
    $deductionlist = $deductiontype->fetch_all();
    retResponse('200','All Deduction Type', true, $deductionlist);
?>
