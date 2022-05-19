<?php include_once('core/Leave.php'); ?>
<?php
    $leaveslist = $leave->fetch_all();
    retResponse('200','All Leave', true, $leaveslist);
?>
