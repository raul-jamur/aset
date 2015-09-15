<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<form id="userform" name="userform" method="post" action="<?php echo site_url('pengguna/input'); ?>">
    <table width="400" border="0" cellpadding="2" cellspacing="0" class="central">
        <tr>
            <td width="150"><label for="username">Username</label></td>
            <td width="250"><input type="text" name="username" id="username" size="25" maxlength="25" class="inputan2 validate[required,minSize[5],funcCall[checkUser]]" /> </td>
        </tr>
        <tr>
            <td><label for="password">Password</label></td>
            <td><input type="password" name="password" id="password" class="inputan validate[required,minSize[5]]" /></td>
        </tr>
        <tr>
            <td><label for="repassword">Ulangi</label></td>
            <td><input type="password" name="repassword" id="repassword" class="inputan validate[required,equals[password]]" /></td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td><label for="role_id">Role</label></td>
            <td>
                <select name="role_id" id="role_id" class="inputan validate[required]">
                    <?php
                        foreach($role as $r){
                            echo '<option value="'.$r->role_id.'">'.ucwords($r->role_nama).'</option>';
                        } 
                    ?>	
                </select>
            </td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td><label for="nama">Nama</label></td>
            <td><input type="text" name="nama" id="nama" maxlength="40" class="inputan validate[required]" /></td>
        </tr>
        <tr>
            <td><label for="email">Email</label></td>
            <td><input type="text" name="email" id="email" maxlength="50" class="inputan validate[custom[email]]" /></td>
        </tr>
        <tr>
            <td><label for="kontak">Kontak</label></td>
            <td><input type="text" name="kontak" id="kontak" maxlength="14" class="inputan validate[custom[phone]]" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <?php if($this->session->flashdata('error')):?>
                <div class="notif flash"><div class="error" style="margin:2px 5px;"><?php echo $this->session->flashdata('error');?></div></div>
                <?php endif;?>
                <?php if($this->session->flashdata('success')):?>
                <div class="notif flash"><div class="success" style="margin:2px 5px;"><?php echo $this->session->flashdata('success');?></div></div>
                <?php endif;?>
                <input type="hidden" name="uname" id="uname" value="" />
                <input type="submit" id="submit" value="Simpan" class="add-button" /> 
                <input type="button" class="button" value="Kembali" onclick="window.location.href='<?php echo site_url('pengguna'); ?>'" />
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
	
	function checkUser(field, rules, i, options){
		var state = '';
    	$.post(
			'<?php echo site_url('pengguna/check'); ?>',
			{uname:field.val()},
			function(data){
				if(data == 'exist'){
					$('#uname').attr('value','exist');
				}else{
					$('#uname').attr('value','free');
				}
			}
		);
		if($('#uname').val() == "exist"){
			return 'This Username already registered';	
		}
    }
</script>
<?php $this->load->view('panelfooter'); ?>