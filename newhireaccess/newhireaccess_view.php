<?php
    session_start();

    if (empty($_SESSION['userid']))
    {
        echo '<script type="text/javascript">alert("Please login first!!");</script>';
        header('refresh:1;url=../index.php' );
    }
    else
    {
            include('../_header.php');
            include("../newhireaccess/newhire-access.php");
            include('../elements/DropDown.php');
            include('../controller/MasterFile.php');
            $allEmpApp = new NewHireAccess(); 
            $mf = new MasterFile();
            $dd = new DropDown();

        if ($empUserType == 'Admin' || $empUserType == 'HR Generalist' ||$empUserType == 'HR Manager' || $empUserType == 'Group Head')
        {
  
        }else{
            echo '<script type="text/javascript">swal({text:"You do not have access here!",icon:"error"});';
            echo "window.location.href = '../index.php';";
            echo "</script>";
        } 

       

    }    
?>
<script type="text/javascript">

    function viewEmpModal(lvlogid)
    {
       $('#viewEmpModal').modal('toggle');
        var url = "../newhireaccess/nh_viewprofile.php";
        var lvlogid = lvlogid;

        $.post (
            url,
            {
                _action: 1,
                lvlogid: lvlogid             
            },
            function(data) { $("#contents2").html(data).show(); }
        );
    }

</script>

<link rel="stylesheet" href="../newhireaccess/newhire-access.css">
<script type='text/javascript' src='../js/validator.js'></script>
<div class="container">
    <div class="section-title">
          <h4>ALL EMPLOYEE LIST</h4>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active bb" aria-current="page"><b><i class='fas fa-users fa-fw'>
                        </i>&nbsp;ALL EMPLOYEE LIST - 201 MASTERFILE</b></li>
            </ol>
          </nav>
    <div class="pt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <div id="tableList" class="table-responsive-sm table-body">
                        <?php $allEmpApp->GetAllEmpHistory(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="HireEmp" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">UPDATE EMPLOYEE DETAILS &nbsp;<i class="fas fa-edit"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
            <div class="modal-body">
                <div class="main-body">
                    <fieldset class="fieldset-border">
                            <div class="d-flex justify-content-center">
                                <legend class="fieldset-border pad">
                                </legend>
                             </div>
                            <div class="form-row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label" for="department">Employee Code</label>
                                        <input type="text" id="rowid" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label" for="lnameg">Last Name</label>
                                        <input type="text" id="lnameg" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label" for="fnameg">First Name</label>
                                        <input type="text" id="fnameg" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label" for="mnameg">Middle Name</label>
                                        <input type="text" id="mnameg" class="form-control" >
                                    </div>
                                </div>                                  
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="lnameg">Email Address</label>
                                        <input type="text" id="emailaddg" class="form-control" placeholder="user@email.com">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="fnameg">Telephone No.</label>
                                        <input type="text" id="telng" class="form-control" onkeypress="return onlyNumberKey(event)"placeholder="0991234567" maxlength="11">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="mnameg">Mobile No.</label>
                                        <input type="text" id="celng" class="form-control" onkeypress="return onlyNumberKey(event)"placeholder="0991234567" maxlength="11">
                                    </div>
                                </div>                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="department">Department</label>
                                        <?php $dd->GenerateDropDown("department", $mf->GetAllDepartment("alldep")); ?> 
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label"  for="position">Job Title</label>
                                        <?php $dd->GenerateDropDown("position", $mf->GetJobPosition("jobpos")); ?>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label" for="Location">Location</label>
                                        <?php $dd->GenerateDropDown("location", $mf->GetPayLocation("locpay")); ?> 
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label class="control-label" for="maidenname">Employee Type</label>
                                        <?php $dd->GenerateDropDown("emp_type", $mf->GetEmpJobType("empjobtype")); ?>
                                </div>

                                <div class="col-lg-3">
                                    <label class="control-label" for="maidenname">Employee Level</label>
                                        <?php $dd->GenerateDropDown("emp_level", $mf->GetAllEmployeeLevel("emp_level")); ?>
                                </div>  

                                <div class="col-lg-3">
                                    <label class="control-label" for="work_sched_type">Work Schedule</label>
                                        <select type="select" class="form-select" id="work_sched_type" name="work_sched_type" >
                                            <option value="0">Compressed</option>
                                            <option value="1">Regular</option>
                                        </select>
                                </div> 

                                <div class="col-lg-3">
                                    <label class="control-label" for="minimum_wage">Minimum Wage</label>
                                        <select type="select" class="form-select" id="minimum_wage" name="minimum_wage" >
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                </div>

                                <div class="col-lg-3">
                                    <label class="control-label" for="pay_type">Payment Type</label>
                                        <select type="select" class="form-select" id="pay_type" name="pay_type" >
                                            <option value="1">Monthly</option>
                                            <option value="0">Daily</option>
                                        </select>
                                </div>  

                                 <div class="col-lg-6">
                                    <label class="control-label" for="pay_type">Reporting To</label>
                                        <?php $dd->GenerateDropDown("reporting_to", $mf->GetEmployeeNames("allempnames")); ?>
                                </div>  

                                <input id="rowid" name="rowid" hidden>
                            </div> <!-- form row closing -->
                    </fieldset>   
                            <div class="modal-footer">
                                <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                                <button type="button" class="subbut" id="Submit" onclick="updateEmpHired()"><i class="fas fa-check-circle"></i> SUBMIT</button>
                            </div>
                        </div> <!-- main body closing -->
                    </div> <!-- modal body closing -->
                </div> <!-- modal content closing -->
            </div> <!-- modal dialog closing -->
        </div><!-- modal fade closing -->

        <div class="modal fade" id="viewEmpModal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">VIEW EMPLOYEE PROFILE <i class="fas fa-profile fa-fw fa-fw"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
        <div class="modal-body">
            <div class="main-body">
                <fieldset class="fieldset-border">
                            <div class="d-flex justify-content-center">
                                <legend class="fieldset-border pad">
                                </legend>
                             </div>
                        <div class="form-row">

                                <div class="col-lg-3">
                                    <label class="control-label" for=""> 
                                        <img src="../img/newob.png" class="imgob">
                                    </label>                                        
                                </div>  

                                <div class="col-lg-8">
                                    <div class="d-flex justify-content-center obc">            
                                        OBANANA CORP.<br>
                                        PMI Tower Cabanillas Corner, 273 Pablo Ocampo Sr. Ext
                                        Makati, 1203 Metro Manila, Makati, Philippines
                                        Cel. No.: +63 945 729 5298 | Website: www.obanana.com 
                                    </div>
                                </div> 
                                <div class="col-lg-1">
                                    <label class="control-label">
                                </div>                                   

                            <div class="row pt-3">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                        <div id="contents2" class="table-responsive-sm table-body">
                                            <button type="button" id="search" hidden>GENERATE</button>

                                        </div>
                                    </div>
                                </div>
                            </div> 
                                                     
                        </div> <!-- form row closing -->
                    </fieldset> 
                                <div class="modal-footer">
                                    <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CLOSE</button>
                                </div> 
                        </div> <!-- main body closing -->
                    </div> <!-- modal body closing -->
                </div> <!-- modal content closing -->
            </div> <!-- modal dialog closing -->
        </div><!-- modal fade closing -->

    </div> <!-- main body mbt closing -->
</div><!-- container closing -->

<script type="text/javascript">

    $('#emailaddg').change(function(){
        var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
        var eadd = document.getElementById("emailaddg").value;

        if(format.test(eadd)){
          // return swal('correct email');
        } else {
          return        swal({
                          title: "Oops...wrong email format",
                          text: "example: useremp@yahoo.com",
                          icon: "error",
                          dangerMode: true
                        });
        }   

    });

function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("allEmpList");
  tr = table.getElementsByTagName("tr");
for (i = 0; i < tr.length; i++) {
   td = tr[i].getElementsByTagName("td");
    if(td.length > 0){ // to avoid th
       if (td[0].innerHTML.toUpperCase().indexOf(filter) > -1 || td[1].innerHTML.toUpperCase().indexOf(filter) > -1 
        || td[2].innerHTML.toUpperCase().indexOf(filter) > -1  || td[3].innerHTML.toUpperCase().indexOf(filter) > -1 ) {
         tr[i].style.display = "";
       } else {
         tr[i].style.display = "none";
       }

    }
 }
}

    function onlyNumberKey(evt) {
          
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return swal({text:"Only numbers are allowed!",icon:"error"});;
        return true;
    }

    
    
 function updateEmpModal(empcd,empname,lname,fname,mname,pstn,dpt,emailadd,teln,celn,loct,emptyp){

        $('#HireEmp').modal('toggle');

        var idrow = document.getElementById('rowid');
        idrow.value = empcd;

        var empcdname1 = document.getElementById('lnameg');
        empcdname1.value = lname;

        var empcdname2 = document.getElementById('fnameg');
        empcdname2.value = fname;

        var empcdname3 = document.getElementById('mnameg');
        empcdname3.value = mname;

        var e1 = document.getElementById('emailaddg');
        e1.value = emailadd;

        var e2 = document.getElementById('telng');
        e2.value = teln;

        var e3 = document.getElementById('celng');
        e3.value = celn;        

        var p1 = document.getElementById('position');
        p1.value = pstn;

        var p2 = document.getElementById('department');
        p2.value = dpt;

        var p3 = document.getElementById('location');
        p3.value = loct;    

        var p4 = document.getElementById('emp_type');
        p4.value = emptyp;                           
                
    }


    function updateEmpHired()
    {

        $("body").css("cursor", "progress");
        var url = "../newhireaccess/update_newhireaccess_process.php";
        var rowid = $('#rowid').val();
        var lastname = $('#lnameg').val();
        var firstname = $('#fnameg').val();
        var middlename = $('#mnameg').val();
        var emailaddress = $('#emailaddg').val();
        var telno = $('#telng').val();
        var celno = $('#celng').val();
        var department = $( "#department option:selected" ).text();
        var position = $( "#position option:selected" ).text();
        var location = $( "#location option:selected" ).text();
        var emp_type = $( "#emp_type option:selected" ).text();
        var emp_level = $('#emp_level').children("option:selected").val();
        var emplevel = emp_level.split(" - ");
        var work_sched_type = $( "#work_sched_type option:selected" ).val();
        var minimum_wage = $( "#minimum_wage option:selected" ).val();
        var pay_type = $( "#pay_type option:selected" ).val();
        var reporting_to = $('#reporting_to').children("option:selected").val();
        var reportingto = reporting_to.split(" - ");

        $('#contents').html('');

                        swal({
                          title:"Are you sure?",
                          text: "You want to update this profile?",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((updateProfile) => {
                          if (updateProfile) {
                                    $.post (
                                        url,
                                        {
                                            action: 1,
                                            lastname: lastname,
                                            firstname: firstname,
                                            middlename: middlename,
                                            emailaddress: emailaddress,
                                            telno: telno,
                                            celno: celno,
                                            department: department,
                                            position: position,
                                            location: location,
                                            emp_type: emp_type,
                                            emp_level: emplevel[0],
                                            work_sched_type: work_sched_type,
                                            minimum_wage: minimum_wage,
                                            pay_type: pay_type,
                                            reporting_to: reportingto[0],
                                            rowid: rowid                
                                        },
                                        function(data) { $("#contents").html(data).show(); }
                                    );
                                swal({text:"Successfully updated the employee details!",icon:"success"});
                                window.location.reload(true);
                          } else {
                            swal({text:"You cancel the updating of employee details!",icon:"error"});
                          }
                        });

                 }

                 
getPagination('#allEmpList');

function getPagination(table) {
  var lastPage = 1;

  $('#maxRows')
    .on('change', function(evt) {
      //$('.paginationprev').html('');  
      // reset pagination

     lastPage = 1;
      $('.pagination')
        .find('li')
        .slice(1, -1)
        .remove();
      var trnum = 0; // reset tr counter
      var maxRows = parseInt($(this).val()); // get Max Rows from select option

      if (maxRows == 5000) {
        $('.pagination').hide();
      } else {
        $('.pagination').show();
      }

      var totalRows = $(table + ' tbody tr').length; // numbers of rows
      $(table + ' tr:gt(0)').each(function() {
        // each TR in  table and not the header
        trnum++; // Start Counter
        if (trnum > maxRows) {
          // if tr number gt maxRows

          $(this).hide(); // fade it out
        }
        if (trnum <= maxRows) {
          $(this).show();
        } // else fade in Important in case if it ..
      }); //  was fade out to fade it in
      if (totalRows > maxRows) {
        // if tr total rows gt max rows option
        var pagenum = Math.ceil(totalRows / maxRows); // ceil total(rows/maxrows) to get ..
        //  numbers of pages
        for (var i = 1; i <= pagenum; ) {
          // for each page append pagination li
          $('.pagination #prev')
            .before(
              '<li data-page="' +
                i +
                '">\
                                  <span>' +
                i++ +
                '<span class="sr-only">(current)</span></span>\
                                </li>'
            )
            .show();
        } // end for i
      } // end if row count > max rows
      $('.pagination [data-page="1"]').addClass('active'); // add active class to the first li
      $('.pagination li').on('click', function(evt) {
        // on click each page
        evt.stopImmediatePropagation();
        evt.preventDefault();
        var pageNum = $(this).attr('data-page'); // get it's number

        var maxRows = parseInt($('#maxRows').val()); // get Max Rows from select option

        if (pageNum == 'prev') {
          if (lastPage == 1) {
            return;
          }
          pageNum = --lastPage;
        }
        if (pageNum == 'next') {
          if (lastPage == $('.pagination li').length - 2) {
            return;
          }
          pageNum = ++lastPage;
        }

        lastPage = pageNum;
        var trIndex = 0; // reset tr counter
        $('.pagination li').removeClass('active'); // remove active class from all li
        $('.pagination [data-page="' + lastPage + '"]').addClass('active'); // add active class to the clicked
        // $(this).addClass('active');                  // add active class to the clicked
        limitPagging();
        $(table + ' tr:gt(0)').each(function() {
          // each tr in table not the header
          trIndex++; // tr index counter
          // if tr index gt maxRows*pageNum or lt maxRows*pageNum-maxRows fade if out
          if (
            trIndex > maxRows * pageNum ||
            trIndex <= maxRows * pageNum - maxRows
          ) {
            $(this).hide();
          } else {
            $(this).show();
          } //else fade in
        }); // end of for each tr in table
      }); // end of on click pagination list
      limitPagging();
    })
    .val(10)
    .change();

  // end of on select change

  // END OF PAGINATION
}

function limitPagging(){
    // alert($('.pagination li').length)

    if($('.pagination li').length > 7 ){
            if( $('.pagination li.active').attr('data-page') <= 3 ){
            $('.pagination li:gt(5)').hide();
            $('.pagination li:lt(5)').show();
            $('.pagination [data-page="next"]').show();
        }if ($('.pagination li.active').attr('data-page') > 3){
            $('.pagination li:gt(0)').hide();
            $('.pagination [data-page="next"]').show();
            for( let i = ( parseInt($('.pagination li.active').attr('data-page'))  -2 )  ; i <= ( parseInt($('.pagination li.active').attr('data-page'))  + 2 ) ; i++ ){
                $('.pagination [data-page="'+i+'"]').show();

            }

        }
    }
}

</script>



<?php include("../_footer.php");?>
