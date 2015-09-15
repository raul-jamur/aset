<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<form id="form" name="form" method="post" action="<?php echo site_url('fasilitas/input'); ?>">
    <table width="400" border="0" cellpadding="2" cellspacing="0" class="central">
        <tr>
            <td><label for="fasilitas_nama">Fasilitas</label></td>
            <td><input type="text" name="fasilitas_nama" id="fasilitas_nama" maxlength="50" class="inputan validate[required]" /></td>
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
                <input type="button" class="button" value="Kembali" onclick="window.location.href='<?php echo site_url('fasilitas'); ?>'" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$("#form").validationEngine('attach');
		if($("div.flash").length){
			$("div.flash").show().delay(2000).hide(1000);
		}
	});
	
</script>
<?php $this->load->view('panelfooter'); ?>