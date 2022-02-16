<?php

Class NewHireAccess{

    public function GetAllEmpHistory(){
        global $connL;

        echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
        <table id="allEmpList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="9" class ="text-center">List of All Employees</th>
            </tr>
            <tr>
                <th>Emp Code</th>
                <th>Name</th>
                <th>Position</th>
                <th>Company</th>
                <th>Department</th>
                <th>Location</th>
                <th>Employee Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT * from dbo.employee_profile ORDER BY lastname asc";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        

        if($result){
            do { 
                $fullname=  $result['lastname'].','.$result['firstname'].' '.substr($result['middlename'],0,1).'.';
                $empcd = "'".$result['emp_code']."'";
                $empname = "'".$fullname."'";
                $lname = "'".$result['lastname']."'";
                $fname = "'".$result['firstname']."'";
                $mname = "'".$result['middlename']."'";
                $pstn = "'".$result['position']."'";
                $dpt = "'".$result['department']."'";
                $emailadd = "'".$result['emailaddress']."'";
                $teln = "'".$result['telno']."'";
                $celn = "'".$result['celno']."'";
                $loct = "'".strtoupper($result['location'])."'";
                $emptyp = "'".$result['emp_type']."'";

                echo '
                <tr>
                <td>' . $result['emp_code'] . '</td>
                <td>' . $fullname . '</td>
                <td>' . $result['position'] . '</td>
                <td>' . $result['company'] . '</td>
                <td>' . $result['department'] . '</td>
                <td>' . $result['location'] . '</td>
                <td>' . $result['emp_type'] . '</td>';
                echo '<td><button type="button" class="actv" onclick="updateEmpModal('.$empcd.','.$empname.','.$lname.','.$fname.','.$mname.','.$pstn.','.$dpt.','.$emailadd.','.$teln.','.$celn.','.$loct.','.$emptyp.')">
                                <i class="fas fa-edit"></i> UPDATE
                            </button></td>';
    
                

            } while ($result = $stmt->fetch());

            echo '</tr></tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="8" class="text-center">No Results Found</td></tr></tfoot>'; 
        }
        echo '</table>';
    }


}

?>

