<?php $this->load->view('header'); ?>
<?php if($gedung): ?>
<?php foreach($gedung as $row): ?>
<p class="title">Gedung <?=$row->gd_nama;?></p>
<div id="content">
    <table border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr valign="top">
        <?php
        if($row->gd_foto){
            $img = base_url("assets/gambar")."/".$row->gd_foto;
        }else{
            $img = base_url("assets/gambar")."/gd_default.jpg";
        }
        ?>
            <td width="200" rowspan="5"><img src="<?=$img; ?>" /></td>
            <td width="100" height="20">Luas Bangunan</td>
            <td width="5">:</td>
            <td>
				<?php
				if($row->gd_luas){
            		echo $row->gd_luas." ".$s_luas;
				}else{
					echo '-';
				}
				?>
            </td>
        </tr>
        <tr valign="top">
            <td height="20">Jumlah Lantai</td>
            <td>:</td>
            <td><?=$row->gd_lantai?> <?=$s_lantai?></td>
        </tr>
        <tr valign="top">
            <td colspan="3"><a class="btn" href="<?php echo site_url()."ruangan/katalog/".$row->gd_id."/list/"; ?>">Daftar Ruangan</a></td>
        </tr>
    </table>
    
    <div class="textblock">
        <?php if(isset($jenisruangan) && $jenisruangan): ?>
        <b><?=$row->gd_nama; ?> merupakan gedung yang digunakan untuk :</b><br />
        <!--<ul>
            <li>Kantor Administrasi</li>
            <li>Ruang Kuliah</li>
            <li>Ruang Praktik</li>
            <li>Perpustakaan/Ruang Baca</li>
        </ul>
        <br /><br />-->
        <?php endif; ?>
        <b>Fasilitas :</b>
        <?php if($fasilitas): ?>
        <ul>
        <?php foreach ($fasilitas as $f): ?>
            <li><?=$f->fasilitas_nama;?></li>  
        <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="notif"><div class="error">Data tidak ditemukan</div></div>
<? endif; ?>
<?php $this->load->view('footer'); ?>