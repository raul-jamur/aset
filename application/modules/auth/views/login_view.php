<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/login.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/message.css" />
</head>

<body onload="document.getElementById('userlogin').focus();">
	<div class="logo"><div class="nama-sistem"><?=$title;?></div></div>
	<div id="login_box">
    	<div class="login-form">
        	<form name="login-form" action="<?php echo site_url('auth/login'); ?>" method="post">
            <label>Username</label>
            <input type="text" name="userlogin" class="inputan" id="userlogin" />
            <label>Password</label>
            <input type="password" name="userpass" class="inputan" />                       
				<?php if($this->session->flashdata('error')):?>
                <div class="notif"><div class="error" style="margin:2px 5px;"><?php echo $this->session->flashdata('error');?></div></div>
                <?php endif;?>
                <?php if($this->session->flashdata('info')):?>
                <div class="notif"><div class="info" style="margin:2px 5px;"><?php echo $this->session->flashdata('info');?></div></div>
                <?php endif;?>
            <input type="submit" value="Login" class="button" />
            </form>
        </div>
    </div>
	<div id="home-btn"><a href="<?php echo site_url("home"); ?>">Front End</a></div>
</body>
</html>