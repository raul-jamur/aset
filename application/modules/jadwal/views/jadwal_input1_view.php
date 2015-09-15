<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<form id="form" name="form" method="post" action="<?php echo site_url('jadwal/input/step/2'); ?>">
    <table width="500" border="0" cellpadding="2" cellspacing="0" class="central">
        <tr>
            <td width="250"><label for="gd_id"><b>Pilih Gedung :</b></label></td>
            <td width="250"><label for="ruang_id"><b>Pilih Ruangan :</b></label></td>
        </tr>
        <tr>
            <td>
            	<select name="gd_id" id="gd_id" class="inputan">
                <?php foreach($gedung as $g): ?>
                	<option value="<?=$g->gd_id;?>">Gd. <?=$g->gd_nama;?></option>
                <?php endforeach; ?>
                </select>
            </td>
            <td>
            	<select name="ruang_id" id="ruang_id" class="inputan">
                	<option value="0"> - </option>
                </select>
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
                <!--<input type="button" class="button" value="Kembali" onclick="window.location.href='<?php echo site_url('backpanel'); ?>'" />-->
                <input type="submit" id="submit" value="Lanjut" class="add-button" /> 
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">

	$(document).ready(function(){
		if($("div.flash").length){
			$("div.flash").show().delay(2000).hide(1000);
		}
		
		$("#gd_id").change(function(){
			$("#ruang_id").empty().load("<?php echo site_url("jadwal/listruangan"); ?>/"+ $("#gd_id").val());
		}).change();
		
	});
	
</script>
<?php $this->load->view('panelfooter'); ?>