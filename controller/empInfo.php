<?php
    
    include('../config/db.php');

    Class EmployeeInformation{

        public $employeeId;

        function SetEmployeeInformation($employeeId) {
            
            global $connL;

            $query = 'SELECT emp_code, employee, location, department, position, emp_type, reporting_to, emailaddress, datehired, usertype, ranking FROM dbo.view_employee WHERE emp_code = :empCode';
            $param = array(":empCode" => $employeeId);
            $stmt =$connL->prepare($query);
            $stmt->execute($param);
            $result = $stmt->fetch();

            $this->employeeCode = $result['emp_code'];
            $this->employeeName = $result['employee'];
            $this->employeeLocation = $result['location'];
            $this->employeeDepartment = $result['department'];
            $this->employeePosition = $result['position'];
            $this->employeeType = $result['emp_type'];
            $this->employeeReportingTo = $result['reporting_to'];
            $this->employeeEmailAddress = $result['emailaddress'];
            $this->employeeDateHired = $result['datehired'];
            $this->employeeUserType = $result['usertype'];
            $this->employeeRanking = $result['ranking'];

        }

        function GetEmployeeCode() {
            return $this->employeeCode;
        }

        function GetEmployeeName() {
            return $this->employeeName;
        }

        function GetEmployeePay() {
            return $this->employeeName;
        }

        function GetEmployeeLocation() {
            return $this->employeeLocation;
        }

        function GetEmployeeDepartment() {
            return $this->employeeDepartment;
        }

        function GetEmployeePosition() {
            return $this->employeePosition;
        }

        function GetEmployeeType() {
            return $this->employeeType;
        }

        function GetEmployeeReportingTo() {
            return $this->employeeReportingTo;
        }

        function GetEmployeeEmailAddress() {
            return $this->employeeEmailAddress;
        }

        function GetEmployeeDateHired() {
            return $this->employeeDateHired;
        }

        function GetEmployeeUserType() {
            return $this->employeeUserType;
        }

        function GetEmployeeRanking() {
            return $this->employeeRanking;
        }
    }

 
?>