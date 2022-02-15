<?php
   session_start();

   include("applicantapproval.php");
   include('../config/db.php');

   
   $applicantApproval = json_decode($_POST["data"]);

   if($applicantApproval->{"Action"} == "ViewApplicantList")
   {
        $keyword = $applicantApproval->{"keyword"};

        ViewApplicantList($keyword);
    }else if ($applicantApproval->{"Action"} == "ViewApplicantInfo"){

        $applicantid = $applicantApproval->{"applicantid"};

        ViewApplicantInfo($applicantid);

    }
    else if ($applicantApproval->{"Action"} == "HireApplicant"){
        $applicantid = $applicantApproval->{"applicantid"};
        $companyid = $applicantApproval->{"companyid"};
        $employeecode = $applicantApproval->{"employeecode"};
        $datehired = $applicantApproval->{"datehired"};
        $userid = $_SESSION['userid'];
        $employeetypelist = $applicantApproval->{"employeetypelist"};
        $locationlist = $applicantApproval->{"locationlist"};
        $departmentlist = $applicantApproval->{"departmentlist"};
        HireApplicant($userid, $applicantid, $companyid, $employeecode, $datehired, $employeetypelist, $locationlist, $departmentlist);

    }
    else if ($applicantApproval->{"Action"} == "RejectApplicant"){
        $applicantid = $applicantApproval->{"applicantid"};
        $reason = $applicantApproval->{"reason"};
        RejectApplicant($applicantid, $reason);

    }
    else if ($applicantApproval->{"Action"} == "GetCompanyList"){
        GetCompanyList();
    }
    else if ($applicantApproval->{"Action"} == "GetEmployeeTypeList"){
        GetEmployeeTypeList();
    }
    else if ($applicantApproval->{"Action"} == "GetLocationList"){
        GetLocationList();
    }
    else if ($applicantApproval->{"Action"} == "GetDepartmentList"){
        GetDepartmentList();
    }


    
    

    




?>