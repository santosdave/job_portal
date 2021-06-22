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
		$sql = "SELECT id, e_hash, password FROM user_account WHERE BINARY email = BINARY '$email' LIMIT 1";
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
<html>

<head>
    <title>KISE JOB APPLICATION PORTAL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js">
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>


    <section id="header">
        <div class="menu-bar">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="home.html"><img src="https://www.kise.ac.ke/sites/default/files/kise_logo6.png"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <b><a class="nav-link" href="alljobs.htm">About</a></b>
                        </li>
                        <li class="nav-item">
                            <b><a class="nav-link" href="internships.html">Services</a></b>
                        </li>
                        <li class="nav-item ">
                            <b><a class="nav-link" href="tenders.html">Contacts</a></b>
                        </li>
                        <br>
                        <li class="nav-item">
                            <b><a class="nav-link" href="login.php" >Sign in</a></b>
                        </li>
                        <li class="nav-item">
                            <b><a class="nav-link" href="signup.php" >No account? Join Now</a></b>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="banner text-center">
            <h1>Welcome to KISE</h1>
            <h3>Career Opportunities</h3>
            <p><sm>Institute Of Special Learning</sm></p>
        </div>
    </section>



    <div class="search-job text-center">
        <input type="text" class="form-control" placeholder="search Jobs">
        <input type="text" class="form-control" placeholder="Location">
        <input type="text" class="form-control" placeholder="Department">
        <br>
        <input type="button" class="btn btn-primary" value="Find Job">

    </div>

    <section id="categories">
        <div class="container">
            <h3>TOP  CAREER CATEGORIES</h3>
            <div>
                <hr>
                <p>ICT<img src="photos/ICT_ICON.png" height="140" width="140"></p>
                <hr>
                <p>HOSPITALITY<img src="photos/hospitality.png" height="140" width="140"></p>
                <hr>
                <p>TENDER<img src="photos/tender.png" height="140" width="140"></p>
                <hr>

            </div>
    </section>


    
            <div>
                <ul class="page-link text-center">
                    <li class="left-arrow">&#8592;</li>
                    <li class="active">1</li>
                    <li>2</li>
                    <li>3</li>
                    <li>4</li>
                    <li>5</li>
                    <li class="right-arrow">&#8594;</li>
                </ul>
            </div>
    </section>

    <!-- Site stats -->
    <section id="site-stats">
        <div class="container text-center">
            <h3>KISE SITE STATS</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-6">
                            <div class="stats-box">
                                <i class="fa fa-user-o"></i><span><small>200 +</small></span>
                                <p>Job Seekers</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-box">
                                <i class="fa fa-slideshare"></i><span><small> 1 </small></span>
                                <p>Employer</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-6">
                            <div class="stats-box">
                                <i class="fa fa-building"></i><span><small>10 +</small></span>
                                <p>Departments</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-box">
                                <i class="fa fa-hand-peace-o"></i><span><small>5 </small></span>
                                <p>Active Jobs</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>




    </section>
    <section id="footer" class="text-center">
        <img src="photos/footer.png">
        <p>As an employer,we value you and we promise transparency throughout the application process<br><i class="fa fa-copyright">2021</i></p>
        <a href="#">
            <i class="fa fa-instagram"></i></a>
        <i class="fa fa-facebook-official"></i></a>
    </section>
    <script type="text/javascript">
function restrict(elem){
	var tf = _(elem);
	var e = _("email").value;
	var pass = _("password").value;
	var rx = new RegExp;
	if(elem == "email"){
		rx = /[' "]/gi;
	}
	if(e != "" && pass != ""){
		_("loginbtn").disabled = false;
	}else{
		_("loginbtn").disabled = true;
	}
	tf.value = tf.value.replace(rx, "");
}
function signin(){
	var email = _("email").value;
	var p = _("password").value;
	if(email != "" || p != ""){
		_("signinbtn").innerHTML = '<button id="loginbtn" class="btn btn-primary" disabled><i class="fa fa-spinner"></i></button>';
		var ajax = ajaxObj("POST", "index.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "login_failed"){
					login();
				} else {
					_("loginbtn").disabled = true;
					_("registerbtn").disabled = true;
					_("email").disabled = true;
					 _("password").disabled = true;
					window.location = "sync&"+ajax.responseText;
				}
	        }
        }
        ajax.send("email="+email+"&p="+encodeURIComponent(p));
	}else {
		login();
	}
}
</script>
</body>

</html>