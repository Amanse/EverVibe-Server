<?php 
include('classes/db.php');


// Login script
function password_verif($Logpassword, $dataPass){
	if($Logpassword == $dataPass){
		return TRUE;
	}else{
		return FALSE;
	}
}

if(isset($_POST['username'])){
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

?>