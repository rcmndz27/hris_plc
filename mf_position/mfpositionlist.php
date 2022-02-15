<?php

Class MfpositionList{

    public function GetAllMfpositionList(){
        global $connL;

        echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for position.." title="Type in employee code">
        <table id="allMfpositionList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6" class ="text-center">List of All Job Position</th>
            </tr>
            <tr>
                <th>Job Position ID</th>
                <th>Job Position Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT * from dbo.mf_position ORDER BY rowid asc";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();


        if($result){
            do { 
                $rowd = "'".$result['rowid']."'";
                $pstn = "'".$result['position']."'";
                echo '
                <tr>
                <td>' . $result['rowid']. '</td>
                <td>' . $result['position']. '</td>';
                echo'<td><button type="button" class="actv" 
                onclick="editMfpositionModal('.$rowd.','.$pstn.')">
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

