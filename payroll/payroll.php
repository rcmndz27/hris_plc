<?php 


function GetPayrollList($action, $dtFrom, $dtTo,$location,$empCode){

           
            global $connL;

            $totalDaysAbsent = 0;
            $totalDaysWorked = 0;
            $lates = 0;
            $undertime = 0;
            $reg_ot = 0;
            $res = 0; 
            $rd_ot = 0;
            $rh_ot = 0;
            $sh_ot = 0;
            $spr_ot = 0;
            $nd = 0;
            $nd_ot = 0;
            $ndr_ot = 0;
            $sl = 0;
            $vl = 0;

            $qins = 'INSERT INTO dbo.payroll_period_logs (emp_code,period_from,period_to,location) 
            VALUES (:emp_code,:period_from,:period_to,:location)';
            $stmt_ins =$connL->prepare($qins);                                 
                                                $params = array(
                                                ":emp_code" => $empCode,
                                                ":period_from" => $dtFrom,
                                                ":period_to" => $dtTo,
                                                ":location" => $location,
                                                );                                
            $result = $stmt_ins->execute($params);


            $query = 'SELECT a.emp_code,a.lastname,a.firstname,a.middlename,b.badge_no,b.employee,b.location,period_from
                  ,period_to,tot_days_absent,tot_days_work
                  ,tot_lates
                  ,tot_overtime_reg
                  ,tot_rest
                  ,tot_overtime_rest
                  ,tot_overtime_regholiday
                  ,tot_overtime_spholiday
                  ,tot_overtime_sprestholiday
                  ,total_undertime
                  ,night_differential
                  ,night_differential_ot
                  ,night_differential_ot_rest 
                  ,sick_leave
                  ,vacation_leave,b.rowid
                  from employee_profile a left join
                  att_summary b on a.badgeno = b.badge_no
                    WHERE tot_days_work is not null and a.emp_status = :status and period_from = :period_from AND period_to = :period_to and b.location = :location ORDER BY a.lastname DESC';
            $param = array(":period_from" => $dtFrom, ":period_to" => $dtTo, ":location" => $location, ":status" => 'Active');
            $stmt =$connL->prepare($query);
            $stmt->execute($param);
            $r = $stmt->fetch();

            // var_dump($r);
            // exit()

            echo "
            
            <input type='text' id='myInput' onkeyup='myFunction()' placeholder='Search for names..' title='Type in a name'>
            <table id='payrollList' class='table table-striped table-sm' cellpadding='0' cellspacing='0'> 
                <thead>
                    <tr>
                        <th colspan='21' class='paytop'>Payroll Period of ".$location." from ".$dtFrom." to ".$dtTo."  </th>
                    </tr>
                    <tr class='noExl'>
                        <th colspan='3'>Employee Name</th>
                        <th>Employee Code</th>
                        <th>Total Days Absent</th>
                        <th>Total Days Worked</th>
                        <th>Lates (Hrs)</th>
                        <th>Undertime (Hrs)</th>
                        <th>Regular Overtime (Hrs)</th>
                        <th>Rest Day (Hrs)</th>
                        <th>Rest Day Overtime (Hrs)</th>
                        <th>Regular Holiday Overtime (Hrs)</th>
                        <th>Special Holiday Overtime (Hrs)</th> 
                        <th>Special Holiday Rest Day Overtime (Hrs)</th> 
                        <th>Night Differential (Hrs)</th> 
                        <th>Night Differential OT (Hrs)</th> 
                        <th>Night Differential Rest Day OT (Hrs)</th>
                        <th>Sick Leave (Days)</th> 
                        <th>Vacation Leave (Days)</th>                          
                        <th class='evac'>Edit/View Attendance</th>           
                    </tr>
                </thead>
                <tbody>";

                 if($r){
                    do {
                        $empn = "'".$r['employee']."'";
                        $badgeno = "'".$r['badge_no']."'"; 
                        $pfrom = "'".date('Y-m-d', strtotime($r['period_from']))."'"; 
                        $pto = "'".date('Y-m-d', strtotime($r['period_to']))."'"; 
                        // $toa = "'".round($r['tot_days_absent'],2)."'";
                        // $tow = "'".round($r['tot_days_work'],2)."'";                                               
                        // $treg = "'".round($r['tot_overtime_reg'],2)."'";
                        // $tres = "'".round($r['tot_overtime_rest'],2)."'";
                        // $tresh = "'".round($r['tot_overtime_regholiday'],2)."'";
                        // $tsp = "'".round($r['tot_overtime_spholiday'],2)."'";
                        // $tsprh = "'".round($r['tot_overtime_sprestholiday'],2)."'";
                        // $ndh = "'".round($r['night_differential'],2)."'";
                        // $ndoth = "'".round($r['night_differential_ot'],2)."'";
                        // $ndotrh = "'".round($r['night_differential_ot_rest'],2)."'";
                        // $slh = "'".round($r['sick_leave'],2)."'";
                        // $vlh = "'".round($r['vacation_leave'],2)."'";                        
                echo "<tr>".
                        "<td id='ln".$r['badge_no']."'>" . $r['lastname'] . "</td>".
                        "<td id='fn".$r['badge_no']."'>" . $r['firstname'] . "</td>".
                        "<td id='mn".$r['badge_no']."'>" . $r['middlename'] . "</td>".
                        "<td>" . $r['badge_no'] . "</td>".
                        "<td id='empc".$r['badge_no']."' hidden>" . $r['emp_code'] . "</td>".
                        "<td id='pf".$r['badge_no']."' hidden>".date('Y-m-d', strtotime($r['period_from']))."</td>".
                        "<td id='pt".$r['badge_no']."' hidden>".date('Y-m-d', strtotime($r['period_to']))."</td>".
                        "<td id='toa".$r['badge_no']."'>" . round($r['tot_days_absent'],2) . "</td>".
                        "<td id='tow".$r['badge_no']."'>" . round($r['tot_days_work'],2) . "</td>".
                        "<td id='tol".$r['badge_no']."'>" . round($r['tot_lates'],2) . "</td>".
                        "<td id='tou".$r['badge_no']."'>" . round($r['total_undertime'],2) . "</td>".
                        "<td id='tor".$r['badge_no']."'>" . round($r['tot_overtime_reg'],2) . "</td>".
                        "<td id='tos".$r['badge_no']."'>" . round($r['tot_rest'],2) . "</td>".
                        "<td id='tors".$r['badge_no']."'>" . round($r['tot_overtime_rest'],2) . "</td>".
                        "<td id='torg".$r['badge_no']."'>" . round($r['tot_overtime_regholiday'],2) . "</td>".
                        "<td id='tosp".$r['badge_no']."'>" . round($r['tot_overtime_spholiday'],2) . "</td>".
                        "<td id='tospr".$r['badge_no']."'>" . round($r['tot_overtime_sprestholiday'],2) . "</td>".
                        "<td id='nd".$r['badge_no']."'>" . round($r['night_differential'],2) . "</td>".
                        "<td id='ndot".$r['badge_no']."'>" . round($r['night_differential_ot'],2) . "</td>".
                        "<td id='ndrot".$r['badge_no']."'>" . round($r['night_differential_ot_rest'],2) . "</td>".
                        "<td id='slh".$r['badge_no']."'>" . round($r['sick_leave'],2) . "</td>".
                        "<td id='vlh".$r['badge_no']."'>" . round($r['vacation_leave'],2) . "</td>"                                    ;
                        echo'<td><button type="button"class="hdeactv" 
                        onclick="editAttModal('.$empn.','.$badgeno.')" title="Edit Attendance">
                                            <i class="fas fa-edit"></i>
                                                        </button>
                            <button type="button" class="hactv" onclick="viewAllAttendanceEmp('.$badgeno.','.$pfrom.','.$pto.')" title="View Attendance Logs">
                                <i class="fas fa-clock"></i>
                            </button>
                            <button type="button" class="voidBut" onclick="viewPayrollLogs('.$badgeno.','.$pfrom.','.$pto.')" title="View Attendance Audit Logs">
                                <i class="fas fa-history"></i>
                            </button>                            
                            </td></tr>';
                
                                $totalDaysAbsent += round($r['tot_days_absent'], 2);
                                $totalDaysWorked += round($r['tot_days_work'] , 2);
                                $lates += round($r['tot_lates'], 2);
                                $undertime += round($r['total_undertime'] , 2);
                                $reg_ot += round($r['tot_overtime_reg'], 2);
                                $res += round($r['tot_rest'], 2);
                                $rd_ot += round($r['tot_overtime_rest'] , 2);
                                $rh_ot += round($r['tot_overtime_regholiday'], 2);
                                $sh_ot += round($r['tot_overtime_spholiday'] , 2);
                                $spr_ot += round($r['tot_overtime_sprestholiday'], 2);
                                $nd += round($r['night_differential'], 2);
                                $nd_ot += round($r['night_differential_ot'] , 2);
                                $ndr_ot += round($r['night_differential_ot_rest'] , 2);
                                $sl += round($r['sick_leave'] , 2);
                                $vl += round($r['vacation_leave'] , 2);                                                                                              
                
                               
                   } while($r = $stmt->fetch(PDO::FETCH_ASSOC));

                            $q_logs = 'SELECT * FROM dbo.payroll WHERE rowid = (SELECT MAX(rowid) AS id 
                            from dbo.payroll where audituser = :emp_cd)';
                            $paramq = array(":emp_cd" => $empCode);
                            $stmt_q =$connL->prepare($q_logs);
                            $stmt_q->execute($paramq);
                            $rs = $stmt_q->fetch();


                        if($rs){                                         
                                    $dtf = date('m/d/Y', strtotime($rs['date_from']));
                                    $dtt = date('m/d/Y', strtotime($rs['date_to']));

                                    $dtf_l = ($dtf === false) ? '0000-00-00' : $dtf;
                                    $dtt_l = ($dtt === false) ? '0000-00-00' : $dtt;
                                    $loc_l = ($rs['location'] === false) ? '0000-00-00' : $rs['location'];

                                       echo"</tbody>";
                                       echo "<tfoot>
                                            <tr>".
                                                "<td class='text-center bg-success' colspan='4'><b>Total</b></td>".
                                                "<td class='bg-success'><b>" . $totalDaysAbsent . "</b></td>".
                                                "<td class='bg-success'><b>" . $totalDaysWorked . "</b></td>".
                                                "<td class='bg-success'><b>" . $lates . "</b></td>".
                                                "<td class='bg-success'><b>" . $undertime . "</b></td>".
                                                "<td class='bg-success'><b>" . $reg_ot . "</b></td>".
                                                "<td class='bg-success'><b>" . $res . "</b></td>".
                                                "<td class='bg-success'><b>" . $rd_ot . "</b></td>".
                                                "<td class='bg-success'><b>" . $rh_ot . "</b></td>".
                                                "<td class='bg-success'><b>" . $sh_ot . "</b></td>".
                                                "<td class='bg-success'><b>" . $spr_ot . "</b></td>".
                                                "<td class='bg-success'><b>" . $nd . "</b></td>".
                                                "<td class='bg-success'><b>" . $nd_ot . "</b></td>".
                                                "<td class='bg-success'><b>" . $ndr_ot . "</b></td>".
                                                "<td class='bg-success'><b>" . $sl . "</b></td>".
                                                "<td class='bg-success' colspan='2'><b>" . $vl . "</b></td>".                                                
                                                "</tr><tr>";
                                            if($dtf_l == $dtFrom and $dtt_l == $dtTo and 
                                                ucwords(strtolower($loc_l)) == ucwords(strtolower($location))){
                                                echo"<td colspan='21' class='paytop'>".
                                                "</tr></tfoot>";   
                                            }else{
                                                echo"<td colspan='21' class='paytop'>".
                                                "<div class='mt-3 d-flex justify-content-center'><button class='svepyrll' onclick='ApprovePayView()'><i class='fas fa-save'></i> SAVE PAYROLL</button></div></td>".
                                                "</tr></tfoot>";  
                                            }

                            }else{
                                        echo"</tbody>";
                                        echo "<tfoot>
                                        <tr>".
                                            "<td class='text-center bg-success' colspan='4'><b>Total</b></td>".
                                            "<td class='bg-success'><b>" . $totalDaysAbsent . "</b></td>".
                                            "<td class='bg-success'><b>" . $totalDaysWorked . "</b></td>".
                                            "<td class='bg-success'><b>" . $lates . "</b></td>".
                                            "<td class='bg-success'><b>" . $undertime . "</b></td>".
                                            "<td class='bg-success'><b>" . $reg_ot . "</b></td>".
                                            "<td class='bg-success'><b>" . $res . "</b></td>".
                                            "<td class='bg-success'><b>" . $rd_ot . "</b></td>".
                                            "<td class='bg-success'><b>" . $rh_ot . "</b></td>".
                                            "<td class='bg-success'><b>" . $sh_ot . "</b></td>".
                                            "<td class='bg-success'><b>" . $spr_ot . "</b></td>".
                                            "<td class='bg-success'><b>" . $nd . "</b></td>".
                                            "<td class='bg-success'><b>" . $nd_ot . "</b></td>".
                                            "<td class='bg-success'><b>" . $ndr_ot . "</b></td>".
                                            "<td class='bg-success'><b>" . $sl . "</b></td>".
                                            "<td class='bg-success' colspan='2'><b>" . $vl . "</b></td>".
                                            "</tr><tr>"; 
                                            echo"<td colspan='21' class='paytop'>".
                                            "<div class='mt-3 d-flex justify-content-center'><button class='svepyrll' onclick='ApprovePayView()'><i class='fas fa-save'></i> SAVE PAYROLL</button></div></td>".
                                            "</tr></tfoot>";  
                                        
                            }

            
                }else { 
                    echo '<tfoot><tr><td colspan="10" class="paytop">No Results Found</td></tr></tfoot>'; 
                }
    
            echo"</table>"; 
                                          
}

 

?>
