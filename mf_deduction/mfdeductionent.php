<?php

Class MfdeductionEnt{

public function InsertMfdeductionEnt($deduction_code,$deduction_name)
    {
        global $connL;

            $query = "INSERT INTO mf_deductions (deduction_code,deduction_name) VALUES(:deduction_code,:deduction_name)";
    
                $stmt =$connL->prepare($query);

                $param = array(
                    ":deduction_code"=> $deduction_code,
                    ":deduction_name" => $deduction_name                                        
                );

            $result = $stmt->execute($param);

            echo $result;

    }


}

?>