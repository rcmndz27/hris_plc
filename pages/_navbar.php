<div class='container p-0 navsContainer'>
    <div>
        <nav class='navbar navbar-expand-lg head_nav w-100 justify-content-between'>
            <a class='navbar-brand' href='../'>Employee Web Portal</a>
            <div class='navbar-empInfo w-50 d-flex justify-content-end'>
                <ul class='navbar-nav'>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="empOptions" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='color:white; font-weight:700;'>
                            
                            <?php echo "<span id='empOptionsText'>Welcome! , " . $empName . "</span>"; ?>

                            <span id='empOptionsImg' class='rounded-circle'><img src="data:image/jpg;base64,<?php GetProfilePic($empID); ?>" class='img-fluid rounded-circle'></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="empOptions">
                            <a class="dropdown-item" href="../pages/profileSettings_view.php">Settings</a>
                            <a class="dropdown-item" href="../controller/logout.php">Sign Out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div id="main-menu">
        <nav class='navbar navbar-expand-lg w-100'>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon' style='font-size:0.7rem'>
                    <i class='fas fa-lg fa-bars' style='color:white; vertical-align:middle;'></i>
                </span>
            </button>
            <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav mr-auto'>

                    <?php

                        if ($empType == 'Admin')
                        {
                            echo "<li class='nav-item'><a href='../pages/index.php'>Home</a></li>
                            <li class='nav-item'><a href='../pages/loanLedger_view.php'>Loan Ledger</a></li>
                            <li class='nav-item'><a href='../pages/travelOrder_view.php'>Travel Order</a></li>
                            <li class='nav-item'><a href='../pages/travelApproval_view.php'>Travel Approval</a></li>
                            <li class='nav-item'><a href='../pages/leaveApplication_view.php'>Leave Application</a></li>
                            <li class='nav-item'><a href='../pages/leaveApproval_view.php'>Leave Approval</a></li>
                            <li class='nav-item'><a href='../pages/otApproval_view.php'>OT Approval</a></li>
                            <li class='nav-item'><a href='../pages/dtr_view.php'>Daily Attendance</a></li>
                            <li class='nav-item'><a href='../pages/payslip_view.php'>Payslip</a></li>
                            <li class='nav-item'><a href='../pages/applicantapproval_view.php'>Applicant Approval</a></li>";
                        }

                        else if (($empType == 'Manager' && $empDept == "Human Resources Department"))
                        {
                        echo "  
                                <li class='nav-item'><a href='../pages/index.php'>Home</a></li>
                                <li class='nav-item'><a href='../pages/travelOrder_view.php'>Travel Order</a></li>
                                <li class='nav-item'><a href='../pages/travelApproval_view.php'>Travel Approval</a></li>
                                <li class='nav-item'><a href='../pages/leaveApplication_view.php'>Leave Application</a></li>
                                <li class='nav-item'><a href='../pages/leaveApproval_view.php'>Leave Approval</a></li>
                                <li class='nav-item'><a href='../pages/otApproval_view.php'>OT Approval</a></li>
                                <li class='nav-item'><a href='../pages/dtr_view.php'>Daily Attendance</a></li>
                                <li class='nav-item'><a href='../pages/payslip_view.php'>Payslip</a></li>
                                <li class='nav-item'><a href='../pages/applicantapproval_view.php'>Applicant Approval</a></li>
                            ";
                        }
                        else if ($empType == 'SP')
                        {
                            echo "<li class='nav-item'><a href='../admin/index.php'>Home</a></li>";
                        }
                        else
                        {
                            if ($empType == 'Manager')
                            {
                                echo "
                                    <li class='nav-item'><a href='../pages/index.php'>Home</a></li>
                                    <li class='nav-item'><a href='../pages/travelOrder_view.php'>Travel Order</a></li>
                                    <li class='nav-item'><a href='../pages/travelApproval_view.php'>Travel Approval</a></li>
                                    <li class='nav-item'><a href='../pages/leaveApplication_view.php'>Leave Application</a></li>
                                    <li class='nav-item'><a href='../pages/leaveApproval_view.php'>Leave Approval</a></li>
                                    <li class='nav-item'><a href='../pages/otApproval_view.php'>OT Approval</a></li>
                                    <li class='nav-item'><a href='../pages/dtr_view.php'>Daily Attendance</a></li>
                                ";
                            }
                            else
                            {
                                echo " 
                                    <li class='nav-item'><a href='../pages/index.php'>Home</a></li>
                                    <li class='nav-item'><a href='../pages/travelOrder_view.php'>Travel Order</a></li>
                                    <li class='nav-item'><a href='../pages/leaveApplication_view.php'>Leave Application</a></li>
                                    <li class='nav-item'><a href='../pages/dtr_view.php'>Daily Attendance</a></li>
                                ";
                            }
                        }
                    ?>

                </ul>
            </div>
        </nav>
    </div>
</div>