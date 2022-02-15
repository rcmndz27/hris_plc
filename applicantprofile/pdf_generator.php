<?php

session_start();

require_once( 'TCPDF/tcpdf.php' );

include('config.php');


$applicantcode = ( isset($_GET['data']) ) ? $_GET['data']: '0';


global $conn;

$sql = 'SELECT * FROM applicantprofile_full WHERE applicantcode = :applicantcode';
$cmd = $conn->prepare($sql);
$param = array(":applicantcode" => $applicantcode);
$cmd->execute($param);


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetHeaderData('../img/logo.png',20,'HRIS PORTAL','Applicant Profile');

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->SetFont('helvetica', '', 11);
$pdf->AddPage();

$html = '';

while ($row = $cmd->fetch())
{
    
    if(!empty($row['applicantpic'])){
        $imageContent = file_get_contents($row['applicantpic']);
        $path = tempnam(sys_get_temp_dir(), 'prefix');
        file_put_contents ($path, $imageContent);

        $img = '<span><img src="'.$path.'" alt="applicantpic" width="100" height="100" border="0"/></span>';

    }else{

        $img = '';
    }

    $html.=
    '<strong>Personal Information</strong>'.
    '<hr>'.
    '<div> </div>'.
    '<table>
        <thead>
            <tr>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>'.
                    '<strong>Applicant Code : '.$row['applicantcode'].'</strong>'.
                    '<br>'.
                    '<strong>Applying for Position : '.$row['applicantposition'].'</strong>'.
                    '<br>'.
                    'Applicant Name : '.$row['lastname'].', '.$row['firstname'].' '.$row['middlename'].
                    '<br>'.
                    'Gender : '.$row['gender'].
                    '<br>'.
                    'Bloodtype : '.$row['bloodtype'].
                    '<br>'.
                    'Civil Status : '.trim($row['civilstatus']).
                    '<br>'.
                    'Birthday : '.date('Y-m-d',strtotime($row['birthday'])).
                    '<br>'.
                    'Email Address : '.$row['emailaddress'].
                    '<br>'.
                    'Telephone No. : '.$row['telno'].
                    '<br>'.
                    'Cellphone No. : '.$row['celno'].
                    '<br>'.
                    'Other Cellphone No. : '.$row['celno1'].
                    '<br>'.
                    'Present Address : '.$row['presentaddress'].
                    '<br>'.
                    'Permanent Address : '.$row['permanentaddress'].
                    '<br>'.
                    'TIN No. : '.$row['tin_no'].
                    '<br>'.
                    'SSS No. : '.$row['sss_no'].
                    '<br>'.
                    'PHILHEALTH No. : '.$row['phil_no'].
                    '<br>'.
                    'PAGIBIG No. : '.$row['pagibig_no'].
                    '<br>'.
                    'PRC License : '.$row['prclicense'].
                    '<br>'.
                    'PRC License Expirydate : '.date('Y-m-d',strtotime($row['prcexpirydate'])).
                    '<br>'.
                    'Drivers License : '.$row['driverslicense'].
                    '<br>'.
                    'Drivers License Expirydate : '.date('Y-m-d',strtotime($row['driversexpirydate'])).
                '</td>
                <td style="text-align:right;">'
                    .$img.
                '</td>
            </tr>    
        </tbody>
    </table><br><br>';

    // $html.=
    //     '<span style="text-align:right;"><img src="'.$path.'" alt="applicantpic" width="100" height="100" border="0" /></span>'.
    //     '<br><br>'.
    //     '<strong>Personal Information</strong>'.
    //     '<hr>'.
    //     '<div> </div>'.
    //     '<strong>Applicant Code : '.$row['applicantcode'].'</strong>'.
    //     '<br>'.
    //     '<strong>Applying for Position : '.$row['applicantposition'].'</strong>'.
    //     '<br>'.
    //     'Applicant Name : '.$row['lastname'].', '.$row['firstname'].' '.$row['middlename'].
    //     '<br>'.
    //     'Gender : '.$row['gender'].
    //     '<br>'.
    //     'Bloodtype : '.$row['bloodtype'].
    //     '<br>'.
    //     'Civil Status : '.trim($row['civilstatus']).
    //     '<br>'.
    //     'Birthday : '.date('Y-m-d',strtotime($row['birthday'])).
    //     '<br>'.
    //     'Email Address : '.$row['emailaddress'].
    //     '<br>'.
    //     'Telephone No. : '.$row['telno'].
    //     '<br>'.
    //     'Cellphone No. : '.$row['celno'].
    //     '<br>'.
    //     'Other Cellphone No. : '.$row['celno1'].
    //     '<br>'.
    //     'Present Address : '.$row['presentaddress'].
    //     '<br>'.
    //     'Permanent Address : '.$row['permanentaddress'].
    //     '<br>'.
    //     'TIN No. : '.$row['tin'].
    //     '<br>'.
    //     'SSS No. : '.$row['sss'].
    //     '<br>'.
    //     'PHILHEALTH No. : '.$row['philhealth'].
    //     '<br>'.
    //     'PAGIBIG No. : '.$row['pagibig'].
    //     '<br>'.
    //     'PRC License : '.$row['prclicense'].
    //     '<br>'.
    //     'PRC License Expirydate : '.date('Y-m-d',strtotime($row['prcexpirydate'])).
    //     '<br>'.
    //     'Drivers License : '.$row['driverslicense'].
    //     '<br>'.
    //     'Drivers License Expirydate : '.date('Y-m-d',strtotime($row['driversexpirydate'])).'<br><br>';
    
        // $html.=
        // '
        // <strong>Educational Information</strong>
        // <hr>
        // <div></div>
        // <table>
        //     <thead>
        //         <tr>
        //             <th>Level</th>
        //             <th>School</th>
        //             <th>Year</th>
        //             <th>Course</th>
        //         </tr>
        //     </thead>
        //     <tbody>
        //         <tr>
        //             <td>Elementary</td>
        //             <td>'.$row['elementary'].'</td>
        //             <td>'.date('Y-m-d',strtotime($row['elementarydate'])).'</td>
        //             <td>'.''.'</td>
        //         </tr>
        //         <tr>
        //             <td>Highschool</td>
        //             <td>'.$row['highschool'].'</td>
        //             <td>'.date('Y-m-d',strtotime($row['highschooldate'])).'</td>
        //             <td></td>
        //         </tr>
        //         <tr>
        //             <td>College</td>
        //             <td>'.$row['college'].'</td>
        //             <td>'.date('Y-m-d',strtotime($row['collegedate'])).'</td>
        //             <td>'.'</td>
        //         </tr>
        //         <tr>
        //             <td>Master&#39;s</td>
        //             <td>'.$row['higherstudies'].'</td>
        //             <td>'.date('Y-m-d',strtotime($row['higherstudiesdate'])).'</td>
        //             <td>'.'</td>
        //         </tr>
        //     </tbody>
        // </table><br><br>';

    $html.=
        '<strong>Educational Information</strong>
        <hr>
        <div></div>

        Master&#39;s : '.$row['higherstudies'].
        '<br>'.
        'Year : '.date('Y-m-d',strtotime($row['higherstudiesdate'])).
        '<br>'.
        'Course : '.$row['highercourse'].

        '<br><br>'.

        'College : '.$row['college'].
        '<br>'.
        'Year : '.date('Y-m-d',strtotime($row['collegedate'])).
        '<br>'.
        'Course : '.$row['collegecourse'].
        
        '<br><br>'.

        'Highschool : '.$row['highschool'].
        '<br>'.
        'Year : '.date('Y-m-d',strtotime($row['highschooldate'])).

        '<br><br>'.
        
        'Elementary : '.$row['elementary'].
        '<br>'.
        'Year : '.date('Y-m-d',strtotime($row['elementarydate'])).
        '<br><br>';

    
    $html.=
        '<strong>Job History</strong>
        <hr>
        <div></div>'.

        'Employer : '.$row['employer1'].
        '<br>'.
        "Contact : ".$row['employercontactno1'].
        '<br>'.
        'Position Held : '.$row['positionheld1'].
        '<br>'.
        'Salary : '.$row['salary1'].
        '<br>'.
        'Month of Service : '.$row['monthsofservice1'].
        '<br>'.
        'Reason for Leaving : '.$row['reasonforleaving1'].
        '<br><br>'.

        'Employer : '.$row['employer2'].
        '<br>'.
        'Contact : '.$row['employercontactno2'].
        '<br>'.
        'Position Held : '.$row['positionheld2'].
        '<br>'.
        'Salary : '.$row['salary2'].
        '<br>'.
        'Month of Service : '.$row['monthsofservice2'].
        '<br>'.
        'Reason for Leaving : '.$row['reasonforleaving2'].
        '<br><br>'.
        
        'Employer : '.$row['employer3'].
        '<br>'.
        'Contact : '.$row['employercontactno3'].
        '<br>'.
        'Position Held : '.$row['positionheld3'].
        '<br>'.
        'Salary : '.$row['salary3'].
        '<br>'.
        'Month of Service : '.$row['monthsofservice3'].
        '<br>'.
        'Reason for Leaving : '.$row['reasonforleaving3'].
        '<br><br>';

    $html.=
        '<strong>References</strong>
        <hr>
        <div></div>'.

        'Name : '.$row['refname1'].
        '<br>'.
        'Contact : '.$row['refcontactno1'].
        '<br>'.
        'Email : '.$row['refemail1'].
        '<br>'.
        'Company : '.$row['refcompany1'].
        '<br>'.
        'Position : '.$row['refposition1'].
        '<br><br>'.
        'Name : '.$row['refname2'].
        '<br>'.
        'Contact : '.$row['refcontactno2'].
        '<br>'.
        'Email : '.$row['refemail2'].
        '<br>'.
        'Company : '.$row['refcompany2'].
        '<br>'.
        'Position : '.$row['refposition2'].
        '<br><br>'.
        'Name : '.$row['refname3'].
        '<br>'.
        'Contact : '.$row['refcontactno3'].
        '<br>'.
        'Email : '.$row['refemail3'].
        '<br>'.
        'Company : '.$row['refcompany3'].
        '<br>'.
        'Position : '.$row['refposition3'].'<br><br>';
    

    // $html.=
    // '
    // <table>
    //     <thead>
    //         <tr>
    //             <th>Employer</th>
    //             <th>Contact</th>
    //             <th>Position Held</th>
    //             <th>Salary</th>
    //             <th>Month of Service</th>
    //             <th>Reason for Leaving</th>
    //         </tr>
    //     </thead>
    //     <tbody>
    //         <tr>
    //             <td>'.$row['employer1'].'</td>
    //             <td>'.$row['employercontactno1'].'</td>
    //             <td>'.$row['positionheld1'].'</td>
    //             <td>'.$row['salary1'].'</td>
    //             <td>'.$row['monthsofservice1'].'</td>
    //             <td>'.$row['reasonforleaving1'].'</td>
    //         </tr>
    //         <tr>
    //             <td>'.$row['employer2'].'</td>
    //             <td>'.$row['employercontactno2'].'</td>
    //             <td>'.$row['positionheld2'].'</td>
    //             <td>'.$row['salary2'].'</td>
    //             <td>'.$row['monthsofservice2'].'</td>
    //             <td>'.$row['reasonforleaving2'].'</td>
    //         </tr>
    //         <tr>
    //             <td>'.$row['employer3'].'</td>
    //             <td>'.$row['employercontactno3'].'</td>
    //             <td>'.$row['positionheld3'].'</td>
    //             <td>'.$row['salary3'].'</td>
    //             <td>'.$row['monthsofservice3'].'</td>
    //             <td>'.$row['reasonforleaving3'].'</td>
    //         </tr>
    //     </tbody>
    // </table><br><br>';

    
    $html.=    
        '<strong>Family Information</strong>'.
        '<hr>'.
        '<div> </div>'.
        'Mother : '.$row['name_of_mother'].
        '<br>'.
        'Address : '.$row['mother_address'].
        '<br>'.
        'Contact No. : '.$row['mother_contactno'].
        '<br><br>'.
        'Father'.$row['name_of_father'].
        '<br>'.
        'Address : '.$row['father_address'].
        '<br>'.
        'Contact No. : '.$row['father_contactno'];

    if(trim($row['civilstatus']) != 'Single'){
        
        
    $html.=
        '<br>'.
        '<br>'.
        'Spouse : '.$row['name_of_spouse'].
        '<br>'.
        'Birthday : '.date('Y-m-d',strtotime($row['birthdate'])).
        '<br>'.
        'Occupation : '.$row['occupation'].
        '<br>'.
        'TIN : '.$row['tinno_of_spouse'].
        '<br>'.
        'SSS : '.$row['sss_of_spouse'].
        '<br><br>'.

        'Child : '.$row['child1'].
        '<br>'.
        'Birthdate : '.date('Y-m-d',strtotime($row['child1_dob'])).
        '<br>'.
        'Gender : '.$row['gender1'].
        '<br><br>'.
        'Child : '.$row['child2'].
        '<br>'.
        'Birthdate : '.date('Y-m-d',strtotime($row['child2_dob'])).
        '<br>'.
        'Gender : '.$row['gender2'].
        '<br><br>'.
        'Child : '.$row['child3'].
        '<br>'.
        'Birthdate : '.date('Y-m-d',strtotime($row['child3_dob'])).
        '<br>'.
        'Gender : '.$row['gender3'].
        '<br><br>'.
        'Child : '.$row['child4'].
        '<br>'.
        'Birthdate : '.date('Y-m-d',strtotime($row['child4_dob'])). 
        '<br>'.
        'Gender : '.$row['gender4'].
        '<br><br>'.
        'Child : '.$row['child5'].
        '<br>'.
        'Birthdate : '.date('Y-m-d',strtotime($row['child5_dob'])).
        '<br>'.
        'Gender : '.$row['gender5'].
        '<br>';
    }
    $html.='<br><br><br><br><br>';    

    $html.=
        '<strong>Incase of Emergency</strong>'.
        '<br><br>'.
        'Contact Person : '.$row['contact_person'].
        '<br>'.
        'Contact No. : '.$row['contact_no'].
        '<br>'.
        'Contact Address : '.$row['contact_address'].
        '<br><br>'.
        'Contact Person : '.$row['contact_person'].
        '<br>'.
        'Contact No. : '.$row['contact_no'].
        '<br>'.
        'Contact Address : '.$row['contact_address'].
        '<br>'.
        '<br>'.
        'PMI Employee : '.$row['relative_name'].
        '<br>'.
        'PMI Employee Relationship : '.$row['relative_relation'].
        '<br><br>';

    
    $html.='<strong>Other Information</strong>'.
        '<hr>'.
        '<div> </div>'.
        'Skills : '.$row['skillset'].
        '<br><br>'.
        '<strong>Have been convicted to any crimes : </strong>'.$row['convictedtocrimes'].
        '<br>'.
        '<strong>Details : </strong>'.$row['crimedetails'].
        '<br><br>'.
        '<strong>Have been hospitalized : </strong>'.$row['hospitalized'].
        '<br>'.
        '<strong>Details : </strong>'.$row['hospitalizationdetails'].
        '<br><br>'.
        '<strong>Explain why you should be considered for the position</strong>'.
        '<p style="text-align:justify;">'.$row['explanations'].'</p><br><br>';
    
    $html.='<br><br><br><br><br>';

    $html.='<span style="text-align:center;"><strong>Certification</strong></span>
    <p style="text-align:justify;">
    I hereby affirm to the best of my knowledge and belief that all the answer to the foregoing are true and correct.
    I acknowledge that filling of this application does not entitle me to any acquired right and Premium Megastructures Inc. (PMI) may dispose of this application in any manner it so desires.
    I also authorized Premium Megastructures Inc. (PMI) to inquire as to my record from any or all my former employers with no liability arising therefrom.</p>';    
    $html.='<br><span style="text-align:justify;">
    I futher acknowledge that any misreprentation in the foregoing answers and data shall be sufficient ground for my dismissal if already employed in 
    Premium Megastructures Inc. (PMI).</span>';

    $html.='<br><br><br><br><br>';

   

    $html.=''.$row['firstname'].' '.$row['middlename'].' '.$row['lastname'].'<br>'.
        'Applicant';
    
}


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('example_003.pdf', 'I');

?>