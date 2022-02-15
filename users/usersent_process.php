<?php


    include('../users/usersent.php');
    include('../config/db.php');

$usrEnt = new UsersEnt();

$usrent = json_decode($_POST["data"]);

if($usrent->{"Action"} == "InsertUsersEnt")
{

    $username = $usrent->{"username"};
    $userid = $usrent->{"userid"};
    $userpassword = $usrent->{"userpassword"};
    $usertype = $usrent->{"usertype"};
    $status = $usrent->{"status"};


    $usrEnt->InsertUsersEnt($username,$userid,$userpassword,$usertype,$status);

}else{

}
    

?>

