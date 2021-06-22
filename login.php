<?php 
include_once("db/check_login_status.php");
if($user_ok == true){
	header("location: sync&".$_SESSION["user_hash"]);
    exit();
}
?><?php
if(isset($_POST["email"])){
	$email = $_POST['email'];
	$p = md5($_POST['p']);
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));

	if($email == "" || $p == ""){
		echo "login_failed";
        exit();
	} else {
		$sql = "SELECT id, e_hash, password FROM user_account WHERE BINARY email = BINARY '$email' AND activated='1' LIMIT 1";
        $query = mysqli_query($db_connection, $sql);
        $row = mysqli_fetch_row($query);
		$db_id = $row[0];
		$db_ehash = $row[1];
        $db_pass_str = $row[2];
		if($p != $db_pass_str){
			echo "login_failed";
            exit();
		} else {
			$_SESSION['userid'] = $db_id;
			$_SESSION['user_hash'] = $db_ehash;
			$_SESSION['password'] = $db_pass_str;
			setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie("e_hash", $db_ehash, strtotime( '+30 days' ), "/", "", "", TRUE);
    		setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE);

			$sql = "UPDATE user_account SET ip='$ip', last_login_date=now() WHERE e_hash='$db_ehash' LIMIT 1";
            $query = mysqli_query($db_connection, $sql);
			echo $db_ehash;
		    exit();
		}
	}
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="sign in.css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <title>Sign in</title>
</head>

<body>
    <section id="header">
        <div class="menu-bar">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="index.php"><img src="photos/logo kise.PNG"></a>
            </nav>
        </div>
    </section>
    <div class="main">
		<span id="status"></span>
        <p class="sign" align="center">Sign in</p>
        <form class="form1" role="form" method="post" onSubmit="return false;">
            <input class="un " type="text" id="email" name="email" value="" align="center" placeholder="Username" onfocus="emptyElement('status')" onkeyup="restrict('email')">
            <input class="pass" type="password" id="password" value="" name="password" align="center" placeholder="Password"  onfocus="emptyElement('status')" class="login password-field">
            <button class="submit" align="center" onclick="signin()">Sign in</button>
            <p class="forgot" align="center"><a href="javascript:void(0)">Forgot Password?</a></p>
            <p class="forgot" align="center"><a href="signup.php">Register</a></p>
		</form>
            
                
    </div>
<?php include_once("_ext/default_js.php");?>
<script type="text/javascript">
function restrict(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "email"){
		rx = /[' "]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function emptyElement(x){
	_(x).innerHTML = "";
	_("password").style.borderColor = "black";
	_("email").style.borderColor = "black";
}
function signin(){
	var email = _("email").value;
	var p = _("password").value;
	var status = _("status");
	if(email == ""){
		status.innerHTML = '<h5><div class="alert">Please fill out all of the form data</div></h5>';
		_("email").style.borderColor = "red";
	} else if(p == ""){
		status.innerHTML = '<h5><div class="alert">Please fill out all of the form data</div></h5>';
		_("password").style.borderColor = "red";
	}else {
		/* _("showloader").style.display = "block"; */
		var ajax = ajaxObj("POST", "login.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "login_failed"){
					status.innerHTML = '<h5><div class="alert">Wrong email or password</div></h5>';
					/* _("showloader").style.display = "none"; */
				} else {
					window.location = "sync&"+ajax.responseText;
				}
	        }
        }
        ajax.send("email="+email+"&p="+encodeURIComponent(p));
	}
}
</script>     
</body>

</html>
