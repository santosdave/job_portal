<?php
include_once("db/check_login_status.php");
if($user_ok == false){
	header("location: ../job_portal/index.php");
    exit();
}
mysqli_query($db_connection, "UPDATE company_profile SET last_checks_rjobs=now() WHERE e_hash='$log_email'");
?><?php 
include_once("_ext/dashboard_ulog.php");
if($e != $log_email){
	header("location: ../job_portal/index.php");
    exit();
}
if($utype == "seeker"){
	header("location: ../job_portal/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>KISE JOB APPLICATION PORTAL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="owner.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js">
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
<?php include_once("_ext/pageloader.php");?>
<?php include_once("_ext/pageloader-starter.php");?>
<?php include_once("_ext/dashboard_navbar.php");?>
<?php include_once("_ext/dashboard_dialog-searchlayer.php");?>
<?php include_once("_parse/_all_note_check.php");?>

    <section id="header">
        <div class="menu-bar">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="owner.html"><img src="https://www.kise.ac.ke/sites/default/files/kise_logo6.png"></a>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        
                        <li class="nav-item ">
                            <b><a class="nav-link" href="tenders.html"><i class="fa fa-user"></i> User</a></b>
                        </li>
                        <br>
                        <li class="nav-item">
                            <b><a class="nav-link" href="sign in.html"> <i class="fa fa-gear"></i> Account</a></b>
                        </li>
                        <li class="nav-item">
                            
                            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="menu-bar2">
            <div>
                <img  class="logo"src="photos/kise icon.png" width="40" height="40" alt="">
                <input  class="search"type="text" placeholder="Search People">
            </div>
            <div class="menu-container">
                <ul class="menu-list ml-auto">
                    <li>
                        <b><a class="nav-link" href="owner.php">Dashboard <i class="fa fa-dashboard"></i></a></b>
                    </li>
                    <li>
                        <b><a href="javascript:void(0);" onclick="notifications('<?php echo $log_email;?>')"><a class="nav-link">Notifications <i class="fa fa-bell"></i></a><span id="quick_note_num"><?php echo $note_label;?></span></b>
                    </li>
                    <li class="active"><a href="javascript:void(0);" onclick="rjob('<?php echo $log_email;?>')"><i class="fa fa-briefcase"></i><span>Jobs</span> </a> </li>
                    <?php echo $subnav_extras2;?>
                    <?php echo $subnav_extras3;?>
                    <?php echo $jobpost;?>
		        </ul>
            </div>
	  </div>
      <div class="main">
	  <div class="main-inner">
		<div class="container">
		  <!-------------------------------------------------------------------->
		   <div class="row">
			<div id="job1" class="span12">
			  <div class="widget widget-nopad">
				<div class="widget-header text-center">
				  <h3>Jobs you have posted</h3>
				</div>
				<div class="widget-content">
				  <div class="widget big-stats-container">
					<div class="widget-content">
					  <div class="big_stats" style="margin-top: 1em;">
						<div class="rjobs">
						  <div id="rjoblogs" class="rjoblogs"><div class="spinner" style="background-color: #000;"></div></div>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
 <div id="shortlist_initiator"></div>
  <br /><br /><br /><br />
<?php /* include_once("_ext/dashboard_footer.php"); */?>
<?php include_once("_ext/popup_jobpost.php");?>
<?php include_once("_ext/popup_jobpost-edit.php");?>
<?php include_once("_ext/popup_changedp.php");?>
<?php include_once("_ext/popup_company-profile.php");?>
<?php include_once("_ext/popup_jobpost-preview.php");?>
<?php include_once("_ext/popup_seeker-profile.php");?>
<!---------------------------------------------------------------------------->
<?php include_once("_ext/default_js.php");?>
<?php include_once("_ext/popup_add-requirements.php");?>
<?php include_once("_ext/dashboard_owlphin-box.php");?>
<script src="_js/multiple-select.js"></script> 
<script type="text/javascript">
$(function() {
    $('.multisel').change(function() {
        console.log($(this).val());
    }).multipleSelect({
        width: '100%'
    });
});
$(document).ready(function(e){
	var xmlhttp2 = new XMLHttpRequest();
	xmlhttp2.onreadystatechange = function(){
		if(xmlhttp2.readyState==4&&xmlhttp2.status==200){
			document.getElementById('rjoblogs').innerHTML = xmlhttp2.responseText;
		}
	}	
	xmlhttp2.open('GET','_parse/load_rjobs.php', true);
	xmlhttp2.send();

})
</script>
</body>
</html>