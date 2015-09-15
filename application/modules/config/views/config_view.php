<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MPS Track &amp; Trace System :: <?=$title; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/message.css" />
</head>

<body>
<?php $this->load->view('topbar_view'); ?>
<div id="wrapper">
	<p class="title"><?=$title; ?></p>
    <p class="breadcrumb"><?=$url; ?><?=$title; ?></p>
   	<div id="content">
    	<?php if($content): ?>
        <?php if($this->session->flashdata('error')):?>
        <div class="notif"><div class="error" style="margin:2px 5px;"><?php echo $this->session->flashdata('error');?></div></div><br/>
        <?php endif;?>
        <?php if($this->session->flashdata('success')):?>
        <div class="notif"><div class="success" style="margin:2px 5px;"><?php echo $this->session->flashdata('success');?></div></div><br/>
        <?php endif;?>
        <form name="configuration" method="post" action="<?php echo site_url('config/save'); ?>">
			<table cellspacing="0" cellpadding="2" border="1" class="tabel central">
            	<thead><td>Function</td><td>Administrator</td><td>User</td></thead>
                <?php
                	foreach($content as $row){
						echo "<tr>";
						echo "<td width='200'><span title='".$row->description."'>".$row->function_name."</span></td>";
						$admin_val = '';
						$user_val = '';
						if($row->administrator == 1){ $admin_val = "checked='true'"; }
						if($row->user == 1){ $user_val = "checked='true'"; }
						echo "<td align='center' width='100'><input type='checkbox' value='1' name='admin-".$row->id."' ".$admin_val." title='".$row->function_name."' /></td>";
						echo "<td align='center' width='100'><input type='checkbox' value='1' name='user-".$row->id."' ".$user_val." title='".$row->function_name."' /></td>";
						echo "</tr>";
					}
				?>
            </table><br />
            <center><input type="submit" value="Save" class="button central"/></center>
        </form>
		<?php endif; ?>
    </div>
    <p class="footer">Copyright &copy; 2012. MPS Track &amp; Trace System</p>
</div>
</body>
</html>
