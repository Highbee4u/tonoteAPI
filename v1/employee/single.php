<?php include_once('core/Employee.php'); ?>
<?php include_once('core/DeductionType.php'); ?>
<?php include_once('core/AllowanceType.php'); ?>

<?php
    $requireddata = [
      'employeeid'
    ];
    
    if(!empty($data)){

      $validata = validaterequiredfields($data, $requireddata);

        if(!empty($validata)){

          retResponse('400','Error', false, $validata);

        }else{

          if($employee->employee_exists($data['employeeid'])){

            $response = $employee->fetch_employeedetail($data['employeeid']);

            if($response){
              $allowancedata = array();
              $deductiondata = array();

              $employeebasicdata = $response['EmployeeInfo'][0];
              $salarygroupdata = $response['SalaryDetail'][0];

              if(count($response['DeductionDetail']) > 0){

                foreach($response['DeductionDetail'] as $val){

                  $deductiondata[] = array('name'=>$deductiontype->get_deduction_type_name_by_id($val['deductiontypeid']),  'amount'=>$val['amount']);

                }

              }

              if(count($response['AllowanceDetail']) > 0){

                foreach($response['AllowanceDetail'] as $val){

                  $allowancedata[] = array('name'=>$allowancetype->get_allowance_type_name_by_id($val['allowancetypeid']),  'amount'=>$val['amount']);

                }

              }

              

              $formated_data = [
                'Basic Info' => [
                  "employeeid"=> $employeebasicdata['employeeid'],
                  "first_name"=> $employeebasicdata['first_name'],
                  "last_name"=> $employeebasicdata['last_name'],
                  "gender"=> $employeebasicdata['gender'],
                  "age"=> $employeebasicdata['age'],
                  "contact_address"=> $employeebasicdata['contact_address'],
                  "email"=> $employeebasicdata['email'],
                  "phone"=> $employeebasicdata['phone']
                ],
                'Salary_Detail'=>[
                  'monthly_gross' => $salarygroupdata['monthly_gross'],
                  'annual_gross' => $salarygroupdata['annual_gross'],
                  'deductions' => $deductiondata,
                  'allowances' => $allowancedata
                ]
              ];

              retResponse('200','Employee Detail', true, $formated_data);

            }else{

              retResponse('400','Unable to retrive data, try later', true, []);

            }
            
          }else{

            retResponse('404','Deduction Type ID Supplied Doesn\'t exist', false, []);

          }

        }

    }else{

      retResponse('400','parameter not set', false);
      
    }