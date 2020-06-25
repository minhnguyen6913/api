<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" />
<title><?php echo ERR_PROJECT ?></title>
<meta name="description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<!-- bootstrap & fontawesome -->
<link rel="stylesheet" href="<?php echo ERR_LINK_ASSETS ?>css/bootstrap.min.css" />
<link rel="stylesheet" href="/assets/fonts/font-awesome.css" />
<!-- text fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<!-- TuanLM: chosen style -->
<link rel="stylesheet" href="<?php echo ERR_LINK_ASSETS ?>css/chosen.min.css" />
<!-- TuanLM: JQuery UI style -->
<link rel="stylesheet" href="<?php echo ERR_LINK_ASSETS ?>css/jquery-ui.min.css" />
<!-- ace styles -->
<link rel="stylesheet" href="<?php echo ERR_LINK_ASSETS ?>css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
<!--[if lte IE 9]>
<link rel="stylesheet" href="<?php echo ERR_LINK_ASSETS ?>css/ace-part2.min.css" class="ace-main-stylesheet" />
<![endif]-->
<link rel="stylesheet" href="<?php echo ERR_LINK_ASSETS ?>css/ace-skins.min.css" />
<link rel="stylesheet" href="<?php echo ERR_LINK_ASSETS ?>css/ace-rtl.min.css" />
<!--[if lte IE 9]>
<link rel="stylesheet" href="<?php echo ERR_LINK_ASSETS ?>css/ace-ie.min.css" />
<![endif]-->
<!-- inline styles related to this page -->
<!-- ace settings handler -->
<script src="<?php echo ERR_LINK_ASSETS ?>js/ace-extra.min.js"></script>
<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
<!--[if lte IE 8]>
<script src="<?php echo ERR_LINK_ASSETS ?>js/html5shiv.min.js"></script>
<script src="<?php echo ERR_LINK_ASSETS ?>js/respond.min.js"></script>
<![endif]-->
</head>
<body class="no-skin">
<!--Header-->
<div id="navbar" class="navbar navbar-default ace-save-state">
<div class="navbar-container ace-save-state" id="navbar-container">
<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
<span class="sr-only">Toggle sidebar</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<div class="navbar-header pull-left"><a href="#" class="navbar-brand"><small><i class="fa fa-leaf"></i> <?php echo ERR_PROJECT ?></small></a></div>
<div class="navbar-buttons navbar-header pull-right" role="navigation">
<ul class="nav ace-nav">
<!--Profile-->
<li class="light-blue dropdown-modal">
<a data-toggle="dropdown" href="#" class="dropdown-toggle">
<img class="nav-user-photo" src="<?php echo ERR_LINK_ASSETS ?>images/avatars/user.jpg" alt="Jason's Photo" />
<span class="user-info">
<small>Welcome,</small>
<?php echo $_SESSION['ssAdminFullname'] ?>
</span>

<i class="ace-icon fa fa-caret-down"></i>
</a>

<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
<li>
<a href="<?php echo ERR_LINK_SITE ?>admin/profile">
<i class="ace-icon fa fa-user"></i>
Profile
</a>
</li>
<li class="divider"></li>
<li>
<a href="<?php echo ERR_LINK_SITE ?>admin/profile/logout">
<i class="ace-icon fa fa-power-off"></i>
Logout
</a>
</li>
</ul>
</li>
<!--/Profile-->
</ul>
</div>
</div>
</div>
<!--/Header-->
<div class="main-container ace-save-state" id="main-container">
<!--Body-->
<div class="main-content">
<div class="main-content-inner">
<div class="page-content">
<div class="row">
<div class="col-xs-12">
<!-- PAGE CONTENT BEGINS -->
<div class="error-container">
<div class="well">
<h1 class="grey lighter smaller">
<span class="blue bigger-125">
<i class="ace-icon fa fa-random"></i>
</span>
<?php echo $heading; ?>
</h1>

<div class="space"></div>

<div>
<h4 class="lighter smaller red"><?php echo $message; ?></h4>

<ul class="list-unstyled spaced inline bigger-110 margin-15">
<li>
<i class="ace-icon fa fa-hand-o-right blue"></i>
Read the faq
</li>

<li>
<i class="ace-icon fa fa-hand-o-right blue"></i>
Give us more info on how this specific error occurred!
</li>
</ul>
</div>

<hr />
<div class="space"></div>

<div class="center">
<a href="javascript:history.back()" class="btn btn-grey">
<i class="ace-icon fa fa-arrow-left"></i>
Go Back
</a>
</div>
</div>
</div>
<!-- PAGE CONTENT ENDS -->
</div>
</div>
</div>
</div>
</div>
<!--/Body-->
<!--Footer-->
<div class="footer">
<div class="footer-inner">
<div class="footer-content">
<span class="bigger-120"><span class="blue bolder"><?php echo ERR_PROJECT ?></span> &copy; 2018</span>
&nbsp; &nbsp;
<span class="action-buttons">
<a href="#"><i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i></a>
<a href="#"><i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i></a>
<a href="#"><i class="ace-icon fa fa-rss-square orange bigger-150"></i></a>
</span>
</div>
</div>
</div>
<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"><i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i></a>
<!--/Footer-->
</div>

<!-- basic scripts -->
<!--[if !IE]> -->
<script src="<?php echo ERR_LINK_ASSETS ?>js/jquery-2.1.4.min.js"></script>
<!-- <![endif]-->
<!--[if IE]>
    <script src="<?php echo ERR_LINK_ASSETS ?>js/jquery-1.11.3.min.js"></script>
<![endif]-->
<script type="text/javascript">
    if ('ontouchstart' in document.documentElement) document.write("<script src='<?php echo ERR_LINK_ASSETS ?>js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="<?php echo ERR_LINK_ASSETS ?>js/bootstrap.min.js"></script>
<!-- ace scripts -->
<script src="<?php echo ERR_LINK_ASSETS ?>js/ace-elements.min.js"></script>
<script src="<?php echo ERR_LINK_ASSETS ?>js/ace.min.js"></script>
<!-- inline scripts related to this page -->
</body>
</html>