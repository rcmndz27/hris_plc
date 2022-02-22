<?php
    session_start();

    if (empty($_SESSION['userid']))
    {
        echo '<script type="text/javascript">alert("Please login first!!");</script>';
        header( "refresh:1;url=../index.php" );
    }
    else
    {
        include('../_header.php');

        global $connL;

        $query = "SELECT * from employee_profile where emp_code = :empcode";
        $stmt =$connL->prepare($query);
        $param = array(":empcode" => $empCode);
        $stmt->execute($param);
        $result = $stmt->fetch();
        $rptto = $result['reporting_to'];
        $reportingto = ($rptto === false) ? 'none' : $rptto;

        if($reportingto == 'none'){
            $repname = 'n/a';
        }else{

        $querys = "SELECT * from employee_profile where emp_code = :reportingto";
        $stmts =$connL->prepare($querys);
        $params = array(":reportingto" => $reportingto);
        $stmts->execute($params);
        $results = $stmts->fetch();
              if(isset($results['emp_code'])){
                $repname = $results['lastname'].",".$results['firstname']." ".$results['middlename'];
              }else{                       
                $repname = 'n/a';
              }
        }
     
    }
        
?>
<style type="text/css">
.main-body {
    padding: 15px;
}
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}

.gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}
.h-100 {
    height: 100%!important;
}
.shadow-none {
    box-shadow: none!important;
}
</style>
<body>
<div class="container">
    <div class="section-title">
          <h1>MY PROFILE</h1>
        </div>
    <div class="main-body">
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-id-card fa-fw'></i>&nbsp;MY PROFILE</b></li>
            </ol>
          </nav>
          <?php  
              $sex = $result['sex'];
              $emp_pic = $result['emp_pic'];

              if($sex == 'Male' AND empty($emp_pic)){
                  $avatar = 'avatar2.png';
                  // var_dump($avatar);
              }else if($sex == 'Female' AND empty($emp_pic)){
                  $avatar = 'avatar8.png';
                  // var_dump($avatar);
              }else{
                  $avatar = $emp_pic;
                  // var_dump($avatar);
              }
           ?>
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <?php 
                    echo'<img src="../img/'.$avatar.'" alt="Admin" class="rounded-circle" width="150">';
                     ?>
                    
                    <div class="mt-3">
                      <h4><?php echo $empName; ?></h4>
                      <p class="text-secondary mb-1"><?php echo $result['position']; ?></p>
                      <p class="text-muted font-size-sm"><?php echo $empCode.'-'.$result['emp_type']; ?></p>
<!--                       <button class="btn btn-primary">Follow</button>
                      <button class="btn btn-outline-primary">Message</button> -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mt-3">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">
                      <i class='fas fa-table fa-fw'></i></svg>Date Hired:</h6>
                    <span class="text-secondary"><?php echo date('m/d/Y', strtotime($result['datehired'])); ?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class='fas fa-birthday-cake fa-fw'></i></svg>Birthdate:</h6>
                    <span class="text-secondary"><?php echo date('m/d/Y', strtotime($result['birthdate'])); ?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class='fas fa-phone fa-fw'></i></svg>Phone:</h6>
                    <span class="text-secondary"><?php echo $result['celno1']; ?></span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name:</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $empName; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email:</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $result['emailaddress']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address:</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $result['emp_address'].' '.$result['emp_address2']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Department:</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $result['department']; ?>
                    </div>
                  </div>
                  <hr>                  
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Job Title:</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $result['position']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Civil Status:</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $result['marital_status']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Reporting To:</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $repname; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
</body>
<?php include('../_footer.php');  ?>
