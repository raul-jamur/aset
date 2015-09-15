<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<form id="userform" name="userform" method="post" action="<?php echo site_url('pengguna/mod'); ?>">
    <input type="hidden" name="oper" value="edit" />
    <input type="hidden" name="id" value="<?=$id; ?>" />
    <table width="400" border="0" cellpadding="2" cellspacing="0" class="central">
        <tr>
            <td width="150"><label for="username">Username</label></td>
            <td width="250"><?=$user[0]->username; ?></td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2"><div class="notif"><div class="info" style="margin:2px 5px;"><em>Diisi hanya jika password hendak diubah.</em></div></div></td></tr>
        <tr>
            <td><label for="password">Password Baru</label></td>
            <td><input type="password" name="password" id="password" class="inputan validate[minSize[5]]" /></td>
        </tr>
        <tr>
            <td><label for="repassword">Ulangi</label></td>
            <td><input type="password" name="repassword" id="repassword" class="inputan validate[equals[password]]" /></td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td><label for="role_id">Role</label></td>
            <td>
                <select name="role_id" id="role_id" class="inputan validate[required]">
                    <?php
                        foreach($role as $r){
                            if($r->role_id == $user[0]->role_id){
                                $roleval = ' selected="true" ';
                            }else{
                                $roleval = '';	
                            }
                            echo '<option value="'. $r->role_id .'"'. $roleval .'>'. ucwords($r->role_nama) .'</option>';
                        } 
                    ?>	
                </select>
            </td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td><label for="name">Nama</label></td>
            <td><input type="text" name="nama" id="nama" maxlength="40" class="inputan validate[required]" value="<?=$user[0]->nama; ?>"/></td>
        </tr>
        <tr>
            <td><label for="email">Email</label></td>
            <td><input type="text" name="email" id="email" maxlength="50" class="inputan validate[custom[email]]" value="<?=$user[0]->email; ?>" /></td>
        </tr>
        <tr>
            <td><label for="kontak">Kontak</label></td>
            <td><input type="text" name="kontak" id="kontak" maxlength="14" class="inputan validate[custom[phone]]" value="<?=$user[0]->kontak; ?>" /></td>
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
	
</script>
<?php $this->load->view('panelfooter'); ?>