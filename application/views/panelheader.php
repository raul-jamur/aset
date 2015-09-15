<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/message.css" />
<?php if(isset($css)){ echo loadcss($css); } ?>
<?php echo loadcss(array("menu")); ?>
<?php if(isset($js)){ echo loadjs($js); } ?>
</head>

<body>
<div id="titlebar">
	<center><img src="<?php echo base_url(); ?>assets/images/logo1.jpg" height="55" /><span><?=$title; ?></span></center>
</div>
<div id="topbar-admin">
	<a href="<?php echo site_url('backpanel'); ?>" class="home-btn"><img src="<?php echo base_url();?>assets/images/home.png" /></a>

	<?php if(!isset($hidenav) || $hidenav =="0"){ $this->load->view('panelmenu'); } ?>
    
	<a href="<?php echo site_url('auth/logout'); ?>" class="logout-btn">Logout</a>
	<!--<div id="jam"></div><div id="tanggal"></div>-->
    <?php $this->load->view('akunmenu'); ?>
</div>
<div id="wrapper">
	