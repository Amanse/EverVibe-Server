<?php
include('classes/db.php');
function password_verif($Logpassword, $dataPass){
	if($Logpassword == $dataPass){
		return TRUE;
	}else{
		return FALSE;
	}
}


 ?>
 <head>
 	  <meta charset="utf-8">
 	 <meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>Login</title>
 	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css"> 
	 <script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
	<style>
		@import url('https://fonts.googleapis.com/css?family=ABeeZee|Questrial|Ropa+Sans');

		.heading{
			font-family: 'Ropa Sans', sans-serif;
			font-size: 30px;
		}

		.title {
			font-size: 60px;
		}

		.hero{

		}
	</style>
 </head>
 <body>
 <section class="hero is-danger is-bold is-fullheight">
 	<div class="hero-body">
 		<div class="container is-one-third">
 			<h1 class="title is-bold" style="font-family: 'ABeeZee', sans-serif;">EverVibe</h1>
			<h1 class="heading">Login</h1>
			<form action="login.php" method="post">
				<div class="column">
					<div class="field">
						<div class="control">
							<lable class="lable"><span style="font-family: 'Questrial', sans-serif;">Username</span></lable>
							<input type="text" class="input is-rounded is-primary" name="username" id='username' autocomplete="off"><br>
						</div>
					</div>
				</div>
				<div class="column">
						<div class="field">
							<div class="control">
								<lable class="lable"><span style="font-family: 'Questrial', sans-serif;">Password</span></lable>
								<input type="password" id='password' class="input is-rounded is-primary " name="password"><br>
						</div>
					</div>	
				</div>
				<input type="button" class="button is-info" id="Login" name="login" value="Login">
			</form>
			<span class="is-info" id="response"><?php echo $message; ?></span>
		</div>
	</div>	
</section>
<script>
	$("#Login").click(function(){
		$.post("functions.php", {
            thing: "login",
			username: document.getElementById("username").value,
			password: document.getElementById("password").value
		},
		function(data, status) {
			console.log(status);
			console.log(data);
			if (data == "Logged in") {
				location.replace("index.php");
			} else {
			$("#response").html(data);
			}
		}
		)
	})
	
	$("#Pass").keypress(function(e){
                var key = e.which;
                if (key == 13) {
                    login();
                }
            })
</script>
</body>
