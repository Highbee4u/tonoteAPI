<?php include_once('core/Employee.php'); ?>
<?php
    $employeelist = $employee->fetch_all();
    retResponse('200','All Employees', true, $employeelist);
?>
