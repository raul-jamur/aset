<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<table width="500" cellpadding="2" cellspacing="0" border="1" class="central tabel">
    <thead>
    	<tr>
            <th width="400">Ruangan</th>
            <th width="100">Penggunaan</th>
        </tr>
	</thead>
    <tbody>
    	<?php if($used): ?>
        <?php foreach($used as $row): ?>
 			<tr>
            	<td><?=anchor(site_url("ruangan/detail/id")."/".$row->ruang_id, ucwords($row->ruang_nama), array("class"=>"stat-btn","target"=>"_blank"));?></td>
                <td align="right"><?=$row->kegiatan?></td>
            </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        <?php if($unused): ?>
        <?php foreach($unused as $r): ?>
 			<tr>
            	<td><?=anchor(site_url("ruangan/detail/id")."/".$r->ruang_id, ucwords($r->ruang_nama), array("class"=>"stat-btn","target"=>"_blank"));?></td>
                <td align="right">0</td>
            </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<br />
<br />
<br />

<?php $this->load->view('panelfooter'); ?>