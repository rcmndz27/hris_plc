<?php
session_start();
include('../../config/dependencies.php');

if ($empDept === 'IT Department') {
include '../../config/db.php';
$status = $_GET['status'];
$db = getDB();

    if (!isset($status))
        $stmt = $db->prepare("SELECT * FROM dbo.ticket_requests");
    else
    {
        $stmt = $db->prepare("SELECT * FROM dbo.ticket_requests where status = :status");
        $stmt->bindParam(":status", $status, PDO::PARAM_STR);
    }

    $stmt->execute();
    $data=$stmt->fetchAll();
    $db = null;
?>
    <!DOCTYPE html>
    <html>
        <noscript><h3>Please enable Javascript in order to use this form.</h3><meta HTTP-EQUIV='refresh' content=0; url='JavascriptNotEnabled.php'></noscript>
        <meta charset='utf-8'>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <meta name="robots" content="noindex">
        <meta http-equiv='cache-control' content='no-cache'>
        <meta http-equiv='expires' content='0'>
        <meta http-equiv='pragma' content='no-cache'>
        <link rel='stylesheet' href="../<?= constant('CSS_DIR'); ?>style.css">
        <link rel='stylesheet' href="../<?= constant('FONTAWESOME_CSS'); ?>">
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js' type='text/javascript'></script>
        <script src="../<?= constant('BOOTSTRAP_JS'); ?>"></script>
        <title>TECH SUPPORT</title>
        <style>
            table td {
                padding: 0.4rem !important;
            }
        </style>
    </html>
    <body>
        <table class='table table-striped w-100' style="text-align:center;">
            <tbody>
                <tr style='color:white;'>
                    <th>Job Order ID</th>
                    <th>Employee Name</th>
                    <th>Employee Department</th>
                    <th>Service Requested</th>
                    <th>Other Services</th>
                    <th>Status:
                    <form method="get">
                        <select name='status' id='status' onchange='this.form.submit();'>
                            <option value='OPEN' <?php echo ($status == "OPEN") ? " selected" : ""; ?>>OPEN</option>
                            <option value='IN PROGRESS' <?php echo ($status == "IN PROGRESS") ? " selected" : ""; ?>>IN PROGRESS</option>
                            <option value='RESOLVED' <?php echo ($status == "RESOLVED") ? " selected" : ""; ?>>RESOLVED</option>
                        </select>
                    </form></th>
                    <th>Support Assigned</th>
                </tr>

                <?php
                    foreach ($data as $ReqInfo)
                    {
                        $JobOrder = htmlspecialchars(trim($ReqInfo['job_orderid']));
                        $empName = htmlspecialchars(trim($ReqInfo['emp_name']));
                        $empDept = htmlspecialchars(trim($ReqInfo['emp_dept']));
                        $empEmail = htmlspecialchars(trim($ReqInfo['emailaddress']));
                        $svcreq = htmlspecialchars(trim($ReqInfo['svc_request']));
                        $svc_desc = htmlspecialchars(trim($ReqInfo['svc_desc']));
                        $other_svc_req = htmlspecialchars(trim($ReqInfo['other_svc_request']));
                        $other_services = htmlspecialchars(trim($ReqInfo['other_services']));
                        $support_status = htmlspecialchars(trim($ReqInfo['status']));
                        $support_assigned = htmlspecialchars(trim($ReqInfo['support_assigned']));
                ?>
                <tr>
                    <td><a href="../tech/ReqDetails.php?id=<?= $JobOrder; ?>"><?= $JobOrder; ?></a></td>
                    <td><?= $empName; ?></td>
                    <td><?= $empDept; ?></td>
                    <td><?= $svcreq; ?></td>
                    <td><?= $other_svc_req; ?></td>
                    <td style="color:<?php
                            if ($support_status == "OPEN")
                                echo "red";
                            elseif ($support_status == "RESOLVED")
                                echo "green";
                            else
                                echo "blue";
                    ?>;"><?= $support_status; ?></td>
                    <td>
                        <select class='dd_itp form-control' id='itp_<?= $JobOrder ?>' style='font-size:0.75rem;'>
                            <option value='NONE'<?php echo ($support_assigned == "NONE") ? " selected" : ""; ?>>NONE</option>
                            <option value='Jamalia Usman'<?php echo ($support_assigned == "Jamalia Usman") ? " selected" : ""; ?>>Jamalia Usman</option>
                            <option value='Jarvis Santiago'<?php echo ($support_assigned == "Jarvis Santiago") ? " selected" : ""; ?>>Jarvis Santiago</option>
                            <option value='Mark Daniel Gudez'<?php echo ($support_assigned == "Mark Daniel Gudez") ? " selected" : ""; ?>>Mark Daniel Gudez</option>
                            <option value='Newton Sanchez'<?php echo ($support_assigned == "Newton Sanchez") ? " selected" : ""; ?>>Newton Sanchez</option>
                            <option value='Patrick Ewing Torteo'<?php echo ($support_assigned == "Patrick Ewing Torteo") ? " selected" : ""; ?>>Patrick Ewing Torteo</option>
                        </select>
                    </td>
                    <input type='hidden' id='itpval_<?= $JobOrder ?>' value='<?= $support_assigned; ?>'>
                </tr>

                <?php } ?>

            </tbody>
        </table>

        <script>
            $('.dd_itp').change(function(){
                var j_id = ($(this).attr('id')).split('_');
                var prevval = ($('#itpval_'.concat(j_id[1]))).val();
                var curval = ($(this).find('option:selected')).val();
                var url = "../../controller/tech/index_process.php";

                $('#footer').html('');

                if (confirm('Confirm assignment of support staff to current ticket!'))
                {
                    ($('#itp_'.concat(j_id[1])).find('option[value="'.concat(curval, '"]'))).prop("selected", true);
                    ($('#itp_'.concat(j_id[1])).find('option[value="'.concat(prevval, '"]'))).prop("selected", false);
                    $('#itpval_'.concat(j_id[1])).val(curval);

                    $.post (
                        url,
                        {
                            jobid: j_id[1],
                            support: $('#itpval_'.concat(j_id[1])).val()
                        },
                        function(data) {
                            $('#footer').html(data).show();
                        }
                    );
                }
                else
                {
                    ($('#itp_'.concat(j_id[1])).find('option[value="'.concat(curval, '"]'))).prop("selected", false);
                    ($('#itp_'.concat(j_id[1])).find('option[value="'.concat(prevval, '"]'))).prop("selected", true);
                }
            });
        </script>
    </body>
    <footer id='footer'></footer>
    </html>

<?php
}
else
{
    echo '<script type="text/javascript">alert("YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE");</script>';
    header( "refresh:0.1;url=../index.php" );
}
?>