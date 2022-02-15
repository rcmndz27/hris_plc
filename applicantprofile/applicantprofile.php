<?php
    include("config.php");

    function GetApplicantNumber(){
        global $conn;
        $sql = "SELECT MAX(applicantcode) applicantcode FROM applicantprofile";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();
        $series = $row["applicantcode"];
        if($series == null ?  $series = 00 : $series);
        $series = substr($series, -4);
        $newseries = str_pad($series + 1, 4, 0, STR_PAD_LEFT);
            
        echo date("Ymd").$newseries;

    }

    function GetPositionList(){
        
        global $conn;

        $sql = "SELECT position FROM dbo.mf_position ORDER BY position";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();

        $positionListArr = [];
        while ($row = $stmt->fetch())
        {
            $positionListArr[] = array( "code" => preg_replace("/\s+/", "",$row["position"]) ,"desc" => $row["position"] );
        }

        echo json_encode($positionListArr);
    }
    
    function GetRelationshipList(){
        
        global $conn;

        $sql = "SELECT rowid, relationship_name FROM dbo.mf_relationship ORDER BY relationship_name";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();

        $relationshipListArr = [];

        if($row){
            do{
                $relationshipListArr[] = array( "code" => $row["rowid"] ,"desc" => $row["relationship_name"] );

            }while ($row = $stmt->fetch());
        }
        
        echo json_encode($relationshipListArr);
    }

    function AddFamilyInformation(
        $applicantcode,
        $mother,$mother_address,$mother_contactno,$father,
        $father_address,$father_contactno,
        $spouse,$spouse_birthdate,$spouse_occupation,$spouse_tin,$spouse_sss,
        $child1,$child1_birthdate,$child1_gender,
        $child2,$child2_birthdate,$child2_gender,
        $child3,$child3_birthdate,$child3_gender,
        $child4,$child4_birthdate,$child4_gender,
        $child5,$child5_gender,$child5_birthdate,
        $contact_person,$contact_no,$contact_address,
        $contact_person1,$contact_no1,$contact_address1,
        $company_personel,$company_personel_relationship) {

        global $conn;

        try{
            $sql = " INSERT INTO applicantfamily(applicantcode,name_of_mother,mother_address,mother_contactno,name_of_father,father_address,father_contactno,name_of_spouse,birthdate,occupation,tinno_of_spouse,sss_of_spouse,child1,child1_dob,gender1,child2,child2_dob,gender2,child3,child3_dob,gender3,child4,child4_dob,gender4,child5,child5_dob,gender5,contact_person,contact_no,contact_address,contact_person1,contact_no1,contact_address1,relative_name,relative_relation) 
            VALUES (:applicantcode,:name_of_mother,:mother_address,:mother_contactno,:name_of_father,:father_address,:father_contactno,:name_of_spouse,:birthdate,:occupation,:tinno_of_spouse,:sss_of_spouse,:child1,:child1_dob,:gender1,:child2,:child2_dob,:gender2,:child3,:child3_dob,:gender3,:child4,:child4_dob,:gender4,:child5,:child5_dob,:gender5,:contact_person,:contact_no,:contact_address,:contact_person1,:contact_no1,:contact_address1,:relative_name,:relative_relation) ";
            
            $stmt = $conn->prepare($sql);
            
            $stmt->bindValue(":applicantcode",$applicantcode);
            $stmt->bindValue(":name_of_mother",$mother);
            $stmt->bindValue(":mother_address",$mother_address);
            $stmt->bindValue(":mother_contactno",$mother_contactno);
            $stmt->bindValue(":name_of_father",$father);
            $stmt->bindValue(":father_address",$father_address);
            $stmt->bindValue(":father_contactno",$father_contactno);
            $stmt->bindValue(":name_of_spouse",$spouse);
            $stmt->bindValue(":birthdate",$spouse_birthdate);
            $stmt->bindValue(":occupation",$spouse_occupation);
            $stmt->bindValue(":tinno_of_spouse",$spouse_tin);
            $stmt->bindValue(":sss_of_spouse",$spouse_sss);
            $stmt->bindValue(":child1",$child1);
            $stmt->bindValue(":child1_dob",$child1_birthdate);
            $stmt->bindValue(":gender1",$child1_gender);
            $stmt->bindValue(":child2",$child2);
            $stmt->bindValue(":child2_dob",$child2_birthdate);
            $stmt->bindValue(":gender2",$child2_gender);
            $stmt->bindValue(":child3",$child3);
            $stmt->bindValue(":child3_dob",$child3_birthdate);
            $stmt->bindValue(":gender3",$child3_gender);
            $stmt->bindValue(":child4",$child4);
            $stmt->bindValue(":child4_dob",$child4_birthdate);
            $stmt->bindValue(":gender4",$child4_gender);
            $stmt->bindValue(":child5",$child5);
            $stmt->bindValue(":child5_dob",$child5_birthdate);
            $stmt->bindValue(":gender5",$child5_gender);
            $stmt->bindValue(":contact_person",$contact_person);
            $stmt->bindValue(":contact_no",$contact_no);
            $stmt->bindValue(":contact_address",$contact_address);

            $stmt->bindValue(":contact_person1",$contact_person);
            $stmt->bindValue(":contact_no1",$contact_no);
            $stmt->bindValue(":contact_address1",$contact_address);

            $stmt->bindValue(":relative_name",$company_personel);
            $stmt->bindValue(":relative_relation",$company_personel_relationship);
                
            $result = $stmt->execute();

            echo $result;

            $errorInfo = $stmt->errorInfo();

                if(isset($errorInfo[2]))
                {
                    $error = $errorInfo[2];
                }
            
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    
    }

    function AddEducationInformation($applicantcode,$elementary,$elementary_date,$highschool,$highschool_date,$college,$course,$college_date,$higherstudies,$higherstudies_course,$higherstudies_date) {
        
        global $conn;

        try{
            $sql = " INSERT INTO applicanteducation(applicantcode,elementary,elementarydate,highschool,highschooldate,college,collegecourse,collegedate,higherstudies,highercourse,higherstudiesdate) VALUES (:applicantcode,:elementary,:elementarydate,:highschool,:highschooldate,:college,:collegecourse,:collegedate,:higherstudies,:highercourse,:higherstudiesdate) ";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":applicantcode",$applicantcode);
            $stmt->bindValue(":elementary",$elementary);
            $stmt->bindValue(":elementarydate",$elementary_date);
            $stmt->bindValue(":highschool",$highschool);
            $stmt->bindValue(":highschooldate",$highschool_date);
            $stmt->bindValue(":college",$college);
            $stmt->bindValue(":collegecourse",$course);
            $stmt->bindValue(":collegedate",$college_date);
            $stmt->bindValue(":higherstudies",$higherstudies);
            $stmt->bindValue(":highercourse",$higherstudies_course);
            $stmt->bindValue(":higherstudiesdate",$higherstudies_date);

            $result = $stmt->execute();
            
            echo $result;
                
            $errorInfo = $stmt->errorInfo();

            if(isset($errorInfo[2]))
            {
                $error = $errorInfo[2];
            }
            
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    function AddJobHistoryInformation(
        $applicantcode,$employer1,$employerContanctNo1,$positionHeld1,$salary1,$monthsOfService1,$reasonForLeaving1,
        $employer2,$employerContanctNo2,$positionHeld2,$salary2,$monthsOfService2,$reasonForLeaving2,
        $employer3,$employerContanctNo3,$positionHeld3,$salary3,$monthsOfService3,$reasonForLeaving3,
        $refName1,$refContactNo1,$refEmail1,$refCompany1,$refPosition1,
        $refName2,$refContactNo2,$refEmail2,$refCompany2,$refPosition2,
        $refName3,$refContactNo3,$refEmail3,$refCompany3,$refPosition3) {
        
        global $conn;
        
        try{
            $sql = " INSERT INTO applicantjobhistory(applicantcode,
            employer1,employercontactno1,positionheld1,salary1,monthsofservice1,reasonforleaving1,
            employer2,employercontactno2,positionheld2,salary2,monthsofservice2,reasonforleaving2,
            employer3,employercontactno3,positionheld3,salary3,monthsofservice3,reasonforleaving3,
            refname1,refcontactno1,refemail1,refcompany1,refposition1,
            refname2,refcontactno2,refemail2,refcompany2,refposition2,
            refname3,refcontactno3,refemail3,refcompany3,refposition3) 
            VALUES (:applicantcode,
            :employer1,:employercontactno1,:positionheld1,:salary1,:monthsofservice1,:reasonforleaving1,
            :employer2,:employercontactno2,:positionheld2,:salary2,:monthsofservice2,:reasonforleaving2,
            :employer3,:employercontactno3,:positionheld3,:salary3,:monthsofservice3,:reasonforleaving3,
            :refname1,:refcontactno1,:refemail1,:refcompany1,:refposition1,
            :refname2,:refcontactno2,:refemail2,:refcompany2,:refposition2,
            :refname3,:refcontactno3,:refemail3,:refcompany3,:refposition3)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":applicantcode",$applicantcode);

            $stmt->bindValue(":employer1",$employer1);
            $stmt->bindValue(":employercontactno1",$employerContanctNo1);
            $stmt->bindValue(":positionheld1",$positionHeld1);
            $stmt->bindValue(":salary1",$salary1);
            $stmt->bindValue(":monthsofservice1",$monthsOfService1);
            $stmt->bindValue(":reasonforleaving1",$reasonForLeaving1);
            
            $stmt->bindValue(":employer2",$employer2);
            $stmt->bindValue(":employercontactno2",$employerContanctNo2);
            $stmt->bindValue(":positionheld2",$positionHeld2);
            $stmt->bindValue(":salary2",$salary2);
            $stmt->bindValue(":monthsofservice2",$monthsOfService2);
            $stmt->bindValue(":reasonforleaving2",$reasonForLeaving2);

            $stmt->bindValue(":employer3",$employer3);
            $stmt->bindValue(":employercontactno3",$employerContanctNo3);
            $stmt->bindValue(":positionheld3",$positionHeld3);
            $stmt->bindValue(":salary3",$salary3);
            $stmt->bindValue(":monthsofservice3",$monthsOfService3);
            $stmt->bindValue(":reasonforleaving3",$reasonForLeaving3);

            $stmt->bindValue(":refname1",$refName1);
            $stmt->bindValue(":refcontactno1",$refContactNo1);
            $stmt->bindValue(":refemail1",$refEmail1);
            $stmt->bindValue(":refcompany1",$refCompany1);
            $stmt->bindValue(":refposition1",$refPosition1);

            $stmt->bindValue(":refname2",$refName2);
            $stmt->bindValue(":refcontactno2",$refContactNo2);
            $stmt->bindValue(":refemail2",$refEmail2);
            $stmt->bindValue(":refcompany2",$refCompany2);
            $stmt->bindValue(":refposition2",$refPosition2);

            $stmt->bindValue(":refname3",$refName3);
            $stmt->bindValue(":refcontactno3",$refContactNo3);
            $stmt->bindValue(":refemail3",$refEmail3);
            $stmt->bindValue(":refcompany3",$refCompany3);
            $stmt->bindValue(":refposition3",$refPosition3);


            $result = $stmt->execute();
            
            echo $result;
                
            $errorInfo = $stmt->errorInfo();

            if(isset($errorInfo[2]))
            {
                $error = $errorInfo[2];
            }
            
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    function AddPersonalInformation($applicantcode,$position,$firstname,$middlename,$lastname,$suffix,$gender,$bloodtype,$civilstatus,$birthday,$email,$telephone,$cellphone,$othercellphone,$presentaddress,$permanentaddress,$tin,$sss,$philhealth,$pagibig,$prclicense,$prcexpirydate,$driverslicense,$driversexpirydate,$applicantpic) {

        global $conn;

        try{
            $sql = " INSERT INTO applicantprofile(applicantcode,applicantposition,dateapplied,firstname,middlename,lastname,gender,bloodtype,civilstatus,birthday,emailaddress,telno,celno,celno1,presentaddress,permanentaddress,tin_no,sss_no,phil_no,pagibig_no,prclicense,prcexpirydate,driverslicense,driversexpirydate,applicantpic,status) VALUES (:applicantcode,:applicantposition,:dateapplied,:firstname,:middlename,:lastname,:gender,:bloodtype,:civilstatus,:birthday,:email,:telephone,:cellphone,:othercellphone,:presentaddress,
                :permanentaddress,:tin,:sss,:philhealth,:pagibig,:prclicense,:prcexpirydate,:driverslicense,:driversexpirydate,:applicantpic,:status) ";

                $stmt = $conn->prepare($sql);

                $stmt->bindValue(":applicantcode",$applicantcode);
                $stmt->bindValue(":applicantposition",$position);
                $stmt->bindValue(":dateapplied",date("Y-m-d"));
                $stmt->bindValue(":firstname",$firstname);
                $stmt->bindValue(":middlename",$middlename);
                $stmt->bindValue(":lastname",$lastname." ".$suffix);
                $stmt->bindValue(":gender",$gender);
                $stmt->bindValue(":bloodtype",$bloodtype);
                $stmt->bindValue(":civilstatus",$civilstatus);
                $stmt->bindValue(":birthday",$birthday);
                $stmt->bindValue(":email",$email);
                $stmt->bindValue(":telephone",$telephone);
                $stmt->bindValue(":cellphone",$cellphone);
                $stmt->bindValue(":othercellphone",$othercellphone);
                $stmt->bindValue(":presentaddress",$presentaddress);
                $stmt->bindValue(":permanentaddress",$permanentaddress);
                $stmt->bindValue(":tin",$tin);
                $stmt->bindValue(":sss",$sss);
                $stmt->bindValue(":philhealth",$philhealth);
                $stmt->bindValue(":pagibig",$pagibig);
                $stmt->bindValue(":prclicense",$prclicense);
                $stmt->bindValue(":prcexpirydate",$prcexpirydate);
                $stmt->bindValue(":driverslicense",$driverslicense);
                $stmt->bindValue(":driversexpirydate",$driversexpirydate);
                $stmt->bindValue(":applicantpic",$applicantpic);
                $stmt->bindValue(":status","Active");

                $result = $stmt->execute();
            
                echo $result;

                $errorInfo = $stmt->errorInfo();

                if(isset($errorInfo[2]))
                {
                    $error = $errorInfo[2];
                }
            
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    function AddOtherInformation($applicantcode,$skillset,$convictedtocrimes,$crime,$hospitalized,$illness,$explanations) {
        global $conn;

        try{
            $sql = " INSERT INTO applicantotherinfo(applicantcode, skillset, convictedtocrimes, crimedetails, hospitalized, hospitalizationdetails, explanations) 
            VALUES (:applicantcode, :skillset, :convictedtocrimes, :crimedetails, :hospitalized, :hospitalizationdetails, :explanations) ";

                $stmt = $conn->prepare($sql);

                $stmt->bindValue(":applicantcode",$applicantcode);
                $stmt->bindValue(":skillset",$skillset);
                $stmt->bindValue(":convictedtocrimes",$convictedtocrimes);
                $stmt->bindValue(":crimedetails",$crime);
                $stmt->bindValue(":hospitalized",$hospitalized);
                $stmt->bindValue(":hospitalizationdetails",$illness);
                $stmt->bindValue(":explanations",$explanations);

                $result = $stmt->execute();
            
                echo $result;

                $errorInfo = $stmt->errorInfo();

                if(isset($errorInfo[2]))
                {
                    $error = $errorInfo[2];
                }
            
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    function GetGovernmentIdDuplicate($idno,$idtype) {
        
        global $conn;
        
        $query = "";
        
        switch ($idtype) {
            case "tin":
                $query =  "SELECT DISTINCT(tin_no) as governmentid FROM dbo.GovermentIdLookUp WHERE tin_no = :idno";
              break;
            case "sss":
                $query =  "SELECT DISTINCT(sss_no) as governmentid FROM dbo.GovermentIdLookUp WHERE sss_no = :idno";
              break;
            case "pagibig":
                $query =  "SELECT DISTINCT(pagibig_no) as governmentid FROM dbo.GovermentIdLookUp WHERE pagibig_no = :idno";
              break;
            case "philhealth":
                $query =  "SELECT DISTINCT(phil_no) as governmentid FROM dbo.GovermentIdLookUp WHERE phil_no = :idno";
          }

        $stmt = $conn->prepare($query);
        $param = array(":idno" => $idno);
        $stmt->execute($param);
        $result = $stmt->fetch();
        
        $returnedResult = "";

        if(isset($result["governmentid"]) ?  $returnedResult = '1' : $returnedResult = '0');

        $governmentIdListArr[] = array( "result" => $returnedResult ,"idtype" => $idtype);

        echo json_encode($governmentIdListArr);

    }
    
?>