<?php

Class MfdepartmentEnt{

public function InseryMfdepartmentEnt($code,$descs)
    {
        global $connL;

            $query = "INSERT INTO mf_dept (code,descs) VALUES(:code,:descs)";
    
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