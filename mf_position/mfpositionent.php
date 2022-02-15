<?php

Class MfpositionEnt{

public function InseryMfpositionEnt($position)
    {
        global $connL;

            $query = "INSERT INTO mf_position (position) VALUES(:position)";
    
                $stmt =$connL->prepare($query);

                $param = array(
                    ":position"=> $position                                      
                );

            $result = $stmt->execute($param);

            echo $result;

    }


}

?>