<?php

            $dbstringsL = "sqlsrv:Server=192.168.201.8;Database=hrissys_test";
            $connL = new PDO($dbstringsL, "mgr", "P@55w0rd456");
            $connL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            

            try
            {
                $dbstrings = "sqlsrv:Server=192.168.201.8;Database=hrissys_test";
                
                $dbConnection = new PDO($dbstrings, "mgr", "P@55w0rd456"); 

                $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $dbConnection;
            }
            catch (PDOException $e)
            {
                die($e->getMessage());
                echo 'Connection failed: ' . $e->getMessage();
            }
        

    
?>

