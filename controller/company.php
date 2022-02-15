<?php
    // include('../config/db.php');


    function  GetCompaniesList() 
    {
        global $connL;

        $cmd = $connL->prepare(@"SELECT company FROM dbo.payroll ORDER BY company");
        $cmd->execute();

        $companiesListArr = [];

        while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
        {
            $companiesListArr[] = array( 'code' => $r['company'] ,'desc' => $r['company'] );
        }

        echo json_encode($companiesListArr);
    }

?>