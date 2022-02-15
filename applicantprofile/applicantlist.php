<?php

Class ApplicantList{

    public function GetAllApplicantList(){
        global $connL;

        echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
        <table id="allAppEnt" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6" class ="text-center">List of All Applicant</th>
            </tr>
            <tr>
                <th>Applicant Name</th>
                <th>How did you apply?</th>
                <th>Preferred Job 1</th>
                <th>Preferred Job 2</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT rowid,familyname,firstname,(LEFT(middlei,1)+'.') as [middlename],howtoapply,jobpos1,jobpos2, 
        (CASE WHEN appent_status = 1 then 'Active' 
             WHEN appent_status = 0 then 'Inactive' else 'Hired' END )as status from dbo.applicant_entry ORDER BY rowid desc";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
       
        

        if($result){
            do { 
                $fullname = "'".ucwords($result['familyname']).",".ucwords($result['firstname'])." ".ucwords($result['middlename'])."'";
                $fulln = ucwords($result['familyname']).",".ucwords($result['firstname'])." ".ucwords($result['middlename']);
                echo '
                <tr>
                <td>' .  $fulln .'</td>
                <td>' . ucwords($result['howtoapply']) . '</td>
                <td>' . ucwords($result['jobpos1']) . '</td>
                <td>' . ucwords($result['jobpos2']) . '</td>
                <td>' . ucwords($result['status']) . '</td>';
                if($result['status'] == 'Inactive'){
                echo '<td><button type="button" class="actv" onclick="verifyEntryModal('.$result['rowid'].','.$fullname.')">
                                <i class="fas fa-user-check"></i> VERIFY
                            </button></td>';
                }else if($result['status'] == 'Active'){
                    echo '<td><button type="button" class="uptv" onclick="updateEntryModal('.$result['rowid'].','.$fullname.')">
                               <i class="fas fa-edit"></i> UPDATE 
                            </button></td>';                  
                }else{
                    echo"<td><span>HIRED</span></td>";
                    
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

