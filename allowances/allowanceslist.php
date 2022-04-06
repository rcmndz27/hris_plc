<?php

Class AllowancesList{

    public function GetAllAllowancesList(){
        global $connL;

        echo '
                <div class="form-row">  
                    <div class="col-lg-1">
                        <select class="form-select" name="state" id="maxRows">
                             <option value="5000">ALL</option>
                             <option value="5">5</option>
                             <option value="10">10</option>
                             <option value="15">15</option>
                             <option value="20">20</option>
                             <option value="50">50</option>
                             <option value="70">70</option>
                             <option value="100">100</option>
                        </select> 
                </div>         
                <div class="col-lg-8">
                </div>                               
                <div class="col-lg-3">        
                    <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for employee allowance.." title="Type in employee details"> 
                        </div>                     
                </div> 

        <table id="allAllowancesList" class="table table-striped table-sm">
        <thead>

            <tr>
                <th>Employee Code</th>
                <th>Employee Name</th>
                <th>Allowances Name</th>
                <th>Period Cutoff</th>
                <th>Allowances Amount</th>
                <th>Effectivity Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT a.benefits_emp_id,c.firstname+' '+c.lastname as [fullname],a.emp_code,b.benefit_name,b.rowid,a.period_cutoff,a.amount,a.effectivity_date from dbo.employee_allowances_management a left join dbo.mf_benefits b on a.benefit_id = b.rowid left join employee_obnprofile c  on a.emp_code = c.emp_code ORDER by a.benefits_emp_id DESC";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        

        if($result){
            do { 
                $empcd = "'".$result['emp_code']."'";
                 
                echo '
                <tr>
                <td>' . $result['emp_code']. '</td>
                <td>' . $result['fullname']. '</td>
                <td id="bn'.$result['emp_code'].'">' . $result['benefit_name']. '</td>
                <td id="bnr'.$result['emp_code'].'" hidden>' . $result['rowid']. '</td>                
                <td id="pc'.$result['emp_code'].'">' . $result['period_cutoff']. '</td>
                <td id="am'.$result['emp_code'].'" hidden>'.round($result['amount'],3).'</td>
                <td id="amtn'.$result['emp_code'].'">₱ ' . number_format($result['amount'],2,'.',',').'</td>
                <td id="ed'.$result['emp_code'].'">' . date('Y-m-d', strtotime($result['effectivity_date'])) . '</td>';
                echo'<td><button type="button" class="actv" onclick="editAlwModal('.$empcd.')">
                                <i class="fas fa-edit"></i> UPDATE
                            </button></td>';                
                
            } while ($result = $stmt->fetch());

            echo '</tr></tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="6" class="text-center">No Results Found</td></tr></tfoot>'; 
        }
        echo '</table>
        <div class="pagination-container">
        <nav>
          <ul class="pagination">
            
            <li data-page="prev" >
                <span> << <span class="sr-only">(current)</span></span></li>
    
          <li data-page="next" id="prev">
                  <span> >> <span class="sr-only">(current)</span></span>
            </li>
          </ul>
        </nav>
      </div>        ';
    }


}

?>

