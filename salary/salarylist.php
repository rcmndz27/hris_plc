<?php

Class SalaryList{

    public function GetAllSalaryList(){
        global $connL;

        echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in employee code">
        <table id="allSalaryList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6" class ="text-center">List of All Employee Salary</th>
            </tr>
            <tr>
                <th>Employee Code</th>
                <th>Bank</th>
                <th>Account No.</th>
                <th>Pay Type</th>
                <th>Pay Rate</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT * from dbo.employee_salary_management ORDER BY salary_id desc";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();


        if($result){
            do { 
                $empcd = "'".$result['emp_code']."'";
                $banktype = "'".$result['bank_type']."'";
                $bankno = "'".$result['bank_no']."'";
                $payrate = "'".$result['pay_rate']."'";
                $amnt = "'".round($result['amount'],3)."'";
                $stts = "'".$result['status']."'";

                echo '
                <tr>
                <td>' . $result['emp_code']. '</td>
                <td>' . $result['bank_type']. '</td>
                <td>' . $result['bank_no']. '</td>
                <td>' . $result['pay_rate']. '</td>
                <td>' . 'P'.' '.round($result['amount'],3). '</td>
                <td>' . $result['status'] . '</td>';
                echo'<td><button type="button" class="actv" onclick="editSalaryModal('.$empcd.','.$banktype.','.$bankno.','.$payrate.','.$amnt.','.$stts.')">
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

