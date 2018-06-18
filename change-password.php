 <?php
include('classes/db.php');
include('classes/Login.php');
$message = ""; 
function password_verif($Logpassword, $dataPass){
	if($Logpassword == $dataPass){
		return TRUE;
	}else{
		return FALSE;
	}
}

if(Login::isLoggedIn()){
	if(isset($_POST['changepassword'])){
		$oldpassword = sha1($_POST['oldpassword']);
		$newpassword = sha1($_POST['newpassword']);
		$newpasswordre = sha1($_POST['newpasswordre']);
		$user_id = Login::isLoggedIn();

		if(password_verif($oldpassword, DB::query('SELECT password FROM users WHERE id=:user_id', array(':user_id'=>$user_id))[0]['password'])){

			if($newpasswordre == $newpassword){

				if(strlen($newpassword) >= 6 && strlen($newpassword) <= 60){

					DB::query('UPDATE users SET password=:newpassword WHERE id=:user_id', array(':newpassword'=>($newpassword), ':user_id'=>Login::isLoggedIn()));
					$message = "Password Changed";

				}else{
					$message = "Invalid Password";
				}
			}else{
				$message = "Passwords Don't Match";
			}

		}else{
			$message =  "Incorrect Old Password";
		}
	}
}else{
	die("Not logged in");
}
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>Change password</title>
 	<script src="http://code.jquery.com/jquery-3.3.1.js"></script>
 	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
 </head>
 <body>
  <section class="hero is-primary is-fullheight">
	 <div class="hero-body">
	 	<div class="cloumns">
	 		<div class="cloumn">	
				<h1 class="title">Change Password</h1>
			</div>
			<div class="cloumn">
				<label class="label">Current Password</label>
				<form action="change-password.php" method="post">
				<input type="password" class="input is-rounded is-danger" name="oldpassword">
				<br>
				<label class="label">New Password</label>
				<input type="password" class="input is-rounded is-danger" onkeyup="checkPass()" class="newPass" name="newpassword" id='newpassword'>
				<br>
				<label class="label">Re-enter New Password</label>
				<input type="password" class="input is-rounded is-danger" onkeyup="checkPass()" class="newPass" name="newpasswordre" id='newpasswordre'>
				<br>
				<br>
				<input type="submit" class="button is-danger is-rounded is-focused" name="changepassword" id='submit' value="Change Password">
			</form>
			<br>
			<a href="index.php" class="button is-danger is-inverted is-outlined">Go to Timeline</a>
			<br>
			<b><?php echo $message; ?></b>
			</div>
		</div>
	</div>
</section>
<script>
	$('#submit').attr('disabled', 'disabled');

	function checkPassSuper(){	
		if($('#newpassword').val() == $('#newpasswordre').val()){
			return true;
		}else if($('#newpassword').val() != $('#newpasswordre').val()){
			return false;
		}
	}	

	function checkPass(){
		if(checkPassSuper()){
			$('#submit').removeAttr('disabled', 'disabled');
		}else {
			$('#submit').attr('disabled', 'disabled');
		}
	}
</script>
 </body>
 </html>

