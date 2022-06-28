<?php
 

class PayrollRegApplication { 
    function GetPayrollRegList(){

           
            global $connL;

            $query = "SELECT * FROM dbo.payroll WHERE payroll_status = 'R' ORDER BY name asc";
            $stmt =$connL->prepare($query);
            $stmt->execute();
            $r = $stmt->fetch();


            echo "
        <div class='form-row'>  
                    <div class='col-lg-1'>
                        <select class='form-select' name='state' id='maxRows'>
                             <option value='5000'>ALL</option>
                             <option value='5'>5</option>
                             <option value='10'>10</option>
                             <option value='15'>15</option>
                             <option value='20'>20</option>
                             <option value='50'>50</option>
                             <option value='70'>70</option>
                             <option value='100'>100</option>
                        </select> 
                </div>         
                <div class='col-lg-8'>
                </div>                               
                <div class='col-lg-3'>        
                    <input type='text' id='myInput' class='form-control' onkeyup='myFunction()' placeholder='Search for employee payroll..' title='Type in employee details'> 
                        </div>                     
                </div>   
            <table id='payrollRegList' class='table table-striped table-sm'>
                <thead>
                    <tr>
                        <th colspan='63' class='paytop'>Payroll Register View</th>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Bank Account#</th>
                        <th>Bank</th>
                        <th>Position</th>
                        <th>Employment Status</th>
                        <th>Company</th>
                        <th>Department </th>
                        <th>Location</th>
                        <th>Date Hired</th>
                        <th>Cut-off From</th>
                        <th>Cut-off To</th>
                        <th>Monthly Rate</th>
                        <th>Daily Rate</th>
                        <th>Semi-Monthly Rate</th>
                        <th>Absences</th>
                        <th> Lates </th>
                        <th> Undertime </th>
                        <th> Salary Adjustment (Days)</th>
                        <th> Salary Adjustment (Hrs)</th>
                        <th> Overtime </th>
                        <th> Meal Allowance </th>
                        <th> Salary Allowance </th>
                        <th> Out of Town Allowance </th>
                        <th> Incentives Allowance </th>
                        <th> Relocation Allowance </th>
                        <th> Discretionary Allowance </th>
                        <th> Transportation Allowance</th>
                        <th> Load Allowance </th>
                        <th> Sick Leave</th>
                        <th> Vacation Leave </th>   
                        <th> Sick Leave No Pay</th>
                        <th> Vacation Leave No Pay</th>  
                        <th> Work From Home </th>
                        <th> Official Business </th>                                            
                        <th> Grosspay </th>
                        <th> Total Taxable </th>
                        <th> Withholding Tax </th>
                        <th> SSS EE </th>
                        <th> SSS MPF EE </th>
                        <th> PHIC EE </th>
                        <th> hdmf EE </th>
                        <th> hdmf Salary Loan </th>
                        <th> hdmf Calamity Loan </th>
                        <th> SSS Salary Loan </th>
                        <th> SSS Calamity Loan </th>
                        <th> Salary Deduction (Taxable)</th>
                        <th> Salary Deduction (Non-Taxable)</th>
                        <th> Salary Loan </th>
                        <th> Company Loan </th>
                        <th> OMHAS </th>
                        <th> COOP CBU </th>
                        <th> COOP Regular Loan </th>
                        <th> COOP MESCCO </th>
                        <th> Uploan </th>
                        <th> Others</th>
                        <th> Total Deduction</th>
                        <th> Netpay </th>
                        <th> SSS ER </th>
                        <th> SSS MPF ER </th>
                        <th> SSS EC </th>
                        <th> PHIC ER </th>
                        <th> hdmf ER </th> 
                        <th> TIN No. </th>
                        <th> Philhealth No. </th>
                        <th> Pagibig No. </th>
                        <th> SSS No. </th>                            
                    </tr>
                </thead>
                <tbody>";

                 if($r){
                    do {

$absences = ($r['absences'] <> '0') ?  '&#8369;'.number_format($r['absences'],2,'.',',') : 0 ;
$late = ($r['late'] <> '0') ?  '&#8369;'.number_format($r['late'],2,'.',',') : 0 ;
$undertime = ($r['undertime'] <> '0') ?  '&#8369;'.number_format($r['undertime'],2,'.',',') : 0 ;
$total_adjstmenthrs = ($r['total_adjstmenthrs'] <> '0') ?  '&#8369;'.number_format($r['total_adjstmenthrs'],2,'.',',') : 0 ;
$salary_adjustment = ($r['salary_adjustment'] <> '0') ?  '&#8369;'.number_format($r['salary_adjustment'],2,'.',',') : 0 ;
$overtime = ($r['overtime'] <> '0') ?  '&#8369;'.number_format($r['overtime'],2,'.',',') : 0 ;
$meal_allowance = ($r['meal_allowance'] <> '0') ?  '&#8369;'.number_format($r['meal_allowance'],2,'.',',') : 0 ;
$salary_allowance = ($r['salary_allowance'] <> '0') ?  '&#8369;'.number_format($r['salary_allowance'],2,'.',',') : 0 ;
$oot_allowance = ($r['oot_allowance'] <> '0') ?  '&#8369;'.number_format($r['oot_allowance'],2,'.',',') : 0 ;
$inc_allowance = ($r['inc_allowance'] <> '0') ?  '&#8369;'.number_format($r['inc_allowance'],2,'.',',') : 0 ;
$rel_allowance = ($r['rel_allowance'] <> '0') ?  '&#8369;'.number_format($r['rel_allowance'],2,'.',',') : 0 ;
$disc_allowance = ($r['disc_allowance'] <> '0') ?  '&#8369;'.number_format($r['disc_allowance'],2,'.',',') : 0 ;
$trans_allowance = ($r['trans_allowance'] <> '0') ?  '&#8369;'.number_format($r['trans_allowance'],2,'.',',') : 0 ;
$load_allowance = ($r['load_allowance'] <> '0') ?  '&#8369;'.number_format($r['load_allowance'],2,'.',',') : 0 ;
$sick_leave = ($r['sick_leave'] <> '0') ?  '&#8369;'.number_format($r['sick_leave'],2,'.',',') : 0 ;
$vacation_leave = ($r['vacation_leave'] <> '0') ?  '&#8369;'.number_format($r['vacation_leave'],2,'.',',') : 0 ;
$wfhome = ($r['wfhome'] <> '0') ?  '&#8369;'.number_format($r['wfhome'],2,'.',',') : 0 ;
$offbusiness = ($r['offbusiness'] <> '0') ?  '&#8369;'.number_format($r['offbusiness'],2,'.',',') : 0 ;
$sick_leave_nopay = ($r['sick_leave_nopay'] <> '0') ?  '&#8369;'.number_format($r['sick_leave_nopay'],2,'.',',') : 0 ;
$vacation_leave_nopay = ($r['vacation_leave_nopay'] <> '0') ?  '&#8369;'.number_format($r['vacation_leave_nopay'],2,'.',',') : 0 ;
$gross_pay = ($r['gross_pay'] <> '0') ?  '&#8369;'.number_format($r['gross_pay'],2,'.',',') : 0 ;
$total_taxable = ($r['total_taxable'] <> '0') ?  '&#8369;'.number_format($r['total_taxable'],2,'.',',') : 0 ;
$witholding_tax = ($r['witholding_tax'] <> '0') ?  '&#8369;'.number_format($r['witholding_tax'],2,'.',',') : 0 ;
$sss_regee = ($r['sss_regee'] <> '0') ?  '&#8369;'.number_format($r['sss_regee'],2,'.',',') : 0 ;
$sss_mpfee = ($r['sss_mpfee'] <> '0') ?  '&#8369;'.number_format($r['sss_mpfee'],2,'.',',') : 0 ;
$phic_ee = ($r['phic_ee'] <> '0') ?  '&#8369;'.number_format($r['phic_ee'],2,'.',',') : 0 ;
$hdmf_ee = ($r['hdmf_ee'] <> '0') ?  '&#8369;'.number_format($r['hdmf_ee'],2,'.',',') : 0 ;
$hdmf_sal_loan = ($r['hdmf_sal_loan'] <> '0') ?  '&#8369;'.number_format($r['hdmf_sal_loan'],2,'.',',') : 0 ;
$hdmf_cal_loan = ($r['hdmf_cal_loan'] <> '0') ?  '&#8369;'.number_format($r['hdmf_cal_loan'],2,'.',',') : 0 ;
$sss_sal_loan = ($r['sss_sal_loan'] <> '0') ?  '&#8369;'.number_format($r['sss_sal_loan'],2,'.',',') : 0 ;
$sss_cal_loan = ($r['sss_cal_loan'] <> '0') ?  '&#8369;'.number_format($r['sss_cal_loan'],2,'.',',') : 0 ;
$sal_ded_tax = ($r['sal_ded_tax'] <> '0') ?  '&#8369;'.number_format($r['sal_ded_tax'],2,'.',',') : 0 ;
$sal_ded_nontax = ($r['sal_ded_nontax'] <> '0') ?  '&#8369;'.number_format($r['sal_ded_nontax'],2,'.',',') : 0 ;
$sal_loan = ($r['sal_loan'] <> '0') ?  '&#8369;'.number_format($r['sal_loan'],2,'.',',') : 0 ;
$com_loan = ($r['com_loan'] <> '0') ?  '&#8369;'.number_format($r['com_loan'],2,'.',',') : 0 ;
$omhas = ($r['omhas'] <> '0') ?  '&#8369;'.number_format($r['omhas'],2,'.',',') : 0 ;
$coop_cbu = ($r['coop_cbu'] <> '0') ?  '&#8369;'.number_format($r['coop_cbu'],2,'.',',') : 0 ;
$coop_reg_loan = ($r['coop_reg_loan'] <> '0') ?  '&#8369;'.number_format($r['coop_reg_loan'],2,'.',',') : 0 ;
$coop_messco = ($r['coop_messco'] <> '0') ?  '&#8369;'.number_format($r['coop_messco'],2,'.',',') : 0 ;
$uploan = ($r['uploan'] <> '0') ?  '&#8369;'.number_format($r['uploan'],2,'.',',') : 0 ;
$others = ($r['others'] <> '0') ?  '&#8369;'.number_format($r['others'],2,'.',',') : 0 ;
$total_deduction = ($r['total_deduction'] <> '0') ?  '&#8369;'.number_format($r['total_deduction'],2,'.',',') : 0 ;
$netpay = ($r['netpay'] <> '0') ?  '&#8369;'.number_format($r['netpay'],2,'.',',') : 0 ;
$sss_reg_er = ($r['sss_reg_er'] <> '0') ?  '&#8369;'.number_format($r['sss_reg_er'],2,'.',',') : 0 ;
$sss_mpf_er = ($r['sss_mpf_er'] <> '0') ?  '&#8369;'.number_format($r['sss_mpf_er'],2,'.',',') : 0 ;
$sss_ec = ($r['sss_ec'] <> '0') ?  '&#8369;'.number_format($r['sss_ec'],2,'.',',') : 0 ;
$phic_er = ($r['phic_er'] <> '0') ?  '&#8369;'.number_format($r['phic_er'],2,'.',',') : 0 ;
$hdmf_er = ($r['hdmf_er'] <> '0') ?  '&#8369;'.number_format($r['hdmf_er'],2,'.',',') : 0 ;

    echo "<tr>".
    "<td>" . $r['name'] . "</td>".
    "<td>" . $r['emp_code'] . "</td>".
    "<td>" . $r['bank_acctno'] . "</td>".
    "<td>" . $r['bank'] . "</td>".
    "<td>" . $r['position'] . "</td>".
    "<td>" . $r['emp_status'] . "</td>".
    "<td>" . $r['company'] . "</td>".
    "<td>" . $r['department'] . "</td>".
    "<td>" . $r['location'] . "</td>".
    "<td>" . date('m/d/y', strtotime($r['date_hired'])) . "</td>".
    "<td>" . date('m/d/y', strtotime($r['date_from'])) . "</td>".
    "<td>" . date('m/d/y', strtotime($r['date_to'])) . "</td>".
    "<td>" . '&#8369;'.number_format($r['month_pay'],2,'.',','). "</td>".
    "<td>" . '&#8369;'.number_format($r['daily_pay'],2,'.',','). "</td>".
    "<td>" . '&#8369;'.number_format($r['semi_month_pay'],2,'.',','). "</td>".
    "<td>" . $absences. "</td>".
    "<td>" . $late. "</td>".
    "<td>" . $undertime. "</td>".
    "<td>" . $total_adjstmenthrs. "</td>".
    "<td>" . $salary_adjustment. "</td>".
    "<td>" . $overtime. "</td>".
    "<td>" . $meal_allowance. "</td>".
    "<td>" . $salary_allowance. "</td>".
    "<td>" . $oot_allowance. "</td>".
    "<td>" . $inc_allowance. "</td>".
    "<td>" . $rel_allowance. "</td>"                                   .
    "<td>" . $disc_allowance. "</td>".
    "<td>" . $trans_allowance. "</td>".
    "<td>" . $load_allowance. "</td>".
    "<td>" . $sick_leave. "</td>".
    "<td>" . $vacation_leave. "</td>". 
    "<td>" . $sick_leave_nopay. "</td>".
    "<td>" . $vacation_leave_nopay. "</td>".   
    "<td>" . $wfhome. "</td>".
    "<td>" . $offbusiness. "</td>".                                     
    "<td>" . $gross_pay. "</td>".
    "<td>" . $total_taxable. "</td>".
    "<td>" . $witholding_tax. "</td>".
    "<td>" . $sss_regee. "</td>".
    "<td>" . $sss_mpfee. "</td>".
    "<td>" . $phic_ee. "</td>".
    "<td>" . $hdmf_ee. "</td>".
    "<td>" . $hdmf_sal_loan. "</td>".
    "<td>" . $hdmf_cal_loan. "</td>".
    "<td>" . $sss_sal_loan. "</td>".
    "<td>" . $sss_cal_loan. "</td>".
    "<td>" . $sal_ded_tax. "</td>".
    "<td>" . $sal_ded_nontax. "</td>".
    "<td>" . $sal_loan. "</td>".
    "<td>" . $com_loan. "</td>".
    "<td>" . $omhas. "</td>".
    "<td>" . $coop_cbu. "</td>".
    "<td>" . $coop_reg_loan. "</td>".
    "<td>" . $coop_messco. "</td>".
    "<td>" . $uploan. "</td>".
    "<td>" . $others. "</td>".
    "<td>" . $total_deduction. "</td>".
    "<td>" . $netpay. "</td>".
    "<td>" . $sss_reg_er. "</td>".
    "<td>" . $sss_mpf_er. "</td>".
    "<td>" . $sss_ec. "</td>".
    "<td>" . $phic_er. "</td>".
    "<td>" . $hdmf_er. "</td>".
    "<td>" . $r['tin_no']. "</td>".
    "<td>" . $r['phil_no']. "</td>".
    "<td>" . $r['pagibig_no']. "</td>".
    "<td>" . $r['sss_no']. "</td>".    
    "</tr>";
    } while($r = $stmt->fetch(PDO::FETCH_ASSOC));
    echo"</tbody><tfoot>".
    "</tr><tr>".
    "<td colspan='63' class='paytop'>".
    "<button class='conPyrll' onclick='ConfirmPayRegView()'><i class='fas fa-check-square'></i> CONFIRM PAYROLL REGISTER</button></td>".
    "</tr></tfoot>";    

    }else { 
        echo '<tfoot><tr><td colspan="63" class="paytop">No Results Found</td></tr></tfoot>'; 
    }

    echo"</table>"; 

    }


    }



?>
