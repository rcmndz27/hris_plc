<?php

    function GetDepartment($empId)
    {
        global $connL;

        $cmd = $connL->prepare(@"SELECT department FROM dbo.view_employee where emp_code = :code");
        $cmd->bindValue(':code', $empId);
        $cmd->execute();

        return $cmd->fetchColumn();
    }

    function GetEmailAddress($empId)
    {
        global $connL;

        $cmd = $connL->prepare(@"SELECT emailaddress FROM dbo.view_employee where emp_code = :code");
        $cmd->bindValue(':code', $empId);
        $cmd->execute();

        return $cmd->fetchColumn();
    }

    function GetUserProfile($empId)
    {
        global $connL;

        $cmd = $connL->prepare(@"SELECT emp_code,emp_type,firstname, middlename, lastname, company, department, sub_department, position FROM dbo.employee_profile where emp_code = :code");
        $cmd->bindValue(':code', $empId);
        $cmd->execute();

        while($r = $cmd->fetch(PDO::FETCH_ASSOC))
        {
            
            echo "<a id='users-name' href='../pages/profileSettings_view.php'><h3>" . $r['firstname'] . " " . $r['middlename'] . " " . $r['lastname'] . "</h3></a>";
            echo "<span class='profle-desc'>" . $r['company'] . "</span><br>";
            echo "<span class='profle-desc'>" . $r['position'] . "</span><br>";
            echo "<span class='profle-desc'>" . $r['department'] . "</span><br>";
            echo "<span class='profle-desc'>" . $r['emp_code'] . "-" . $r['emp_type'] . "</span><br>";

            if (!(is_null($r['sub_department']))){
                if ($r['sub_department'] !== 'NA') {
                    echo "<span class='profle-desc'>" . $r['sub_department'] . "</span>";
                }
            }
            
        }

    }

    function GetProfile($empId)
    {
        global $connL;

        $cmd = $connL->prepare(@"SELECT * FROM dbo.employee_profile where emp_code = :code");
        $cmd->bindValue(':code', $empId);
        $cmd->execute();

        echo "<div class='col-12'>";

        while($r = $cmd->fetch(PDO::FETCH_ASSOC))
        {
            echo "
                <ul>
                    <li>
                        <div class='row'>
                            <div class='col-3'><b>Name: </b></div>
                            <div class='col-9'>" . $r['firstname'] . " " . $r['middlename'] . " " . $r['lastname'] . "</div>
                        </div>
                    </li>
                    <li>
                        <div class='row'>
                            <div class='col-3'><b>Company: </b></div>
                            <div class='col-9'>" . $r['company'] . "</div>
                        </div>
                    </li>
                    <li>
                        <div class='row'>
                            <div class='col-3'><b>Department: </b></div>
                            <div class='col-9'>" . $r['department'];
                    
                            if (!(is_null($r['sub_department'])))
                            {
                                echo " - " . $r['sub_department'];
                            }
            echo "
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class='row'>
                            <div class='col-3'><b>Position: </b></div>
                            <div class='col-9'>" . $r['position'] . "</div>
                        </div>
                    </li>
                    <li>
                        <div class='row'>
                            <div class='col-3'><b>Date Hired: </b></div>
                            <div class='col-9'>" . date("F d, Y", strtotime($r['datehired'])) . "</div>
                        </div>
                    </li>
                    <li class='w-100'><hr class='my-2'></li>
                    <li>
                        <div class='row'>
                            <div class='col-3'><b>Birth Date: </b></div>
                            <div class='col-9'>" . date("F d, Y", strtotime($r['birthdate'])) . "</div>
                        </div>
                    </li>
                    <li>
                        <div class='row'>
                            <div class='col-3'><b>Contact No: </b></div>
                            <div class='col-9'>" . $r['celno'] . "</div>
                        </div>
                    </li>
                    <li>
                        <div class='row'>
                            <div class='col-3'><b>Address: </b></div>
                            <div class='col-9'>" . $r['emp_address'] . "</div>
                        </div>
                    </li>
            ";
        }

        echo "</div>";
    }

    function GetProfilePic($emp)
    {
        global $connL;

        $cmd = $connL->prepare(@"SELECT emp_pic FROM dbo.employee_profile where emp_code = :emp");
        $cmd->bindValue(":emp", $emp);
        $cmd->execute();

        $picpath = $cmd->fetchColumn();

        if($picpath == null ?  $picpath = "url('../img/person.jpg')" : $picpath = "url('data:image/jpg;base64,".base64_encode($picpath)."')");

        echo $picpath;
    }

    function GetSupportReq()
    {    
        global $connL;

        $sql = "SELECT count(*) FROM dbo.ticket_requests WHERE status = 'OPEN'"; 
        $result = $connL->prepare($sql); 
        $result->execute(); 
        $open_requests = $result->fetchColumn(); 

        $sql = "SELECT count(*) FROM dbo.ticket_requests WHERE status = 'RESOLVED'"; 
        $result = $connL->prepare($sql); 
        $result->execute(); 
        $resolved_requests = $result->fetchColumn();
        
        $sql = "SELECT count(*) FROM dbo.ticket_requests WHERE status = 'IN PROGRESS'"; 
        $result = $connL->prepare($sql); 
        $result->execute(); 
        $pending_requests = $result->fetchColumn();

        echo $open_requests . " <strong><a href='../pages/tech/?status=open'>OPEN Support Tickets</a></strong><br/>";
        echo $pending_requests . "<strong><a href='../pages/tech/?status=in%20progress'>In Progress</a></strong><br/>";
        echo $resolved_requests ." <strong><a href='../pages/tech/?status=resolved'>Resolved Tickets</a></strong>";
    }


function GetLeaveCount($empId,$empDateHired,$empStatus){

        global $connL;

        $dateTime = new DateTime(date('Y-m-d'));
        $firstDay = $dateTime->format('Y-m-01');
        $resetDate = $dateTime->format('Y-02-01');
        $currentDate = $dateTime->format('Y-m-d');

        $hiredDate = new DateTime(date('Y-m-d',strtotime($empDateHired)));
        $currentDateTime = new DateTime(date('Y-m-d'));

        $dateDiff = date_diff($hiredDate,$dateTime);
    
        $earnedVL = round($dateDiff->format('%m') * 0.833,2);
        $earnedSL = round($dateDiff->format('%m') * 0.833,2);


        switch($empStatus){
            case 'Probationary':

                if($currentDate === $firstDay){

                    if($currentDate !== $resetDate){
        
                        $sql = 'SELECT emp_code FROM dbo.employee_leave WHERE emp_code = :emp_code';
                        $stmt =$connL->prepare($sql);
                        $param = array(":emp_code" => $empId);
                        $stmt->execute($param);
                        $result = $stmt->fetch();
        
                        if($result["emp_code"]){
        
                            $sql = 'SELECT earned_vl, earned_sl, status FROM dbo.employee_leave WHERE emp_code = :emp_code';
                            $stmt =$connL->prepare($sql);
                            $param = array(":emp_code" => $empId);
                            $stmt->execute($param);
                            $result = $stmt->fetch();
        
                            if($result['earned_vl'] < 10 && $result['earned_sl'] < 10 && $result['status'] == 1){
        
                                $sql = " UPDATE employee_leave SET earned_vl = :earned_vl ,earned_sl = :earned_sl WHERE emp_code = :emp_code ";
                                $param = array(":earned_vl" => $earnedVL, ":earned_sl" => $earnedSL, ":emp_code" => $empId);
        
                            }else{
        
                                $sql = " UPDATE employee_leave SET status = '0' WHERE emp_code = :emp_code ";
                                $param = array(":emp_code" => $empId);
        
                            }
        
                            $stmt =$connL->prepare($sql);
                            $result = $stmt->execute($param);
        
                        }
                    }else{
        
                        $sql = " UPDATE employee_leave SET earned_vl = :earned_vl ,earned_sl = :earned_sl, SET status = '0'  WHERE emp_code = :emp_code ";
                        $param = array(":earned_vl" => 10, ":earned_sl" => 10, ":emp_code" => $empId);
                        $stmt =$connL->prepare($sql);
                        $result = $stmt->execute($param);
        
                        // $sql = " INSERT INTO employee_leave(emp_code,earned_vl,earned_sl,status) VALUES (:emp_code,:earned_vl,:earned_sl,:status) ";
                        // $stmt =$connL->prepare($sql);
                        // $param = array(":emp_code" => $empId, ":earned_vl" => $earnedVL, ":earned_sl" => $earnedSL, ":status" =>'1');
                        // $result = $stmt->execute($param);
                        // echo $result;
                    }
                }

            break;
            case 'Project Based':
                // echo $empStatus;
            break;
            case 'Regular':

                if($currentDate === $resetDate){

                    $sql = " UPDATE employee_leave SET earned_vl = :earned_vl ,earned_sl = :earned_sl, status = '0'  WHERE emp_code = :emp_code ";
                    $param = array(":earned_vl" => 10, ":earned_sl" => 10, ":emp_code" => $empId);
                    $stmt =$connL->prepare($sql);
                    $result = $stmt->execute($param);

                }
            break;
        }

        
    }
?>