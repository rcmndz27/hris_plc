<?php

            $dbstringsL = "sqlsrv:Server=192.168.201.8;Database=hrissys_test";
            $connL = new PDO($dbstringsL, "mgr", "mgr");
            $connL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            

            try
            {
                $dbstrings = "sqlsrv:Server=192.168.201.8;Database=hrissys_test";
                
                $dbConnection = new PDO($dbstrings, "mgr", "mgr"); 

                $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $dbConnection;
            }
            catch (PDOException $e)
            {
                die($e->getMessage());
                echo 'Connection failed: ' . $e->getMessage();
            }
        

    
?>

