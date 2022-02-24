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

      $empInfo = new EmployeeInformation();
      $empInfo->SetEmployeeInformation($_SESSION['userid']);
      $empCode = $empInfo->GetEmployeeCode();

    global $connL;


    //GET COMPANY
    $query = "SELECT * from employee_profile where emp_code = :empcode";
    $stmt =$connL->prepare($query);
    $param = array(":empcode" => $empCode);
    $stmt->execute($param);
    $result = $stmt->fetch();
    $cmp = $result['company'];
    $subemp = strlen($cmp);


    // GET CUT OFF
    $qry = "SELECT * from payroll_cutoff WHERE GETDATE() between cutoff_from and cutoff_to" ;
    $stm =$connL->prepare($qry);
    $stm->execute();
    $resul = $stm->fetch();
    $cutoff_from = (isset($resul['cutoff_from'])) ? $resul['cutoff_from'] : date("Y/m/d") ;;
    $cutoff_to = (isset($resul['cutoff_to'])) ? $resul['cutoff_to'] : date("Y/m/d") ;


    // LEAVE BALANCE
    $query = "SELECT  earned_vl,earned_sl,round(earned_vl * 100 / 10,0) as vlpct,round(earned_sl * 100 / 10,0) as slpct from employee_leave where emp_code = :empcode" ;
    $stmt =$connL->prepare($query);
    $param = array(":empcode" => $empCode);
    $stmt->execute($param);
    $result = $stmt->fetch();
    $earned_vl = (isset($result['earned_vl'])) ? round($result['earned_vl'],2) : 0 ;
    $earned_sl = (isset($result['earned_sl'])) ? round($result['earned_sl'],2) : 0 ;
    $vlpct = (isset($result['vlpct'])) ? round($result['vlpct'],2) : 0 ;
    $slpct = (isset($result['slpct'])) ? round($result['slpct'],2) : 0 ;


    // TOTAL APPLIED LEAVE
    $querys = "SELECT sum(app_days) as app_leave from tr_leave where emp_code = :empcode and
    date_from between :cutoff_from and :cutoff_to and
    date_to between :cutoff_from2 and :cutoff_to2" ;
    $stmts =$connL->prepare($querys);
    $params= array(":empcode" => $empCode,":cutoff_from" => $cutoff_from,":cutoff_to" => $cutoff_to,
      ":cutoff_from2" => $cutoff_from,":cutoff_to2" => $cutoff_to);
    $stmts->execute($params);
    $results = $stmts->fetch();
    $app_leave =  (isset($results['app_leave'])) ? $results['app_leave'] : 0 ;


    // TOTAL WORK HRS
    $queryrenot = 'EXEC hrissys_test.dbo.xp_attendance_portal_work :emp_code,:startDate,:endDate';
    $paramrenot = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-01-01"), ":endDate" => date("Y-12-31") );
    $stmtrenot =$connL->prepare($queryrenot);
    $stmtrenot->execute($paramrenot);
    $resultrenot = $stmtrenot->fetch();
    $workhrs = (isset($resultrenot['workhrs'])) ? round($resultrenot['workhrs'],2) : 0 ;


    //JAN 
    $queryjan = 'EXEC hrissys_test.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
    $paramjan = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-01-01"), ":endDate" => date("Y-01-31") );
    $stmtjan =$connL->prepare($queryjan);
    $stmtjan->execute($paramjan);
    $resultjan = $stmtjan->fetch();
    $jancnt = $resultjan['cnt'];

    //FEB 
    $queryfeb = 'EXEC hrissys_test.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
    $paramfeb = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-02-01"), ":endDate" => date("Y-02-28") );
    $stmtfeb =$connL->prepare($queryfeb);
    $stmtfeb->execute($paramfeb);
    $resultfeb = $stmtfeb->fetch();
    $febcnt = $resultfeb['cnt'];

    //MAR 
    $querymar = 'EXEC hrissys_test.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
    $parammar = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-03-01"), ":endDate" => date("Y-03-31") );
    $stmtmar =$connL->prepare($querymar);
    $stmtmar->execute($parammar);
    $resultmar = $stmtmar->fetch();
    $marcnt = $resultmar['cnt'];

    //APR 
    $queryapr = 'EXEC hrissys_test.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
    $paramapr = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-04-01"), ":endDate" => date("Y-04-30") );
    $stmtapr =$connL->prepare($queryapr);
    $stmtapr->execute($paramapr);
    $resultapr = $stmtapr->fetch();
    $aprcnt = $resultapr['cnt'];

    //MAY 
    $querymay = 'EXEC hrissys_test.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
    $parammay = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-05-01"), ":endDate" => date("Y-05-31") );
    $stmtmay =$connL->prepare($querymay);
    $stmtmay->execute($parammay);
    $resultmay = $stmtmay->fetch();
    $maycnt = $resultmay['cnt'];    

    //jun 
    $queryjun = 'EXEC hrissys_test.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
    $paramjun = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-06-01"), ":endDate" => date("Y-06-30") );
    $stmtjun =$connL->prepare($queryjun);
    $stmtjun->execute($paramjun);
    $resultjun = $stmtjun->fetch();
    $juncnt = $resultjun['cnt'];

    //jul 
    $queryjul = 'EXEC hrissys_test.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
    $paramjul = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-07-01"), ":endDate" => date("Y-07-31") );
    $stmtjul =$connL->prepare($queryjul);
    $stmtjul->execute($paramjul);
    $resultjul = $stmtjul->fetch();
    $julcnt = $resultjul['cnt'];

    //aug 
    $queryaug = 'EXEC hrissys_test.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
    $paramaug = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-08-01"), ":endDate" => date("Y-08-31") );
    $stmtaug =$connL->prepare($queryaug);
    $stmtaug->execute($paramaug);
    $resultaug = $stmtaug->fetch();
    $augcnt = $resultaug['cnt'];    

    //sep 
    $querysep = 'EXEC hrissys_test.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
    $paramsep = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-09-01"), ":endDate" => date("Y-09-30") );
    $stmtsep =$connL->prepare($querysep);
    $stmtsep->execute($paramsep);
    $resultsep = $stmtsep->fetch();
    $sepcnt = $resultsep['cnt'];

    //OCT 
    $queryoct = 'EXEC hrissys_test.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
    $paramoct = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-10-01"), ":endDate" => date("Y-10-31") );
    $stmtoct =$connL->prepare($queryoct);
    $stmtoct->execute($paramoct);
    $resultoct = $stmtoct->fetch();
    $octcnt = $resultoct['cnt'];

    //nov 
    $querynov = 'EXEC hrissys_test.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
    $paramnov = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-11-01"), ":endDate" => date("Y-11-30") );
    $stmtnov =$connL->prepare($querynov);
    $stmtnov->execute($paramnov);
    $resultnov = $stmtnov->fetch();
    $novcnt = $resultnov['cnt'];    

    //dec 
    $querydec = 'EXEC hrissys_test.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
    $paramdec = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-12-01"), ":endDate" => date("Y-12-31") );
    $stmtdec =$connL->prepare($querydec);
    $stmtdec->execute($paramdec);
    $resultdec = $stmtdec->fetch();
    $deccnt = $resultdec['cnt'];  

    //laudot 
    $querylaudot = 'EXEC hrissys_test.dbo.xp_attendance_portal_sum :emp_code,:startDate,:endDate';
    $paramlaudot = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-01-01"), ":endDate" => date("Y-12-31") );
    $stmtlaudot =$connL->prepare($querylaudot);
    $stmtlaudot->execute($paramlaudot);
    $resultlaudot = $stmtlaudot->fetch();
    $latepct = (isset($resultlaudot['latepct'])) ? round($resultlaudot['latepct'],2) : 0 ;
    $udpct =  (isset($resultlaudot['udpct'])) ? round($resultlaudot['udpct'],2) : 0 ;
    $otpct = (isset($resultlaudot['otpct'])) ? round($resultlaudot['otpct'],2) : 0 ;

    }

    
    

?>


<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<body id="page-top" style="background-color: #f8f9fc;height:100%;">


    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">
                      <div class="row">
                        <div class="col-md-12 pt-5">
                        </div>
                    </div>
                      <div class="row">
                        <div class="col-md-12 pt-5">
                        </div>
                    </div>                    

                    <!-- Content Row -->
                    <div class="row">

                        <!-- All Act Emp-->
                         <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">SICK LEAVE BALANCE
                                            <?php echo date("Y") ?> </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $earned_sl; ?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar allact" role="progressbar"
                                                            style="width: <?php echo $slpct; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-head-side-cough fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                        

                        <!-- All Inact Emp-->
                         <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Vacation Leave Balance <?php echo date("Y") ?> 
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $earned_vl; ?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar allinact" role="progressbar"
                                                            style="width: <?php echo $vlpct; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-plane fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Male-->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Applied Leave <?php echo date("Y") ?> 
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $app_leave; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-car fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Female -->
                         <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Working Hours <?php echo date("Y") ?> 
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $workhrs; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">ATTENDANCE SUMMARY <?php echo date("Y") ?>  </h6>
                                    <button id='jan' value="<?php echo $jancnt; ?>" hidden></button>
                                    <button id='feb' value="<?php echo $febcnt; ?>" hidden></button>
                                    <button id='mar' value="<?php echo $marcnt; ?>" hidden></button>
                                    <button id='apr' value="<?php echo $aprcnt; ?>" hidden></button>
                                    <button id='may' value="<?php echo $maycnt; ?>" hidden></button>
                                    <button id='jun' value="<?php echo $juncnt; ?>" hidden></button>
                                    <button id='jul' value="<?php echo $julcnt; ?>" hidden></button>
                                    <button id='aug' value="<?php echo $augcnt; ?>" hidden></button>
                                    <button id='sep' value="<?php echo $sepcnt; ?>" hidden></button>
                                    <button id='oct' value="<?php echo $octcnt; ?>" hidden></button>
                                    <button id='nov' value="<?php echo $novcnt; ?>" hidden></button>
                                    <button id='dec' value="<?php echo $deccnt; ?>" hidden></button>                                
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">LATE - UNDERTIME - OVERTIME <?php echo date("Y") ?> </h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Late
                                            <button id='late' value="<?php echo $latepct; ?>" hidden></button>
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Undertime
                                            <button id='udtime' value="<?php echo $udpct; ?>" hidden></button>
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Overtime
                                            <button id='ottime' value="<?php echo $otpct; ?>" hidden></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                     
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->
                              <div class="row">
                        <div class="col-md-12 pt-5">
                        </div>
                    </div>
                      <div class="row">
                        <div class="col-md-12 pt-5">
                        </div>
                    </div>   

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
<?php include('../_footer.php');  ?>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-employee.js"></script>
    
</body>

</html>