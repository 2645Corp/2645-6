<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="assets/icon/favicon.ico">
<title>Weihai No.1 High School EX Dep. AMP</title>

<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="assets/plugins/bootstrap-3.3.1/css/bootstrap.min.css" type='text/css'>
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<script src="assets/js/modernizr.js"></script>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
          <script src="assets/js/html5shiv.min.js"></script>
          <script src="assets/js/respond.min.js"></script>
        <![endif]-->
</head>
<body>
<?php
session_start();
if(isset($_SESSION['username'])&&isset($_SESSION['userflag']))
{
	if($_SESSION['userflag']!="student")
		header("Location: include/admin.php");
	else
		header("Location: include/stumain.php");
}
?>
<script language="javascript">
var DEFAULT_VERSION = "8.0";
var ua = navigator.userAgent.toLowerCase();
var isIE = ua.indexOf("msie")>-1;
var safariVersion;
if(isIE){
    safariVersion =  ua.match(/msie ([\d.]+)/)[1];
}
if(safariVersion <= DEFAULT_VERSION ){
   window.location.href = "updatebrowser.html";
}
</script>
<!-- Preloader -->
<div id="preloader">
  <div id="status">&nbsp;</div>
</div>
<!-- Fixed navbar -->
<div class="navbar main-menu navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="http://www.whyzsyb.com"><img src="assets/images/logo.png" alt="logo" /></a> </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-left" id="menu">
        <li><a class="hvr-underline-from-left" data-scroll data-options="easing: easeOutQuart" href="http://www.whyzsyb.com">Home</a></li>
        <li><a class="hvr-underline-from-left" data-scroll data-options="easing: easeOutQuart" href="#">About</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right" id="menu">
        <li><a class="hvr-underline-from-left" data-scroll data-options="easing: easeOutQuart" href="reg/">Sign up</a></li>
        <li role="presentation" class="dropdown"> <a href="#" data-scroll data-options="easing: easeOutQuart" data-toggle="dropdown" class="dropdown-toggle hvr-underline-from-left">Select Language<b class="caret"></b></a>
          <ul role="menu" class="dropdown-menu">
            <li><a href="index.php">简体中文</a></li>
            <li><a href="index_en.php">English</a></li>
            <li><a href="index_tw.php">正體中文</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <!--/.nav-collapse --> 
  </div>
</div>
<div class="container">
  <div class="row loginpanel col-xs-9 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-6 col-lg-offset-7">
    <form method="post" action="include/check_login.php" class="form-horizontal">
      <div class="col-xs-12"> <br/>
        <input class="form-control" name="username" id="username" required="true" placeholder="Username" />
        <br/>
        <input class="form-control" type="password" name="pass" id="pass" required="true"  placeholder="Password"/>
        <br/>
        <!--<input class="btn btn-default" type="button" id="Button2" value="注册" onclick="window.location.href='reg'"/>-->
        <input class="btn btn-primary" type="submit" id="Button1" style="width:100%; margin-bottom:10px;" value="Log in" />
        <a href="reg/findmypass.html">Forget your password?</a> </div>
    </form>
  </div>
</div>
<section id="slider">
  <div class="slider-grid">
    <div class="col-md-12 col-sm-12 item"> <img src="assets/images/slider/slider-img.jpg" alt="gallery">
      <div class="text left"> </div>
    </div>
    <div class="col-md-12 col-sm-12 item"> <img src="assets/images/slider/slider-img-1.jpg" alt="gallery">
      <div class="text left">
        <h2 class="wow fadeInRight" data-wow-duration="1s" data-wow-delay="1s">Welcome to<strong>Acadamic Management Platform</strong></h2>
      </div>
    </div>
    <div class="col-md-12 col-sm-12 item"> <img src="assets/images/slider/slider-img-2.jpg" alt="gallery">
      <div class="text left">
        <h2 class="wow fadeInRight" data-wow-duration="1s" data-wow-delay="1s">Welcome to<strong>Acadamic Management Platform</strong></h2>
      </div>
    </div>
    <div class="col-md-12 col-sm-12 item"> <img src="assets/images/slider/slider-img-3.jpg" alt="gallery">
      <div class="text left">
        <h2 class="wow fadeInRight" data-wow-duration="1s" data-wow-delay="1s">Welcome to<strong>Acadamic Management Platform</strong></h2>
      </div>
    </div>
  </div>
</section>
<footer>
  <div class="container">
    <ul class="list-inline social">
      <li class="wow bounceIn" data-wow-duration="0.5s" data-wow-delay="0.5s"><a href="https://www.cool2645.com" target="_blank" title="2645 Studio"><img src="assets/images/social-icons/studio.png" alt="2645 studio"></a></li>
      <li class="wow bounceIn" data-wow-duration="0.6s" data-wow-delay="0.6s"><a href="https://github.com/2645Corp/2645-6" target="_blank" title="Get source code"><img src="assets/images/social-icons/github.png" alt="github"></a></li>
      <li class="wow bounceIn" data-wow-duration="0.7s" data-wow-delay="0.7s"><a href="http://www.whyizhong.net" target="_blank" title="Weihai No.1 High School"><img src="assets/images/social-icons/yizhong.png" alt="Weihai No.1 High School"></a></li>
      <li class="wow bounceIn" data-wow-duration="0.8s" data-wow-delay="0.8s"><a href="http://linux.cool2645.com/2645-6" target="_blank" title="2645-6 Dev site"><img src="assets/images/social-icons/typhoon.png" alt="Experimental site"></a></li>
      <!--<li class="wow bounceIn" data-wow-duration="0.9s" data-wow-delay="0.9s"><a href="#"><img src="assets/images/social-icons/linkedin.png" alt="green flower"></a></li>
      <li class="wow bounceIn" data-wow-duration="1s" data-wow-delay="1s"><a href="#"><img src="assets/images/social-icons/vimeo.png" alt="green flower"></a></li>
      <li class="wow bounceIn" data-wow-duration="1.1s" data-wow-delay="1.1s"><a href="#"><img src="assets/images/social-icons/youtube.png" alt="green flower"></a></li>
      <li class="wow bounceIn" data-wow-duration="1.2s" data-wow-delay="1.2s"><a href="#"><img src="assets/images/social-icons/sharethis.png" alt="green flower"></a></li>-->
    </ul>
  </div>
  <div class="foot-line">
    <p>&copy; 2016 2645 Studio. Designed by <a href="#"><strong><a href="http://www.flashline.cn/" target="_blank">CreativeMonkie</a>.</strong></a> <a href="http://www.miitbeian.gov.cn">鲁ICP备16005737号-2</a></p>
  </div>
</footer>
<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a> 

<!-- Bootstrap core JavaScript
        ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="assets/js/jquery-1.11.2.min.js"></script> 
<!-- bootstrap --> 
<script src="assets/plugins/bootstrap-3.3.1/js/bootstrap.min.js"></script> 

<!-- smooth scrolling --> 
<script src="assets/plugins/smooth-scroll/smooth-scroll.js"></script> 
<!-- isotope --> 
<script src="assets/plugins/isotope/jquery.isotope.min.js"></script> 
<!-- wow --> 
<script src="assets/plugins/wow/wow.min.js"></script> 

<!-- hcaptions --> 
<script src="assets/plugins/hcaptions/jquery.hcaptions.js"></script> 

<!-- prettyPhoto --> 
<script src="assets/plugins/prettyPhoto/jquery.prettyPhoto.js"></script> 

<!-- owl-carousel --> 
<script src="assets/plugins/owl-carousel/owl.carousel.js"></script> 

<!-- animateNumber --> 
<script src="assets/plugins/animateNumber/jquery.appear.js"></script> 
<script src="assets/plugins/animateNumber/jquery.animateNumber.min.js"></script> 

<!-- Form Validation --> 
<script src="assets/plugins/jquery-validate/jquery.validate.min.js"></script> 

<!-- custom --> 
<script src="assets/js/app.js"></script>
</body>
</html>
