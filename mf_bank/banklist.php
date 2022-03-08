<?php

Class BankList{

    public function GetAllBankList(){
        global $connL;

        echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in employee code">
        <table id="allBankList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6" class ="text-center">List of All Bank Type</th>
            </tr>
            <tr>
                <th>Bank ID</th>
                <th>Bank Acronym</th>
                <th>Bank Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT * from dbo.mf_banktypes ORDER BY rowid asc";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();

        if($result){
            do { 
                $rowd = "'".$result['rowid']."'";
                $dscsb = "'".$result['descsb']."'";
                $descsbname = "'".$result['descsb_name']."'";
                $stts = "'".$result['status']."'";
                echo '
                <tr>
                <td>' . $result['rowid']. '</td>
                <td>' . $result['descsb']. '</td>
                <td>' . $result['descsb_name']. '</td>
                <td>' . $result['status']. '</td>';
                echo'<td><button type="button" class="actv" 
                onclick="editBankModal('.$rowd.','.$dscsb.','.$descsbname.','.$stts.')">
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

