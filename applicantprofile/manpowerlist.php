<?php

Class ManpowerList{

    public function GetAllManpowerList(){
        global $connL;

        echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
        <table id="allManList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6" class ="text-center">List of Manpower Request</th>
            </tr>
            <tr>
                <th>MRF NO.</th>
                <th>Position</th>
                <th>Requirement</th>
                <th>Date Needed</th>
                <th>Status</th>
                <th>Applicant Name</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT a.rowid,a.position,a.req_ment,a.date_needed,a.status,b.familyname,b.firstname,(LEFT(b.middlei,1)+'.') as [middlename] from dbo.applicant_manpower a left join dbo.applicant_entry b on a.app_no = b.rowid ORDER BY rowid asc";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        

        if($result){
            do { 
                echo '
                <tr>
                <td>' . 'MRF#'.$result['rowid'] . '</td>
                <td>' . $result['position'] . '</td>
                <td>' . $result['req_ment'] . '</td>
                <td>' . date('m/d/Y', strtotime($result['date_needed'])) . '</td>
                <td>' . $result['status'] . '</td>
                <td>' . ucwords($result['familyname']).','.ucwords($result['firstname']).' '.ucwords($result['middlename']). '</td>';
                

            } while ($result = $stmt->fetch());

            echo '</tr></tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="6" class="text-center">No Results Found</td></tr></tfoot>'; 
        }
        echo '</table>';
    }

}

?>