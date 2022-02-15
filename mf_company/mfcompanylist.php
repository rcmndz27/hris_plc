<?php

Class MfcompanyList{

    public function GetAllMfcompanyList(){
        global $connL;

        echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for company.." title="Type in employee code">
        <table id="allMfcompanyList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6" class ="text-center">List of All Company</th>
            </tr>
            <tr>
                <th>Company ID</th>
                <th>Company Code</th>
                <th>Company Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT * from dbo.mf_company ORDER BY rowid asc";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();


        if($result){
            do { 
                $rowd = "'".$result['rowid']."'";
                $cde = "'".$result['code']."'";
                $des = "'".$result['descs']."'";
                echo '
                <tr>
                <td>' . $result['rowid']. '</td>
                <td>' . $result['code']. '</td>
                <td>' . $result['descs']. '</td>';
                echo'<td><button type="button" class="actv" 
                onclick="editMfcompanyModal('.$rowd.','.$cde.','.$des.')">
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

