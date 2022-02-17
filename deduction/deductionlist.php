<?php

Class DeductionList{

    public function GetAllDeductionList(){
        global $connL;

        echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for employee code.." title="Type in employee code">
        <table id="allDeductionList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6" class ="text-center">List of All Employee Deduction</th>
            </tr>
            <tr>
                <th>Employee Code</th>
                <th>Deduction Name</th>
                <th>Period Cutoff</th>
                <th>Deduction Amount</th>
                <th>Effectivity Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT a.deduction_emp_id,a.emp_code,b.deduction_name,b.rowid,a.period_cutoff,a.amount,a.effectivity_date from dbo.employee_deduction_management a left join dbo.mf_deductions b on a.deduction_id = b.rowid ORDER by a.deduction_emp_id DESC ";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();


        if($result){
            do { 
                $empcd = "'".$result['emp_code']."'";
                $deductionname = $result['deduction_name'];
                $deductionid = $result['rowid'];
                $dedname = "'".$deductionid.' - '.$deductionname."'";
                $periodcutoff = "'".$result['period_cutoff']."'";
                $amnt = "'".round($result['amount'],3)."'";
                $effectivitydate = "'".date('Y-m-d', strtotime($result['effectivity_date']))."'";                
                echo '
                <tr>
                <td>' . $result['emp_code']. '</td>
                <td>' . $result['deduction_name']. '</td>
                <td>' . $result['period_cutoff']. '</td>
                <td>' . 'P'.' '.round($result['amount'],3). '</td>
                <td>' . date('m/d/Y', strtotime($result['effectivity_date'])) . '</td>';
                echo'<td><button type="button" class="actv" onclick="editDedModal(' . $empcd. ',' . $dedname. ',' . $periodcutoff. ',' . $amnt. ',' . $effectivitydate. ')">
                                <i class="fas fa-edit"></i> UPDATE
                            </button></td>';
                
                

            } while ($result = $stmt->fetch());

            echo '</tr></tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="6" class="text-center">No Results Found</td></tr></tfoot>'; 
        }
        echo '</table>';
    }


}

?>

