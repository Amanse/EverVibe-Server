<?php 
include("classes/db.php");
include('classes/Login.php');
if(isset($_GET['username'])){
    $otherId = DB::query("SELECT id FROM users WHERE username=:username", array(":username"=>$_GET['username']))[0]['id'];
    $Username = DB::query("SELECT username FROM users WHERE id=:loginId", array(":loginId"=>Login::isLoggedIn()))[0]['username'];
    $messages = DB::query("SELECT * FROM messages WHERE (sender=:sender AND reciever=:reciever) OR (reciever=:sender AND sender=:reciever) ", array(":reciever"=>Login::isLoggedIn(), ":sender"=>$otherId));
 }   

?>
<!DOCTYPE html>
<html>
<head>
	<title>CHAT</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<body>
	<div class='chatbox'>
		<div class='chatlogs' id='yourdiv'>
			<div id="data"></div>
		</div>
        <form method="post" class="chat-form" action="full-talk.php?reciever=<?php echo $otherId; ?>&username=<?php echo $_GET['username']; ?>">
                <textarea name="body" class="form-control"></textarea>
                <br>
                <button type="submit" name="send">Send </button>
            </form>
	</div>
 <script type="text/javascript">
            function getData(username, divid){
                $.ajax({
                    url: 'full-talk.php?username='+username, //call storeemdata.php to store form data
                    success: function(html) {
                        var ajaxDisplay = document.getElementById(divid);
                        ajaxDisplay.innerHTML = html;
                    }
                });
            }
            //var func = getData(<?php echo json_encode($_GET['username']) ?>, "data");
            setInterval(function(){
            	getData(<?php echo json_encode($_GET['username']) ?>, "data");
            }, 20);
</script>
</body>
</html>