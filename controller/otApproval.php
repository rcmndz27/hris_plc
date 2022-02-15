<?php

    function ShowALLOT($rpt, $dtFrom, $dtTo, $emp)
    {
        global $connL;

        $sql = $connL->prepare(@"SELECT SUM(ot_approved) FROM dbo.att_ot_approve where emp_code = :emp AND date >= :dtFrom AND date <= :dtTo");
        $sql->bindParam(":emp", $emp, PDO::PARAM_STR);
        $sql->bindParam(":dtFrom", $dtFrom, PDO::PARAM_STR);
        $sql->bindParam(":dtTo", $dtTo, PDO::PARAM_STR);
        $sql->execute();

        //return (float)$sql->fetchColumn();
        echo "<span class='script'><script>$('#tApproved').html(parseFloat(" . (float)$sql->fetchColumn() . ").toFixed(2)).show();</script></span>";
        
        $totalPreShiftPlanned = 0;
        $totalPostShiftOTPlanned = 0;
        $totalOTRendered = 0;

        $ct = $connL->prepare(@"exec dbo.sp_attendance_OT :reporting_to, :dtF, :dtT, :emp");
        $ct->bindValue(':reporting_to', $rpt);
        $ct->bindValue(':dtF', $dtFrom);
        $ct->bindValue(':dtT', $dtTo);
        $ct->bindValue(':emp', $emp);
        $vct = $ct->execute();
        //$vct = $ct->rowCount();
        
        echo "
            <div class='float-md-left pb-3'><label>Total OT Approved: <strong><span id='tApproved'>0.00</span></strong> </label></div>
            <div class='float-md-right pb-3'>
                <button type='button' id='autoapprove' class='btn btn-sm btn-primary' onclick='javascript:AutoApprove();'>APPROVE SELECTED</button>
                <button type='button' id='autoreject' class='btn btn-sm btn-primary' data-toggle='modal' data-target='#rejectForm2'>REJECT SELECTED</button>
            </div>

            <div id='table-container'>
            <table id='list' class='table table-dark table-striped table-sm'>
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Day</th>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Hours Worked</th>
                        <th colspan='2'>
                            <div class='d-flex justify-content-center py-1' style='border-bottom: 1px solid white;'>Planned Overtime</div>
                            <div class='row py-1'>
                                <div class='col-lg-6'>Pre Shift</div>
                                <div class='col-lg-6'>Post Shift</div>
                            </div>
                        </th>
                        <th>Rendered Overtime</th>
                        <th>Overtime Approval</th>
                        <th class='pr-3'><input type='checkbox' id='checkall'> Check All</th>
                        <th>Action</th>
                    </tr>
                </thead>
                    <tbody>";

        if($vct)
        {
            while ($r = $ct->fetch(PDO::FETCH_ASSOC))
            {
                $date = date("Yxmxd", strtotime($r["emp_att_date"]));
                $timefiled = date("YxmxdxHxixs", strtotime($r["datefiled"]));
                $prefix = $r["emp_code"] . "-" . $date;

                echo "<tr>
                        <td class='first'><label id='". $prefix . "-name' class='m-0'>" . $r["emp_name"] . "</labe></td>
                        <td><label id='". $prefix . "-day' class='m-0'>" . $r["emp_att_day"] . "</labe></td>
                        <td><label id='". $prefix . "-date' class='m-0'>" . $r["emp_att_date"] . "</labe></td>
                        <td><label id='". $prefix . "-in' class='m-0'>" . $r["t_in"] . "</labe></td>
                        <td><label id='". $prefix . "-out' class='m-0'>" . $r["t_out"] . "</labe></td>
                        <td><label id='". $prefix . "-worked' class='m-0'>" . round($r["hrs_w"], 2) . "</labe></td>
                        <td><label id='". $prefix . "-planot' class='m-0 tplanned'>" . round($r["ot_time"], 2) . "</labe></td>
                        <td><label id='". $prefix . "-planot2' class='m-0 tplanned2'>" . round($r["ot_time2"], 2) . "</labe></td>
                        <td><label id='". $prefix . "-ot' class='m-0 trendered'>" . round($r["hrs_ot"], 2) . "</labe></td>
                        <td><input type='number' id='". $prefix . "-otapp' step='0.01' value='" . round($r["hrs_ot"], 2) . "' class='w-75 text-center editable' min='0' max='" . $r["hrs_ot"] . "'></td>
                        <td class='pr-3'><input type='checkbox' id='". $prefix . "-check' class='cb'></td>
                        <td>";

                $upload = $connL->prepare(@"SELECT upload, rowid FROM dbo.att_ot_filed where ot_date = :date AND emp_code = :emp");
                $upload->bindParam(":date", $r["emp_att_date"], PDO::PARAM_STR);
                $upload->bindParam(":emp", $r["emp_code"], PDO::PARAM_STR);
                $upload->execute();

                while ($rr = $upload->fetch(PDO::FETCH_ASSOC))
                {
                    if ($rr['upload'] == null || $rr['upload'] == '')
                    {
                        echo "NO ATTACHMENT";
                    }
                    else
                    {
                        echo "<button id='" . $rr["rowid"] . "' class='btn btn-sm btn-primary atview'><i class='fas fa-search'></i></button>";
                    }
                }

                if (round($r["hrs_ot"], 2) > 0.5)
                {
                    echo "
                        <button class='btn btn-sm btn-primary btnApprove' id='" . $prefix . "-approve-". $rpt ."'><i class='fas fa-check'></i></button>&nbsp;
                        <button class='btn btn-sm btn-primary btnReject' data-toggle='modal' data-target='#rejectForm' id='" . $prefix . "-reject-". $rpt ."'><i class='fas fa-times'></i></button>
                    ";
                }
                echo '</td></tr>';

                $totalPreShiftPlanned += round($r["ot_time"], 2);
                $totalPostShiftOTPlanned += round($r["ot_time2"], 2);
                $totalOTRendered += round($r["hrs_ot"], 2);
            }
        }
        else
        {
            echo "<tr><td colspan='12'>No overtime results to show.</td></tr>";
        }

            

        echo '
                </tbody>
                    <tfoot class="bg-success">
                        <td colspan="6" class="text-center"><b>Total</b></td>
                        <td><b>'.$totalPreShiftPlanned.'</b></td>
                        <td><b>'.$totalPostShiftOTPlanned.'</b></td>
                        <td><b>'.$totalOTRendered.'</b></td>
                        <td id="tEditable" style="font-weight: 700;"></td>
                        <td colspan="2"></td>
                    </tfoot>
            </table>
            </div>';

        echo "
            <div class='modal fade' id='rejectForm' tabindex='-1' role='dialog' aria-labelledby='rejectform' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content small'>
                        <div class='modal-header'>
                            <h4 class='modal-title' id='exampleModalLabel'>OT Application Reject Form</h4>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <span id='modal-data'></span>
                            <div class='row mb-2'>
                                <div class='col-sm-3 d-flex '>
                                    <label class='p-0'><b>Name: </b></label>
                                </div>
                                <div class='col-sm-9'>
                                    <label id='modal-name'></label>
                                </div>
                            </div>
                            <div class='row mb-2'>
                                <div class='col-sm-3 d-flex '>
                                    <label class='p-0'><b>Date: </b></label>
                                </div>
                                <div class='col-sm-9'>
                                    <label id='modal-date'></label>
                                </div>
                            </div>
                            <div class='row mb-2'>
                                <div class='col-sm-3 d-flex '>
                                    <label class='p-0'><b>Time In: </b></label>
                                </div>
                                <div class='col-sm-9'>
                                    <label id='modal-tin'></label>
                                </div>
                            </div>
                            <div class='row mb-2'>
                                <div class='col-sm-3 d-flex '>
                                    <label class='p-0'><b>Time Out: </b></label>
                                </div>
                                <div class='col-sm-9'>
                                    <label id='modal-tout'></label>
                                </div>
                            </div>
                            <div class='row mb-2'>
                                <div class='col-sm-3 d-flex '>
                                    <label class='p-0'><b>Worked (hrs): </b></label>
                                </div>
                                <div class='col-sm-9'>
                                    <label id='modal-hrs'></label>
                                </div>
                            </div>
                            <div class='row mb-2'>
                                <div class='col-sm-3 d-flex '>
                                    <label class='p-0'><b>Remarks: </b></label>
                                </div>
                                <div class='col-sm-9'>
                                    <input type='text' id='modal-rem' class='w-100'>
                                </div>
                            </div>
                            <div class='row mb-2'>
                                <div class='col-sm-3 d-flex '>
                                    <label class='p-0'><b>Approved OT: </b></label>
                                </div>
                                <div class='col-sm-9'>
                                    <label id='modal-otapp' style='color:red;'>0</label>
                                </div>
                            </div>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' id='btnRejectConfirm' class='btn btn-primary'>Confirm</button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <script type='text/javascript' src='../js/otApplication.js'></script>
        ";
    }

    

    function SumApprovedOT($dtFrom, $dtTo, $emp)
    {
        global $connL;

        try
        {
            $sql = $connL->prepare(@"SELECT SUM(ot_approved) FROM dbo.att_ot_approve where emp_code = :emp AND date >= :dtFrom AND date <= :dtTo");
            $sql->bindParam(":emp", $emp, PDO::PARAM_STR);
            $sql->bindParam(":dtFrom", $dtFrom, PDO::PARAM_STR);
            $sql->bindParam(":dtTo", $dtTo, PDO::PARAM_STR);
            $sql->execute();

            //return (float)$sql->fetchColumn();
            echo "<span class='script'><script>$('#tApproved').html(parseFloat(" . (float)$sql->fetchColumn() . ").toFixed(2)).show();</script></span>";
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    function ApproveOT($name, $badge, $date, $in, $out, $hrs_worked, $ot_rendered, $ot, $user)
    {
        global $connL;

        $null = null;
        $now = date("Y-m-d H:i:s");

        $cmd = $connL->prepare(@"INSERT INTO dbo.att_ot_approve VALUES(:badge, :name, :date, :tin, :tout, :hrs_worked, :default, :otr, :ota, :user, :auditdate)");
        $cmd->bindValue(":badge", $badge);
        $cmd->bindValue(":name", $name);
        $cmd->bindValue(":date", $date);
        $cmd->bindValue(":tin", $in);
        $cmd->bindValue(":tout", $out);
        $cmd->bindValue(":hrs_worked", $hrs_worked);
        $cmd->bindValue(":default", $null);
        $cmd->bindValue(":otr", $ot_rendered);
        $cmd->bindValue(":ota", $ot);
        $cmd->bindValue(":user", $user);
        $cmd->bindValue(":auditdate", $now);
        $cmd->execute();
    }

    function RejectOT($name, $badge, $date, $in, $out, $hrs_worked, $ot_rendered, $user, $remarks)
    {
        global $connL;

        $ot = 0;
        $now = date("Y-m-d H:i:s");

        $cmd = $connL->prepare(@"INSERT INTO dbo.att_ot_approve VALUES(:badge, :name, :date, :tin, :tout, :hrs_worked, :remarks, :otr, :ota, :user, :auditdate)");
        $cmd->bindValue(":badge", $badge);
        $cmd->bindValue(":name", $name);
        $cmd->bindValue(":date", $date);
        $cmd->bindValue(":tin", $in);
        $cmd->bindValue(":tout", $out);
        $cmd->bindValue(":hrs_worked", $hrs_worked);
        $cmd->bindValue(":remarks", $remarks);
        $cmd->bindValue(":otr", $ot_rendered);
        $cmd->bindValue(":ota", $ot);
        $cmd->bindValue(":user", $user);
        $cmd->bindValue(":auditdate", $now);
        $cmd->execute();
    }

?>