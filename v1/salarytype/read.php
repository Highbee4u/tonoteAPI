<?php include_once('core/SalaryType.php'); ?>
<?php
    $salarydetaillist = $salary->fetch_all();
    retResponse('200','All Salary Detail', true, $salarydetaillist);
?>
