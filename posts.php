<?php 
include('classes/db.php');
include('classes/Login.php');
include('classes/Post.php');
include('classes/Comment.php');
$PosterID = "";

if(isset($_GET['id'])){
	$posts = DB::query("SELECT body FROM posts WHERE id=:id", array(":id"=>$_GET['id']))[0]['body'];
	$PosterID = Login::isLoggedIn();
	$username = DB::query("SELECT username FROM users WHERE id=:id", array(":id"=>$PosterID))[0]['username'];
	echo "<h1 class='huge'>".Post::link_add($posts)."</h1>";
	echo "<div id='CommentsAll'></div>";
	echo "<br>";
	echo "<a href='profile.php?username=".$username."'>Back to profile</a>";
	echo "<form>
			<label for='commentbody' class='label'>Comments</label>
			<textarea name='commentbody' id='commentBody' class='input is-small is-rounded is-danger' rows='1' cols='20'></textarea><br>
			<input type='button' name='comment' id='makeComment' class='button is-warning' Value='Comment'>
			</form>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="http://code.jquery.com/jquery-3.3.1.js"></script>
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
	<title>Comments</title>
	<style type="text/css">
		.comments {
			margin: 2px;
			padding: 5px;
		}

		.huge {
			font-size: 60px;
			font-weight: 20;
		}
	</style>
</head>
<body>
	<div id="something"></div>
<script>
	function GetComments(){	
		$.post("functions.php", {
			thing: "Get comments", 
			PostId: <?php echo $_GET['id']; ?>
		},function(data, status){
			$("#CommentsAll").html(data);
			console.log(status);
		})
	}

	GetComments();

	$("#makeComment").click(function(){
		$.post("functions.php", {
			thing: "Make Comment",
			commentBody: $("#commentBody").val(),
			posterId: <?php echo $PosterID; ?>,
			postId: <?php echo $_GET['id']; ?>
		},function(data){
			$("#something").html(data);
			GetComments();
			$("#commentBody").val("");
		})
	})

</script>
</body>
</html>