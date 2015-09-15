<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<form id="form" name="form" method="post" action="<?php echo site_url('preferensi/simpan'); ?>">
    <table width="500" border="0" cellpadding="2" cellspacing="0" class="central">
        <tr>
            <td><label for="nama_sistem">Nama Sistem</label></td>
            <td><input type="text" name="nama_sistem" id="nama_sistem" class="inputan validate[required]" value="<?=$preferensi[0]->nama_sistem; ?>"/></td>
        </tr>
        <tr>
            <td><label for="footer_text">Teks Footer</label></td>
            <td><input type="text" name="footer_text" id="footer_text" class="inputan validate[required]" value="<?=$preferensi[0]->footer_text; ?>"/></td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td><label for="sess_exp">Masa aktif sesi login</label></td>
            <td><input type="text" name="sess_exp" id="sess_exp" size="6" maxlength="6" class="inputan2 validate[required,custom[integer],min[0]]" value="<?=$preferensi[0]->sess_exp; ?>"/> Jam</td>
        </tr>
        <tr><td></td><td><em>* Isi dengan 0 jika ingin sesi login tidak pernah habis.</em></td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td><label for="scroll_generate">Waktu otomatis <em>generate<br />scroll</em> Jadwal</label></td>
            <td><input type="text" name="scroll_generate" size="4" id="scroll_generate" maxlength="4" class="inputan2 validate[required,custom[integer],min[0]]" value="<?=$preferensi[0]->scroll_generate; ?>"/> Menit</td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <?php
        $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
		?>
        <tr>
            <td><label for="smt_ganjil">Semester Ganjil</label></td>
            <td>
            	<select name="smt_ganjil_start" id="smt_ganjil_start" class="inputan2">
                <?php
                	for($i=1;$i<sizeof($bulan);$i++){
						$x = $preferensi[0]->smt_ganjil_start;
						if($i == $x){
							$s='selected="true"';
						}else{
							$s='';
						}
						echo '<option value="'.$i.'" '.$s.'>'.$bulan[$i].'</option>';
						echo "\n";
					}
				?>
                </select>
                sampai
                <select name="smt_ganjil_end" id="smt_ganjil_end" class="inputan2">
                <?php
                	for($i=1;$i<sizeof($bulan);$i++){
						$x = $preferensi[0]->smt_ganjil_end;
						if($i == $x){
							$s='selected="true"';
						}else{
							$s='';
						}
						echo '<option value="'.$i.'" '.$s.'>'.$bulan[$i].'</option>';
						echo "\n";
					}
				?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="smt_genap">Semester Genap</label></td>
            <td>
            	<select name="smt_genap_start" id="smt_genap_start" class="inputan2">
                <?php
                	for($i=1;$i<sizeof($bulan);$i++){
						$x = $preferensi[0]->smt_genap_start;
						if($i == $x){
							$s='selected="true"';
						}else{
							$s='';
						}
						echo '<option value="'.$i.'" '.$s.'>'.$bulan[$i].'</option>';
						echo "\n";
					}
				?>
                </select>
                sampai
                <select name="smt_genap_end" id="smt_genap_end" class="inputan2">
                <?php
                	for($i=1;$i<sizeof($bulan);$i++){
						$x = $preferensi[0]->smt_genap_end;
						if($i == $x){
							$s='selected="true"';
						}else{
							$s='';
						}
						echo '<option value="'.$i.'" '.$s.'>'.$bulan[$i].'</option>';
						echo "\n";
					}
				?>
                </select>
            </td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td><label for="satuan_luas">Satuan Luas</label></td>
            <td><input type="text" name="satuan_luas" id="satuan_luas" size="10" maxlength="10" class="inputan2 validate[required]" value="<?=$preferensi[0]->satuan_luas; ?>"/></td>
        </tr>
        <tr>
            <td><label for="satuan_lantai">Satuan Lantai</label></td>
            <td><input type="text" name="satuan_lantai" id="satuan_lantai" size="10" maxlength="10" class="inputan2 validate[required]" value="<?=$preferensi[0]->satuan_lantai; ?>"/></td>
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
		
		$("#smt_ganjil_end").change(function(){
			//alert($(this).val() +" - "+ $("#smt_genap_start").val());
			if( parseInt($(this).val()) >= parseInt($("#smt_genap_start").val()) ){
				$("#smt_genap_start > option").each(function(){
					$(this).removeAttr("selected");
				});
				var v = parseInt($(this).val());
				if(v > 12){
					$("#smt_genap_start > option:eq(1)").attr("selected", "true");
				}else{
					$("#smt_genap_start > option:eq("+ v +")").attr("selected", "true");
				}
			}
		}).change();
		
		$("#smt_genap_end").change(function(){
			//alert($(this).val() +" - "+ $("#smt_ganjil_start").val());
			if( parseInt($(this).val()) >= parseInt($("#smt_ganjil_start").val()) ){
				$("#smt_ganjil_start > option").each(function(){
					$(this).removeAttr("selected");
				});
				var v = parseInt($(this).val());
				if(v > 12){
					$("#smt_ganjil_start > option:eq(1)").attr("selected", "true");
				}else{
					$("#smt_ganjil_start > option:eq("+ v +")").attr("selected", "true");
				}
			}
		}).change();
	});
	
</script>
<?php $this->load->view('panelfooter'); ?>