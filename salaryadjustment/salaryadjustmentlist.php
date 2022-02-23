<?php

Class SalaryAdjList{

    public function GetAllSalaryAdjList(){
        global $connL;

        echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for employee code.." title="Type in employee code">
        <table id="allSalaryAdjList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6" class ="text-center">List of All Employee Salary Adjustment</th>
            </tr>
            <tr>
                <th>Employee Code</th>
                <th>Period From</th>
                <th>Period To</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Remarks</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>';

        $query = "SELECT * from dbo.employee_salaryadj_management ORDER by salaryadj_id DESC ";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();


        if($result){
            do { 
                $empcd = "'".$result['emp_code']."'";
                $perfrom = date('m/d/Y', strtotime($result['period_from']));
                $perto = date('m/d/Y', strtotime($result['period_to']));
                $percutoff = "'".$perfrom.' - '.$perto."'";
                $descript = "'".$result['description']."'";
                $amnt = "'".round($result['amount'],3)."'";
                $remark = "'".$result['remarks']."'";   
                $incdecr = "'".$result['inc_decr']."'";               
                echo '
                <tr>
                <td>' . $result['emp_code']. '</td>
                <td>' . date('m/d/Y', strtotime($result['period_from'])) . '</td>
                <td>' . date('m/d/Y', strtotime($result['period_to'])) . '</td>
                <td>' . $result['description']. '</td>
                <td>' . substr(hash('sha256', $result['amount']),50). '</td>                
                <td>' . $result['remarks']. '</td>';
                echo'<td><button type="button" class="actv" onclick="editSalAdjModal('.$empcd.','.$percutoff.','.$descript.','.$amnt.','.$remark.','.$incdecr.')">
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

