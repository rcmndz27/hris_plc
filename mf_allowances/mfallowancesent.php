<?php

Class MfallowancesEnt{

public function InseryMfallowancesEnt($benefit_code,$benefit_name)
    {
        global $connL;

            $query = "INSERT INTO mf_benefits (benefit_code,benefit_name) VALUES(:benefit_code,:benefit_name)";
    
                $stmt =$connL->prepare($query);

                $param = array(
                    ":benefit_code"=> $benefit_code,
                    ":benefit_name" => $benefit_name                                        
                );

            $result = $stmt->execute($param);

            echo $result;

    }


}

?>