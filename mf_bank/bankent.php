<?php

Class BankEnt{

public function InseryBankEnt($descsb,$descsb_name)
    {
        global $connL;

            $query = "INSERT INTO mf_banktypes (descsb,descsb_name) VALUES(:descsb,:descsb_name)";
    
                $stmt =$connL->prepare($query);

                $param = array(
                    ":descsb"=> $descsb,
                    ":descsb_name" => $descsb_name                                        
                );

            $result = $stmt->execute($param);

            echo $result;

    }


}

?>