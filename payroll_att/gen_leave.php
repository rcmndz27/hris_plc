<?php 
              

function GenLeave($eMplogName,$pyrollco_from,$pyrollco_to){

           
    global $connL;

    $cmd = $connL->prepare('EXEC GenerateLeaveToAttendance :pay_from,:pay_to,:eMplogName');
    $cmd->bindValue(':pay_from',$pyrollco_from);
    $cmd->bindValue(':pay_to',$pyrollco_to);
    $cmd->bindValue(':eMplogName',$eMplogName);
    $cmd->execute();


    $query = "INSERT INTO logs_gen_script (pay_from,pay_to,remarks,audituser,auditdate) 
                                    VALUES(:pay_from,:pay_to,:remarks,:audituser,:auditdate)";

        $stmt =$connL->prepare($query);

        $param = array(
            ":pay_from"=> $pyrollco_from,
            ":pay_to"=> $pyrollco_to,
            ":remarks"=> 'Leave',
            ":audituser" => $eMplogName,
            ":auditdate"=>date('Y-m-d h:i:s')                                          
        );

    $result = $stmt->execute($param);

    echo $result;
    
                                       
}


?>
