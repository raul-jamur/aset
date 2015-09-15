<?php $this->load->view('header'); ?>
<p class="title"><?=$pagetitle;?></p>
<?php if($gedung): ?>
<div id="content">
<ul class="asset-item">
	<?php foreach($gedung as $row): ?>
    <li>
        <a class="asset-btn" href="<?php echo site_url('gedung/detail/'.$row->gd_id); ?>">
        <?php
        if($row->gd_foto){
			$img = base_url("assets/gambar")."/".$row->gd_foto;
		}else{
			$img = base_url("assets/gambar")."/gd_default.jpg";
		}
		?>
            <div><img src="<?=$img; ?>" height="100" /><p>Gedung <?=$row->gd_nama;?></p></div>
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