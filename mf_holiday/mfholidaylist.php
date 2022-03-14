<?php

Class MfholidayList{

    public function GetAllMfholidayList(){
        global $connL;

        echo '<div class="form-row">  
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
                    <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Holiday Name.." title="Type in holiday name"> 
                        </div>                     
                </div>  
                                     
        <table id="allMfholidayList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th>Holiday ID</th>
                <th>Holiday Date</th>
                <th>Holiday Type</th>
                <th>Holiday Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT * from dbo.mf_holiday ORDER BY rowid asc";
        $stmt =$connL->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();


        if($result){
            do { 
                $hdate = "'".date('m-d-Y', strtotime($result['holidaydate']))."'";
                $htype = "'".$result['holidaytype']."'";
                $hdescs = "'".$result['holidaydescs']."'";
                $stts = "'".$result['status']."'";
                $rowd = "'".$result['rowid']."'";
                $ddt = date('Y/m/d', strtotime($result['holidaydate']));
                $newdate= date('d M, Y', strtotime($ddt));
                echo '
                <tr>
                <td>' . $result['rowid']. '</td>
                <td>' . $newdate. '</td>
                <td>' . $result['holidaytype']. '</td>
                <td>' . $result['holidaydescs']. '</td>
                <td>' . $result['status']. '</td>';
                echo'<td><button type="button" class="actv" 
                onclick="editMfholidayModal('.$rowd.','.$hdate.','.$htype.','.$hdescs.','.$stts.')">
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
      </div>';
    }
}

?>

