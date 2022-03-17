<?php

Class UsersList{

    public function GetAllUsersList(){
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
                    <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for employee account.." title="Type in employee details"> 
                        </div>                     
                </div>         
        <table id="allUsersList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6" class ="text-center">List of All Employee Users</th>
            </tr>
            <tr>
                <th>Employee Code</th>
                <th>Employee Name</th>
                <th>Employee Type</th>
                <th>Employee Email</th>
                <th>Employee Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT * from mf_user";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();


        if($result){
            do { 
                $empcd = "'".$result['userid']."'";
                $usrmail = "'".$result['useremail']."'";
                $usrtyp = "'".$result['usertype']."'";
                $bempcd = $result['userid'];
                $bname = $result['username'];
                $name = "'".$bempcd.' - '.$bname."'";
                $stts = "'".$result['status']."'";
              
                echo '
                <tr>
                <td>' . $result['userid']. '</td>
                <td>' . $result['username']. '</td>
                <td>' . $result['usertype']. '</td>
                <td>' . $result['useremail']. '</td>
                <td>' . $result['status']. '</td>';
                echo'<td><button type="button" class="hactv" onclick="editUsrModal('. $empcd.','. $name.','. $usrtyp.','. $usrmail.','. $stts.')" title="Update User/Change Password">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="hdeactv" onclick="deleteLogsModal('. $empcd.')" title="Unblocked User">
                                <i class="fas fa-lock-open"></i>
                            </button>
                            </td>';
                
                
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
      </div>                 ';
    }


}

?>

