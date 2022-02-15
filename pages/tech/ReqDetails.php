<?php
include '../../config/db.php';

$db = getDB();
    $stmt = $db->prepare("SELECT * FROM dbo.ticket_requests WHERE job_orderid=:job_orderid");
    $stmt->bindParam("job_orderid", $_GET['id'],PDO::PARAM_STR) ;
    $stmt->execute();
    $data=$stmt->fetchAll();
    $db = null;

    foreach ($data as $ReqDetails) {
        $reqID = trim($ReqDetails['job_orderid']);
        $empName = trim($ReqDetails['emp_name']);
        $empDept = htmlspecialchars(trim($ReqDetails['emp_dept']));
        $empEmail = htmlspecialchars(trim($ReqDetails['emailaddress']));
        $svcReq = htmlspecialchars(trim($ReqDetails['svc_request']));
        $svcDesc = htmlspecialchars(trim($ReqDetails['svc_desc']));
        $othersvcReq = htmlspecialchars(trim($ReqDetails['other_svc_request']));
        $otherservices = htmlspecialchars(trim($ReqDetails['other_services']));
        $status = htmlspecialchars(trim($ReqDetails['status']));
        $support_assigned = htmlspecialchars(trim($ReqDetails['support_assigned']));
    }
?>
<html>
<head>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js' type='text/javascript'></script>
</head>
<body>
    <h1>Service Request Details</h1>
    <h2>Employee Information</h2>
    <p><strong>Employee Name:</strong> <?= $empName; ?> &nbsp; <strong>Employee Department:</strong> <?= $empDept; ?></p>
    <p><strong>Employee Email: <?= $empEmail; ?></strong></p>
    <p><strong>Employee Concern: <?= $svcReq; ?></strong></p>
    <p><strong>Description of Concern: <?= $svcDesc; ?></strong></p>
    <p><strong>Other Concerns: <?= $othersvcReq.',&nbsp;'.$otherservices; ?></strong></p>

    <select class='dd_itp form-control' id='status' style='font-size:0.75rem;'>
        <option value='OPEN'<?php echo ($status == "OPEN") ? " selected" : ""; ?>>OPEN</option>
        <option value='IN PROGRESS'<?php echo ($status == "IN PROGRESS") ? " selected" : ""; ?>>IN PROGRESS</option>
        <option value='RESOLVED'<?php echo ($status == "RESOLVED") ? " selected" : ""; ?>>RESOLVED</option>
    </select>

    <p><strong>Support Assigned: <?= $support_assigned; ?></strong></p>

<script>
    $('#status').change(function(){
        var prevval = "<?php echo $status; ?>";
        var curval = ($(this).find('option:selected')).val();
        var url = "../../controller/tech/ReqDetails_process.php";

        if (confirm('Confirm assignment of support staff to current ticket!'))
        {
            $.post (
                url,
                {
                    jobid: <?php echo $reqID; ?>,
                    stats: $('#status').val()
                },
                function(data) {
                    location.reload();
                }
            );
        }
        else
        {
            $('#status').find('option[value="'.concat(curval, '"]')).prop("selected", false);
            $('#status').find('option[value="'.concat(prevval, '"]')).prop("selected", true);
        }
    });
</script>

</body>

</html>