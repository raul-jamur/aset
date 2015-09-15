<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<form id="form" name="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('ruangan/input'); ?>">
    <table width="500" border="0" cellpadding="2" cellspacing="0" class="central">
        <tr>
            <td><label for="ruang_nama">Nama Ruangan</label></td>
            <td><input type="text" name="ruang_nama" id="ruang_nama" maxlength="50" class="inputan validate[required]" /></td>
        </tr>
        <tr>
            <td><label for="jenisruangan_id">Jenis Ruangan</label></td>
            <td>
            	<select name="jenisruang_id" id="jenisruang_id" class="inputan2">
                <?php foreach($jenisruangan as $j): ?>
                	<option value="<?=$j->jenisruang_id;?>"><?=$j->jenisruang_nama;?></option>
                <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="ruang_luas">Luas</label></td>
            <td><input type="text" name="ruang_luas" id="ruang_luas" size="4" maxlength="4" class="inputan2 validate[custom[integer],min[0]]" /> <?=$s_luas;?></td>
        </tr>
        <tr>
            <td><label for="ruang_lokasi">Lokasi</label></td>
            <td>
            	<select name="gd_id" id="gd_id" class="inputan2">
                <?php foreach($gedung as $g): ?>
                	<option value="<?=$g->gd_id;?>"><?=$g->gd_nama;?></option>
                <?php endforeach; ?>
                </select>
                &nbsp;&nbsp;Lantai&nbsp;&nbsp;
                <select name="gd_lantai" id="gd_lantai" class="inputan2">
                	<option value="0"> - </option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="ruang_foto">Foto</label></td>
            <td><input type="file" name="ruang_foto" id="ruang_foto" class="inputan" /></td>
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
                <input type="button" class="button" value="Kembali" onclick="window.location.href='<?php echo site_url('ruangan'); ?>'" />
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
		
		$("#gd_id").change(function(){
			$("#gd_lantai").empty().load("<?php echo site_url("ruangan/gdlantai"); ?>/"+ $("#gd_id").val());
		}).change();
		
		$("#ruang_foto").change(function(){
			var value = $(this).val();
			if(value){
				var val = value.split(".");
				var ext = val[val.length - 1];
				//alert(ext);
				if( ext == "gif" || ext == "jpg" || ext == "png" || ext == "jpeg" ){
					$("#submit").removeAttr("disabled");
					jQuery('#ruang_foto').validationEngine('hide');
				}else{
					$("#submit").attr("disabled","disabled");
					jQuery('#ruang_foto').validationEngine('showPrompt', 'Browse only file with .gif/.jpg/.png/.jpeg extension');
				}
			}else{
				$("#submit").removeAttr("disabled");
				jQuery('#ruang_foto').validationEngine('hide');
			}
			
		});
	});
	
</script>
<?php $this->load->view('panelfooter'); ?>