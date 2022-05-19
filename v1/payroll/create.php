<?php include_once('core/Deduction.php'); ?>
<?php include_once('core/Allowance.php'); ?>
<?php include_once('core/Payroll.php'); ?>
<?php include_once('core/Employee.php'); ?>
<?php include_once('core/SalaryType.php'); ?>

<?php
    $requireddata = [
      'employeeid', 
      'effective_date',

      
   ];

     if(!empty($data)){

        $totaldeduction = 0;
        $totalallowance = 0;
        $netpay = 0;

        $validata = validaterequiredfields($data, $requireddata);
        if(!empty($validata)){
           retResponse('400','Error', false, $validata);
        }

        if($employee->employee_exists($data['employeeid'])){

          $basic_info = $employee->fetch_by_criterial('employeedetail', array('employeeid'=> $data['employeeid']));
          $totalallowance = $allowance->get_employee_total_allowance($data['employeeid'], $data['effective_date']);
          $totaldeduction = $deduction->get_employee_total_deduction($data['employeeid'], $data['effective_date']);
          $salarygroupdata = $salary->fetch_by_criterial(array('group_id'=>$basic_info[0]['salary_groupid']));
          

          $validdate = validate_date($data['effective_date']);

          if(!$validdate){
            retResponse('400','Error: Effective date must be in \'Y-m-d\' format', false, []);
          }

          $payrollid = "PID/".rand(0123, 9999);

          $payrolldata = [
           'payrollid' => $payrollid,
           'totaldeduction'=> $totaldeduction,
           'employeeid'=> $data['employeeid'],
           'totalallowance'=> $totalallowance,
           'effective_date'=> $data['effective_date'],
           'netpay'=> (($salarygroupdata[0]['monthly_gross'] + $totalallowance) - $totaldeduction)
          ];

          
              
          $result = $payroll->create_employee_payroll($payrolldata);

          // retResponse('400','Debug', false, $result);
          if($result){
                retResponse('200','Payroll Created Successfully', true);
          }else{
                retResponse('400','Unable to add Payroll Created, try later', false);
          }
        
        }else{
          retResponse('400','Error: Employee ID Supplied Doesn\'t exists', false);
        }
        
      }else{
        retResponse('400','parameter not set', false);
      }
?>
