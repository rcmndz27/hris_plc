<?php  

 function GetNhaProfile($lvlogid){
        
        global $connL;

        echo '
        <table id="EmployeProfileList" class="wtable">
        <thead>
            <tr>
                <th class="thw" colspan="4">I. Personal Background</th>
                
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT a.lastname,a.firstname,a.middlename,a.emp_address,a.emp_address2,a.celno,a.celno1,a.emailaddress,a.emailaddress1,a.birthdate,a.birthplace,a.sex,a.sss_no,a.marital_status,
            a.height,a.pagibig_no,a.weight,a.tin_no,a.bloodtype,a.phil_no,a.driver_lic,a.non_driver_lic,
            a.expirydate_non,a.expirydate,a.spousename,a.marriagedate,a.spousebirthdate,a.spousesssno,
            a.spousetinno,a.spouseoccupation
        from employee_profile a 
                    left join employee_employments b on a.emp_code = b.emp_code 
                    left join employee_educations c on  a.emp_code = c.emp_code  
                    left join employee_convictions d on a.emp_code = d.emp_code 
                    left join employee_siblings e on a.emp_code = e.emp_code
                    left join employee_dependents f on a.emp_code = f.emp_code where a.emp_code = :lvlogid ";
        $param = array(':lvlogid' => $lvlogid);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        if($result){
            do { 
                $birthDate = $result['birthdate'];

                $currentDate = date("Y-m-d");

                $age = date_diff(date_create($birthDate), date_create($currentDate));

                echo '
                <tr><th class="thw" colspan="4"></th></tr> 
                <tr>
                <td class="thw" >Last Name:</td>
                <td colspan="3">' . $result['lastname'] . '</td></tr>
                <tr><th class="thw" >First Name:</th>
                <td colspan="3">' . $result['firstname'] . '</td></tr>   
                <tr><th class="thw" >Middle Name:</th>
                <td colspan="3">' . $result['middlename'] . '</td></tr>
                <tr><th class="thw" >Present Address:</th>
                <td colspan="3">' . $result['emp_address'] . '</td></tr>
                <tr><th class="thw" >Permanent Address:</th>
                <td colspan="3">' . $result['emp_address2'] . '</td></tr>
                <tr><th class="thw" rowspan="2" >Contact No. :</th>
                <td >' . $result['celno'] . '</td>
                <td class="thw"rowspan="2">Email Address:</td>
                <td>'.((isset($result['emailaddress'])) ? $result['emailaddress'] : 'no email found').'</td>
                </tr> 
                <tr><td>' . $result['celno1'] . '</td>
                <td >'.((isset($result['emailaddress1'])) ? $result['emailaddress1'] : 'no email found').'</td></tr>
                <tr><th class="thw">Birthday:</th>
                <td >' . $result['birthdate'] . '</td>
                <td class="thw">Age:</td>
                <td>'.$age->format("%y").'</td></tr>
                <tr><th class="thw">Birthplace:</th>
                <td >' . $result['birthplace'] . '</td>
                <td class="thw">Sex:</td>
                <td>' . $result['sex'] . '</td></tr>
                <tr><th class="thw">SSS No:</th>
                <td >' . $result['sss_no'] . '</td>
                <td class="thw">Civil Status:</td>
                <td>' . $result['marital_status'] . '</td></tr>
                <tr><th class="thw">Philhealth No: </th>
                <td >' . $result['phil_no'] . '</td>
                <td class="thw"> Height: </td>
                <td>' . $result['height'] . '</td></tr>                
                <tr><th class="thw">Pag-IBIG No:</th>
                <td >' . $result['pagibig_no'] . '</td>
                <td class="thw">Weight: </td>
                <td>' . $result['weight'] . '</td></tr>                
                <tr><th class="thw">TIN No: </th>
                <td >' . $result['tin_no'] . '</td>
                <td class="thw"> Blood Type: </td>
                <td>' . $result['bloodtype'] . '</td></tr>
                <tr><th class="thw">Professional License No:</th>
                <td >' . $result['driver_lic'] . '</td>
                <td class="thw">Non-Professional License No:</td>
                <td>' . $result['non_driver_lic'] . '</td></tr>
                <tr><th class="thw">Expiry Date:</th>
                <td >' . ($result['expirydate'] <> ('1900-01-01'|| '') ? $result['expirydate'] : 'n/a') . '</td>
                <td class="thw">Expiry Date:</td>
                <td>' . ($result['expirydate_non'] <> ('1900-01-01'|| '') ? $result['expirydate_non'] : 'n/a') . '</td></tr>
                <tr><th class="thw" colspan="4"></th></tr> 
                <tr><th class="thw" colspan="4">II. Family Background:</th></tr>
                <tr><th class="thw" colspan="4"></th></tr>
                <tr><th class="thw">Name of Spouse (if married):</th>
                <td colspan="3">' . $result['spousename'] . '</td></tr>
                <tr><th class="thw">Date of Marriage  (if married):</th>
                <td colspan="3">' . $result['marriagedate'] . '</td></tr> 
                <tr><th class="thw">Birthday:</th>
                <td >' . ($result['spousebirthdate'] <> ('1900-01-01'|| '') ? $result['spousebirthdate'] : 'n/a') . '</td>
                <td class="thw">SSS No.:</td>
                <td>' . $result['spousesssno']. '</td></tr>
                <tr><th class="thw">Occupation:</th>
                <td >' . $result['spouseoccupation'] . '</td>
                <td class="thw">TIN No.:</td>
                <td>' . $result['spousetinno']. '</td></tr>
                <tr><th class="thw" colspan="4">Name of Children:</th></tr>
                <tr>' . $result['spousetinno']. ':</tr> ';


            } while ($result = $stmt->fetch());

            echo '</tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="3" class="text-center">No Results Found</td></tr></tfoot>'; 
        }
        echo '</table>';
    } 

?>