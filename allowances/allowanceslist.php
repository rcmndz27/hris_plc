<?php

Class AllowancesList{

    public function GetAllAllowancesList(){
        global $connL;

        echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in employee code">
        <table id="allAllowancesList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6" class ="text-center">List of All Employee Allowances</th>
            </tr>
            <tr>
                <th>Employee Code</th>
                <th>Allowances Name</th>
                <th>Period Cutoff</th>
                <th>Allowances Amount</th>
                <th>Effectivity Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT a.benefits_emp_id,a.emp_code,b.benefit_name,b.rowid,a.period_cutoff,a.amount,a.effectivity_date from dbo.employee_allowances_management a left join dbo.mf_benefits b on a.benefit_id = b.rowid ORDER by a.benefits_emp_id DESC ";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        

        if($result){
            do { 
                $empcd = "'".$result['emp_code']."'";
                $benefitname = $result['benefit_name'];
                $benefitid = $result['rowid'];
                $benname = "'".$benefitid.' - '.$benefitname."'";
                $periodcutoff = "'".$result['period_cutoff']."'";
                $amnt = "'".round($result['amount'],3)."'";
                $effectivitydate = "'".date('Y-m-d', strtotime($result['effectivity_date']))."'";                   
                echo '
                <tr>
                <td>' . $result['emp_code']. '</td>
                <td>' . $result['benefit_name']. '</td>
                <td>' . $result['period_cutoff']. '</td>
                <td>' . substr(hash('sha256', $result['amount']),50). '</td>
                <td>' . date('m/d/Y', strtotime($result['effectivity_date'])) . '</td>';
                echo'<td><button type="button" class="actv" onclick="editAlwModal(' . $empcd. ',' . $benname. ',' . $periodcutoff. ',' . $amnt. ',' . $effectivitydate. ')">
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

