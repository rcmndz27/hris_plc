<?php

Class WfhApp{

    private $employeeCode;
    
    public function SetWfhAppParams($employeeCode){
        $this->employeeCode = $employeeCode;
    }


    public function GetWfhAppHistory(){
        global $connL;

        echo '
        <table id="dtrList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="8" class ="text-center">History of Work From Home</th>
            </tr>
            <tr>
                <th>WFH Date</th>
                <th>Remarks</th>
                <th>Reject Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>';

        $query = 'SELECT * FROM dbo.tr_workfromhome where emp_code = :emp_code ORDER BY wfh_date DESC';
        $param = array(':emp_code' => $this->employeeCode);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        if($result){
            do { 
                echo '
                <tr>
                <td>' . date('m-d-Y', strtotime($result['wfh_date'])) . '</td>
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
            echo '<tfoot><tr><td colspan="8" class="text-center">No Results Found</td></tr></tfoot>'; 
        }
        echo '</table>';
    }

    public function InsertAppliedWfhApp($empCode,$empReportingTo,$wfhDate,$remarks,$attachment){

        global $connL;

            $query = "INSERT INTO tr_workfromhome (emp_code,wfh_date,reporting_to,remarks,attachment,audituser,auditdate) 
                VALUES(:emp_code,:wfhDate,:empReportingTo,:remarks,:attachment,:audituser,:auditdate) ";
    
                $stmt =$connL->prepare($query);

                $param = array(
                    ":emp_code"=> $empCode,
                    ":wfhDate" => $wfhDate,
                    ":empReportingTo" => $empReportingTo,
                    ":remarks"=> $remarks,
                    ":attachment"=> $attachment,
                    ":audituser" => $empCode,
                    ":auditdate"=>date('m-d-Y')
                );

            $result = $stmt->execute($param);

            echo $result;

    }
}

?>