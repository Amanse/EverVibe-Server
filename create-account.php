<?php
include('classes/db.php');


?>
<head>
	<meta charset="utf-8">
 	 <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Create-Account</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
    <script src="http://code.jquery.com/jquery-3.3.1.js"></script>

	<style type="text/css">
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
			<h1 class="title" style="font-family: 'ABeeZee', sans-serif; font-size:60px;">EverVibe</h1>
			<h1 class="heading">Create-account</h1>
				<form action="create-account.php" method="post">
					<lable class="lable"><span style="font-family: 'Questrial', sans-serif;">Username</span></lable>
					<input type="text" id="username" class="input is-rounded is-primary" name="username" ><br>
					<lable class="lable"><span style="font-family: 'Questrial', sans-serif;">Password</span></lable>
					<input type="password" id="password" class="input is-rounded is-primary" name="password" ><br>
					<lable class="lable"><span style="font-family: 'Questrial', sans-serif;">E-mail</span></lable>
					<input type="email" id="email" class="input is-rounded is-primary" name="email" ><br>	
					<br>
					<input type="button" id="MakeAccount" class="button is-info" name="create-account" value="Create-Account">
				</form>
				<div id="something"></div>
				<a href="login.php">Already have an account?</a>
		</div>
	</div>
</section>
<script>
    
    $("#MakeAccount").click(function(){
        $.post("functions.php", {
            thing: "Register",
            username: $("#username").val(),
            password: $("#password").val(),
            email: $("#email").val()
        },
        function(data, status) {
            if (data == "Registered") {
                location.replace("login.php");
            } else {
                $("#something").html(data);
            }
            $("#something").html(data);
            console.log(status);
        }    
        )
    })
    
</script>
</body>