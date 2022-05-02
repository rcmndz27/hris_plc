<?php 
              

function GenAttendance($eMplogName,$pyrollco_from,$pyrollco_to){

           
    global $dbConnectionL;
    global $connL;

    $cmd = $dbConnectionL->prepare('EXEC biotime8.dbo.insert_xp_attendance_portal :emp_code, :emp_name,:pay_from,:pay_to');
    $cmd->bindValue(':emp_code','');
    $cmd->bindValue(':emp_name',$eMplogName);
    $cmd->bindValue(':pay_from',$pyrollco_from);
    $cmd->bindValue(':pay_to',$pyrollco_to);
    $cmd->execute();


    $query = "INSERT INTO logs_gen_att (pay_from,pay_to,audituser,auditdate) VALUES(:pay_from,:pay_to,:audituser,:auditdate)";

        $stmt =$connL->prepare($query);

        $param = array(
            ":pay_from"=> $pyrollco_from,
            ":pay_to"=> $pyrollco_to,
            ":audituser" => $eMplogName,
            ":auditdate"=>date('m-d-Y')                                          
        );

    $result = $stmt->execute($param);

    echo $result;
    
                                       
}


?>
