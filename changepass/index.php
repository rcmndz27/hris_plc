<?php
session_start();

if (empty($_SESSION["userid"]))
{
    header( "refresh:1;url=../index.php" );
}
else
{   
    include("../_header.php");
}

?>



<script type='text/javascript' src="../changepass/changepass.js"></script>


<div class="container">

    <div class="row">
        <div class="col-md-8 pt-5">
            <fieldset class="fieldset-border">

                <!-- <legend class="fieldset-border">
                Change Password
            </legend> -->

                <div class="form-row pt-5">
                    <div class="col-md-4">
                        <label for="userPassword">Password</label>
                    </div>
                    <div class="col-md-4">
                        <input type="password" name="userPassword" id="userPassword">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="userPassword">Confirm Password</label>
                    </div>
                    <div class="col-md-4">
                        <input type="password" name="reUserPassword" id="reUserPassword">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4">
                        <span id="errMsg"></span>
                    </div>
                </div>
                <div class="form-row">
                    <button type="button" class="btn btn-primary submit" id="submit">Submit</button>
                </div>

            </fieldset>

        </div>
    </div>
</div>












<div class="modal fade" id="popUpModal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popUpModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="text-md-center text-success"><i class="fas fa-check-circle"></i>&nbsp;<label for="">Password
                        change success</label></h5>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button> -->
            </div>
        </div>
    </div>
</div>