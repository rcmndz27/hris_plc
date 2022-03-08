<?php

Class MfallowancesList{

    public function GetAllMfallowancesList(){
        global $connL;

        echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in employee code">
        <table id="allMfallowancesList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6" class ="text-center">List of All Mfallowances Type</th>
            </tr>
            <tr>
                <th>Allowances ID</th>
                <th>Allowances Code</th>
                <th>Allowances Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT * from dbo.mf_benefits ORDER BY rowid asc";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();


        if($result){
            do { 
                $rowd = "'".$result['rowid']."'";
                $benefitcode = "'".$result['benefit_code']."'";
                $benefitname = "'".$result['benefit_name']."'";
                $stts = "'".$result['status']."'";
                echo '
                <tr>
                <td>' . $result['rowid']. '</td>
                <td>' . $result['benefit_code']. '</td>
                <td>' . $result['benefit_name']. '</td>
                <td>' . $result['status']. '</td>';
                echo'<td><button type="button" class="actv" 
                onclick="editMfallowancesModal('.$rowd.','.$benefitcode.','.$benefitname.','.$stts.')">
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

