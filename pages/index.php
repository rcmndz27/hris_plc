<?php
    session_start();

    if (empty($_SESSION['userid']))
    {
        echo '<script type="text/javascript">alert("Please login first!!");</script>';
        header( "refresh:1;url=../index.php" );
    }
    else
    {
        include_once('../_header.php');

        GetLeaveCount($empCode,$empDateHired,$empType);

    }

    

?>

<div class='container-fluid'>
    <div class='row'>
        <?php 
            include('../pages/frontpage.php');
        ?>

    </div>
</div>



<?php include('../_footer.php');  ?>