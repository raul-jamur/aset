<?php $this->load->view('header'); ?>
<p class="title"><?=$pagetitle;?></p>
<?php if($ruangan): ?>
<div id="content">
<ul class="asset-item" style="text-align:left; margin:0 auto; width:660px; padding-left:10px;">
	<?php foreach($ruangan as $row): ?>
    <li>
        <a class="asset-btn-small" href="<?php echo site_url('ruangan/detail/id/'.$row->ruang_id); ?>">
        <?php
        if($row->ruang_foto){
			$img = base_url("assets/gambar")."/".$row->ruang_foto;
		}else{
			$img = base_url("assets/gambar")."/ruangan_default.jpg";
		}
		?>
            <div><img src="<?=$img; ?>" height="40" /><p><?=$row->ruang_nama;?> (Lt.<?=$row->gd_lantai;?>)</p></div>
        </a>
    </li>
    <?php endforeach; ?>
</ul>
<?php echo $paginator;?>
</div>
<?php else: ?>
<div class="notif"><div class="error">Data tidak ditemukan</div></div>
<?php endif;?>

<?php $this->load->view('footer'); ?>