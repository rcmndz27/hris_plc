<?php

Class SalaryList{

    public function GetAllSalaryList(){
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
                    <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for employee salary.." title="Type in employee details"> 
                        </div>                     
                </div> 
        <table id="allSalaryList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th>Employee Code</th>
                <th>Bank</th>
                <th>Account No.</th>
                <th>Pay Type</th>
                <th>Pay Rate</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT * from dbo.employee_salary_management ORDER BY salary_id desc";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();


        if($result){
            do { 
                $empcd = "'".$result['emp_code']."'";
                $banktype = "'".$result['bank_type']."'";
                $bankno = "'".$result['bank_no']."'";
                $payrate = "'".$result['pay_rate']."'";
                $amnt = "'".round($result['amount'],3)."'";
                $stts = "'".$result['status']."'";

                echo '
                <tr>
                <td>' . $result['emp_code']. '</td>
                <td>' . $result['bank_type']. '</td>
                <td>' . $result['bank_no']. '</td> 
                <td>' . $result['pay_rate']. '</td> 
                <td>' . substr(hash('sha256', $result['pay_rate']),50).'</td>
                <td>' . $result['status'] . '</td>';
                echo'<td><button type="button" class="actv" onclick="editSalaryModal('.$empcd.','.$banktype.','.$bankno.','.$payrate.','.$amnt.','.$stts.')">
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
      </div> ';
    }


}

?>

