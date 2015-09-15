<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<?php if($ruangan): ?>
<?php foreach($ruangan as $row): ?>
<table border="0" cellpadding="5" cellspacing="0" width="100%">
    <tr valign="top">
    <?php
    if($row->ruang_foto){
		$img = base_url("assets/gambar")."/".$row->ruang_foto;
	}else{
		$img = base_url("assets/gambar")."/ruangan_default.jpg";
	}
	?>
        <td width="100" rowspan="5"><img src="<?=$img; ?>" height="100" width="100" /></td>
        <td width="100" height="20">Peruntukan</td>
        <td width="5">:</td>
        <td><?=$row->jenisruang_nama;?></td>
    </tr>
    <tr valign="top">
        <td height="20">Luas</td>
        <td>:</td>
        <?php if($row->ruang_luas): ?>
        <td><?=$row->ruang_luas;?> <?=$s_luas;?></td>
        <?php else: ?>
        <td>-</td>
        <?php endif; ?>
    </tr>
    <tr valign="top">
        <td>Lokasi</td>
        <td>:</td>
        <td>Gd. <?=$gedung[0]->gd_nama;?>  Lt. <?=$row->gd_lantai;?></td>
    </tr>
</table>
<div class="textblock">
<form id="form" name="form" method="post" action="<?php echo site_url('jadwal/update'); ?>">
	<input type="hidden" name="jadwal_id" value="<?=$jadwal[0]->jadwal_id;?>" />
    <input type="hidden" name="ruang_id" value="<?=$row->ruang_id;?>" />
    <table width="500" cellpadding="2" cellspacing="0" border="0" class="central">
    	<tr>
        	<td><b>Kegiatan</b></td>
            <td>:</td>
            <td><input type="text" name="jadwal_acara" value="<?=$jadwal[0]->jadwal_acara;?>" id="jadwal_acara" class="inputan validate[required]" /></td>
        </tr>
        <tr>
  			<td width="100"><b>Rutin tiap minggu</b></td>
            <td width="5">:</td>
            <td>
            	<?php
                	if($jadwal[0]->jadwal_rutin){
						$s0 = '';
						$s1 = 'selected="true"';
					}else{
						$s0 = 'selected="true"';
						$s1 = '';
					}
				?>
            	<select id="jadwal_rutin" name="jadwal_rutin" class="inputan2">
                	<option value="1" <?=$s1;?> >Ya</option>
                    <option value="0" <?=$s0;?> >Tidak</option>
                </select>
            </td>
        </tr>
    </table>
    <table width="500" cellpadding="2" cellspacing="0" border="0" id="tidakrutin" class="central">
    	<tr>
        	<td width="100">Mulai</td>
            <td width="5">:</td>
            <td>
            <?php
            	if($jadwal[0]->jadwal_mulai != NULL || $jadwal[0]->jadwal_mulai != ''){
					$jm = explode(" ", $jadwal[0]->jadwal_mulai);
					$tm = explode("-", $jm[0]);
					$jadwal_mulai = $tm[2].'-'.$tm[1].'-'.$tm[0].' jam '.substr($jm[1],0,5);
				}else{
					$jadwal_mulai = '';
				}
			?>
            	<input type="text" id="jadwal_mulai" value="<?=$jadwal_mulai;?>" name="jadwal_mulai" class="inputan" />
            </td>
            <td width="100"></td>
        </tr>
        <tr>          
        	<td width="100">Selesai</td>
            <td width="5">:</td>
            <td>
            <?php
            	if($jadwal[0]->jadwal_selesai != NULL || $jadwal[0]->jadwal_selesai != ''){
					$js = explode(" ", $jadwal[0]->jadwal_selesai);
					$ts = explode("-", $js[0]);
					$jadwal_selesai = $ts[2].'-'.$ts[1].'-'.$ts[0].' jam '.substr($js[1],0,5);
				}else{
					$jadwal_selesai = '';
				}
			?>
            	<input type="text" id="jadwal_selesai" value="<?=$jadwal_selesai;?>" name="jadwal_selesai" class="inputan" />
            </td> 
            <td width="100"></td>         
        </tr>
    </table>
    <table width="500" cellpadding="2" cellspacing="0" border="0" id="rutin" class="central">
        <tr>
  			<td width="100">Hari</td>
            <td width="5">:</td>
            <td>
            <?php
            	$hari = array("","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
			?>
            	<select name="jadwal_hari" id="jadwal_hari" class="inputan2">
             	<?php
				for($i=1;$i<sizeof($hari);$i++){
					if($jadwal[0]->jadwal_hari == $i){
						$s = 'selected="true"';
					}else{
						$s = '';
					}
					echo '<option value="'. $i .'" '.$s.'>'. $hari[$i] .'</option>',"\n";
				}
				?>
                    <option value="0" disabled="disabled">Minggu</option>
                 </select>
            </td>
        </tr>
        <tr>
            <td>Waktu</td>
            <td>:</td>
            <td>
            	<input type="text" id="t3" name="jam_mulai" value="<?=substr($jadwal[0]->jam_mulai,0,5);?>" class="inputan2" onchange="cekWaktu('mulai')" />
                &nbsp;&nbsp;&nbsp;sampai :&nbsp;
                <input type="text" id="t4" name="jam_selesai" value="<?=substr($jadwal[0]->jam_selesai,0,5);?>" class="inputan2" onchange="cekWaktu('selesai')" />
            </td>          
        </tr>
        <tr>
            <td>Semester</td>
            <td>:</td>
            <td>
            	<?php
                	if($jadwal[0]->jadwal_smt == "1"){
						$s2 = '';
						$s1 = 'selected="true"';
					}elseif($jadwal[0]->jadwal_smt == "2"){
						$s2 = 'selected="true"';
						$s1 = '';
					}else{
						$s2 = ''; $s1 = '';
					}
				?>
            	<select name="jadwal_smt" id="jadwal_smt" class="inputan2">
                	<option value="1" <?=$s1;?>>Ganjil</option>
                    <option value="2" <?=$s2;?>>Genap</option>
                </select>
                &nbsp;&nbsp;&nbsp;Tahun Akademik :&nbsp;
                <!--<input type="text" id="jadwal_tahun" name="jadwal_tahun" value="<?=$jadwal[0]->jadwal_tahun;?>" class="inputan2 validate[custom[integer],min[<?=date("Y");?>]]"/>-->
                <select name="jadwal_tahun" id="jadwal_tahun" class="inputan2">
                <?php
					$taun = date("Y");
					if($taun == $jadwal[0]->jadwal_tahun){
						$t1 = ''; $t2 = 'selected="selected"';
					}else{
						$t2 = ''; $t1 = 'selected="selected"';
					}
				?>
                	<option value="<?php echo $taun-1; ?>" <?=$t1?>><?php echo $taun-1 ."/". $taun; ?></option>
                    <option value="<?php echo $taun; ?>" <?=$t2?>><?php echo $taun."/"; echo $taun+1; ?></option>
                </select>
            </td>          
        </tr>
    </table>
    <table width="500" cellpadding="2" cellspacing="0" border="0" class="central">
    	<tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td colspan="2" align="center">
                <?php if($this->session->flashdata('error')):?>
                <div class="notif flash"><div class="error" style="margin:2px 5px;"><?php echo $this->session->flashdata('error');?></div></div>
                <?php endif;?>
                <?php if($this->session->flashdata('success')):?>
                <div class="notif flash"><div class="success" style="margin:2px 5px;"><?php echo $this->session->flashdata('success');?></div></div>
                <?php endif;?>
                <input type="button" class="button" value="Kembali" onclick="history.go(-1)" />
                <input type="submit" id="submit" value="Simpan" class="add-button" /> 
            </td>
        </tr>
    </table>
</form>
<input type="hidden" id="status-jam" value="1" />
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="notif"><div class="error">Data tidak ditemukan</div></div>
<? endif; ?>
<script type="text/javascript">
	$(function() {
		$('#jadwal_mulai').datetimepicker({
			dateFormat: "d-m-yy",
			timeFormat: "HH:mm",
			stepMinute: 15,
			separator: " jam ",
			onClose: function(dateText, inst) {
				var endDateTextBox = $('#jadwal_selesai');
				if (endDateTextBox.val() != '') {
					//var testStartDate = new Date(dateText);
					//var testEndDate = new Date(endDateTextBox.val());
					var testStartDate = $('#jadwal_mulai').datetimepicker('getDate').valueOf();
					var testEndDate = $('#jadwal_selesai').datetimepicker('getDate').valueOf();
					if (testStartDate > testEndDate)
						endDateTextBox.val(dateText);
				}
				else {
					endDateTextBox.val(dateText);
				}
				//alert($('#jadwal_mulai').datetimepicker('getDate').valueOf());
			},
			onSelect: function (selectedDateTime){
				var start = $(this).datetimepicker('getDate');
				$('#jadwal_selesai').datetimepicker('option', 'minDate', new Date(start.getTime()));
			}
		});
		$('#jadwal_selesai').datetimepicker({
			dateFormat: "d-m-yy",
			timeFormat: "HH:mm",
			stepMinute: 15,
			separator: " jam ",
			onClose: function(dateText, inst) {
				var startDateTextBox = $('#jadwal_mulai');
				if (startDateTextBox.val() != '') {
					//var testStartDate = new Date(startDateTextBox.val());
					//var testEndDate = new Date(dateText);
					var testStartDate = $('#jadwal_mulai').datetimepicker('getDate').valueOf();
					var testEndDate = $('#jadwal_selesai').datetimepicker('getDate').valueOf();
					if (testStartDate > testEndDate)
						startDateTextBox.val(dateText);
				}
				else {
					startDateTextBox.val(dateText);
				}
			},
			onSelect: function (selectedDateTime){
				var end = $(this).datetimepicker('getDate');
				$('#jadwal_mulai').datetimepicker('option', 'maxDate', new Date(end.getTime()) );
			}
		});
		
		$('#t3').datetimepicker({
			stepMinute: 15,
			timeOnly: true,
			/*onClose: function(dateText, inst) {
				$('#t3').datetimepicker('setDate','01/01/1970 : '+$('#t3').val());
				var endDateTextBox = $('#t4');
				if (endDateTextBox.val() != null) {

					var testStartDate = $('#t3').datetimepicker('getDate').valueOf();
					var testEndDate = $('#t4').datetimepicker('getDate').valueOf();
					if (testStartDate > testEndDate){
						endDateTextBox.val(dateText);
					}
				}
				else {
					endDateTextBox.val(dateText);
				}
			},
			onSelect: function (selectedDateTime){
				$('#t3').datetimepicker('setDate','01/01/1970 : '+$('#t3').val());
				var start = $(this).datetimepicker('getDate');
				$('#t4').datetimepicker('option', 'minDate', new Date(start.getTime()));
			}*/
		});
		$('#t4').datetimepicker({
			stepMinute: 15,
			timeOnly: true,
			/*onClose: function(dateText, inst) {
				$('#t4').datetimepicker('setDate','01/01/1970 : '+$('#t3').val());
				var startDateTextBox = $('#t3');
				if (startDateTextBox.val() != null) {

					var testStartDate = $('#t3').datetimepicker('getDate').valueOf();
					var testEndDate = $('#t4').datetimepicker('getDate').valueOf();
					if (testEndDate < testStartDate){
						startDateTextBox.val(dateText);
					}
				}
				else {
					startDateTextBox.val(dateText);
				}
			},
			onSelect: function (selectedDateTime){
				$('#t4').datetimepicker('setDate','01/01/1970 : '+$('#t4').val());
				var start = $(this).datetimepicker('getDate');
				$('#t3').datetimepicker('option', 'maxDate', new Date(start.getTime()));
			}*/
		});
	});

	$(document).ready(function(){
		$("#form").validationEngine('attach');
		$("#form").submit(function(event){
			cekWaktu('mulai');
			cekWaktu('selesai');
			if($("#status-jam").val() == "0"){
				return false;
			}else{
				return true;
			}
		});

		if($("div.flash").length){
			$("div.flash").show().delay(2000).hide(1000);
		}
		
		$("#jadwal_rutin").change(function(){
			var rutin = $(this).val();
			if(rutin == "1"){
				$("#tidakrutin").hide();
				$("#rutin").show();
			}else{
				$("#rutin").hide();
				$("#tidakrutin").show();
			}
		}).change();
		
	});
	
	function cekWaktu(waktu){
		var selesai = $("#t4").val().replace(/:/, '');
		var mulai = $("#t3").val().replace(/:/,'');
		
		if (parseInt(selesai) <= parseInt(mulai)) {
			if(waktu == 'selesai'){
				$("#t4").validationEngine('showPrompt', 'Jam selesainya kegiatan tidak boleh sebelum jam mulai!');
			}else if(waktu == 'mulai'){
				$("#t3").validationEngine('showPrompt', 'Jam dimulainya kegiatan tidak boleh melebihi jam selesai!');
			}
			$("#status-jam").val("0");
		}else{
			$("#status-jam").val("1");
			$("#t3").validationEngine('hide');
			$("#t4").validationEngine('hide');
		}
	}
	
</script>
<?php $this->load->view('panelfooter'); ?>