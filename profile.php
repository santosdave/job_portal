<?php
include_once("db/check_login_status.php");
if($user_ok == false){
	header("location: ../job_portal/index.php");
    exit();
}
?><?php 
include_once("_ext/dashboard_ulog.php");
?><?php 
$sql = "SELECT avatartemp FROM user_account WHERE e_hash='$log_email'";
$query = mysqli_query($db_connection, $sql);
$row = mysqli_fetch_row($query);
$old_dp = $row[0];
if($old_dp != ""){
	$picurl = "_USER/$log_email/$old_dp"; 
	if (file_exists($picurl)) { unlink($picurl); }
}
mysqli_query($db_connection, "UPDATE user_account SET avatartemp=NULL WHERE e_hash='$log_email'");
$sq = "SELECT start_date,date_date FROM experience_detail WHERE is_current_job='1'";
$q = mysqli_query($db_connection, $sq);
while ($row = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
	$start_date = strftime("%b %Y", strtotime($row["start_date"]));
	$date_date = strftime("%b %Y", strtotime($row["date_date"]));
	$diff = abs(strtotime($date_date) - strtotime($start_date));
	$date_year_diff = floor($diff / (365*60*60*24));
}
$query2 = mysqli_query($db_connection, "UPDATE experience_detail SET date_date=now(),date_year_diff='$date_year_diff' WHERE is_current_job='1'");
$addBtn = 'style="display:none;"';if($e == $log_email){$addBtn = 'style="display:;"';}
?><?php 
$sql = "SELECT * FROM education_detail WHERE e_hash='$e' ORDER BY postdate DESC";
$query = mysqli_query($db_connection, $sql);
$eduList = "";
while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$eid = $row["id"];
	$degree = $row["certificate_degree_name"];
	$major = $row["major"];
	$sch = $row["institute_university_name"];
	$from = $row["starting_date"];
	$to = $row["completion_date"];
	$cgpa = $row["cgpa"];
	$eduDeleteButton = '';
	if($e == $log_email){
		$eduDeleteButton = '<div class="mobile-no-show" style="float: right;padding: 5px;" id="edb_'.$eid.'"><button class="btn btn-primary btn-small" onmousedown="deleteEdu(\''.$eid.'\',\'edb_'.$eid.'\');" ><span class="fa fa-trash"></span></button></div>';
	}
	$eduList .= '<div id="edb_'.$eid.'" class="profile_widget">'.$eduDeleteButton.'<div class="profile_widget-image"><span class="fa fa-institution"></span></div>';
	$eduList .= '<div class="profile_widget-details"><h3>'.$sch.'</h3><h4 style="margin-top:5px;">'.$degree.', '.$major.' - '.$from.' to '.$to.'</h4>';
	$eduList .= '</div></div>';		
}
?><?php 
$sql2 = "SELECT * FROM experience_detail WHERE e_hash='$e' ORDER BY postdate DESC";
$query = mysqli_query($db_connection, $sql2);
$xpList = "";
while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$xid = $row["id"];
	$is_current_job = $row["is_current_job"];
	$job_title  = $row["job_title"];
	$job_specialization  = $row["job_specialization"];
	$company_name = $row["company_name"];
	$business_stream = $row["business_stream"];
	$start_date = strftime("%b %Y", strtotime($row["start_date"]));
	$date_date = strftime("%b %Y", strtotime($row["date_date"]));
	$description = $row["description"];
	$xpDeleteButton = '';
	if($e == $log_email){
		$xpDeleteButton = '<div class="mobile-no-show" style="float: right;padding: 5px;" id="xdb_'.$xid.'"><button class="btn btn-primary btn-small" onmousedown="deleteXp(\''.$xid.'\',\'xdb_'.$xid.'\');" ><span class="fa fa-trash"></span></button></div>';
	}
	$end_date = "Today";
	if($is_current_job == '0'){
		$end_date = $date_date;
	}
	$xpList .= '<div id="xdb_'.$xid.'" class="profile_widget">'.$xpDeleteButton.'<div class="profile_widget-image"><span class="fa fa-briefcase"></span></div>';
	$xpList .= '<div class="profile_widget-details"><h3>'.$job_title.'</h3><h4 style="margin-top:5px;">'.$company_name.' - '.$business_stream.' </h4>';
	$xpList .= '<h4 style="margin-top:5px;">Job specialization - '.$job_specialization.'</h4><h4 style="margin-top:5px;color: grey;">'.$description.' </h4>';
	$xpList .= '<h4 style="margin-top:5px;">'.$start_date.' - '.$end_date.'</h4></div></div>';				
}
?><?php 
$sql3 = "SELECT * FROM seeker_skill_set WHERE e_hash='$e' LIMIT 5";
$query = mysqli_query($db_connection, $sql3);
$skillList = "";
while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$sid = $row["id"];
	$skill_set_name = $row["skill_set_name"];

	$skillList .= '<div id="" class="profile_widget" style="margin: 0 .9% 5px;"><div class="profile_widget-image"><span style="font-size: 1em;" class="fa fa-star"></span></div>';
	$skillList .= '<div class="profile_widget-details"><h5>'.$skill_set_name.'</h5></div></div>';
					
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
                        <b><?php echo $usershow;?>><a href="javascript:void(0);" onclick="profile('<?php echo $log_email;?>')"><a class="nav-link">Profile <i class="fa fa-user"></i></a></b>
                    </li>
                    <li>
                        <b><a href="javascript:void(0);" onclick="notifications('<?php echo $log_email;?>')"><a class="nav-link">Notifications <i class="fa fa-bell"></i></a><span id="quick_note_num"><?php echo $note_label;?></span></b>
                    </li>
                    <?php echo $subnav_extras1;?>
                    <?php echo $subnav_extras2;?>
                    <?php echo $subnav_extras3;?>
                    <?php echo $jobpost;?>
                </ul>
		    </div>
	    </div>
        <div class="main">
            <div class="main-inner">
                <div class="container">
                <div <?php echo $usershow;?> class="row">
			<div class="span12">
			  <div class="box box-widget widget-user profile-gradient">
				<div style="text-align: center;"><div class="widget-user-header bg-profile"></div></div>	
				<div id="targetDpLayer" class="widget-user-image hand targetDpLayer" pd-popup-open="changeDp"><?php echo $user_pic;?></div>
				<div class="banner-user text-center" style="padding-bottom: 0px;">
				  <h2 class="profile-user text-center"><?php echo $firstname;?> <?php echo $lastname;?></h2>
				  <h3><span style="font-size:14px;"><?php echo $email;?></span></h3>
				  <h3><span style="font-size:12px;"><?php echo $user_phonenumber;?></span></h3><br>
				</div>
			  </div>
			</div>
		  </div>
		  <div <?php echo $usershow;?> class="row" style="margin-bottom: 15px;">
		    <div class="span12">
			  <div class="widget widget-nopad">
				<div class="widget-header"> <i class="fa fa-user"></i>&nbsp;
				  <h3>Bio</h3>
				  <div style="float:right;margin-right: 5px;"><button <?php echo $addBtn;?> class="btn btn-primary btn-small" pd-popup-open="addbio">Add / Edit</button></div>
				</div>
				<div class="widget-content">
				  <div class="widget big-stats-container">
					<div class="widget-content">
					  <div class="big_stats cf">
						<div class="profile_widgets"> 
						  <div class="user_bio" style="padding: 0px 10px 10px 10px;font-size: 14px;"><?php echo $seeker_bio;?></div>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		  <div <?php echo $usershow;?> class="row" style="margin-bottom: 15px;">
		    <div class="span12">
			  <div class="widget widget-nopad">
				<div class="widget-header"> <i class="fa fa-gavel"></i>&nbsp;
				  <h3>Skills</h3>
				  <div style="float:right;margin-right: 5px;"><button <?php echo $addBtn;?> class="btn btn-small" pd-popup-open="addskill">Add / Edit</button></div>
				</div>
				<div class="widget-content">
				  <div class="widget big-stats-container">
					<div class="widget-content">
					  <div class="big_stats cf">
						<div class="profile_widgets"> 
						  <div class="user_skill">
						     <?php echo $skillList;?>
						  </div>
						  <div class="text-center"><a href="javascript:void(0)" pd-popup-open="v_allskills">View all</a></div>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		   <div class="row" <?php echo $usershow;?> style="margin-bottom: 15px;">
			<div class="span12">
			  <div class="widget widget-nopad">
				<div class="widget-header"> <i class="fa fa-mortar-board"></i>&nbsp;
				  <h3>Education</h3>
				  <div style="float:right;margin-right: 10px;"><button <?php echo $addBtn;?> class="btn btn-small" pd-popup-open="addeducation"> Add</button></div>
				</div>
				<div class="widget-content">
				  <div class="widget big-stats-container">
					<div class="widget-content">
					  <div class="big_stats">
					     <div class="profile_widgets"> 
						  <div id="user_edu">
						    <?php echo $eduList;?>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="row" <?php echo $usershow;?>>
			<div class="span12">
			  <div class="widget widget-nopad">
				<div class="widget-header"> <i class="fa fa-suitcase"></i>&nbsp;
				  <h3>Experience</h3>
				  <div style="float:right;margin-right: 10px;"><button <?php echo $addBtn;?> class="btn btn-small" pd-popup-open="addxp">Add</button></div>
				</div>
				<div class="widget-content">
				  <div class="widget big-stats-container">
					<div class="widget-content">
					  <div class="big_stats">
					     <div class="profile_widgets"> 
						  <div id="user_xp">
						    <?php echo $xpList;?>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div> 
		  <div class="row" <?php echo $usershow;?>>
			<div class="span12">
			  <div class="widget widget-nopad">
				<div class="widget-header"> <i class="fa fa-file"></i> &nbsp;
				  <h3>CV Reference</h3>
				  <div style="float:right;margin-right: 10px;"><button <?php echo $addBtn;?> class="btn btn-small" pd-popup-open="addcv">Add/ Replace CV</button></div>
				</div>
				<div class="widget-content">
				  <div class="widget big-stats-container">
					<div class="widget-content">
					  <div class="big_stats">
					     <div class="profile_widgets"> 
						  <div id="user_cv" class="text-center">
						    <span id="targetCvLayer"><?php echo $user_cv;?></span>
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
  </div>
 <div id="shortlist_initiator"></div>
  <br /><br /><br />
<?php /* include_once("_ext/dashboard_footer.php"); */?>
<?php include_once("_ext/popup_jobpost.php");?>
<?php include_once("_ext/popup_changedp.php");?>
<?php include_once("_ext/popup_add-education.php");?>
<?php include_once("_ext/popup_add-experience.php");?>
<?php include_once("_ext/popup_add-bio.php");?>
<?php include_once("_ext/popup_add-cv.php");?>
<?php include_once("_ext/popup_company-profile.php");?>
<?php include_once("_ext/popup_view-all-skills.php");?>
<?php include_once("_ext/popup_seeker-profile.php");?>
<!---------------------------------------------------------------------------->
<?php include_once("_ext/default_js.php");?>
<?php include_once("_ext/dashboard_owlphin-box.php");?>
<?php include_once("_ext/popup_add-skills.php");?>
<script src="_js/multiple-select.js"></script> 
<script type="text/javascript">
$(function() {
    $('.multisel').change(function() {
        console.log($(this).val());
    }).multipleSelect({
        width: '100%'
    });
});
</script>
</body>
</html>