<?php

Class ChangePassword{

    function UpdatePassword($empCode,$userpassword){

        global $connL;
    
        $query = "UPDATE mf_user SET userpassword = :userPassword, userchange = 'Y' WHERE userid = :empCode";
        $param = array(":userPassword" => hash('sha256', $userpassword), ":empCode" => $empCode );
        $stmt =$connL->prepare($query);
        $result = $stmt->execute($param);
    
        echo $result;
    
    }

}

?>