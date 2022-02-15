<?php 
Class ChangePasswordApplication{

 function ChangePasswordApp($empCode, $newpassword,$confirmpassword){

        global $connL;
  			
  			$hashpassword = hash('sha256', $confirmpassword);

  			$cmd = $connL->prepare("UPDATE dbo.mf_user SET userpassword = :hashpassword where userid = :empCode ");
            $cmd->bindValue('hashpassword',$hashpassword);
            $cmd->bindValue('empCode',$empCode);
            $cmd->execute();
    } 

}
?>