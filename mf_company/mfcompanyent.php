<?php

Class MfcompanyEnt{

public function InseryMfcompanyEnt($code,$descs)
    {
        global $connL;

            $query = "INSERT INTO mf_company (code,descs) VALUES(:code,:descs)";
    
                $stmt =$connL->prepare($query);

                $param = array(
                    ":code"=> $code,
                    ":descs" => $descs                                        
                );

            $result = $stmt->execute($param);

            echo $result;

    }


}

?>