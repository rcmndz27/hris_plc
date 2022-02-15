<?php

$emp_name = $_POST['FullName'];
$emp_dept = $_POST['Department'];
$emp_email = $_POST['EmailAddress'];
$svc_req = implode(", ", $_POST['ServiceRequest']);
$svc_desc = $_POST['svc_desc'];
$other_services = trim($_POST['other_services']);

//$othersvcreq = trim($_POST['OtherSvcReq']);

if (isset($_POST['OtherSvcReq']) && !empty($_POST['OtherSvcReq'])) {
    $othersvcreq = implode(", ", $_POST['OtherSvcReq']);
}
else {
    $othersvcreq = 'NONE';
}

    if (strlen($other_services) == 0){
        include '../config/db.php';
        $db = getDB();

        $data = [
            'emp_name' => $emp_name,
            'emp_dept' => $emp_dept,
            'emailaddress' => $emp_email,
            'svc_req' => $svc_req,
            'svc_desc' => $svc_desc,
            'other_svc_req' => $othersvcreq,
            'other_services' => 'NONE',
            'status' => 'OPEN',
            'support_assigned' => 'NONE',
        ];
        $sql = "INSERT INTO dbo.ticket_requests (emp_name, emp_dept, emailaddress, svc_request, svc_desc, other_svc_request, other_services, status, support_assigned) VALUES (:emp_name, :emp_dept, :emailaddress, :svc_req, :svc_desc, :other_svc_req, :other_services, :status, :support_assigned)";
        $stmt= $db->prepare($sql);
        $stmt->execute($data);
        $job_order = $db->lastInsertId();

        echo "No Other Services. Job Order ID:<a href='../support/tech/ReqDetails.php?id=$job_order'> $job_order</a>";
    } elseif (strlen($other_services) > 0) {
        include '../config/db.php';
        $db = getDB();

        $data = [
            'emp_name' => $emp_name,
            'emp_dept' => $emp_dept,
            'emailaddress' => $emp_email,
            'svc_req' => $svc_req,
            'svc_desc' => $svc_desc,
            'other_svc_req' => $othersvcreq,
            'other_services' => $other_services,
            'status' => 'OPEN',
            'support_assigned' => 'NONE',
        ];
        $sql = "INSERT INTO dbo.ticket_requests (emp_name, emp_dept, emailaddress, svc_request, svc_desc, other_svc_request, other_services, status, support_assigned) VALUES (:emp_name, :emp_dept, :emailaddress, :svc_req, :svc_desc, :other_svc_req, :other_services, :status, :support_assigned)";
        $stmt= $db->prepare($sql);
        $stmt->execute($data);
        $job_order = $db->lastInsertId();

        echo "With Other Services, Job Order ID:<a href='../support/tech/ReqDetails.php?id=$job_order'> $job_order</a>";
    }
?>