<?php

    include('otApproval.php');
    include('../config/db.php');

    $choice = $_POST['choice'];

    if ($choice == 0) // LOAD
    {
        ShowAllOT($_POST["empId"], $_POST["dateFrom"], $_POST["dateTo"], $_POST['emp']);
        SumApprovedOT($_POST["dateFrom"], $_POST["dateTo"], $_POST['emp']);
    }
    else if ($choice == 1) // APPROVE ONE TIME
    {
        ApproveOT($_POST['_name'], $_POST['_badge'], $_POST['_date'], $_POST['_hin'], $_POST['_hout'], $_POST['_wrk'], $_POST['_otr'], $_POST['_ot'], $_POST['_usr']);
        ShowAllOT($_POST["_usr"], $_POST["_dateFrom"], $_POST["_dateTo"], $_POST['_badge']);
        SumApprovedOT($_POST["_dateFrom"], $_POST["_dateTo"], $_POST['_badge']);

        echo "<span class='etcMessage'>
                <script type='text/javascript'>
                    alert('Successfully approved OT appplication.');
                    $('etcMessage').remove();
                </script>
            </span>";
    }
    else if ($choice == 2) // REJECT ONE TIME
    {
        RejectOT($_POST['_name'], $_POST['_badge'], $_POST['_date'], $_POST['_hin'], $_POST['_hout'], $_POST['_wrk'], $_POST['_otr'], $_POST['_usr'], $_POST["_remarks"]);
        ShowAllOT($_POST["_usr"], $_POST["_dateFrom"], $_POST["_dateTo"], $_POST['_badge']);
        SumApprovedOT($_POST["_dateFrom"], $_POST["_dateTo"], $_POST['_badge']);

        echo "<span class='etcMessage'>
                <script type='text/javascript'>
                    alert('Successfully rejected OT application.');
                    $('.etcMessage').remove();
                </script>
            </span>";
    }
    else if ($choice == 3) // SHOW ALL SUMS
    {
        ShowAllOT($_POST["empId"], $_POST["dateFrom"], $_POST["dateTo"], $_POST['emp']);
        SumApprovedOT($_POST["dateFrom"], $_POST["dateTo"], $_POST['emp']);
    }
    else if ($choice == 4) // APPROVE ALL
    {
        $badges = $_POST['_badge'];
        $counter = count($badges);

        for ($i = 0; $i < $counter; $i++)
        {
            ApproveOT($_POST['_name'][$i], $_POST['_badge'][$i], $_POST['_date'][$i], $_POST['_hin'][$i], $_POST['_hout'][$i], $_POST['_wrk'][$i], $_POST['_otr'][$i], $_POST['_ot'][$i], $_POST['_usr']);
        }

        ShowAllOT($_POST["_usr"], $_POST["_dateFrom"], $_POST["_dateTo"], $_POST['_ibadge']);
        SumApprovedOT($_POST["_dateFrom"], $_POST["_dateTo"], $_POST['_ibadge']);

        echo "<span class='etcMessage'>
                <script type='text/javascript'>
                    alert('Successfully approved all valid OT appplications.');
                    $('etcMessage').remove();
                </script>
            </span>";
    }
    else if ($choice == 5) // REJECT ALL
    {
        $badges = $_POST['_badge'];
        $counter = count($badges);

        for ($i = 0; $i < $counter; $i++)
        {
            RejectOT($_POST['_name'][$i], $_POST['_badge'][$i], $_POST['_date'][$i], $_POST['_hin'][$i], $_POST['_hout'][$i], $_POST['_wrk'][$i], $_POST['_otr'][$i], $_POST['_usr'], $_POST["_rem"]);
        }

        ShowAllOT($_POST["_usr"], $_POST["_dateFrom"], $_POST["_dateTo"], $_POST['_ibadge']);
        SumApprovedOT($_POST["_dateFrom"], $_POST["_dateTo"], $_POST['_ibadge']);

        echo "<span class='etcMessage'>
                <script type='text/javascript'>
                    alert('Successfully rejected all valid OT applications.');
                    $('.etcMessage').remove();
                </script>
            </span>";
    }
    else {}
?>