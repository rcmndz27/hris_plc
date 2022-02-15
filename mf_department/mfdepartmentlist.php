<?php

Class MfdepartmentList{

    public function GetAllMfdepartmentList(){
        global $connL;

        echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for department.." title="Type in employee code">
        <table id="allMfdepartmentList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6" class ="text-center">List of All Department</th>
            </tr>
            <tr>
                <th>Department ID</th>
                <th>Department Code</th>
                <th>Department Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT * from dbo.mf_dept ORDER BY rowid asc";
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
                onclick="editMfdepartmentModal('.$rowd.','.$cde.','.$des.')">
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

