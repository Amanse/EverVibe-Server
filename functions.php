<?php
include('classes/db.php');
include('classes/Post.php');
include('classes/notify.php');
include('classes/Comment.php');

// Login script
function password_verif($Logpassword, $dataPass){
	if($Logpassword == $dataPass){
		return TRUE;
	}else{
		return FALSE;
	}
}

if($_POST['thing'] == "login"){
	$username =$_POST['username'];
	$password = $_POST['password'];

	if(DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))){

		if(password_verif(sha1($password), DB::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password'])){
			echo "Logged in";
			$cstrong = True;
			$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
			$user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];
			DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));

			setcookie("SNID", $token, time() + 60*60*24*7, '/', NULL, NULL, TRUE);
			setcookie("SNID_", '1', time() + 60*60*24*3, '/', NULL, NULL, TRUE);
		}else{
			echo  "Incorrect Password!";
		}


	}else{
		echo "User is not registered";
	}

}
// end of login script

//Users search
if (isset($_GET['query'])) {

	$searchQuery = $_GET['query'];
	$tosearch = explode(" ", $searchQuery);
	if(count($tosearch) == 1){
		$tosearch = str_split($tosearch[0], 2);
	}
	$whereclause = "";
	$paramsarray = array(':username'=>'%'.$searchQuery.'%');
	for ($i = 0; $i < count($tosearch); $i++){
		$whereclause .= " OR username LIKE :u$i";
		$paramsarray[":u$i"] = $tosearch[$i];
	}
	$users = DB::query('SELECT username FROM users WHERE username LIKE :username '.$whereclause.'', $paramsarray);

	if($users != ""){
		echo "<span class='result'> Results </span><br>";
		echo "<ul style='list-style:none;'>";
	foreach ($users as $u ) {
		echo "<li><a class='results' href='profile.php?username=".htmlspecialchars($u['username'])."'> ".htmlspecialchars($u['username']) . " </a><br></li>";
	}
		echo "</ul>";
	} else {
		echo "No users found";
	}
}
// End of user search script

//Registeration script

if ($_POST['thing'] == "Register") {
    $username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];

	if(!DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))){

		if(strlen($username) >= 3 && strlen($username) <= 32) {

			if(strlen($password) >= 6 && strlen($password) <= 60){

			if(preg_match('/[a-zA-Z0-9_]/', $username)){

			if(!DB::query('SELECT email FROM users WHERE email=:email', array(":email"=>$email))){

				DB::query('INSERT INTO `users` VALUES (\'\' ,:username, :password, :email)', array(':username'=>$username, ':password'=>sha1($password), ':email'=>$email));
				echo "Registered";
				//header("LOCATION: login.php");
			}else{
				echo  "Email already exits";
			}

		}else{
			echo "Invalid username";
		}

		}else{
			echo "Invalid Password";
		}

	}else{
		echo "Invalid Username";
	}
}else{
	echo "User already exist";
}
}
// Sign up script Ends

//Follow script
if($_POST['thing'] == "Following") {
	$userid = $_POST['userId'];
	$followerid = $_POST['followerId'];
	$followCheck = DB::query('SELECT user_id FROM followers WHERE follower_id=:followerid AND user_id=:userid', array(':userid'=>$userid, ':followerid'=>$followerid));
	 if(!$followCheck) {
	 	DB::query('INSERT INTO followers VALUES (\'\', :userid, :followerid)', array(':userid'=>$userid, ':followerid'=>$followerid));
					$isFollowing = True;
		DB::query("INSERT INTO notification VALUES('', :type, :reciever, :sender, :extra)", array(":type"=>3, ":reciever"=>$userid, ":sender"=>$followerid,":extra"=>""));
	 } else {
	 	echo "already Following";
	 }
}
//End of follow script

//UnFollow Script
if ($_POST['thing'] == "UnFollowing") {
	$userid = $_POST['userId'];
	$followerid = $_POST['followerId'];
	$followCheck = DB::query('SELECT user_id FROM followers WHERE follower_id=:followerid AND user_id=:userid', array(':userid'=>$userid, ':followerid'=>$followerid));

	if ($followCheck) {
		DB::query('DELETE FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid));
	} else {
		echo "Not following";
	}
}

//make post script
if($_POST['thing'] == "MakingPost") {
	Post::MakePost($_POST['postbody'], $_POST['followerid'], $_POST['userid']);
}
//End of Making Post Script

//Getting Post
if ($_GET['thing'] == "Get Posts") {
	$userid = $_GET['userid'];
	$username = DB::query("SELECT username FROM users WHERE id=:id", array(":id"=>$userid))[0]['username'];
	$followerid = $_GET['followerid'];

	$post = Post::displayPosts($userid, $username, $followerid);
	echo $post;
}
//End of getting post

//Making Comment
if ($_POST['thing'] == "Make Comment") {
	$Poster_id = $_POST['posterId'];
	$Post_id = $_POST['postId'];
	$commentBody = $_POST['commentBody'];

	Comment::MakeComment($commentBody, $Post_id, $Poster_id);
}
//End making comment

//Getting Comments
if ($_POST['thing'] == "Get comments") {
	Comment::displayComments($_POST['PostId']);
}
//Got Comments
?>
