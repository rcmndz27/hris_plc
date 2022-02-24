<?php 
              

function GetPayslipsList($action, $dtFrom, $dtTo,$empCode){

           
            global $connL;

            $cmd = $connL->prepare('EXEC hrissys_test.dbo.payslip_summary :date_start, :date_end , :emp_code');
            $cmd->bindValue(':date_start',$dtFrom);
            $cmd->bindValue(':date_end',$dtTo);
            $cmd->bindValue(':emp_code',$empCode);
            $cmd->execute();
            $r = $cmd->fetch();

            if($r){
                    do {

                echo"<table id='payslipsList'><thead>
                    <tr>
                        <th colspan='5' style='text-align:center;'><img src='../img/obanana.png' style='height:50px;'></th>
                        <button id='showpay' value='ok' hidden></button>
                    </tr>
                    <tr>
                        <th>NAME: </th>
                        <th>".$r['name']."</th>
                        <th></th>
                        <th>PAY PERIOD: </th>
                        <th>".$dtFrom." to ".$dtTo."</th>
                    </tr>
                </thead>
                <tbody>";

                 
                        $subtotal = $r['absences']+$r['late']+$r['undertime']+$r['sss_regee']+$r['phic_ee']
                                                    +$r['hmdf_ee']+$r['sss_sal_loan']+$r['hmdf_sal_loan']+$r['com_loan']
                                                    +$r['total_deduction']+$r['witholding_tax'];
                        $gross_income = $r['semi_month_pay']+$r['reg_ot']+$r['res_ot']+$r['reg_hol']+$r['spe_hol']
                                                    +$r['nyt_diff']+$r['salary_adjustment'];
                        $netpay = $gross_income - $subtotal;

                                echo "<tr>".
                                    "<td>POSITION:</td>".
                                    "<td>" . $r['position']. "</td>".
                                    "<td> </td>".                                            
                                    "<td>DEPARTMENT:</td>".
                                    "<td>" . $r['department'] . "</td>".
                                    "</tr>";

                                echo "<tr>".
                                        "<th>Basic Pay:</th>".
                                        "<td>" .number_format($r['semi_month_pay'],2,".", ","). "</td>".
                                        "<td> </td>".
                                        "<td colspan='2'> </td>". 
                                    "</tr>";
                                echo "<tr>".
                                        "<th>De Minimis:</th>".
                                        "<td>0.00</td>".
                                        "<td> </td>". 
                                        "<td colspan='2'> </td>".
                                    "</tr>";
                                echo "<tr>".
                                        "<th>ECOLA:</th>".
                                        "<td>0.00</td>". 
                                        "<td> </td>".
                                        "<td colspan='2'> </td>".
                                    "</tr>";
                                echo "<tr>".
                                        "<th>Monthly Salary:</th>".
                                        "<td>" . number_format($r['month_pay'],2,".", ","). "</td>". 
                                        "<td> </td>".
                                        "<td colspan='2'> </td>".
                                    "</tr>";

                                echo "<tr>".
                                        "<th colspan='2' class='paybg'>PAY:</th>".
                                        "<td> </td>".
                                        "<td colspan='2' class='dedbg'>DEDUCTIONS:</td>".
                                    "</tr>";
                                echo "<tr >".
                                        "<th rowspan='2'>Basic Pay:</th>".
                                        "<td>" .number_format($r['semi_month_pay'],2,".", ","). "</td>".
                                        "<td> </td>". 
                                        "<td>Absences:</td>".
                                        "<td>" .number_format($r['absences'],2,".", ","). "</td>".                                    
                                        "</tr>";
                                echo "<tr rowspan='2'>".
                                        "<th></th>".
                                        "<td> </td>". 
                                        "<td>Tardiness/UT:</td>".
                                        "<td>" .number_format($r['undertime'],2,".", ","). "</td>".                                   
                                        "</tr>";
                                echo "<tr>".
                                        "<th>ECOLA:</th>".
                                        "<td>0.00</td>". 
                                        "<td> </td>".
                                        "<td>SSS Contribution:</td>".
                                        "<td>" .number_format($r['sss_regee'],2,".", ","). "</td>".                                     
                                        "</tr>";
                                echo "<tr>".
                                        "<th>De Minimis:</th>".
                                        "<td>0.00</td>". 
                                        "<td> </td>".
                                        "<td>PhilHealth Contribution:</td>".
                                        "<td>" .number_format($r['phic_ee'],2,".", ","). "</td>".
                                    "</tr>";
                                echo "<tr>".
                                        "<th>Other Income:</th>".
                                        "<td>0.00</td>". 
                                        "<td> </td>".
                                        "<td>hmdf Contribution:</td>".
                                        "<td>" .number_format($r['hmdf_ee'],2,".", ","). "</td>".  
                                    "</tr>";
                                echo "<tr>".
                                        "<th>Regular OT:</th>".
                                        "<td>" .number_format($r['reg_ot'],2,".", ","). "</td>".  
                                        "<td> </td>".
                                        "<td>SSS Loan:</td>".                                    
                                        "<td>" .number_format($r['sss_sal_loan'],2,".", ","). "</td>".  
                                    "</tr>";
                                 echo "<tr>".
                                        "<th>Rest Day OT:</th>".
                                        "<td>" .number_format($r['res_ot'],2,".", ","). "</td>". 
                                        "<td> </td>".
                                        "<td>hmdf Loan:</td>".
                                        "<td>" .number_format($r['hmdf_sal_loan'],2,".", ","). "</td>". 
                                    "</tr>";
    
                                echo "<tr>".
                                        "<th>Regular Holiday:</th>".
                                        "<td>" .number_format($r['reg_hol'],2,".", ","). "</td>". 
                                        "<td> </td>".
                                        "<td>Office  Loan:</td>".
                                        "<td>" .number_format($r['com_loan'],2,".", ","). "</td>". 
                                    "</tr>";
                                 echo "<tr>".
                                        "<th>Special Holiday:</th>".
                                        "<td>" .number_format($r['spe_hol'],2,".", ","). "</td>". 
                                        "<td> </td>".
                                        "<td>Other Deduction:</td>".
                                        "<td>" .number_format($r['total_deduction'],2,".", ","). "</td>".      
                                    "</tr>";
    
                                echo "<tr>".
                                        "<th>Night Differential:</th>".
                                        "<td>" .number_format($r['nyt_diff'],2,".", ","). "</td>". 
                                        "<td> </td>". 
                                        "<td>Withholding Tax:</td>".
                                        "<td>" .number_format($r['witholding_tax'],2,".", ","). "</td>".  
                                    "</tr>";
                                 echo "<tr>".
                                        "<th>Adjustment:</th>".
                                        "<td>" .number_format($r['salary_adjustment'],2,".", ","). "</td>". 
                                        "<td> </td>".
                                        "<td class='subbg'>SUB TOTAL:</td>".
                                        "<td class='subbg'>".number_format($subtotal,2,".", ",")."</td>".
                                    "</tr>";

                                echo "<tr>".
                                        "<th></th>".
                                        "<td></td>".
                                        "<td></td>".
                                        "<td></td>".
                                        "<td></td>". 
                                    "</tr>";

                                echo "<tr>".
                                        "<th class='grossbg'>GROSS INCOME:</th>".
                                        "<td class='grossbg'>".number_format($gross_income,2,".", ",")."</td>".
                                        "<td> </td>".
                                        "<td class='netbg'>NETPAY:</td>".
                                        "<td class='netbg'>".number_format($netpay,2,".", ",")."</td>".
                                    "</tr>";
                
                               
                   } while($r = $cmd->fetch(PDO::FETCH_ASSOC));
        
                     // echo"</tbody>";
                     //       echo "<tfoot></tfoot>";    

                }else { 

                    echo '<tfoot><tr><td colspan="11" class="cnt"><button id="showpay" value="notok" hidden></button>No Payslip Found</td></tr></tfoot>'; 
                }
    
            echo"</table>"; 


                                          
}


?>
