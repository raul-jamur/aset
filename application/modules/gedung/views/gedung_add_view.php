<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<form id="form" name="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('gedung/input'); ?>">
    <table width="500" border="0" cellpadding="2" cellspacing="0" class="central">
        <tr>
            <td><label for="gd_nama">Nama Gedung</label></td>
            <td><input type="text" name="gd_nama" id="gd_nama" class="inputan validate[required]" /></td>
        </tr>
        <tr>
            <td><label for="gd_luas">Luas</label></td>
            <td><input type="text" name="gd_luas" id="gd_luas" size="4" maxlength="4" class="inputan2 validate[custom[integer],min[0]]" /> <?=$s_luas;?></td>
        </tr>
        <tr>
            <td><label for="gd_lantai">Jumlah Lantai</label></td>
            <td><input type="text" name="gd_lantai" id="gd_lantai" size="3" maxlength="3" class="inputan2 validate[required,custom[integer],min[1]]" /> <?=$s_lantai;?></td>
        </tr>
        <?php if($fasilitas): ?>
        <tr valign="top">
            <td><label for="gd_fasilitas">Fasilitas</label></td>
            <td>
            	<?php foreach($fasilitas as $f): ?>
            	<input type="checkbox" name="gd_fasilitas[]" value="<?=$f->fasilitas_id; ?>" class="" /> <?=$f->fasilitas_nama; ?> <br />
                <?php endforeach; ?>
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <td><label for="gd_foto">Foto</label></td>
            <td><input type="file" name="gd_foto" id="gd_foto" class="inputan" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
            	<em>&diams; Ukuran file maksimal : 200 KB.</em><br />
                <em>&diams; Ukuran lebar & panjang maksimal gambar : 400 pixel.</em>
            </td>
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
                <input type="button" class="button" value="Kembali" onclick="window.location.href='<?php echo site_url('gedung'); ?>'" />
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
		
		$("#gd_foto").change(function(){
			var value = $(this).val();
			if(value){
				var val = value.split(".");
				var ext = val[val.length - 1];
				//alert(ext);
				if( ext == "gif" || ext == "jpg" || ext == "png" || ext == "jpeg" ){
					$("#submit").removeAttr("disabled");
					jQuery('#gd_foto').validationEngine('hide');
				}else{
					$("#submit").attr("disabled","disabled");
					jQuery('#gd_foto').validationEngine('showPrompt', 'Browse only file with .gif/.jpg/.png/.jpeg extension');
				}
			}else{
				$("#submit").removeAttr("disabled");
				jQuery('#gd_foto').validationEngine('hide');
			}
			
		});
	});
	
</script>
<?php $this->load->view('panelfooter'); ?>