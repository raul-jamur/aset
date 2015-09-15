<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<?php if($ruangan): ?>
	<table border="0" cellpadding="5" cellspacing="0" width="100%">
		<tr valign="top">
		<?php
		if($ruangan[0]->ruang_foto){
			$img = base_url("assets/gambar")."/".$ruangan[0]->ruang_foto;
		}else{
			$img = base_url("assets/gambar")."/ruangan_default.jpg";
		}
		?>
			<td width="100" rowspan="5"><img src="<?=$img; ?>" height="100" width="100" /></td>
			<td width="100" height="17">Ruangan</td>
			<td width="5">:</td>
			<td><b><?=$ruangan[0]->ruang_nama;?></b></td>
		</tr>
        <tr>
        	<td width="100" height="17">Peruntukan</td>
			<td width="5">:</td>
			<td><?=$ruangan[0]->jenisruang_nama;?></td>
		</tr>
		<tr valign="top">
			<td height="17">Luas</td>
			<td>:</td>
			<?php if($ruangan[0]->ruang_luas): ?>
			<td><?=$ruangan[0]->ruang_luas;?> <?=$s_luas;?></td>
			<?php else: ?>
			<td>-</td>
			<?php endif; ?>
		</tr>
		<tr valign="top">
			<td width="17">Lokasi</td>
			<td>:</td>
			<td>Gd. <?=$gedung[0]->gd_nama;?>  Lt. <?=$ruangan[0]->gd_lantai;?></td>
		</tr>
	</table>
    <br />
<div id="tabs">
	<ul>
    	<li><a href="#tabs-1">Daftar</a></li>
        <li><a href="#tabs-2" onclick='$("#calendar").fullCalendar("refetchEvents");'>Kalender</a></li>
    </ul>
    <div id="tabs-1">
    <?php if($this->session->flashdata('error')):?>
    <div class="notif flash"><div class="error" style="margin:2px 5px;"><?php echo $this->session->flashdata('error');?></div></div>
    <?php endif;?>
    <?php if($this->session->flashdata('success')):?>
    <div class="notif flash"><div class="success" style="margin:2px 5px;"><?php echo $this->session->flashdata('success');?></div></div>
    <?php endif;?>
    	<div class="jadwal">
        <?php
		$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
		$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
		if($jadwal_rutin){
        	$jh = '';
			echo '<table width="100%" cellpadding="2" cellspacing="0" border="0" class="table-jadwal">',"\n";
			echo '<tr><td colspan="3"><p style="text-decoration:underline; font-weight:bold;">Jadwal Rutin</p></td></tr>',"\n";
        	foreach($jadwal_rutin as $j1){
            	if($j1->jadwal_hari != $jh){
                	echo '<tr><td colspan="3"><b>'.$hari[$j1->jadwal_hari].'</b></td></tr>',"\n";
					$jh = $j1->jadwal_hari;
				}
				echo '<tr class="baris-jadwal" id="jadwal_'.$j1->jadwal_id.'">',"\n";
                echo '<td width="5%" align="center">&bull;</td>',"\n";
				echo '<td width="80%">'.substr($j1->jam_mulai,0,5).' - '.substr($j1->jam_selesai,0,5).' <b>:</b> '.$j1->jadwal_acara.'</td>',"\n";
				echo '<td align="right"><button class="edit-btn" name="'.$j1->jadwal_id.'">Edit</button>';
				echo '&nbsp;&nbsp;<button class="del-btn" name="'.$j1->jadwal_id.'">Hapus</button></td>';
				echo '</tr>',"\n";
			}
			echo '</table>',"\n";
		}
        ?>
        <br />
        <?php
		if($jadwal_tidak_rutin){
			echo '<table width="100%" cellpadding="2" cellspacing="0" border="0" class="table-jadwal">',"\n";
			echo '<tr><td colspan="3"><p style="text-decoration:underline; font-weight:bold;">Jadwal Tidak Rutin</p></td></tr>',"\n";
            	foreach($jadwal_tidak_rutin as $j2){
					$m = explode(" ",$j2->jadwal_mulai);
					$tm = explode("-", $m[0]);
					$jm = explode(":", $m[1]);
					if($tm[1] < 10){$tm[1]=str_replace("0","",$tm[1]);}
					$mulai = $tm[2].' '.$bulan[$tm[1]].' '.$tm[0];
					$s = explode(" ",$j2->jadwal_selesai);
					$ts = explode("-", $s[0]);
					$js = explode(":", $s[1]);
					if($ts[1] < 10){$ts[1]=str_replace("0","",$ts[1]);}
					$selesai = $ts[2].' '.$bulan[$ts[1]].' '.$ts[0];
					if($m[0] == $s[0]){
						$waktu = $mulai.', '.$jm[0].':'.$jm[1].' - '.$js[0].':'.$js[1];
					}else{
						$waktu = $mulai.', '.$jm[0].':'.$jm[1].' <sup>s</sup>/<sub>d</sub> '.$selesai.', '.$js[0].':'.$js[1];
					}
					echo '<tr class="baris-jadwal" id="jadwal_'.$j2->jadwal_id.'">',"\n";
                	echo '<td width="5%" align="center">&bull;</td>',"\n";
                    echo '<td width="80%">'.$waktu.' <b>:</b> '.$j2->jadwal_acara.'</td>',"\n";
					echo '<td align="right"><button class="edit-btn" name="'.$j2->jadwal_id.'">Edit</button>';
					echo '&nbsp;&nbsp;<button class="del-btn" name="'.$j2->jadwal_id.'">Hapus</button></td>',"\n";
					echo '</tr>',"\n";
				}
			echo '</table>';
		}
        ?>
        <form id="mod_form" method="post" action="<?php echo site_url("jadwal/edit/"); ?>">
        	<input type="hidden" id="ruang_id" name="ruang_id" value="<?=$ruangan[0]->ruang_id;?>" />
        	<input type="hidden" id="del_id" value="" />
        	<input type="hidden" id="edit_id" name="edit_id" value="" />
        </form>
        </div>
    </div>
    <div id="tabs-2" style="background:#f2f2f2;">
    	<div id="calendar"></div>
    </div>
</div>
<?php else: ?>
<div class="notif"><div class="error">Data tidak ditemukan</div></div>
<? endif; ?>

<div id="del-confirm" title="Konfirmasi Penghapusan Data">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Hapus jadwal terpilih?</p>
</div>

<script type="text/javascript">
$(document).ready(function(){
	var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
	
	var calendar = $('#calendar').fullCalendar({
		// this is where you specify where to pull the events from.
		events: "<?php echo site_url("jadwal/penggunaan").'/'.$ruangan[0]->ruang_id;?>",
		eventRender: function(event, element) {		   	
			element.qtip({
				style:{name: 'blue', tip: 'bottomMiddle'},
				position:{
					corner:{
						target: 'topMiddle',
						tooltip: 'bottomMiddle'
					}
				},
				content: splitter(event.start, event.end) +' : '+ event.title
			});
		},
		editable: false,
		defaultView: 'agendaWeek',
		allDayDefault: false,
		//etc etc
	});
	
	if($("div.flash").length){
		$("div.flash").show().delay(2000).hide(1000);
	}
	
	$("#tabs").tabs();
	
	$("button.edit-btn").button({
		icons: { primary: 'ui-icon-pencil' },
		text: false
	});
	
	$("button.del-btn").button({
		icons: { primary: 'ui-icon-trash' },
		text: false
	});
	
	$("button.edit-btn").each(function(){
		$(this).click(function(){
			$("#edit_id").val($(this).attr("name"));
			$("#mod_form").submit();
		});
	});
	
	$("button.del-btn").each(function(){
		$(this).click(function(){
			$("#del_id").val($(this).attr("name"));
			$('#del-confirm').dialog('open');
		});
	});
	
	$("#del-confirm").dialog({
		autoOpen: false,
		resizable: false,
		modal: true,
		buttons: {
			'Batal': function() {
				$(this).dialog('close');
			},
			'Hapus': function() {
				$.post(
					'<?php echo site_url('jadwal/hapus'); ?>',
					{jid:$("#del_id").val()},
					function(data){
						if(data == 'berhasil'){
							$("#jadwal_"+ $("#del_id").val()).addClass('ui-state-error');
							setTimeout(function() {
								$("#jadwal_"+ $("#del_id").val()).removeClass('ui-state-error', 1500);
								$("#jadwal_"+ $("#del_id").val()).hide().remove();
							}, 500);

						}else{
							alert("Data tidak terhapus.");
						}
					}
				);
				$(this).dialog('close');
			}
		}
	});

	
});

function splitter(start, end){
	var w1 = start.toString().split(" ");
	var j1 = w1[4].toString().split(":");
	var t1 = w1[2] +' '+ w1[1];
	var w2 = end.toString().split(" ");
	var j2 = w2[4].toString().split(":");
	var t2 = w2[2] +' '+ w2[1];
	
	if(t1 == t2){
		return t1 +', '+ j1[0] +':'+ j1[1] +' - '+ j2[0] +':'+ j2[1];
	}else{
		return t1 +', '+ j1[0] +':'+ j1[1] +' - '+ t2 +', '+ j2[0] +':'+ j2[1];
	}
}
</script>
<?php $this->load->view('panelfooter'); ?>