<?php
    include("applicantprofile.php");

    $applicantProfile = json_decode($_POST["data"]);
   
    if($applicantProfile->{"Action"} == "Insert")
    {
        
        $ActiveForm = $applicantProfile->{"ActiveForm"};
        
        switch ($ActiveForm)
        {
            case "Family":
                
                $applicantcode = $applicantProfile->{"applicantcode"};
                $civilstatus = $applicantProfile->{"civilstatus"};
                $mother = $applicantProfile->{"mother"};
                $mother_address = $applicantProfile->{"motherAddress"};
                $mother_contactno = $applicantProfile->{"motherContact"};
                
                $father = $applicantProfile->{"father"};
                $father_address = $applicantProfile->{"fatherAddress"};
                $father_contactno = $applicantProfile->{"fatherContact"};

                $spouse = $applicantProfile->{"spouse"};
                $spouse_occupation = $applicantProfile->{"spouseOccupation"};
                $spouse_tin = $applicantProfile->{"spouseTIN"};
                $spouse_sss = $applicantProfile->{"spouseSSS"};
                
                $child1 = $applicantProfile->{"child1"};
                $child1_gender = $applicantProfile->{"child1Gender"};

                $child2 = $applicantProfile->{"child2"};
                $child2_gender = $applicantProfile->{"child2Gender"};
                
                $child3 = $applicantProfile->{"child3"};
                $child3_gender = $applicantProfile->{"child3Gender"};
                
                $child4 = $applicantProfile->{"child4"};
                $child4_gender = $applicantProfile->{"child4Gender"};
                
                $child5 = $applicantProfile->{"child5"};
                $child5_gender = $applicantProfile->{"child5Gender"};
                
                $contact_person = $applicantProfile->{"contactPerson"};
                $contact_no = $applicantProfile->{"contactNumber"};
                $contact_address = $applicantProfile->{"contactAddress"};

                $contact_person1 = $applicantProfile->{"contactPerson1"};
                $contact_no1 = $applicantProfile->{"contactNumber1"};
                $contact_address1 = $applicantProfile->{"contactAddress1"};
                
                $company_personel = $applicantProfile->{"companyPersonel"};
                $company_personel_relationship = $applicantProfile->{"companyPersonelRelationship"};
                
                if($civilstatus !=='single'){
                    $spouse_birthdate = $applicantProfile->{"spouseBirthdate"};
                    $child1_birthdate = $applicantProfile->{"child1Birthdate"};
                    $child2_birthdate = $applicantProfile->{"child2Birthdate"};
                    $child3_birthdate = $applicantProfile->{"child3Birthdate"};
                    $child4_birthdate = $applicantProfile->{"child4Birthdate"};
                    $child5_birthdate = $applicantProfile->{"child5Birthdate"};
                }else{
                    $spouse_birthdate = '';
                    $child1_birthdate = '';
                    $child2_birthdate = '';
                    $child3_birthdate = '';
                    $child4_birthdate = '';
                    $child5_birthdate = '';
                }
                
                AddFamilyInformation($applicantcode,$mother,$mother_address,$mother_contactno,$father,$father_address,$father_contactno,
                $spouse,$spouse_birthdate,$spouse_occupation,$spouse_tin,$spouse_sss,
                $child1,$child1_birthdate,$child1_gender,
                $child2,$child2_birthdate,$child2_gender,
                $child3,$child3_birthdate,$child3_gender,
                $child4,$child4_birthdate,$child4_gender,
                $child5,$child5_gender,$child5_birthdate,
                $contact_person,$contact_no,$contact_address,
                $contact_person1,$contact_no1,$contact_address1,
                $company_personel,$company_personel_relationship);
                        
            break;
            case "Education":
                
                $applicantcode = $applicantProfile->{"applicantcode"};
                $elementary = $applicantProfile->{"elementary"};
                
                $elementary_date = $applicantProfile->{"elementaryDate"};
                $highschool = $applicantProfile->{"highschool"};
                
                $highschool_date = $applicantProfile->{"highschoolDate"};
                $college = $applicantProfile->{"college"};
                $course = $applicantProfile->{"course"};
                $college_date = $applicantProfile->{"collegeDate"};
                $higherstudies = $applicantProfile->{"higherstudies"};
                $higherstudies_course = $applicantProfile->{"higherstudiesCourse"};
                $higherstudies_date = $applicantProfile->{"higherstudiesDate"};
                
                AddEducationInformation($applicantcode,$elementary,$elementary_date,$highschool,$highschool_date,$college,$course,$college_date,$higherstudies,$higherstudies_course,$higherstudies_date);
                
            break;
            case "JobHistory":
                
                $applicantcode = $applicantProfile->{"applicantcode"};

                $employer1 = $applicantProfile->{"employer1"};
                $employerContanctNo1 = $applicantProfile->{"employerContanctNo1"};
                $positionHeld1 = $applicantProfile->{"positionHeld1"};
                $salary1 = $applicantProfile->{"salary1"};
                $monthsOfService1 = $applicantProfile->{"monthsOfService1"};
                $reasonForLeaving1 = $applicantProfile->{"reasonForLeaving1"};

                $employer2 = $applicantProfile->{"employer2"};
                $employerContanctNo2 = $applicantProfile->{"employerContanctNo2"};
                $positionHeld2 = $applicantProfile->{"positionHeld2"};
                $salary2 = $applicantProfile->{"salary2"};
                $monthsOfService2 = $applicantProfile->{"monthsOfService2"};
                $reasonForLeaving2 = $applicantProfile->{"reasonForLeaving2"};

                $employer3 = $applicantProfile->{"employer3"};
                $employerContanctNo3 = $applicantProfile->{"employerContanctNo3"};
                $positionHeld3 = $applicantProfile->{"positionHeld3"};
                $salary3 = $applicantProfile->{"salary3"};
                $monthsOfService3 = $applicantProfile->{"monthsOfService3"};
                $reasonForLeaving3 = $applicantProfile->{"reasonForLeaving3"};

                $refName1 = $applicantProfile->{"refName1"};
                $refContactNo1 = $applicantProfile->{"refContactNo1"};
                $refEmail1 = $applicantProfile->{"refEmail1"};
                $refCompany1 = $applicantProfile->{"refCompany1"};
                $refPosition1 = $applicantProfile->{"refPosition1"};

                $refName2 = $applicantProfile->{"refName2"};
                $refContactNo2 = $applicantProfile->{"refContactNo2"};
                $refEmail2 = $applicantProfile->{"refEmail2"};
                $refCompany2 = $applicantProfile->{"refCompany2"};
                $refPosition2 = $applicantProfile->{"refPosition2"};

                $refName3 = $applicantProfile->{"refName3"};
                $refContactNo3 = $applicantProfile->{"refContactNo3"};
                $refEmail3 = $applicantProfile->{"refEmail3"};
                $refCompany3 = $applicantProfile->{"refCompany3"};
                $refPosition3 = $applicantProfile->{"refPosition3"};
        
                
                AddJobHistoryInformation($applicantcode,
                $employer1,$employerContanctNo1,$positionHeld1,$salary1,$monthsOfService1,$reasonForLeaving1,
                $employer2,$employerContanctNo2,$positionHeld2,$salary2,$monthsOfService2,$reasonForLeaving2,
                $employer3,$employerContanctNo3,$positionHeld3,$salary3,$monthsOfService3,$reasonForLeaving3,
                $refName1,$refContactNo1,$refEmail1,$refCompany1,$refPosition1,
                $refName2,$refContactNo2,$refEmail2,$refCompany2,$refPosition2,
                $refName3,$refContactNo3,$refEmail3,$refCompany3,$refPosition3);
                
            break;
            case "Others":
                
                $applicantcode = $applicantProfile->{"applicantcode"};
                $skillset = $applicantProfile->{"skillset"};
                $convictedtocrimes = $applicantProfile->{"convictedtocrimes"};
                $crime = $applicantProfile->{"crime"};
                $hospitalized = $applicantProfile->{"hospitalized"};
                $illness = $applicantProfile->{"illness"};
                $explanations = $applicantProfile->{"explanation"};
                
                // echo $applicantcode.", ".$skillset.", ".$convictedtocrimes.", ".$crime.", ".$hospitalized.", ".$illness.", ".$explanations;

                AddOtherInformation($applicantcode,$skillset,$convictedtocrimes,$crime,$hospitalized,$illness,$explanations);
                
            break;
            case "Personal":
                
                $applicantcode = $applicantProfile->{"applicantcode"}; 
                $position = $applicantProfile->{"position"};
                $otherposition = $applicantProfile->{"otherposition"};
                $firstname = $applicantProfile->{"firstname"};
                $middlename = $applicantProfile->{"middlename"};
                $lastname = $applicantProfile->{"lastname"};
                $suffix = $applicantProfile->{"suffix"};
                $gender = $applicantProfile->{"gender"};
                $bloodtype = $applicantProfile->{"bloodtype"};
                $civilstatus = $applicantProfile->{"civilstatus"};
                $birthday = $applicantProfile->{"birthday"};
                $email = $applicantProfile->{"email"};
                $telephone = $applicantProfile->{"telephone"};
                $cellphone = $applicantProfile->{"cellphone"};
                $othercellphone = $applicantProfile->{"othercellphone"};
                $presentaddress = $applicantProfile->{"presentaddress"};
                $permanentaddress = $applicantProfile->{"permanentaddress"};

                $tin = $applicantProfile->{"tin"};
                $sss = $applicantProfile->{"sss"};
                $philhealth = $applicantProfile->{"philhealth"};
                $pagibig = $applicantProfile->{"pagibig"};
                $prclicense = (isset($applicantProfile->{"prclicense"}) ? $applicantProfile->{"prclicense"} : '');;
                $prcexpirydate = $applicantProfile->{"prcexpirydate"};
                $driverslicense = (isset($applicantProfile->{"driverslicense"}) ? $applicantProfile->{"driverslicense"} : '');
                $driversexpirydate = $applicantProfile->{"driversexpirydate"};
                
                $applicantpic = (isset($applicantProfile->{"applicantpic"}) ? $applicantProfile->{"applicantpic"} : '');

                if($position === "Others" ? $position = $otherposition : $position);
                
                AddPersonalInformation($applicantcode,$position,$firstname,$middlename,$lastname,$suffix,$gender,$bloodtype,$civilstatus,$birthday,$email,$telephone,$cellphone,$othercellphone,$presentaddress,$permanentaddress,$tin,$sss,$philhealth,$pagibig,$prclicense,$prcexpirydate,$driverslicense,$driversexpirydate,$applicantpic);
                
                break;
        }


    }// Insert
    elseif($applicantProfile->{"Action"} == "GetPositionList")
    {
        GetPositionList();
    }
    elseif($applicantProfile->{"Action"} == "GetApplicantNumber")
    {
        GetApplicantNumber();
    }
    elseif($applicantProfile->{"Action"} == "GetRelationshipList")
    {
        GetRelationshipList();
    }
    elseif($applicantProfile->{"Action"} == "GetGovernmentIdDuplicate")
    {
        $idno = $applicantProfile->{"idno"};
        $idtype = $applicantProfile->{"idtype"};
        
        GetGovernmentIdDuplicate($idno,$idtype);
    }

    

?>