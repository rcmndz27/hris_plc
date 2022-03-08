<?php

Class MfcompanyEnt{

public function InsertMfcompanyEnt($code,$descs,$status)
    {
        global $connL;

            $query = "INSERT INTO mf_company (code,descs,status) VALUES(:code,:descs,:status)";
    
                $stmt =$connL->prepare($query);

                $param = array(
                    ":code"=> $code,
                    ":descs" => $descs,                                        
                    ":status" => $status  
                );

            $result = $stmt->execute($param);

            echo $result;

    }


}

?>