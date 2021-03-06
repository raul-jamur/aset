<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<form id="userform" name="userform" method="post" action="<?php echo site_url('akun/updateprofil'); ?>">
    <table width="400" border="0" cellpadding="2" cellspacing="0" class="central">
        <tr>
            <td width="150"><label for="username">Username</label></td>
            <td width="250"><?=$user[0]->username; ?></td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td><label for="nama">Nama</label></td>
            <td><input type="text" name="nama" id="nama" class="inputan validate[required]" value="<?=$user[0]->nama; ?>"/></td>
        </tr>
        <tr>
            <td><label for="email">Email</label></td>
            <td><input type="text" name="email" id="email" class="inputan validate[custom[email]]" value="<?=$user[0]->email; ?>" /></td>
        </tr>
        <tr>
            <td><label for="kontak">Kontak</label></td>
            <td><input type="text" name="kontak" id="kontak" class="inputan validate[custom[phone]]" value="<?=$user[0]->kontak; ?>" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <?php if($this->session->flashdata('error')):?>
                <div class="notif flash"><div class="error" style="margin:2px 5px;"><?php echo $this->session->flashdata('error');?></div></div>
                <?php endif;?>
                <?php if($this->session->flashdata('success')):?>
                <div class="notif flash"><div class="success" style="margin:2px 5px;"><?php echo $this->session->flashdata('success');?></div></div>
                <?php endif;?>
                <input type="submit" id="submit" value="Simpan" class="add-button" /> 
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">

	$(document).ready(function(){
		$("#userform").validationEngine('attach');
		if($("div.flash").length){
			$("div.flash").show().delay(2000).hide(1000);
		}
	});
	
</script>
<?php $this->load->view('panelfooter'); ?>