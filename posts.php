<?php 
include('classes/db.php');
include('classes/Login.php');
include('classes/Post.php');
include('classes/Comment.php');


if(isset($_GET['id'])){
	$posts = DB::query("SELECT * FROM posts WHERE id=:id", array(":id"=>$_GET['id']));

	$PosterID = Login::isLoggedIn();
	$username = DB::query("SELECT username FROM users WHERE id=:id", array(":id"=>$PosterID))[0]['username'];
	if(isset($_POST['comment'])){
	Comment::MakeComment($_POST['commentbody'], $_GET['id'], $PosterID);
}
	
	foreach ($posts as $post) {
		//echo "<h1 class='title'>".$post['body']."</h1>";
		//echo "<br>";
		Comment::displayComments($_GET['id']);
	}
	echo "<br>";
	echo "<a href='profile.php?username=".$username."'>Back to profile</a>";
	echo "<form action='posts.php?id=".$_GET['id']."' method='post'>
			<label for='commentbody' class='label'>Comments</label>
			<textarea name='commentbody' class='input is-small is-rounded is-danger' rows='1' cols='20'></textarea><br>
			<input type='submit' name='comment' class='button is-warning' Value='Comment'>
			</form>";
}
?>
<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
	<title>Comments</title>
</head>
<body>

</body>
</html>