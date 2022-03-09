<?php

Class MfpositionEnt{

public function InseryMfpositionEnt($position,$status)
    {
        global $connL;

            $query = "INSERT INTO mf_position (position,status) VALUES(:position,:status)";
    
                $stmt =$connL->prepare($query);

                $param = array(
                    ":position"=> $position,                                      
                    ":status"=> $status
                );

            $result = $stmt->execute($param);

            echo $result;

    }


}

?>