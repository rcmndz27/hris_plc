<?php

include('../config/db.php');

Class GlobalFunction{

    public function GetCompanyList()
    {
        global $connL;

        $query = "SELECT code,descs FROM dbo.mf_company";
        // $param = array(":currDate" => $value);
        $stmt =$connL->prepare($query);
        // $stmt->execute($param);
        $stmt->execute();
        $result = $stmt->fetch();

        $companyListArr = [];
    
            if($result){	
                do { 
                    $companyListArr[] = array( 'code' => $result['code'] ,'desc' => $result['descs'] );
                } while ($result = $stmt->fetch()); 	
            }

        echo json_encode($companyListArr);
    }

    public function GetLocationList()
    {
        global $connL;

        $query = "SELECT location,location FROM dbo.mf_location";
        // $param = array(":currDate" => $value);
        $stmt =$connL->prepare($query);
        // $stmt->execute($param);
        $stmt->execute();
        $result = $stmt->fetch();

        $locationListArr = [];
    
            if($result){	
                do { 
                    $locationListArr[] = array( 'code' => $result['location'] ,'desc' => $result['location'] );
                } while ($result = $stmt->fetch()); 	
            }

        echo json_encode($locationListArr);
    }

    public function GetDepartmentList()
    {
        global $connL;

        $query = "SELECT code,descs FROM dbo.mf_dept";
        // $param = array(":currDate" => $value);
        $stmt =$connL->prepare($query);
        // $stmt->execute($param);
        $stmt->execute();
        $result = $stmt->fetch();

        $companyListArr = [];
    
            if($result){	
                do { 
                    $companyListArr[] = array( 'code' => $result['code'] ,'desc' => $result['descs'] );
                } while ($result = $stmt->fetch()); 	
            }

        echo json_encode($companyListArr);
    }

    public function GetPositionList()
    {
        global $connL;

        $query = "SELECT position FROM dbo.mf_position ORDER BY position";
        // $param = array(":currDate" => $value);
        $stmt =$connL->prepare($query);
        // $stmt->execute($param);
        $stmt->execute();
        $result = $stmt->fetch();

        $positionListArr = [];
    
            if($result){	
                do { 
                    $positionListArr[] = array( "code" => preg_replace("/\s+/", "",$result["position"]) ,"desc" => $result["position"] );
                } while ($result = $stmt->fetch()); 	
            }

        echo json_encode($positionListArr);
    }

    public function GetEmployeeTypeList()
    {
        global $connL;

        $query = "SELECT emp_status_code,emp_status_name FROM mf_employee_type ORDER BY emp_status_name";
        // $param = array(":currDate" => $value);
        $stmt =$connL->prepare($query);
        // $stmt->execute($param);
        $stmt->execute();
        $result = $stmt->fetch();

        $employeeTypeListArr = [];
    
            if($result){	
                do { 
                    $employeeTypeListArr[] = array( 'code' => $result['emp_status_code'] ,'desc' => $result['emp_status_name'] );
                } while ($result = $stmt->fetch()); 	
            }

        echo json_encode($employeeTypeListArr);
    }

    public function GetEmployeeReportingToList()
    {
        global $connL;

        $query = "SELECT emp_code, name FROM EmployeeReportingTo ORDER BY name";
        // $param = array(":currDate" => $value);
        $stmt =$connL->prepare($query);
        // $stmt->execute($param);
        $stmt->execute();
        $result = $stmt->fetch();

        $employeeReportingToListArr = [];
    
            if($result){	
                do { 
                    $employeeReportingToListArr[] = array( 'code' => $result['emp_code'] ,'desc' => $result['name'] );
                } while ($result = $stmt->fetch()); 	
            }

        echo json_encode($employeeReportingToListArr);
    }

    public function GetEmployeeLevelList()
    {
        global $connL;

        $query = "SELECT level_code, level_description FROM employee_level ORDER BY level_description";
        // $param = array(":currDate" => $value);
        $stmt =$connL->prepare($query);
        // $stmt->execute($param);
        $stmt->execute();
        $result = $stmt->fetch();

        $employeeReportingToListArr = [];
    
            if($result){	
                do { 
                    $employeeReportingToListArr[] = array( 'code' => $result['level_code'] ,'desc' => $result['level_description'] );
                } while ($result = $stmt->fetch()); 	
            }

        echo json_encode($employeeReportingToListArr);
    }


}

?>