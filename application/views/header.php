<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/message.css" />
<?php if(isset($css)){ echo loadcss($css); } ?>
<?php if(isset($js)){ echo loadjs($js); } ?>
</head>

<body>
<div id="titlebar2">
	<center><img src="<?php echo base_url(); ?>assets/images/logo.gif" height="65" /><span><?=$title; ?></span></center>
</div>
<div id="topbar">
	<a href="<?php echo site_url('home'); ?>/" class="home-btn"><img src="<?php echo base_url();?>assets/images/home.png" /></a>
    <?php if(isset($breadcrumb)){ echo "<div class='breadcrumb'>".$breadcrumb."</div>"; } ?>
    <div id="jam"></div><div id="tanggal"></div>
</div>
<div id="wrapper">
	