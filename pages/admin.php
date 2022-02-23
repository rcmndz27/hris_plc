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

    // GET ACTIVE EMPLOYEES
    $qry = "SELECT count(emp_code) as empcnt,round(count(emp_code) * 100 / (SELECT count(*) from employee_profile),0) as empcntpct  from employee_profile where active = 'Active'" ;
    $stm =$connL->prepare($qry);
    $stm->execute();
    $resul = $stm->fetch();
    $empcnt = (isset($resul['empcnt'])) ? $resul['empcnt'] : '0' ;
    $empcntpct = (isset($resul['empcntpct'])) ? $resul['empcntpct'] : '0' ;

    // GET INACTIVE EMPLOYEES
    $qrys = "SELECT count(emp_code) as empcnti,round(count(emp_code) * 100 / (SELECT count(*) from employee_profile),0) as empcntipct from employee_profile where active = 'Inactive'" ;
    $stms =$connL->prepare($qrys);
    $stms->execute();
    $resuls = $stms->fetch();
    $empcnti = (isset($resuls['empcnti'])) ? $resuls['empcnti'] : '0' ;
    $empcntipct = (isset($resuls['empcntipct'])) ? $resuls['empcntipct'] : '0' ;

    // MALES
    $qryt = "SELECT count(emp_code) as male,round(count(emp_code) * 100 / (SELECT count(*) from employee_profile),0) as malepct
      FROM employee_profile where sex = 'Male'" ;
    $stmt =$connL->prepare($qryt);
    $stmt->execute();
    $result = $stmt->fetch();
    $male = (isset($result['male'])) ? $result['male'] : '0' ;
    $malepct = (isset($result['malepct'])) ? $result['malepct'] : '0' ;

    // FEMALES
    $qryst = "SELECT count(emp_code) as female,round(count(emp_code) * 100 / (SELECT count(*) from employee_profile),0) as femalepct from employee_profile where sex = 'Female' " ;
    $stmst =$connL->prepare($qryst);
    $stmst->execute();
    $resulst = $stmst->fetch();
    $female = (isset($resulst['female'])) ? $resulst['female'] : '0' ;
    $femalepct = (isset($resulst['femalepct'])) ? $resulst['femalepct'] : '0' ;

    // REGULAR
    $qrysta = "SELECT count(emp_code) as reg,round(count(emp_code) * 100 / (SELECT count(*) from employee_profile),0) as regpct from employee_profile where emp_type = 'Regular' " ;
    $stmsta =$connL->prepare($qrysta);
    $stmsta->execute();
    $resulsta = $stmsta->fetch();
    $reg = (isset($resulsta['reg'])) ? $resulsta['reg'] : '0' ;
    $regpct = (isset($resulsta['regpct'])) ? $resulsta['regpct'] : '0' ;

    // PROBATIONARY
    $qrystab = "SELECT count(emp_code) as prob,round(count(emp_code) * 100 / (SELECT count(*) from employee_profile),0) as probpct from employee_profile where emp_type = 'Probationary' " ;
    $stmstab =$connL->prepare($qrystab);
    $stmstab->execute();
    $resulstab = $stmstab->fetch();
    $prob = (isset($resulstab['prob'])) ? $resulstab['prob'] : '0' ;
    $probpct = (isset($resulstab['probpct'])) ? $resulstab['probpct'] : '0' ;


    // PROJECT BASED
    $rystab = "SELECT count(emp_code) as proj,round(count(emp_code) * 100 / (SELECT count(*) from employee_profile),0) as projpct from employee_profile where emp_type = 'Project Based' " ;
    $tmstab =$connL->prepare($rystab);
    $tmstab->execute();
    $esulstab = $tmstab->fetch();
    $proj = (isset($esulstab['proj'])) ? $esulstab['proj'] : '0' ;
    $projpct = (isset($esulstab['projpct'])) ? $esulstab['projpct'] : '0' ;


    // LEAVE
    $rysta = "SELECT sum(actl_cnt) as leave from tr_leave" ;
    $tmsta =$connL->prepare($rysta);
    $tmsta->execute();
    $esulsta = $tmsta->fetch();
    $leave = (isset($esulsta['leave'])) ? $esulsta['leave'] : '0' ;

    // OVERTIME
    $frysta = "SELECT CAST(sum(ot_req_hrs) AS INT) as ot from tr_overtime" ;
    $ftmsta =$connL->prepare($frysta);
    $ftmsta->execute();
    $fesulsta = $ftmsta->fetch();
    $ot = (isset($fesulsta['ot'])) ? $fesulsta['ot'] : '0' ;

    // WORK FROM HOME
    $fryst = "SELECT CAST(count(wfh_date) AS INT) as wfh from tr_workfromhome" ;
    $ftmst =$connL->prepare($fryst);
    $ftmst->execute();
    $fesulst = $ftmst->fetch();
    $wfh = (isset($fesulst['wfh'])) ? $fesulst['wfh'] : '0' ;


    }
    

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" type="text/css" href="../pages/adm.css">
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>
<body id="page-top" >

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
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">All Active Employee
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $empcnt; ?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar allact" role="progressbar"
                                                            style="width: <?php echo $empcntpct; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">All Inactive Employee
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $empcnti; ?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar allinact" role="progressbar"
                                                            style="width: <?php echo $empcntipct; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users-slash fa-2x text-gray-300"></i>
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
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Male
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $male; ?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: <?php echo $malepct; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-male fa-2x text-gray-300"></i>
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
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Female
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $female; ?></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar female" role="progressbar"
                                                            style="width: <?php echo $femalepct; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-female fa-2x text-gray-300"></i>
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
                                    <h6 class="m-0 font-weight-bold text-primary">ACTIVE EMPLOYEE SUMMARY</h6>
                                    <button id='allemp' value="<?php echo $empcnt; ?>" hidden></button>
                                    <button id='leave' value="<?php echo $leave; ?>" hidden></button>
                                    <button id='otf' value="<?php echo $ot; ?>" hidden></button>
                                    <button id='wfht' value="<?php echo $wfh; ?>" hidden></button>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myBarChart"></canvas>
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
                                    <h6 class="m-0 font-weight-bold text-primary">EMPLOYEE STATUS</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Regular
                                            <button id='reg' value="<?php echo $regpct; ?>" hidden></button>
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Probationary
                                            <button id='prob' value="<?php echo $probpct; ?>" hidden></button>
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Project-Based
                                            <button id='proj' value="<?php echo $projpct; ?>" hidden></button>
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
    <script src="../js/demo/chart-bar-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>
    
</body>

</html>