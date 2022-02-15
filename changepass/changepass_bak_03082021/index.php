<?php
	session_start();
	
	if(isset($_SESSION['user_id_reset_pass']))
	{
		include('../config/db.php');

		if (isset($_POST['password2']) && isset($_POST['password1']))
		{
			$db = getDB();
			$new_pass = hash('sha256', trim($_POST['password2']));
			$stmt = $db->prepare("UPDATE dbo.mf_user SET userpassword=:userpassword, permanentpass=1, userchange='Y' WHERE useremail=:useremail");
			$stmt->bindParam("useremail", $_POST['email'],PDO::PARAM_STR) ;
			$stmt->bindParam("userpassword", $new_pass,PDO::PARAM_STR) ;
			$stmt->execute();
			$result = $stmt->rowCount();

			if ($result > 0)
			{
				echo "<script>alert('Successfully Updated! Please login now using your new password!');</script>";
				header( "refresh:0;url=../index.php" );
			}
			else
			{
				echo "<script>alert('Unable to process your request. Please contact your site administrator');</script>";
				header("refresh:0;");
			}
		}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Premium Megastructures Inc. | Web Portal</title>
    <link rel='stylesheet' href='../css/style.css'>
	<link rel='stylesheet' href='../node_modules/@fortawesome/fontawesome-free/css/all.css'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js' type='text/javascript'></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
<!------ Include the above in your HEAD tag ---------->

	<div class="container h-100">
		<div class="row h-100">
			<div id="container" class="frmLogin col-sm-12 my-auto">
				<div id="login" class='mx-auto'>
					<div clas='row'>
						<div class="title-container">
							<div class="logo rounded-circle"></div>
							<h2 class="title">HRIS WEB PORTAL</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class='row'>
								<div class="form-group col-lg-12 w-100 text-center">
									<small style='font-size: 0.6rem;'>Use the form below to change your password. Your password cannot be the same as your username.</small>
								</div>
							</div>
							<form class='container' method="post" id="passwordForm" action="">
								<div class='row'>
                                    <div class="form-group col-lg-12 w-100">
										<label class="form-label" for="email">COMPANY EMAIL</label>
										<input type="email" class="form-input w-100" name="email" id="email" autocomplete="off" value="<?= $_SESSION['requestemail']; ?>">
									</div>
								</div>
								<div class='row'>
									<div class="form-group col-lg-12 w-100">
										<label class="form-label" for="password1">NEW PASSWORD</label>
										<input type="password" class="form-input w-100" name="password1" id="password1" autocomplete="off">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<ul style="padding-left:10%;">
											<li><small id="8charContainer" style="color:#FF0004;"><i id="8char" class='fa fa-times'></i> 8 Characters Long</small></li>
											<li><small id="ucaseContainer" style="color:#FF0004;"><i id="ucase" class='fa fa-times'></i> One Uppercase Letter</small></li>
										</ul>
									</div>
									<div class="col-sm-6">
										<ul style="padding-left:10%;">
											<li><small id="lcaseContainer" style="color:#FF0004;"><i id="lcase" class='fa fa-times'></i> One Lower Case</small></li>
											<li><small id="numContainer" style="color:#FF0004;"><i id="num" class='fa fa-times'></i> One Number</small></li>
										</ul>
									</div>
								</div>
								<div class='row'>
									<div class="form-group col-lg-12 w-100">
										<label class="form-label" for="password2">CONFIRM PASSWORD</label>
										<input type="password" class="form-input w-100" name="password2" id="password2" autocomplete="off">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<ul style="padding-left:10%;">
											<li><small id='pwmatchContainer' style="color:#FF0004;"><i id="pwmatch" class="fa fa-times"></i> Passwords Match</small></li>
										</ul>
									</div>
								</div>
								<div class='d-flex justify-content-center'>
									<input type="submit" class="btn btn-primary w-100" data-loading-text="Changing Password..." name="change-pass-btn" id="change-pass-btn" value="Change Password" disabled>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<script src='../js/passwordValidator.js'></script>

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
<?php
} else {
	echo "<script>alert('Invalid Request!');</script>";
	header("refresh:0;url=../index.php" );
}
?>