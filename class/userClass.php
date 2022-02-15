<?php

     class userClass
     {
          public function userLogin($userid,$password)
          {
               try{
                    
                    global $connL;

                    $hash_password= hash('sha256', $password);

                    $query = 'SELECT userid FROM dbo.mf_user WHERE userid=:userid AND userpassword=:hash_password';
                    $param = array(":userid" => $userid, ":hash_password" => $hash_password);
                    $stmt =$connL->prepare($query);
                    $stmt->execute($param);
                    $count=$stmt->rowCount();
                    $data=$stmt->fetch();

                    if($count)
                    {
                         $_SESSION['uid'] = $data->uid; // Storing user session value
                         return true;
                    }
                    else
                    {
                    return false;
                    }
               }
               catch(PDOException $e)
               {
                    echo '{"error":{"text":'. $e->getMessage() .'}}';
               } 
               
          }
     }
?>