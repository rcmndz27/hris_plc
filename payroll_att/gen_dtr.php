<?php 
              

function GenDtr(){

           
    global $connL;
    global $dbConnection;

    $cmd2 = $connL->prepare('EXEC dbo.LoadEmployeeDTRPLCDetails');
    $cmd2->execute();

    $cmd = $dbConnection->prepare('EXEC hrissys_dev.dbo.LoadEmployeeDTRDetails');
    $cmd->execute();
                                       
}


?>
