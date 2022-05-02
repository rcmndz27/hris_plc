<?php

Class DeductionEnt{

public function InsertDeductionEnt($eMplogName,$emp_code,$deduction_id,$period_cutoff,$effectivity_date,$amount)
    {
        global $connL;

            $query = "INSERT INTO employee_deduction_management (emp_code,deduction_id,period_cutoff,effectivity_date,amount,audituser,auditdate) 

                VALUES(:emp_code,:deduction_id,:period_cutoff,:effectivity_date,:amount,:audituser,:auditdate)";
    
                $stmt =$connL->prepare($query);

                $param = array(
                    ":emp_code"=> $emp_code,
                    ":deduction_id" => $deduction_id,
                    ":period_cutoff" => $period_cutoff,
                    ":effectivity_date"=> $effectivity_date,
                    ":amount"=> $amount,
                    ":audituser" => $eMplogName,
                    ":auditdate"=>date('m-d-Y')                                          
                );

            $result = $stmt->execute($param);

            echo $result;

    }


}

?>