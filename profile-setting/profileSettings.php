<?php

    // VIEWING

    // function ShowBasicDetails($empId)
    // {
    //     global $connL;

    //     $ct = $connL->prepare(@"SELECT COUNT(*) from dbo.employee_profile where emp_code = :emp");
    //     $ct->bindValue(':emp', $empId);
    //     $ct->execute();

    //     if ($ct->fetchColumn() >= 1)
    //     {
    //         $cmd = $connL->prepare(@"SELECT * from dbo.employee_profile where emp_code = :emp");
    //         $cmd->bindValue(':emp', $empId);
    //         $cmd->execute();

    //         echo "
    //             <div class='contents-info-basicdetails'>
    //                 <div class='col-lg-12 editbar'>
    //                     <div class='row'>
    //                         <div class=' errMessage";
            
    //         while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
    //         {
    //             if ($r['approved_edit'] == 1)
    //             {
    //                 echo " my-auto'>CHANGES PENDING FOR APPROVAL";
    //             }
    //             else
    //             {
    //                 echo "'>";
    //             }
                                
    //             echo "      </div>
    //                         <button class='btn btn-primary' style='width:100px;' onclick='javascript:editEnable()'>EDIT</button> &nbsp;
    //                         <button class='btn btn-primary btn-save' style='width:100px;' disabled onclick='javascript:UpdateBasic(\"EDIT\")'>SAVE</button></div>
    //                     </div>
    //                     <div class='col-12 content-block-info'>
    //                         <div class='row px-2 profileSettings-SubtitleContainer'>
    //                             <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                         </div>
    //                         <div class='row'>
    //                             <ul class='w-100'>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Name: </b></div>
    //                                         <div class='col-sm-7 labelInfo'>" . $r['lastname'] . ", " . $r['firstname'] . " " . $r['middlename'] . "</div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Sex: </b></div>
    //                                         <div class='col-sm-7 labelInfo'>" . $r['sex'] . "</div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Blood Type: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' class='w-100' id='p-0' value='" . $r['bloodtype'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Birth Date: </b></div>
    //                                         <div class='col-sm-7 labelInfo dateDisplay'>". date('F d, Y', strtotime($r['birthdate'])) . "</div>
    //                                         <div class='col-sm-7 labelInfo dateEdit' style='display:none;'><input type='date' id='p-1' class='w-100' value='". date('Y-m-d', strtotime($r['birthdate'])) . "'></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Civil Status: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-2' class='w-100' value='" . $r['civilstatus'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Address 1: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-3' class='w-100' value='" . $r['emp_address'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Address 2: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-4' class='w-100' value='" . $r['emp_address2'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Contact No(s): </b></div>
    //                                         <div class='col-sm-1 labelHead' style='padding-right: 0 !important;'><small>Cel No 1</small></div>
    //                                         <div class='col-sm-6 labelInfo'><input type='text' id='p-5' class='w-100' value='";
    //                                             if ($r['celno'] == 0) { echo "NA"; }
    //                                             else { echo $r['celno']; }
    //             echo "' autocomplete='off' disabled>
    //                 </div>
    //                     </div>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'></div>
    //                                         <div class='col-sm-1 labelHead' style='padding-right: 0 !important;'><small>Cel No 2</small></div>
    //                                         <div class='col-sm-6 labelInfo'><input type='text' id='p-6' class='w-100' value='";
    //                                             if ($r['celno1'] == 0) { echo "NA"; }
    //                                             else { echo $r['celno1']; }
    //             echo "' autocomplete='off' disabled>
    //                 </div>
    //                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'></div>
    //                                         <div class='col-sm-1 labelHead' style='padding-right: 0 !important;'><small>Tel No</small></div>
    //                                         <div class='col-sm-6 labelInfo'><input type='text' id='p-7' class='w-100' value='";
    //                                             if ($r['telno'] == 0) { echo "NA"; }
    //                                             else { echo $r['telno']; }
    //             echo "' autocomplete='off' disabled>
    //                 </div>
    //                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Email Address: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-8' class='w-100' value='" . $r['emailaddress'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                             </ul>
    //                         </div>
    //                         <div class='row px-2 profileSettings-SubtitleContainer'>
    //                             <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                         </div>
    //                         <div class='row'>
    //                             <ul class='w-100'>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Department: </b></div>
    //                                         <div class='col-sm-7 labelInfo'>" . $r['department'] . "</div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Sub-department: </b></div>
    //                                         <div class='col-sm-7 labelInfo'>" . $r['sub_department'] . "</div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Group: </b></div>
    //                                         <div class='col-sm-7 labelInfo'>". $r['groupby'] . "</div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Position: </b></div>
    //                                         <div class='col-sm-7 labelInfo'>". $r['position'] . "</div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Date Hired: </b></div>
    //                                         <div class='col-sm-7 labelInfo'>". date("F d, Y", strtotime($r['datehired'])) . "</div>
    //                                     </div>
    //                                 </li>
    //                             </ul>
    //                         </div>
    //                         <div class='row px-2 profileSettings-SubtitleContainer'>
    //                             <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                         </div>
    //                         <div class='row'>
    //                             <ul class='w-100'>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>PRC License: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-9' class='w-100' value='". $r['prc_lic'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>PRC License Exp: </b></div>
    //                                         <div class='col-sm-7 labelInfo dateDisplay'>";
    //                                             if (date("F d, Y", strtotime($r['prc_expirydate'])) ==  "January 01, 1900") { echo "NA"; }
    //                                             else { echo date("F d, Y", strtotime($r['prc_expirydate'])); }
    //         echo "
    //                                         </div>
    //                                         <div class='col-sm-7 labelInfo dateEdit' style='display:none;'><input type='date' id='p-10' class='w-100' value='";
    //                                             if (date("F d, Y", strtotime($r['prc_expirydate'])) ==  "January 01, 1900") { echo date('Y-m-d', "1900-01-01"); }
    //                                             else { echo date("Y-m-d", strtotime($r['prc_expirydate'])); }
    //         echo "'>
    //                                         </div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Driver's License: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-11' class='w-100' value='". $r['driver_lic'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Driver's License Exp: </b></div>
    //                                         <div class='col-sm-7 labelInfo dateDisplay'>";
    //                                             if (date("F d, Y", strtotime($r['expirydate'])) ==  "January 01, 1900") { echo "NA"; }
    //                                             else { echo date("F d, Y", strtotime($r['expirydate'])); }
    //         echo "
    //                                         </div>
    //                                         <div class='col-sm-7 labelInfo dateEdit' style='display:none;'><input type='date' id='p-12' class='w-100' value='";
    //                                             if (date("F d, Y", strtotime($r['expirydate'])) ==  "January 01, 1900") { echo date('Y-m-d', "1900-01-01"); }
    //                                             else { echo date("Y-m-d", strtotime($r['expirydate'])); }
    //         echo "'>
    //                                         </div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>TIN No: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-13' class='w-100' value='". $r['tin_no'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>SSS No: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-14' class='w-100' value='". $r['sss_no'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Philhealth No: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-15' class='w-100' value='". $r['phil_no'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Pag-ibig No: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-16' class='w-100' value='". $r['pagibig_no'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                             </ul>
    //                         </div>";
    //         }
    //     }
    //     else { echo "<div class='d-flex justify-content-center'><h4>There is no record found for your basic information. Please contact HR!</h4></div>"; }

    //     echo "
    //                 <div class='row px-2 profileSettings-SubtitleContainer'>
    //                     <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                 </div>
    //             </div>
    //         </div>
    //         <script type='text/javascript'>
    //             function UpdateBasic(act)
    //             {
    //                 if (confirm('Are you sure you want to update your personal details?'))
    //                 {
    //                     var url = '../controller/profileSettingsProcess.php';
    //                     var data = [
    //                         $('#p-0').val(), $('#p-1').val(), $('#p-2').val(), $('#p-3').val(),
    //                         $('#p-4').val(), $('#p-5').val(), $('#p-6').val(), $('#p-7').val(),
    //                         $('#p-8').val(), $('#p-9').val(), $('#p-10').val(), $('#p-11').val(),
    //                         $('#p-12').val(), $('#p-13').val(), $('#p-14').val(), $('#p-15').val(),
    //                         $('#p-16').val()
    //                     ];

    //                     $.post (
    //                         url,
    //                         {
    //                             empId: '" . $empId . "',
    //                             option: 0,
    //                             action: act,
    //                             info: data
    //                         },
    //                         function(data) { $('#contents-info').html(data).show(); }
    //                     );
    //                 }
    //             }
    //         </script>
    //     ";
    // }
    
    // function ShowFamilyDetails($empId)
    // {
    //     global $connL;

    //     $ct = $connL->prepare(@"SELECT COUNT(*) from dbo.employee_family_background where emp_code = :emp");
    //     $ct->bindValue(':emp', $empId);
    //     $ct->execute();

    //     if ($ct->fetchColumn() >= 1)
    //     {
    //         $cmd = $connL->prepare(@"SELECT * from dbo.employee_family_background where emp_code = :emp");
    //         $cmd->bindValue(':emp', $empId);
    //         $cmd->execute();

    //         echo "
    //             <div class='contents-info-familydetails'>
    //                 <div class='editbar'>
    //                     <div class='row flex'>
    //                         <div class='errMessage";

    //         while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
    //         {
    //             if ($r['approved_edit'] == 1)
    //             {
    //                 echo " my-auto'>CHANGES PENDING FOR APPROVAL";
    //             }
    //             else
    //             {
    //                 echo "'>";
    //             }
                                
    //         echo "          </div>
    //                         <button class='btn btn-primary' style='width:100px;' onclick='javascript:editEnable()'>EDIT</button> &nbsp;
    //                         <button class='btn btn-primary btn-save' style='width:100px;' disabled onclick='javascript:UpdateFamily(\"EDIT\")'>SAVE</button>
    //                     </div>
    //                     <div class='col-12 content-block-info'>
    //                         <div class='row px-2 profileSettings-SubtitleContainer'>
    //                             <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                         </div>
    //                         <div class='row'>
    //                             <ul class='w-100'>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Name of Father: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-0' class='w-100' value='" . $r['name_of_father'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Name of Mother: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-1' class='w-100' value='" . $r['name_of_mother'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Address: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-2' class='w-100' value='" . $r['fam_address'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Contact Person: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-3' class='w-100' value='" . $r['contact_person'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Contact No: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-4' class='w-100' value='" . $r['contact_no'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Contact Address: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-5' class='w-100' value='" . $r['contact_address'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                             </ul>
    //                         </div>
    //                     <div class='row px-2 profileSettings-SubtitleContainer'>
    //                         <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                     </div>
    //                         <div class='row'>
    //                             <ul class='w-100'>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Name of Spouse: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-6' class='w-100' value='" . $r['name_of_spouse'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Birth Date: </b></div>
    //                                         <div class='col-sm-7 labelInfo dateDisplay'>";
    //                                             if (date('F d, Y', strtotime($r['birthdate'])) ==  "January 01, 1900") { echo "NA"; }
    //                                             else { echo date('F d, Y', strtotime($r['birthdate'])); }
                     
    //             echo "
    //                                         </div>
    //                                         <div class='col-sm-7 labelInfo dateEdit' style='display:none;'><input type='date' id='p-7' class='w-100' value='";
    //                                             if (date('F d, Y', strtotime($r['birthdate'])) ==  "January 01, 1900") { echo "1900-01-01"; }
    //                                             else { echo date('Y-m-d', strtotime($r['birthdate'])); }
    //             echo "'>
    //                                         </div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Occupation: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-8' class='w-100' value='" . $r['occupation'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>TIN No of Spouse: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-9' class='w-100' value='" . $r['tinno_of_spouse'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>SSS No of Spouse: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-10' class='w-100' value='" . $r['sss_of_spouse'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                             </ul>
    //                         </div>
    //                     <div class='row px-2 profileSettings-SubtitleContainer'>
    //                         <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                     </div>
    //                         <div class='row'>
    //                             <ul class='w-100'>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Name of Relative: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-11' class='w-100' value='" . $r['relative_name'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Relationship: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-12' class='w-100' value='" . $r['relative_relation'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                             </ul>
    //                         </div>";
    //         }
    //     }
    //     else
    //     {
    //         echo "
    //             <div class='d-flex justify-content-center'>
    //                 <h4>There is no record found for your family background. Please contact HR!</h4>
    //             </div>";
    //     }

    //     echo "
    //                 <div class='row px-2 profileSettings-SubtitleContainer'>
    //                     <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                 </div>
    //             </div>
    //         </div>
    //         <script type='text/javascript'>
    //             function UpdateFamily(act)
    //             {
    //                 if (confirm('Are you sure you want to update your family background information?'))
    //                 {
    //                     var url = '../controller/profileSettingsProcess.php';
    //                     var data = [
    //                         $('#p-0').val(), $('#p-1').val(), $('#p-2').val(), $('#p-3').val(),
    //                         $('#p-4').val(), $('#p-5').val(), $('#p-6').val(), $('#p-7').val(),
    //                         $('#p-8').val(), $('#p-9').val(), $('#p-10').val(), $('#p-11').val(),
    //                         $('#p-12').val()
    //                     ];

    //                     $.post (
    //                         url,
    //                         {
    //                             empId: '" . $empId . "',
    //                             option: 1,
    //                             action: act,
    //                             info: data
    //                         },
    //                         function(data) { $('#contents-info').html(data).show(); }
    //                     );
    //                 }
    //             }
    //         </script>";
    // }
    
    // function ShowEducationDetails($empId)
    // {
    //     global $connL;

    //     $ct = $connL->prepare(@"SELECT COUNT(*) from dbo.employee_others where emp_code = :emp");
    //     $ct->bindValue(':emp', $empId);
    //     $ct->execute();
        
    //     if ($ct->fetchColumn() >= 1)
    //     {
    //         $cmd = $connL->prepare(@"SELECT * from dbo.employee_others where emp_code = :emp");
    //         $cmd->bindValue(':emp', $empId);
    //         $cmd->execute();

    //         echo "<div class='contents-info-educdetails'>
    //                 <div class='editbar'>
    //                     <div class='row flex'>
    //                         <div class=' errMessage";

    //         while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
    //         {
    //             if ($r['approved_edit'] == 1)
    //             {
    //                 echo " my-auto'>CHANGES PENDING FOR APPROVAL";
    //             }
    //             else
    //             {
    //                 echo "'>";
    //             }

    //             echo "      </div>
    //                         <button class='btn btn-primary' style='width:100px;' onclick='javascript:editEnable()'>EDIT</button> &nbsp;
    //                         <button class='btn btn-primary btn-save' style='width:100px;' disabled onclick='javascript:UpdateEducation(\"EDIT\")'>SAVE</button>
    //                     </div>
    //                     <div class='col-12 content-block-info'>
    //                         <div class='row px-2 profileSettings-SubtitleContainer'>
    //                             <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                         </div>
    //                         <div class='row'>
    //                             <ul class='w-100'>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Post-graduate School: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-0' class='w-100' value='". $r['post_grad'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Course Taken: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-1' class='w-100' value='" . $r['post_grad_course'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Graduation Date: </b></div>
    //                                         <div class='col-sm-7 labelInfo dateDisplay'>";
    //                                             if (date('F d, Y', strtotime($r['post_grad_date'])) ==  "January 01, 1900") { echo "Please fill up if applicable"; }
    //                                             else { echo date('F d, Y', strtotime($r['post_grad_date'])); }

    //             echo "
    //                                         </div>
    //                                         <div class='col-sm-7 labelInfo dateEdit' style='display:none;'><input type='date' id='p-2' class='w-100' value='";
    //                                         if (date('F d, Y', strtotime($r['post_grad_date'])) ==  "January 01, 1900") { echo "1900-01-01"; }
    //                                         else { echo date('Y-m-d', strtotime($r['post_grad_date'])); }
    //             echo "'></div>
    //                                     </div>
    //                                 </li>
    //                             </ul>
    //                         </div>

    //                     <div class='row px-2 profileSettings-SubtitleContainer'>
    //                         <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                     </div>
    //                         <div class='row'>
    //                             <ul class='w-100'>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>College School: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-3' class='w-100' value='" . $r['college'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Course Taken: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-4' class='w-100' value='" . $r['course_taken'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Graduation Date: </b></div>
    //                                         <div class='col-sm-7 labelInfo dateDisplay'>";
    //                                             if (date('F d, Y', strtotime($r['college_graduated'])) ==  "January 01, 1900") { echo "Please fill up if applicable"; }
    //                                             else { echo date('F d, Y', strtotime($r['college_graduated'])); }
    //             echo "
    //                                         </div>
    //                                         <div class='col-sm-7 labelInfo dateEdit' style='display:none;'><input type='date' id='p-5' class='w-100' value='";
    //                                         if (date('F d, Y', strtotime($r['college_graduated'])) ==  "January 01, 1900") { echo "1900-01-01"; }
    //                                         else { echo date('Y-m-d', strtotime($r['college_graduated'])); }
    //             echo "'></div>
    //                                     </div>
    //                                 </li>
    //                             </ul>
    //                         </div>

    //                     <div class='row px-2 profileSettings-SubtitleContainer'>
    //                         <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                     </div>
    //                             <div class='row'>
    //                                 <ul class='w-100'>
    //                                     <li>
    //                                         <div class='row'>
    //                                             <div class='col-sm-2 labelHead'><b>Highschool School: </b></div>
    //                                             <div class='col-sm-7 labelInfo'><input type='text' id='p-6' class='w-100' value='" . $r['highschool'] . "' autocomplete='off' disabled></div>
    //                                         </div>
    //                                     </li>
    //                                     <li>
    //                                         <div class='row'>
    //                                             <div class='col-sm-2 labelHead'><b>Graduation Date: </b></div>
    //                                             <div class='col-sm-7 labelInfo dateDisplay'>";
    //                                             if (date('F d, Y', strtotime($r['high_graduated'])) ==  "January 01, 1900") { echo "Please fill up if applicable"; }
    //                                             else { echo date('F d, Y', strtotime($r['high_graduated'])); }
    //             echo "
    //                                         </div>
    //                                         <div class='col-sm-7 labelInfo dateEdit' style='display:none;'><input type='date' id='p-7' class='w-100' value='";
    //                                         if (date('F d, Y', strtotime($r['high_graduated'])) ==  "January 01, 1900") { echo "1900-01-01"; }
    //                                         else { echo date('Y-m-d', strtotime($r['high_graduated'])); }
    //             echo "'></div>
    //                                         </div>
    //                                     </li>
    //                                 </ul>
    //                             </div>

    //                     <div class='row px-2 profileSettings-SubtitleContainer'>
    //                         <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                     </div>

    //                         <div class='row'>
    //                             <ul class='w-100'>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Elementary School: </b></div>
    //                                         <div class='col-sm-7 labelInfo'><input type='text' id='p-8' class='w-100' value='" . $r['elementary'] . "' autocomplete='off' disabled></div>
    //                                     </div>
    //                                 </li>
    //                                 <li>
    //                                     <div class='row'>
    //                                         <div class='col-sm-2 labelHead'><b>Graduation Date: </b></div>
    //                                         <div class='col-sm-7 labelInfo dateDisplay'>";
    //                                             if (date('F d, Y', strtotime($r['elem_graduated'])) ==  "January 01, 1900") { echo "Please fill up if applicable"; }
    //                                             else { echo date('F d, Y', strtotime($r['elem_graduated'])); }
                     
    //             echo "
    //                                         </div>
    //                                         <div class='col-sm-7 labelInfo dateEdit' style='display:none;'><input type='date' id='p-9' class='w-100' value='";
    //                                         if (date('F d, Y', strtotime($r['elem_graduated'])) ==  "January 01, 1900") { echo "1900-01-01"; }
    //                                         else { echo date('Y-m-d', strtotime($r['elem_graduated'])); }
    //             echo "'></div>
    //                                     </div>
    //                                 </li>
    //                             </ul>
    //                         </div>";
    //         }
    //     }
    //     else
    //     {
    //         echo "<div class='d-flex justify-content-center'>
    //                 <h4>There is no record found for your educational background. Please contact HR!</h4>
    //             </div>";
    //     }

    //     echo "<div class='row px-2 profileSettings-SubtitleContainer'>
    //                     <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                 </div>
    //             </div>
    //         </div>
    //         <script type='text/javascript'>
    //             function UpdateEducation(act)
    //             {
    //                 if (confirm('Are you sure you want to update your educational background information?'))
    //                 {
    //                     var url = '../controller/profileSettingsProcess.php';
    //                     var data = [
    //                         $('#p-0').val(), $('#p-1').val(), $('#p-2').val(), $('#p-3').val(),
    //                         $('#p-4').val(), $('#p-5').val(), $('#p-6').val(), $('#p-7').val(),
    //                         $('#p-8').val(), $('#p-9').val()
    //                     ];

    //                     $.post (
    //                         url,
    //                         {
    //                             empId: '" . $empId . "',
    //                             option: 2,
    //                             action: act,
    //                             info: data
    //                         },
    //                         function(data) { $('#contents-info').html(data).show(); }
    //                     );
    //                 }
    //             }
    //         </script>";
    // }

    // function ShowSettings($empId)
    // {
    //     global $connL;

    //     $cmd = $connL->prepare(@"SELECT * from dbo.mf_user where userid = :emp");
    //     $cmd->bindValue(':emp', $empId);
    //     $cmd->execute();

    //     echo "<div class='row contents-info-accdetails'>";

    //     while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
    //     {
    //         echo "
    //             <div class='col-12'>
    //                 <div class='row px-2 profileSettings-SubtitleContainer'>
    //                     <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                 </div>
    //                     <div class='row'>
    //                         <ul class='w-100'>
    //                             <li>
    //                                 <div class='row'>
    //                                     <div class='col-sm-2 labelHead'><b>User Name: </b></div>
    //                                     <div class='col-sm-7 labelInfo'>" . $r['username'] . "</div>
    //                                 </div>
    //                             </li>
    //                             <li>
    //                                 <div class='row'>
    //                                     <div class='col-sm-2 labelHead'><b>User ID: </b></div>
    //                                     <div class='col-sm-7 labelInfo'>" . $r['userid'] . "</div>
    //                                 </div>
    //                             </li>
    //                             <li>
    //                                 <div class='row'>
    //                                     <div class='col-sm-2 labelHead'><b>Email Address: </b></div>
    //                                     <div class='col-sm-7 labelInfo'>" . $r['useremail'] . "</div>
    //                                 </div>
    //                             </li>
    //                         </ul>
    //                     </div>
    //                 <div class='row px-2 profileSettings-SubtitleContainer'>
    //                     <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                 </div>
    //                 <div class='row'>
    //                     <ul class='w-100'>
    //                         <li>
    //                             <div class='row'>
    //                                 <div class='col-sm-2 labelHead'><b>New Password: </b></div>
    //                                 <div class='col-sm-7 labelInfo'><input type='password' id='password1' class='w-100 edit' autocomplete='off'></div>
    //                             </div>
    //                         </li>
    //                         <li>
    //                             <div class='row'>
    //                                 <div class='col-sm-2 labelHead'><b>Confirm Password: </b></div>
    //                                 <div class='col-sm-7 labelInfo'><input type='password' id='password2' class='w-100 edit' autocomplete='off'></div>
    //                             </div>
    //                         </li>
    //                         <li>
    //                             <div class='row'>
    //                                 <div class='col-4'>
    //                                     <ul>
    //                                         <li class='labelInfo'><small id='8charContainer' style='color:#FF0004;'><i id='8char' class='fa fa-times'></i> 8 Characters Long</small></li>
    //                                         <li class='labelInfo'><small id='ucaseContainer' style='color:#FF0004;'><i id='ucase' class='fa fa-times'></i> One Uppercase Letter</small></li>
    //                                     </ul>
    //                                 </div>
    //                                 <div class='col-4'>
    //                                     <ul>
    //                                         <li class='labelInfo'><small id='lcaseContainer' style='color:#FF0004;'><i id='lcase' class='fa fa-times'></i> One Lower Case</small></li>
    //                                         <li class='labelInfo'><small id='numContainer' style='color:#FF0004;'><i id='num' class='fa fa-times'></i> One Number</small></li>
    //                                     </ul>
    //                                 </div>
    //                                 <div class='col-4'>
    //                                     <ul>
    //                                         <li class='labelInfo'><small id='pwmatchContainer' style='color:#FF0004;'><i id='pwmatch' class='fa fa-times'></i> Passwords Match</small></li>
    //                                     </ul>
    //                                 </div>
    //                             </div>
    //                         </li>
    //                         <li>
    //                             <div class='d-flex justify-content-start py-1'>
    //                                 <input type='submit' class='btn btn-primary' data-loading-text='Changing Password...' name='change-pass-btn' id='change-pass-btn' value='Change Password' disabled style='width:18%;' onclick='javascript:UpdatePassword(\"EDIT\")'>
    //                             </div>
    //                         </li>
    //                     </ul>
    //                 </div>
    //                 <div class='row px-2 profileSettings-SubtitleContainer'>
    //                     <h4 class='profileSettings-Subtitle'>&nbsp;</h4>
    //                 </div>
    //             </div>
    //             <script type='text/javascript' src='../js/passwordValidator.js'></script>
    //             <script type='text/javascript'>
    //                 function UpdatePassword(act)
    //                 {
    //                     if (confirm('Are you sure you want to update your password?'))
    //                     {
    //                         var url = '../controller/profileSettingsProcess.php';
    //                         var pw = $('#password1').val();

    //                         $.post (
    //                             url,
    //                             {
    //                                 empId: '" . $empId . "',
    //                                 option: 3,
    //                                 action: act,
    //                                 pass: pw
    //                             },
    //                             function(data) { $('#contents-info').html(data).show(); }
    //                         );
    //                     }
    //                 }
    //             </script>";
    //     }
    // }

    // // EDITING

    // function EditBasicDetails($empId, $data)
    // {
    //     global $connL;

    //     $cmd = $connL->prepare(@"UPDATE dbo.employee_profile SET 
    //         bloodtype = :blood,
    //         birthdate = :bday,
    //         civilstatus = :civ,
    //         emp_address = :addr,
    //         emp_address2 = :addr2,
    //         celno = :cp,
    //         celno1 = :cp2,
    //         telno = :tel,
    //         emailaddress = :email,
    //         prc_lic = :prc,
    //         prc_expirydate = :prcdate,
    //         driver_lic = :driver,
    //         expirydate = :driverdate,
    //         tin_no = :tin,
    //         sss_no = :sss,
    //         phil_no = :phl,
    //         pagibig_no = :ibig,
    //         audituser = :auduser,
    //         auditdate = :auddate,
    //         approved_edit = 1 WHERE emp_code = :emp");

    //     $cmd->bindValue(':emp', $empId);
    //     $cmd->bindValue(':auduser', $empId);
    //     $cmd->bindValue(':auddate', date('Y-m-d H:i:s'));
    //     $cmd->bindValue(':blood', $data[0]);
    //     $cmd->bindValue(':bday', date('Y-m-d', strtotime($data[1])));
    //     $cmd->bindValue(':civ', $data[2]);
    //     $cmd->bindValue(':addr', $data[3]);
    //     $cmd->bindValue(':addr2', $data[4]);
    //     $cmd->bindValue(':cp', $data[5]);
    //     $cmd->bindValue(':cp2', $data[6]);
    //     $cmd->bindValue(':tel', $data[7]);
    //     $cmd->bindValue(':email', $data[8]);
    //     $cmd->bindValue(':prc', $data[9]);
    //     $cmd->bindValue(':prcdate', date('Y-m-d', strtotime($data[10])));
    //     $cmd->bindValue(':driver', $data[11]);
    //     $cmd->bindValue(':driverdate', date('Y-m-d', strtotime($data[12])));
    //     $cmd->bindValue(':tin', $data[13]);
    //     $cmd->bindValue(':sss', $data[14]);
    //     $cmd->bindValue(':phl', $data[15]);
    //     $cmd->bindValue(':ibig', $data[16]);
    //     $cmd->execute();
        
    //     echo "<span class='etcMessage'>
    //             <script type='text/javascript'>
    //                 alert('Your personal details are updated successfully!');
    //                 $('.etcMessage').remove();
    //             </script>
    //         </span>";
    // }
    
    // function EditFamilyDetails($empId, $data)
    // {
    //     global $connL;

    //     $cmd = $connL->prepare(@"UPDATE dbo.employee_family_background SET 
    //         name_of_father = :nameFather,
    //         name_of_mother = :nameMother,
    //         fam_address = :addrFam,
    //         contact_person = :contactPerson,
    //         contact_no = :contactNum,
    //         contact_address = :contactAddr,
    //         name_of_spouse = :nameSpouse,
    //         birthdate = :bday,
    //         occupation = :occ,
    //         tinno_of_spouse = :tinSpouse,
    //         sss_of_spouse = :sssSpouse,
    //         relative_name = :nameRelative,
    //         relative_relation = :nameRelation,
    //         audituser = :auduser,
    //         auditdate = :auddate,
    //         approved_edit = 1 WHERE emp_code = :emp");

    //     $cmd->bindValue(':emp', $empId);
    //     $cmd->bindValue(':auduser', $empId);
    //     $cmd->bindValue(':auddate', date('Y-m-d H:i:s'));
    //     $cmd->bindValue(':nameFather', $data[0]);
    //     $cmd->bindValue(':nameMother', $data[1]);
    //     $cmd->bindValue(':addrFam', $data[2]);
    //     $cmd->bindValue(':contactPerson', $data[3]);
    //     $cmd->bindValue(':contactNum', $data[4]);
    //     $cmd->bindValue(':contactAddr', $data[5]);
    //     $cmd->bindValue(':nameSpouse', $data[6]);
    //     $cmd->bindValue(':bday', date('Y-m-d', strtotime($data[7])));
    //     $cmd->bindValue(':occ', $data[8]);
    //     $cmd->bindValue(':tinSpouse', $data[9]);
    //     $cmd->bindValue(':sssSpouse', $data[10]);
    //     $cmd->bindValue(':nameRelative', $data[11]);
    //     $cmd->bindValue(':nameRelation', $data[12]);
    //     $cmd->execute();
        
    //     echo "<span class='etcMessage'>
    //             <scrip type='text/javascript't>
    //                 alert('Your family background information are updated successfully!');
    //                 $('.etcMessage').remove();
    //             </script>
    //         </span>";
    // }
    
    // function EditEducationDetails($empId, $data)
    // {
    //     global $connL;

    //     $cmd = $connL->prepare(@"UPDATE dbo.employee_others SET 
    //         post_grad = :ps,
    //         post_grad_course = :pc,
    //         post_grad_date = :pd,
    //         college = :cs,
    //         course_taken = :cc,
    //         college_graduated = :cd,
    //         highschool = :hs,
    //         high_graduated = :hd,
    //         elementary = :ec,
    //         elem_graduated = :ed,
    //         audituser = :auduser,
    //         auditdate = :auddate,
    //         approved_edit = 1 WHERE emp_code = :emp");

    //     $cmd->bindValue(':emp', $empId);
    //     $cmd->bindValue(':auduser', $empId);
    //     $cmd->bindValue(':auddate', date('Y-m-d H:i:s'));
    //     $cmd->bindValue(':ps', $data[0]);
    //     $cmd->bindValue(':pc', $data[1]);
    //     $cmd->bindValue(':pd', date('Y-m-d', strtotime($data[2])));
    //     $cmd->bindValue(':cs', $data[3]);
    //     $cmd->bindValue(':cc', $data[4]);
    //     $cmd->bindValue(':cd', date('Y-m-d', strtotime($data[5])));
    //     $cmd->bindValue(':hs', $data[6]);
    //     $cmd->bindValue(':hd', date('Y-m-d', strtotime($data[7])));
    //     $cmd->bindValue(':ec', $data[8]);
    //     $cmd->bindValue(':ed', date('Y-m-d', strtotime($data[9])));
    //     $cmd->execute();

    //     echo "<span class='etcMessage'>
    //             <script type='text/javascript'>
    //                 alert('Your educational background information are updated successfully!');
    //                 $('.etcMessage').remove();
    //             </script>
    //         </span>";
    // }

    // function EditPassword($empId, $password)
    // {
    //     global $connL;

    //     echo "<span class='etcMessage'><script type='text/javascript'>";

    //     if (strlen($password) >= 8 && preg_match('/[A-Z]/', $password) && preg_match('/[0-9]/', $password) && preg_match('/[a-z]/', $password))
    //     {
    //         $hash_password = hash('sha256', $password);

    //         $cmd = $connL->prepare(@"UPDATE dbo.mf_user SET userpassword = :pass WHERE userid =:emp");
    //         $cmd->bindValue(':emp', $empId);
    //         $cmd->bindParam(":pass", $hash_password,PDO::PARAM_STR);
    //         $cmd->execute();

    //         echo "alert('Successfully updated password!');";
    //     }
    //     else { echo "alert('Password does not match criteria!');"; }

    //     echo "$('.etcMessage').remove();</script></span>";
    // }

?>