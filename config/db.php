<?php

            $dbstringsL = "sqlsrv:Server=SYSDEV-RMENDOZA\SQL2019;Database=hrissys_test";
            $connL = new PDO($dbstringsL, "mgr", "P@55w0rd456");
            $connL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 

            try
            {
            $dbstrings = "sqlsrv:Server=SYSDEV-RMENDOZA\SQL2019;Database=hrissys_dev";             
            $dbConnection = new PDO($dbstrings, "mgr", "P@55w0rd456"); 

            $dbstringsLs = "sqlsrv:Server=SYSDEV-RMENDOZA\SQL2019;Database=biotime8";     
            $dbConnectionL = new PDO($dbstringsLs, "mgr", "P@55w0rd456"); 
      

            }


            catch (PDOException $e)
            {
                die($e->getMessage());
                echo 'Connection failed: ' . $e->getMessage();
            }
        
    
?>

