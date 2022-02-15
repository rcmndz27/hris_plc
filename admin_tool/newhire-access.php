<?php
include('../config/db.php');

Class NewHireAccess{

    public function AddNewHireAccess($empCode,$employeecode,$firstname,$middlename,$lastname,$company,$location,$department,$position,$employeetype,$reportingto, $datehired, $level){
        // echo $empCode.', '.$employeecode.', '.$firstname.', '.$middlename.', '.$lastname.', '.$company.', '.$location.', '.$department.', '.$position.', '.$employeetype.', '.$reportingto.', '.$datehired.', '.$level;
        
        global $connL;

        $query = "NewHirePeocess :company, :emp_code, :firstname, :middlename, :lastname, :department, :emp_type, :reporting_to, :datehired, :location, :position, :level, :pin, :audituser";
    
                $stmt =$connL->prepare($query);
    
                $param = array(
                    ":company"=> $company,
                    ":emp_code" => $employeecode,
                    ":firstname" => $firstname,
                    ":middlename"=> $middlename,
                    ":lastname"=> $lastname,
                    ":department"=> $department,
                    ":emp_type"=> $employeetype,
                    ":reporting_to"=> $reportingto,
                    ":datehired"=> $datehired,
                    ":location"=> $location,
                    ":position"=> $position,
                    ":level"=> $level,
                    ":pin"=> preg_replace('/[^0-9]/', '', $employeecode),
                    ":audituser" => $empCode
                );

            $result = $stmt->execute($param);

            echo $result;
    }

}

?>