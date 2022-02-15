<?php

Class PlantillaList{

    public function GetAllPlantillaList(){
        global $connL;

        echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for department.." title="Type in a name">
        <table id="allPlaList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6" class ="text-center">List of Plantilla</th>
            </tr>
            <tr>
                <th>Entry Date</th>
                <th>Department</th>
                <th>Position</th>
                <th>Reporting To</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT * from dbo.applicant_plantilla ORDER BY rowid asc";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        

        if($result){
            do { 
                echo '
                <tr>
                <td>' . date('m/d/Y', strtotime($result['entry_date'])) . '</td>
                <td>' . $result['department'] . '</td>
                <td>' . $result['position'] . '</td>
                <td>' . $result['reporting_to'] . '</td>
                <td>' . $result['status'] . '</td>
                ';

                if($result['status'] === 'Open' or $result['status'] === 'De-Activated'){
                echo '<td><button type="button" class="actv" onclick="activatePlant('.$result['rowid'].')">
                                <i class="fas fa-check-circle"></i> ACTIVATE
                            </button></td>';
                }else{
                    echo '<td><button type="button" class="deactv" onclick="deactivatePlant('.$result['rowid'].');">
                               <i class="fas fa-times-circle"></i> DE-ACTIVATE
                            </button></td>';
                }
                
                

            } while ($result = $stmt->fetch());

            echo '</tr></tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="6" class="text-center">No Results Found</td></tr></tfoot>'; 
        }
        echo '</table>';
    }

}

?>