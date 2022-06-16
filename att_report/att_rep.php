<?php

    Class AttRepDTR{

        public function GetAttRepList($dateStart,$dateEnd){

            global $connL;

            $total_days = 0;

            $query = "SELECT count(a.punch_date) as [total_days],b.lastname+','+b.firstname as [fullname]
            ,(CASE WHEN count(a.punch_date) >= 20 then 'Perfect Attendance' else ' ' END) as remarks from employee_attendance a right join employee_profile b on a.emp_code = b.badgeno
            where punch_date between :startDate and :endDate and timein is not null and timeout is not null
            and b.emp_status = 'Active' GROUP by b.badgeno,b.lastname,b.firstname";
            $param = array(":startDate" => $dateStart, ":endDate" => $dateEnd);
            $stmt =$connL->prepare($query);
            $stmt->execute($param);
            $result = $stmt->fetch();

            echo "
            <table id='attRepListTab' class='table table-striped table-sm'>
                <thead>
                    <tr>
                        <th colspan='7' class='text-center'>Attendance from ".date('F d', strtotime($dateStart))." to ".date('F d, Y', strtotime($dateEnd))." </th>
                    </tr>
                    <tr>
                        <th>Days</th>
                        <th>Full Name</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>";

                if($result){
                    do { 
                        echo    "<tr>".
                                "<td>" . round($result['total_days'],2) . "</td>".
                                "<td>" . $result['fullname'] . "</td>".
                                "<td>" . $result['remarks'] . "</td>".
                                "</tr>";
    
                        $total_days += $result['total_days'];
    
                    } while ($result = $stmt->fetch()); 	

                    echo"</tbody>";

                    echo "<tfoot>
                            <tr>".
                                "<td class='bg-success'><b>" . $total_days . "</b></td>".
                                "<td class='bg-success'><b></b></td>".
                                "<td class='bg-success'><b></b></td>".
                            "</tr>
                        </tfoot>";
                }else { 
                    echo '<tfoot><tr><td colspan="7" class="text-center">No Results Found</td></tr></tfoot>'; 
                }
    
            echo"
                
            </table>";
    

        }


    }



?>