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

        $query = "SELECT a.rowid,a.emp_code,(a.lastname+','+a.firstname+' '+ LEFT(a.middlename,1)+'.') as [emp_name],a.position,a.company,a.department,a.location,a.emp_type,a.datehired,a.reporting_to as [sup_name] from employee_profile a left join employee_profile b on a.emp_code = b.emp_code
        ORDER BY a.datehired DESC";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        

        if($result){
            do { 
                $empcd = "'".$result['emp_code']."'";
                $empname = "'".$result['emp_name']."'";
                echo '
                <tr>
                <td>' . $result['emp_code'] . '</td>
                <td>' . $result['emp_name'] . '</td>
                <td>' . $result['position'] . '</td>
                <td>' . $result['company'] . '</td>
                <td>' . $result['department'] . '</td>
                <td>' . $result['location'] . '</td>
                <td>' . $result['emp_type'] . '</td>';
                echo '<td><button type="button" class="actv" onclick="updateEmpModal('.$empcd.','.$empname.')">
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

