<?php $this->load->view('header'); ?>
<?php if($ruangan): ?>
<?php foreach($ruangan as $row): ?>
<p class="title"><?=$ruangan[0]->ruang_nama;?></p>
<div id="content">
<input type="hidden" id="ruang_id" name="ruang_id" value="<?=$row->ruang_id;?>" />
<table border="0" cellpadding="5" cellspacing="0" width="100%">
    <tr valign="top">
    <?php
    if($row->ruang_foto){
		$img = base_url("assets/gambar")."/".$row->ruang_foto;
	}else{
		$img = base_url("assets/gambar")."/ruangan_default.jpg";
	}
	?>
        <td width="200" rowspan="5"><img src="<?=$img; ?>" /></td>
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
        <td>Gd. <?=$gedung[0]->gd_nama;?>  lt. <?=$row->gd_lantai;?></td>
    </tr>
</table>
<br />
<p class="subtitle">Jadwal Penggunaan</p>
<div id="tabs">
	<ul>
    	<li><a href="#tabs-1">Daftar</a></li>
        <li><a href="#tabs-2" onclick='$("#calendar").fullCalendar("refetchEvents");'>Kalender</a></li>
    </ul>
    <div id="tabs-1">
    	<div class="jadwal">
        <?php
		$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
		$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
		if($jadwal_rutin){
        	$jh = '';
			echo '<p style="text-decoration:underline; font-weight:bold;">Jadwal Rutin</p>';
        	foreach($jadwal_rutin as $j1){
            	if($j1->jadwal_hari != $jh){
                	echo '<b>'.$hari[$j1->jadwal_hari].'</b>';
					$jh = $j1->jadwal_hari;
				}
                echo '<ul><li>'.substr($j1->jam_mulai,0,5).' - '.substr($j1->jam_selesai,0,5).' <b>:</b> '.$j1->jadwal_acara.'</li></ul>';
			}
		}
        ?>
        <br />
        <?php
		if($jadwal_tidak_rutin){
			echo '<p style="text-decoration:underline; font-weight:bold;">Jadwal Tidak Rutin</p>';
        	echo '<ul>';
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
					
                    echo '<li>'.$waktu.' <b>:</b> '.$j2->jadwal_acara.'</li>';
				}
            echo '</ul>';
		}
        ?>
        </div>
    </div>
    <div id="tabs-2">
        <div id="calendar"></div>
    </div>
</div>
<?php endforeach; ?>
</div>
<?php else: ?>
<div class="notif"><div class="error">Data tidak ditemukan</div></div>
<? endif; ?>
<script type="text/javascript">
$(document).ready(function(){
	var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
	
    var calendar = $('#calendar').fullCalendar({
       // this is where you specify where to pull the events from.

       	events: "<?php echo site_url("jadwal/penggunaan").'/';?>"+ $("#ruang_id").val(),
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
	
	$("#tabs").tabs();
	
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
<?php $this->load->view('footer'); ?>