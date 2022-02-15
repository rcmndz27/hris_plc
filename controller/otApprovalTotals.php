<?php

    function RetrieveTotals($dtFrom, $dtTo, $emp)
    {
        global $connL;

        try
        {
            $sql = $connL->prepare(@"SELECT SUM(ot_approved) FROM dbo.att_ot_approve where emp_code = :emp AND date >= :dtFrom AND date <= :dtTo");
            $sql->bindParam(":emp", $emp, PDO::PARAM_STR);
            $sql->bindParam(":dtFrom", $dtFrom, PDO::PARAM_STR);
            $sql->bindParam(":dtTo", $dtTo, PDO::PARAM_STR);
            $sql->execute();

            return (float)$sql->fetchColumn();
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

?>