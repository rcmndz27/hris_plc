<?php

Class OtApp{

    private $employeeCode;
    
    public function SetOtAppParams($employeeCode){
        $this->employeeCode = $employeeCode;
    }


    public function GetOtAppHistory(){
        global $connL;

        echo '
        <table id="dtrList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="9" class ="text-center">History of Overtime</th>
            </tr>
            <tr>
                <th>OT Date</th>
                <th>OT Type</th>
                <th>Time-In</th>
                <th>Time-Out</th>
                <th>Plan OT</th>
                <th>Rendered OT</th>
                <th>Remarks</th>
                <th>Reject Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>';

        $query = 'SELECT * FROM dbo.tr_overtime where emp_code = :emp_code ORDER BY ot_date DESC';
        $param = array(':emp_code' => $this->employeeCode);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        if($result){
            do { 
                echo '
                <tr>
                <td>' . date('m-d-Y', strtotime($result['ot_date'])) . '</td>
                <td>' . $result['ot_type'] . '</td>
                <td>' . date('h:i a', strtotime($result['ot_start_dtime'])) . '</td>
                <td>' . date('h:i a', strtotime($result['ot_end_dtime'])) . '</td>
                <td>' . $result['ot_req_hrs'] . '</td>
                <td>' . $result['ot_ren_hrs'] . '</td>
                <td>' . $result['remarks'] . '</td>
                <td>' . $result['reject_reason'] . '</td>';

                switch((int)$result['status'])
                {
                    case 1:
                        echo '<td><p class="text-warning">PENDING</p></td>';
                        break;
                    case 2:
                        echo '<td><p class="text-success">APPROVED</p></td>';
                        break;
                    case 3:
                        echo '<td><p class="text-danger">REJECTED</p></td>';
                        break;
                    case 4:
                        echo '<td><p class="text-danger">VOID</p></td>';
                        break;    
                    default:
                        break;
                }

            } while ($result = $stmt->fetch());

            echo '</tr></tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="9" class="text-center">No Results Found</td></tr></tfoot>'; 
        }
        echo '</table>';
    }

    public function InsertAppliedOtApp($empCode,$empReportingTo,$otDate,$otStartDtime,$otEndDtime,$otReqHrs,$remarks){

        global $connL;

            $query = "INSERT INTO tr_overtime (emp_code,ot_date,datefiled,reporting_to,ot_start_dtime,ot_end_dtime, ot_req_hrs,remarks,audituser, auditdate) 
                VALUES(:emp_code,:otDate,:datefiled,:empReportingTo,:otStartDtime,:otEndDtime,:otReqHrs, :remarks,:audituser,:auditdate) ";
    
                $stmt =$connL->prepare($query);

                $param = array(
                    ":emp_code"=> $empCode,
                    ":otDate" => $otDate,
                    ":datefiled"=>date('m-d-Y'),
                    ":empReportingTo" => $empReportingTo,
                    ":otStartDtime" => $otStartDtime,
                    ":otEndDtime"=> $otEndDtime,
                    ":otReqHrs"=> $otReqHrs,
                    ":remarks"=> $remarks,
                    ":audituser" => $empCode,
                    ":auditdate"=>date('m-d-Y')
                );

            $result = $stmt->execute($param);

            echo $result;

            $query_pay = $connL->prepare('EXEC hrissys_test.dbo.GenerateOTType');
            $query_pay->execute(); 

    }

}

?>