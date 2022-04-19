<?php

Class WfhApp{

    private $employeeCode;
    
    public function SetWfhAppParams($employeeCode){
        $this->employeeCode = $employeeCode;
    }


    public function GetWfhAppHistory(){
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
                    <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for work from home.." title="Type in work from home details"> 
                        </div>                     
                </div>         
        <table id="wfhList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th>WFH Date</th>
                <th>Task</th>
                <th>Expected Output</th>
                <th>Percentage %</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT (CASE when status = 1 then 'PENDING'
                    when   status = 2 then 'APPROVED'
                    when   status = 3 then 'REJECTED'
                    when   status = 4 then 'VOID' ELSE 'N/A' END) as stats,* FROM dbo.tr_workfromhome where emp_code = :emp_code ORDER BY wfh_date DESC";
        $param = array(':emp_code' => $this->employeeCode);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        if($result){
            do { 

                $wfhdate = "'".date('m-d-Y', strtotime($result['wfh_date']))."'";
                $wfhtask = "'".$result['wfh_task']."'";
                $wfhoutput = "'".$result['wfh_output']."'";
                $wfhpercentage = "'".$result['wfh_percentage']."'";
                $wfhstats = "'".$result['stats']."'";
                $wfhid = "'".$result['rowid']."'";
                $empcode = "'".$result['emp_code']."'";
                echo '
                <tr>
                <td>' . date('m-d-Y', strtotime($result['wfh_date'])) . '</td>
                <td>' . $result['wfh_task'] . '</td>
                <td>' . $result['wfh_output'] . '</td>
                <td>' . $result['wfh_percentage'] . '</td>
                <td id="st'.$result['rowid'].'">' . $result['stats'] . '</td>';
                if($result['stats'] == 'PENDING'){
                echo'
                <td><button type="button" class="hactv" onclick="viewWfhModal('.$wfhdate.','.$wfhtask.','.$wfhoutput.','.$wfhpercentage.','.$wfhstats.')" title="View Work From Home">
                                <i class="fas fa-binoculars"></i>
                            </button>
                            <button type="button" class="hdeactv" onclick="viewWfhHistoryModal('.$wfhid.')" title="View Logs">
                                <i class="fas fa-history"></i>
                            </button>                           
                            <button type="button" id="clv" class="voidBut" onclick="cancelWfh('.$wfhid.','.$empcode.')" title="Cancel Work From Home">
                                <i class="fas fa-ban"></i>
                            </button>
                            </td>';
                }else{
                echo'
                <td><button type="button" class="hactv" onclick="viewWfhModal('.$wfhdate.','.$wfhtask.','.$wfhoutput.','.$wfhpercentage.','.$wfhstats.')" title="View Work From Home">
                                <i class="fas fa-binoculars"></i>
                            </button>
                            <button type="button" class="hdeactv" onclick="viewWfhHistoryModal('.$wfhid.')" title="View Logs">
                                <i class="fas fa-history"></i>
                            </button>                        
                            </td>';
                }                            


            } while ($result = $stmt->fetch());

            echo '</tr></tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="8" class="text-center">No Results Found</td></tr></tfoot>'; 
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
      </div>';
    }

    public function InsertAppliedWfhApp($empCode,$empReportingTo,$wfhDate,$wfh_task,$wfh_output,$wfh_percentage){

            global $connL;

            $query = "INSERT INTO tr_workfromhome (emp_code,wfh_date,date_filed,wfh_task,wfh_output,wfh_percentage,reporting_to,audituser,auditdate) 
                VALUES(:emp_code,:wfhDate,:date_filed,:wfh_task,:wfh_output,:wfh_percentage,:empReportingTo,:audituser,:auditdate) ";
    
                $stmt =$connL->prepare($query);

                $param = array(
                    ":emp_code"=> $empCode,
                    ":wfhDate" => $wfhDate,
                    ":date_filed"=>date('m-d-Y'),
                    ":empReportingTo" => $empReportingTo,
                    ":wfh_task"=> $wfh_task,
                    ":wfh_output"=> $wfh_output,
                    ":wfh_percentage"=> $wfh_percentage,
                    ":audituser" => $empCode,
                    ":auditdate"=>date('m-d-Y')
                );

            $result = $stmt->execute($param);

            echo $result;

            $squery = "SELECT lastname+', '+firstname as [fullname] FROM employee_profile WHERE emp_code = :empCode";
            $sparam = array(':empCode' => $empCode);
            $sstmt =$connL->prepare($squery);
            $sstmt->execute($sparam);
            $sresult = $sstmt->fetch();
            $sname = $sresult['fullname'];

            $qry = 'SELECT max(rowid) as maxid FROM tr_workfromhome WHERE emp_code = :emp_code';
            $prm = array(":emp_code" => $empCode);
            $stm =$connL->prepare($qry);
            $stm->execute($prm);
            $rst = $stm->fetch();

            $querys = "INSERT INTO logs_wfh (wfh_id,emp_code,emp_name,remarks,audituser,auditdate) 
                VALUES(:wfh_id, :emp_code,:emp_name,:remarks,:audituser, :auditdate) ";
    
                $stmts =$connL->prepare($querys);
    
                $params = array(
                    ":wfh_id" => $rst['maxid'],
                    ":emp_code"=> $empCode,
                    ":emp_name"=> $sname,
                    ":remarks" => 'Apply WFH for '.$wfhDate,
                    ":audituser" => $empCode,
                    ":auditdate"=>date('m-d-Y')
                );

            $results = $stmts->execute($params);

            echo $results;            

    }
}

?>