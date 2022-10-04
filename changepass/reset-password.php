<?php

if (isset($_POST['reset-pass'])) {
    include('../config/db.php');
    require '../mailer/src/PHPMailer.php';
    require '../mailer/src/SMTP.php';
    require '../mailer/src/Exception.php';
    
    $pdo = $connL;

    //Get the name that is being searched for.
    $email = isset($_POST['company-email']) ? trim($_POST['company-email']) : '';
    
    //The simple SQL query that we will be running.
    $sql = "SELECT emp_code, emailaddress, Employee FROM dbo.view_employee WHERE emailaddress = :useremail";
    
    //Prepare our SELECT statement.
    $statement = $pdo->prepare($sql);
    
    //Bind the $name variable to our :name parameter.
    $statement->bindValue(':useremail', $email);
    
    //Execute the SQL statement.
    $statement->execute();
    
    //Fetch our result as an associative array.
    $userInfo = $statement->fetch(PDO::FETCH_ASSOC);
    
    //If $userInfo is empty, it means that the submitted email
    //address has not been found in our users table.
    if(empty($userInfo)){
        echo 'That email address was not found in our system!';
        exit;
    }
    
    //The user's email address and id.
    $userEmail = $userInfo['emailaddress'];
    $userId = $userInfo['emp_code'];
    $userName = $userInfo['Employee'];
    
    //Create a secure token for this forgot password request.
    $token = openssl_random_pseudo_bytes(16);
    $token = bin2hex($token);
    
    //Insert the request information
    //into our password_reset_request table.
    
    //The SQL statement.
    $insertSql = "INSERT INTO dbo.changepass_requests (user_id, date_requested, token) VALUES (:user_id, :date_requested, :token)";
    
    //Prepare our INSERT SQL statement.
    $statement = $pdo->prepare($insertSql);
    
    //Execute the statement and insert the data.
    $statement->execute(array(
        "user_id" => $userId,
        "date_requested" => date("Y-m-d H:i:s"),
        "token" => $token
    ));
    
    //Get the ID of the row we just inserted.
    $passwordRequestId = $pdo->lastInsertId();
    
    //Create a link to the URL that will verify the
    //forgot password request and allow the user to change their
    //password.
    $verifyScript = 'http://192.168.201.17:8080/webportal-beta/changepass/verify.php';
    
    //The link that we will send the user via email.
    $linkToSend = $verifyScript . '?uid=' . $userId . '&id=' . $passwordRequestId . '&t=' . $token . '&email=' . $userEmail;
    
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsMail(); // enable SMTP

    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = "STARTTLS"; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.office365.com";
    $mail->Port = 587; // or 587
    $mail->IsHTML(true);
    $mail->Username = "pmisysdev@gmail.com";
    $mail->Password = "Pm!@123...";
    $mail->SetFrom("pmisysdev@gmail.com", "Systems Development Team");
    $mail->Subject = "Password Reset Request";
    $mail->Body = "Hello, $userName!<br>";
    $mail->Body .= "<br>Please click on this link to reset your password: $linkToSend <br>";
    $mail->Body .= "<br>Regards,<br>PMI Webmaster";
    $mail->AddAddress($userEmail);

     if(!$mail->Send()) { echo "Mailer Error: " . $mail->ErrorInfo; }
     else { echo "Message has been sent"; }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Premium Megastructures Inc. | Web Portal</title>
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <link rel='stylesheet' href='../css/style.css'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js' type='text/javascript'></script>
    <script src="../hris-payroll/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class='container h-100'>
        <div class='row h-100'>
            <div id="container" class="frmLogin col-sm-12 my-auto">
                <div id="login" class='mx-auto'>
                    <div clas='row'>
                        <div class="title-container">
                            <div class="logo rounded-circle"></div>
                            <h2 class="title">HRIS WEB PORTAL</h2>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='row'>
                                <div class="form-group col-lg-12 w-100 text-center">
                                    <small style='font-size: 0.6rem;'>Reset your password.</small>
                                </div>
                            </div>
                            <form class='container' action="" method="post">
                                <div class='row'>
                                    <div class="form-group col-lg-12 w-100">
                                        <label class="form-label" for="company-email">COMPANY EMAIL</label>
                                        <input type="email" name="company-email" id="company-email" class='form-input w-100' autocomplete='off'>
                                    </div>
                                </div>
                                <div class="row errorMsg">
                                    <div class='col-lg-12 w-100'>
                                        <small><?php echo ""; ?></small>
                                    </div>
                                </div>
                                <div class='d-flex justify-content-center'>
                                    <input type="submit" name="reset-pass" id="reset-pass" class="btn btn-primary w-100" value="Submit">
                                </div>
<br>
                                <div class='d-flex justify-content-center'>
                                    <a class="btn forgetlink w-100" href='../'>&raquo; Back &laquo;</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('input').focus(function() {
            $(this).parents('.form-group').addClass('focused');
        });

        $('input').blur(function() {
            var inputValue = $(this).val();

            if ( inputValue == "" )
            {
                $(this).removeClass('filled');
                $(this).parents('.form-group').removeClass('focused');  
            }
            else
            {
                $(this).addClass('filled');
            }
        });
    </script>
</body>
</html>