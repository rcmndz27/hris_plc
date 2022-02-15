<?php

function ViewApplicantList($keyword)
{

    global $connL;

    $cmd = $connL->prepare(@"SELECT applicantcode, applicantname, applicantposition, status, rowid FROM dbo.applicantprofile_list  WHERE applicantname+','+applicantposition  LIKE :keyword ");
    $cmd->bindValue(':keyword', '%' . $keyword . '%');
    $cmd->execute();

    echo "
    <br>
    <table id='applicantList' class='table table-striped table-sm'>
        <thead>
            <tr>
                <th>Applicant ID</th>
                <th>Applicant Name</th>
                <th>Applicant Position</th>
                <th>Status</th>
                <th class='text-center'>Action</th>
            </tr>
        </thead>
        <tbody>";

    while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
    {
        echo"<tr>".
                "<td>".$r['applicantcode']."</td>".
                "<td>".$r['applicantname']."</td>".
                "<td>".$r['applicantposition']."</td><td>";

                switch(trim($r['status'])){
                    case "Hired":
                        echo"<p class='text-success'>".$r['status']."</p>";
                    break;
                    case  "Rejected":
                        echo"<p class='text-danger'>".$r['status']."</p>";
                    break;
                    case  "Active":
                        echo"<p class='text-warning'>".$r['status']."</p>";
                    break;
                }

                echo "</td><td>". 
                    "<button class='btnView' id='".$r['rowid']."-view'> <i class='fas fa-search'></i></button> &nbsp;".
                    "<button class='btnApprove' id='".$r['rowid']. "-approve'> <i class='fas fa-check'></i></button> &nbsp;".
                    "<button class='btnReject' id='".$r['rowid']. "-reject'> <i class='fas fa-times'></i></button>".
                "</td>".
            "</tr>";
    }
    echo "
    </tbody>
    </table>";

}//ViewApplicantList

function ViewApplicantInfo($applicantid)
{
    global $connL;

    $cmd = $connL->prepare(@"SELECT * FROM dbo.applicantprofile  WHERE   applicantcode = :id ");
    $cmd->bindValue(':id',$applicantid);
    $cmd->execute();

    while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
    {
        echo "
        <div class='container-fluid' id='applicantinfo'>
            <div class='row'>
                <div class='col-md-4'><b>Applicant ID</b></div>
                <div class='col-md-8'>".$r['applicantcode']."</div>
            </div>
            <div class='row'>
                <div class='col-md-4'><b>Position</b></div>
                <div class='col-md-8'>".$r['applicantposition']."</div>
            </div>
            <div class='row'>
                <div class='col-md-4'><b>Date Applied</b></div>
                <div class='col-md-8'>".date('m/d/y', strtotime($r['dateapplied']))."</div>
            </div>
            <div class='row'>
                <div class='col-md-4'><b>Name</b></div>
                <div class='col-md-8'>".$r['firstname']." ".$r['middlename']." ".$r['lastname']."</div>
            </div>
            <div class='row'>
                <div class='col-md-4'><b>Gender</b></div>
                <div class='col-md-8'>".rtrim($r['gender'])."</div>
            </div>
            <div class='row'>
                <div class='col-md-4'><b>Civil Status</b></div>
                <div class='col-md-8'>".rtrim($r['civilstatus'])."</div>
            </div>
            <div class='row'>
                <div class='col-md-4'><b>Birthday</b></div>
                <div class='col-md-8'>".date('m/d/y', strtotime($r['birthday']))."</div>
            </div>
            <div class='row'>
                <div class='col-md-4'><b>Present Address</b></div>
                <div class='col-md-8'>".$r['presentaddress']."</div>
            </div>
            <div class='row'>
                <div class='col-md-4'><b>Permanent Address</b></div>
                <div class='col-md-8'>".$r['permanentaddress']."</div>
            </div>
            <div class='row'>
                <div class='col-md-4'><b>TIN</b></div>
                <div class='col-md-8'>".$r['tin_no']."</div>
            </div>
            <div class='row'>
                <div class='col-md-4'><b>SSS</b></div>
                <div class='col-md-8'>".$r['sss_no']."</div>
            </div>
            <div class='row'>
                <div class='col-md-4'><b>Philhealth</b></div>
                <div class='col-md-8'>".$r['phil_no']."</div>
            </div>
            <div class='row'>
                <div class='col-md-4'><b>PagIbig</b></div>
                <div class='col-md-8'>".$r['pagibig_no']."</div>
            </div>
            <div class='row'>
                <div class='col-md-4'><b>PRC License</b></div>
                <div class='col-md-8'>".$r['prclicense']."</div>
            </div>
            <div class='row'>
                <div class='col-md-4'><b>Expiry Date</b></div>
                <div class='col-md-8'>".date('m/d/y', strtotime($r['prcexpirydate']))."</div>
            </div>

            <div class='row'>
                <div class='col-md-4'><b>Drivers License</b></div>
                <div class='col-md-8'>".$r['driverslicense']."</div>
            </div>
            <div class='row'>
                <div class='col-md-4'><b>Expiry Date</b></div>
                <div class='col-md-8'>".date('m/d/y', strtotime($r['driversexpirydate']))."</div>
            </div>

        </div>";
    }
}//ViewApplicantInfo



function HireApplicant($userid, $applicantid, $companyid, $employeecode, $datehired, $employeetypelist, $locationlist, $departmentlist)
{

    // echo $userid.", ".$applicantid.", ".$companyid.", ".$employeecode.", ".$datehired.", ".$employeetypelist.", ".$locationlist.", ".$departmentlist;


    global $connL;

    $cmd = $connL->prepare(@"EXEC sp_newhireportal :applicantid, :companyid, :employeecode, :datehired, :userid, :active, :emptype, :location, :dept ");
    $cmd->bindValue(':applicantid',$applicantid);
    $cmd->bindValue(':companyid',$companyid);
    $cmd->bindValue(':employeecode',$employeecode);
    $cmd->bindValue(':datehired',$datehired);
    $cmd->bindValue(':userid',$userid);

    $cmd->bindValue(':active','Active');
    $cmd->bindValue(':emptype',$employeetypelist);
    $cmd->bindValue(':location',$locationlist);
    $cmd->bindValue(':dept',$departmentlist);
    $r = $cmd->execute();

    echo $r;

}

function RejectApplicant($applicantid, $reason)
{
    global $connL;

    $cmd = $connL->prepare(@"UPDATE dbo.applicantprofile SET status = 'Rejected', remarks = :reason WHERE applicantcode = :applicantid ");
    $cmd->bindValue(':applicantid',$applicantid);
    $cmd->bindValue(':reason',$reason);
    $r = $cmd->execute();

    echo $r;

}

function GetCompanyList()
{
    global $connL;

    $cmd = $connL->prepare(@"SELECT code,descs FROM dbo.mf_company");
    $cmd->execute();

    $companyListArr = [];

    while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
    {
        $companyListArr[] = array( 'code' => $r['code'] ,'desc' => $r['descs'] );
    }

    echo json_encode($companyListArr);

}

function  GetEmployeeTypeList() 
{
    global $connL;

    $cmd = $connL->prepare(@"SELECT DISTINCT(emp_type) emp_type FROM dbo.employee_profile WHERE emp_type IS NOT NULL ORDER BY emp_type");
    $cmd->execute();

    $employeeTypeListArr = [];

    while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
    {
        $employeeTypeListArr[] = array( 'code' => $r['emp_type'] ,'desc' => $r['emp_type'] );
    }

    echo json_encode($employeeTypeListArr);
}

function  GetLocationList() 
{
    global $connL;

    $cmd = $connL->prepare(@"SELECT location FROM dbo.mf_location ORDER BY location");
    $cmd->execute();

    $locationListArr = [];

    while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
    {
        $locationListArr[] = array( 'code' => $r['location'] ,'desc' => $r['location'] );
    }

    echo json_encode($locationListArr);
}

function  GetDepartmentList() 
{
    global $connL;

    $cmd = $connL->prepare(@"SELECT descs FROM dbo.mf_dept ORDER BY descs");
    $cmd->execute();

    $departmentListArr = [];

    while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
    {
        $departmentListArr[] = array( 'code' => $r['descs'] ,'desc' => $r['descs'] );
    }

    echo json_encode($departmentListArr);
}




?>