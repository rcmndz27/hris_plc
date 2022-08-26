\<?php
session_start();

if (empty($_SESSION['userid']))
{
    include_once('../loginfirst.php');
    exit();
}
else
{
  include_once('../_header.php');

  $empInfo = new EmployeeInformation();
  $empInfo->SetEmployeeInformation($_SESSION['userid']);
  $empCode = $empInfo->GetEmployeeCode();

  global $connL;
  global $dbConnection;

    //BIRTHDAY CELEBRANTS
  $queryu = "SELECT * from employee_profile where emp_status = 'Active' AND month(birthdate) = month(GETDATE())";
  $stmtu =$connL->prepare($queryu);
  $stmtu->execute();
  $resultu = $stmtu->fetch();


    //GET COMPANY
  $query = "SELECT * from employee_profile where emp_code = :empcode";
  $stmt =$connL->prepare($query);
  $param = array(":empcode" => $empCode);
  $stmt->execute($param);
  $result = $stmt->fetch();
  $cmp = $result['company'];
  $bdno = $result['badgeno'];
  $subemp = strlen($cmp);

    //GET LAST TIME IN
  $yquery = "SELECT timein from employee_attendance where emp_code = :empcode and punch_date = :todate";
  $ystmt =$connL->prepare($yquery);
  $yparam = array(":empcode" => $bdno,":todate" => date('Y-m-d'));
  $ystmt->execute($yparam);
  $yresult = $ystmt->fetch();
  $timeinf =  (isset($yresult['timein']) ? date('h:i A', strtotime($yresult['timein'])) : 'NO TIME-IN');
    // $start = $yresult['timein'];
  $timeoutf =      (isset($yresult['timein']) ? date('h:i A',strtotime('+10 hour 30 minute',strtotime($yresult['timein']))): 'n/a');

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
  $queryrenot = 'EXEC hrissys_dev.dbo.xp_attendance_portal_work :emp_code,:startDate,:endDate';
  $paramrenot = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-01-01"), ":endDate" => date("Y-12-31") );
  $stmtrenot =$dbConnection->prepare($queryrenot);
  $stmtrenot->execute($paramrenot);
  $resultrenot = $stmtrenot->fetch();
  $workhrs = (isset($resultrenot['workhrs'])) ? round($resultrenot['workhrs'],2) : 0 ;


    //JAN 
  $queryjan = 'EXEC hrissys_dev.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
  $paramjan = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-01-01"), ":endDate" => date("Y-01-31") );
  $stmtjan =$dbConnection->prepare($queryjan);
  $stmtjan->execute($paramjan);
  $resultjan = $stmtjan->fetch();
  $jancnt = $resultjan['cnt'];

    //FEB 
  $queryfeb = 'EXEC hrissys_dev.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
  $paramfeb = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-02-01"), ":endDate" => date("Y-02-28") );
  $stmtfeb =$dbConnection->prepare($queryfeb);
  $stmtfeb->execute($paramfeb);
  $resultfeb = $stmtfeb->fetch();
  $febcnt = $resultfeb['cnt'];

    //MAR 
  $querymar = 'EXEC hrissys_dev.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
  $parammar = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-03-01"), ":endDate" => date("Y-03-31") );
  $stmtmar =$dbConnection->prepare($querymar);
  $stmtmar->execute($parammar);
  $resultmar = $stmtmar->fetch();
  $marcnt = $resultmar['cnt'];

    //APR 
  $queryapr = 'EXEC hrissys_dev.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
  $paramapr = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-04-01"), ":endDate" => date("Y-04-30") );
  $stmtapr =$dbConnection->prepare($queryapr);
  $stmtapr->execute($paramapr);
  $resultapr = $stmtapr->fetch();
  $aprcnt = $resultapr['cnt'];

    //MAY 
  $querymay = 'EXEC hrissys_dev.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
  $parammay = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-05-01"), ":endDate" => date("Y-05-31") );
  $stmtmay =$dbConnection->prepare($querymay);
  $stmtmay->execute($parammay);
  $resultmay = $stmtmay->fetch();
  $maycnt = $resultmay['cnt'];    

    //jun 
  $queryjun = 'EXEC hrissys_dev.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
  $paramjun = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-06-01"), ":endDate" => date("Y-06-30") );
  $stmtjun =$dbConnection->prepare($queryjun);
  $stmtjun->execute($paramjun);
  $resultjun = $stmtjun->fetch();
  $juncnt = $resultjun['cnt'];

    //jul 
  $queryjul = 'EXEC hrissys_dev.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
  $paramjul = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-07-01"), ":endDate" => date("Y-07-31") );
  $stmtjul =$dbConnection->prepare($queryjul);
  $stmtjul->execute($paramjul);
  $resultjul = $stmtjul->fetch();
  $julcnt = $resultjul['cnt'];

    //aug 
  $queryaug = 'EXEC hrissys_dev.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
  $paramaug = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-08-01"), ":endDate" => date("Y-08-31") );
  $stmtaug =$dbConnection->prepare($queryaug);
  $stmtaug->execute($paramaug);
  $resultaug = $stmtaug->fetch();
  $augcnt = $resultaug['cnt'];    

    //sep 
  $querysep = 'EXEC hrissys_dev.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
  $paramsep = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-09-01"), ":endDate" => date("Y-09-30") );
  $stmtsep =$dbConnection->prepare($querysep);
  $stmtsep->execute($paramsep);
  $resultsep = $stmtsep->fetch();
  $sepcnt = $resultsep['cnt'];

    //OCT 
  $queryoct = 'EXEC hrissys_dev.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
  $paramoct = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-10-01"), ":endDate" => date("Y-10-31") );
  $stmtoct =$dbConnection->prepare($queryoct);
  $stmtoct->execute($paramoct);
  $resultoct = $stmtoct->fetch();
  $octcnt = $resultoct['cnt'];

    //nov 
  $querynov = 'EXEC hrissys_dev.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
  $paramnov = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-11-01"), ":endDate" => date("Y-11-30") );
  $stmtnov =$dbConnection->prepare($querynov);
  $stmtnov->execute($paramnov);
  $resultnov = $stmtnov->fetch();
  $novcnt = $resultnov['cnt'];    

    //dec 
  $querydec = 'EXEC hrissys_dev.dbo.xp_attendance_portal_count :emp_code,:startDate,:endDate';
  $paramdec = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-12-01"), ":endDate" => date("Y-12-31") );
  $stmtdec =$dbConnection->prepare($querydec);
  $stmtdec->execute($paramdec);
  $resultdec = $stmtdec->fetch();
  $deccnt = $resultdec['cnt'];  

    //laudot 
  $querylaudot = 'EXEC hrissys_dev.dbo.xp_attendance_portal_sum :emp_code,:startDate,:endDate';
  $paramlaudot = array(":emp_code" => substr($empCode,$subemp), ":startDate" => date("Y-01-01"), ":endDate" => date("Y-12-31") );
  $stmtlaudot =$dbConnection->prepare($querylaudot);
  $stmtlaudot->execute($paramlaudot);
  $resultlaudot = $stmtlaudot->fetch();
  $latepct = (isset($resultlaudot['latepct'])) ? round($resultlaudot['latepct'],2) : 0 ;
  $udpct =  (isset($resultlaudot['udpct'])) ? round($resultlaudot['udpct'],2) : 0 ;
  $otpct = (isset($resultlaudot['otpct'])) ? round($resultlaudot['otpct'],2) : 0 ;

    //wfh login
  $spquery = "SELECT (CASE when status = 1 then 'PENDING'
    when   status = 2 then 'APPROVED'
    when   status = 3 then 'REJECTED'
    when   status = 4 then 'CANCELLED' ELSE 'N/A' END) as stats,a.rowid  as wfhid,a.emp_code as empcd,b.rowid as attid,* 
  FROM dbo.tr_workfromhome a
  left join employee_attendance b
  on RIGHT(A.emp_code, LEN(A.emp_code) - 3) = b.emp_code
  and a.wfh_date = b.punch_date where a.emp_code = :emp_code and a.wfh_date = :wfh_date and status = 2 ORDER BY wfh_date DESC";
  $spparam = array(':emp_code' => $empCode,':wfh_date' => date('Y-m-d'));
  $spstmt =$connL->prepare($spquery);
  $spstmt->execute($spparam);
  $spresult = $spstmt->fetch();
  $wfhd =  (isset($spresult['wfh_date'])) ? "'".$spresult['wfh_date']."'" : null ;
  $wfhid = (isset($spresult['wfhid'])) ? "'".$spresult['wfhid']."'" : '' ;
  $wfhempcd = (isset($spresult['empcd'])) ? "'".$spresult['empcd']."'" : '' ;
  $attid = (isset($spresult['attid'])) ? "'".$spresult['attid']."'" : '' ;
}

?>
<script type="text/javascript">

    function timeInModal(lvid,empcd){

        $('#timeInModal').modal('toggle');
        document.getElementById('empcd').value =  empcd;   
        document.getElementById('lvid').value =  lvid;   

    }

    function timeIn()
    {

        var url = "../wfhome/timeInProcess.php";  
        var wfhid = document.getElementById("lvid").value; 
        var emp_code = document.getElementById("empcd").value;
        var wfh_output = document.getElementById("wfh_output").value;  

        if(wfh_output){
            swal({
              title: "Are you sure?",
              text: "You want to time in now?",
              icon: "success",
              buttons: true,
              dangerMode: true,
          })
            .then((timeIn) => {
              if (timeIn) {
                $.post (
                    url,
                    {
                        choice: 1,
                        wfhid:wfhid,
                        emp_code:emp_code,
                        wfh_output:wfh_output
                    },
                    function(data) { 
                        console.log(data);
                        swal({
                            title: "Success!", 
                            text: "Successfully time in!", 
                            type: "info",
                            icon: "info",
                        }).then(function() {
                            location.href = '../pages/employee.php';
                        });  
                    }
                    );
            } else {
                swal({text:"You cancel your time in!",icon:"warning"});
            }
        });
        }else{
            swal({text:"Kindly fill up blank details!",icon:"warning"});
        }


    }    

    function timeOutModal(lvid,empcd,attid){

        $('#timeOutModal').modal('toggle');
        document.getElementById('empcd').value =  empcd;   
        document.getElementById('lvid').value =  lvid;   
        document.getElementById('attid').value =  attid;   

    }

    function timeOut()
    {

        var url = "../wfhome/timeInProcess.php";  
        var wfhid = document.getElementById("lvid").value; 
        var emp_code = document.getElementById("empcd").value;
        var wfh_output2 = document.getElementById("wfh_output2").value;  
        var wfh_percentage = document.getElementById("wfh_percentage").value;  
        var attid = document.getElementById("attid").value;  


        if(!wfh_output2 || !wfh_percentage){
          swal({text:"Kindly fill up blank details!",icon:"warning"});  
      }else{
        swal({
          title: "Are you sure?",
          text: "You want to time out now?",
          icon: "success",
          buttons: true,
          dangerMode: true,
      })
        .then((timeIn) => {
          if (timeIn) {
            $.post (
                url,
                {
                    choice: 2,
                    wfhid:wfhid,
                    emp_code:emp_code,
                    wfh_output2:wfh_output2,
                    wfh_percentage:wfh_percentage,
                    attid:attid

                },
                function(data) { 
                    console.log(data);
                    swal({
                        title: "Success!", 
                        text: "Successfully time out!", 
                        type: "info",
                        icon: "info",
                    }).then(function() {
                        location.href = '../wfhome/wfh_app_view.php';
                    });  
                }
                );
        } else {
            swal({text:"You cancel your time out!",icon:"warning"});
        }
    });                
    }

}    
</script>

<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<body id="page-top" style="background-color: #f8f9fc;height:100%;overflow: hidden;">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <div class="modal fade" id="timeInModal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title bb" id="popUpModalTitle">Time-In <i class="fas fa-play"></i></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times; </span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div>                  

                                <input type="text" name="lvid" id="lvid" hidden>
                                <input type="text" name="empcd" id="empcd" hidden>
                                <div class="form-row align-items-center mb-2">
                                    <div class="col-md-2 d-inline">
                                        <label for="">Expected Output:</label><span class="req">*</span>
                                    </div>
                                    <div class="col-md-10 d-inline">
                                     <textarea class="form-control inputtext" id="wfh_output" name="wfh_output" rows="4" cols="50" ></textarea> 
                                 </div>
                             </div>

                         </div>
                     </div>


                     <div class="modal-footer">
                        <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                        <button type="button" class="subbut" id="Submit" onclick="timeIn()" ><i class="fas fa-check-circle"></i> SUBMIT</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- end timein wfh -->


        <!-- start time out wfh  -->

        <div class="modal fade" id="timeOutModal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">Time-Out <i class="fas fa-hand-paper"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>                  
                        <input type="text" name="lvid" id="lvid" hidden>
                        <input type="text" name="empcd" id="empcd" hidden>
                        <input type="text" name="attid" id="attid" hidden>
                        <div class="form-row align-items-center mb-2">
                            <div class="col-md-2 d-inline">
                                <label for="">Output:</label><span class="req">*</span>
                            </div>
                            <div class="col-md-10 d-inline">
                                <textarea class="form-control inputtext" id="wfh_output2" name="wfh_output2" rows="4" cols="50" ></textarea>                                        
                            </div>
                        </div>
                        <div class="form-row align-items-center mb-2">
                           <div class="col-md-2 d-inline">
                            <label for="">Percentage:</label><span class="req">*</span>
                        </div>
                        <div class="col-md-2 d-inline">
                            <input type="number" id="wfh_percentage" name="wfh_percentage" class="form-control inputtext" min="10" max="100" step="10" onkeypress="return false" placeholder="0">
                        </div>
                        <div class="col-md-1 d-inline">
                            <label for="">%</label>
                        </div> 
                    </div>                            

                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                <button type="button" class="subbut" id="Submit" onclick="timeOut()" ><i class="fas fa-check-circle"></i> SUBMIT</button>
            </div>

        </div>
    </div>
</div>

<!-- end time out wfh -->
<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 pt-5">
     <h1><br></h1>
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

<!-- time in -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Today's Time-In: <?php echo date("F d, Y");  if(isset($wfhd)){echo': WFH';}   ?> 
                </div>
                <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $timeinf; ?>
                        <?php  

                        if(isset($wfhd)){
                            if(empty($spresult['timein']) && empty($spresult['timeout'])){
                                echo'
                                <button type="button"  class="startIn" onclick="timeInModal('.$wfhid.','.$wfhempcd.')" title="Time In">
                                <i class="fas fa-play"> Time-In </i>
                                </button>                            
                                </td>';
                            }else if(!empty($spresult['timein']) && empty($spresult['timeout'])){
                                echo'<button type="button"  class="startOut" onclick="timeOutModal('.$wfhid.','.$wfhempcd.','.$attid.')" title="Time Out">
                                <i class="fas fa-hand-paper"> Time-Out </i>
                                </button>                            
                                </td>';

                            }
                        }else{
                        }   
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-auto py-2">
            <i class="fas fa-clock fa-2x text-gray-300"></i>
        </div>
    </div>
    <span class="text-muted small pt-2 ps-1">Estimated Time-Out:</span>
    <span class="text-success small pt-1 fw-bold"><?php echo $timeoutf; ?></span> 
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
<div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-birthday-cake"></i> BIRTHDAY CELEBRANTS <?php echo strtoupper(date("M Y")) ?> </h6>
        </div>
        <!-- Card Body -->

        <div class="card-body">
            <?php  
            if($resultu){
                $ppic = (isset($resultu['emp_pic_loc'])) ? $resultu['emp_pic_loc'] : 'nophoto.jpg' ;

                do { 
                    echo ' <div class="row">
                    <div class="col-sm-1">
                    <h6 class="mb-0"><img class="rounded-circle" style="width:40px;height:40px;" src="../img/'.$ppic.'"></h6>
                    </div>
                    <div class="col-sm-9 text-secondary"><b>
                    '.$resultu['firstname'].' '.$resultu['lastname'].'</b><br>'.$resultu['department'].'<br>'.date('F d', strtotime($resultu['birthdate'])).'  
                    </div>
                    </div><hr style="margin:5;">  ';

                } while ($resultu = $stmtu->fetch());
            }

            ?>             
        </div>
    </div>
</div>                   
</div>

</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
</div>
<!-- End of Content Wrapper -->,
</div>
<!-- End of Page Wrapper -->

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