<?php

Class MfdeductionList{

    public function GetAllMfdeductionList(){
        global $connL;

        echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for deduction.." title="Type in employee deduction_code">
        <table id="allMfdeductionList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6" class ="text-center">List of All Deduction</th>
            </tr>
            <tr>
                <th>Deduction ID</th>
                <th>Deduction Code</th>
                <th>Deduction Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT * from dbo.mf_deductions ORDER BY rowid asc";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();


        if($result){
            do { 
                $rowd = "'".$result['rowid']."'";
                $deductioncode = "'".$result['deduction_code']."'";
                $deductionname = "'".$result['deduction_name']."'";
                $stts = "'".$result['status']."'";
                echo '
                <tr>
                <td>' . $result['rowid']. '</td>
                <td>' . $result['deduction_code']. '</td>
                <td>' . $result['deduction_name']. '</td>
                <td>' . $result['status']. '</td>';
                echo'<td><button type="button" class="actv" 
                onclick="editMfdeductionModal('.$rowd.','.$deductioncode.','.$deductionname.','.$stts.')">
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

