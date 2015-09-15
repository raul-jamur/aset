<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<form id="userform" name="userform" method="post" action="<?php echo site_url('akun/update'); ?>">
    <table width="400" border="0" cellpadding="2" cellspacing="0" class="central">
        <tr>
            <td width="150"><label for="username">Username</label></td>
            <td width="250"><?=$user[0]->username; ?></td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td><label for="oldpassword">Old Password</label></td>
            <td><input type="password" name="oldpassword" id="oldpassword" class="inputan validate[required,minSize[5],funcCall[checkOldPass]]" /></td>
        </tr>
        <tr>
            <td><label for="password">New Password</label></td>
            <td><input type="password" name="password" id="password" class="inputan validate[required,minSize[5]]" /></td>
        </tr>
        <tr>
            <td><label for="repassword">Retype New Password</label></td>
            <td><input type="password" name="repassword" id="repassword" class="inputan validate[required,equals[password]]" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <?php if($this->session->flashdata('error')):?>
                <div class="notif flash"><div class="error" style="margin:2px 5px;"><?php echo $this->session->flashdata('error');?></div></div>
                <?php endif;?>
                <?php if($this->session->flashdata('success')):?>
                <div class="notif flash"><div class="success" style="margin:2px 5px;"><?php echo $this->session->flashdata('success');?></div></div>
                <?php endif;?>
                <input type="hidden" name="op" id="op" value="" />
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
	
	function checkOldPass(field, rules, i, options){
		var state = '';
    	$.post(
			'<?php echo site_url('akun/checkoldpass'); ?>',
			{op:field.val()},
			function(data){
				if(data == 'wrong'){
					$('#op').attr('value','wrong');
				}else{
					$('#op').attr('value','correct');
				}
			}
		);
		if($('#op').val() == "wrong"){
			return 'Your old password is wrong! new password is not saved.';	
		}
    }
	
</script>
<?php $this->load->view('panelfooter'); ?>