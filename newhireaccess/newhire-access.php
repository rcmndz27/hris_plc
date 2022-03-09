0<?php

Class NewHireAccess{

    public function GetAllEmpHistory(){
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
                    <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for names.." title="Type in employee name"> 
                        </div>                     
                </div>  
        <table id="allEmpList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="9" class ="text-center">List of All Employees</th>
            </tr>
            <tr>
                <th>Emp Code</th>
                <th>Name</th>
                <th>Position</th>
                <th>Company</th>
                <th>Department</th>
                <th>Location</th>
                <th>Employee Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT * from dbo.employee_profile ORDER BY lastname asc";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        

        if($result){
            do { 
                $fullname=  $result['lastname'].','.$result['firstname'].' '.substr($result['middlename'],0,1).'.';
                $empcd = "'".$result['emp_code']."'";
                echo '
                <tr>
                <td>' . $result['emp_code'] . '</td>
                <td>' . $fullname . '</td>
                <td>' . $result['position'] . '</td>
                <td>' . $result['company'] . '</td>
                <td>' . $result['department'] . '</td>
                <td>' . $result['location'] . '</td>
                <td>' . $result['emp_type'] . '</td>';
                echo '<td><button type="button" class="hactv" onclick="viewEmpModal('.$empcd.')" title="View Employee Profile"><i class="fas fa-binoculars"></i>
                            </button><button type="button" class="hdeactv" onclick="updateEmpModal()" title="Update Employee Profile">
                                <i class="fas fa-edit"></i>
                            </button><button type="button" class="hactv" onclick="viewEmpHistoryModal()" title="View Employee Logs">
                                <i class="fas fa-history"></i>
                            </button></td>
                            ';
    
                

            } while ($result = $stmt->fetch());

            echo '</tr></tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="8" class="text-center">No Results Found</td></tr></tfoot>'; 
        }
        echo '</table><div class="pagination-container">
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


}

?>

