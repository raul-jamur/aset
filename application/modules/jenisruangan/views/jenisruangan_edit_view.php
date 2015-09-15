<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<form id="form" name="form" method="post" action="<?php echo site_url('jenisruangan/mod'); ?>">
    <input type="hidden" name="oper" value="edit" />
    <input type="hidden" name="id" value="<?=$id; ?>" />
    <table width="400" border="0" cellpadding="2" cellspacing="0" class="central">
        <tr>
            <td><label for="jenisruang_nama">Jenis Ruang</label></td>
            <td><input type="text" name="jenisruang_nama" id="jenisruang_nama" maxlength="25" class="inputan validate[required]" value="<?=$jenisruangan[0]->jenisruang_nama; ?>"/></td>
        </tr>
        <tr>
            <td><label for="jenisruang_jadwal">Menggunakan Jadwal</label></td>
            <td>
            <?php
            if($jenisruangan[0]->jenisruang_jadwal == 1){
				$j1 = 'checked="checked"';
				$j2 = '';
			}else{
				$j2 = 'checked="checked"';
				$j1 = '';
			}
			?>
            <input type="radio" name="jenisruang_jadwal" id="jenisruang_jadwal1" value="1" class="validate[required]" <?=$j1;?> /> Ya<br />
            <input type="radio" name="jenisruang_jadwal" id="jenisruang_jadwal2" value="0" class="validate[required]" <?=$j2;?> /> Tidak
            </td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td colspan="2" align="center">
                <?php if($this->session->flashdata('error')):?>
                <div class="notif flash"><div class="error" style="margin:2px 5px;"><?php echo $this->session->flashdata('error');?></div></div>
                <?php endif;?>
                <?php if($this->session->flashdata('success')):?>
                <div class="notif flash"><div class="success" style="margin:2px 5px;"><?php echo $this->session->flashdata('success');?></div></div>
                <?php endif;?>
                <input type="submit" id="submit" value="Simpan" class="add-button" /> 
                <input type="button" class="button" value="Kembali" onclick="window.location.href='<?php echo site_url('jenisruangan'); ?>'" />
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