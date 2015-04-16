<?php
include('lib/php/curling.php');
	$remoteStyles = curlit('http://www.uvu.edu/_resources/includes/styles.inc');
	$remoteHscripts = curlit('http://www.uvu.edu/_resources/includes/headerscripts.inc');
	$remoteMegaMenu = curlit('http://www.uvu.edu/_resources/includes/megamenu.inc');
	$remoteHeader = curlit('http://www.uvu.edu/_resources/includes/header.inc');
	$remoteSearch = curlit('http://www.uvu.edu/_resources/includes/search.inc');
	$remoteFatFooter = curlit('http://www.uvu.edu/_resources/includes/footer.inc');
	$remoteFscripts = curlit('http://www.uvu.edu/_resources/includes/footerscripts.inc');
	$deptTitle = curlit('http://www.uvu.edu/besc/lib/includes/deptitle.inc'); /*Repoint to your department or app title*/
	$deptNav = curlit('http://www.uvu.edu/besc/lib/includes/nav-dept.inc'); /*Repoint to your department or app nav*/
	$deptFoot = curlit('http://www.uvu.edu/besc/lib/includes/footer-dept.inc');/*Repoint to your department or app footer*/
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Subject Pool</title>
		<link rel="shortcut icon" type="image/png" href="uvu.png">
		<meta name="keywords" content="" />
		<meta name="description" content="" />
      	<?php if($remoteStyles) echo $remoteStyles; // make sure we got a result and print it into the page ?>
		<link type="text/css" rel="stylesheet" href="//www.uvu.edu/wds/lib/css/dept.css" />
		<link type="text/css" rel="stylesheet" href="DevStyle.css"/>
      	<?php if($remoteHscripts) echo $remoteHscripts; // make sure we got a result and print it into the page ?>
	</head>
	<body>
    <!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5TK9V6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-5TK9V6');</script>
<!-- End Google Tag Manager -->
		<div style="height:0px; width:0px;"></div>
		<div id="wrapper">
			<div id="slideMenu"> 
      			<?php if($deptNav) echo $deptNav; // make sure we got a result and print it into the page ?>
			</div>
			<div id="container">
				<div id="lHeaderShadow"></div>
				<div id="rHeaderShadow"></div>
				<div id="header">
					<div id="logoAndTitle">
     					<?php if($remoteHeader) echo $remoteHeader; // make sure we got a result and print it into the page ?>
						<div id="pageTitle">
							<p><a href="http://www.uvu.edu/besc"><?php if($deptTitle) echo $deptTitle; // make sure we got a result and print it into the page ?>
								</a></p>
							<p><a href="http://subjectpool.uvu.edu">/Subject Pool</a></p>
						</div>
						<div class="clearfloat"></div>
					</div>
                    <a href="#" id="searchMobile" class="ori_mobile">&nbsp;</a>
					<div id="searchAndNav">
						<?php if($remoteSearch) echo $remoteSearch; // make sure we got a result and print it into the page ?>
						<?php if($remoteMegaMenu) echo $remoteMegaMenu; // make sure we got a result and print it into the page ?>
					</div>
					<div class="clearfloat"></div>
					<div id="deptNavBar">
						<div id="deptNav" class="dropNav">
							<?php if($deptNav) echo $deptNav; // make sure we got a result and print it into the page ?>
							<div class="clearfloat"></div>
						</div>
					</div>
					<div class="clearfloat"></div>
					<div id="slideMenuSep"><a id="slideMenuButton">Menu</a></div>
				</div>
				<div  class="contentArea" style="padding-bottom:0px;">
					<div class="row" style = "border-left:50px solid #748A48;">
						<!--<div class="col-xs-1"style="height:100%; width:100%;border-left:1% solid #4D7123; float:left;padding:3%"> -->
                    	<div class="col-xs-12"  style="border-left:5px solid #E7D165; border-right:80px solid #748A48;padding:5%;padding-left:10%; margin-left:5px;"><!--style=" border-left:10px solid #EED665;border-right:150px solid #4D7123;;padding:0px"  your content goes within this div -->
						


