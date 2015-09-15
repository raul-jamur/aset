<?php if($this->session->userdata('role_id') == 1): ?>
<div class="menu_wrap">
	<ul class="menu">
    	<li><a href="<?php echo site_url('backpanel#paneltabs-4'); ?>">Statistik</a></li>
        <li>
        	<a>Jadwal</a>
            <ul>
            	<li><a href="<?php echo site_url('jadwal/ruangan'); ?>">Penggunaan</a></li>
                <li><a href="<?php echo site_url('jadwal/input'); ?>">Input Penggunaan</a></li>
            </ul>
        </li>
        <li>
        	<a>Master Data</a>
            <ul>
            	<li><a href="<?php echo site_url('gedung'); ?>">Gedung</a></li>
                <li><a href="<?php echo site_url('ruangan'); ?>">Ruangan</a></li>
                <li><a href="<?php echo site_url('jenisruangan'); ?>">Jenis Ruangan</a></li>
                <li><a href="<?php echo site_url('fasilitas'); ?>">Fasilitas</a></li>
            </ul>
        </li>
        <li>
        	<a>Pengaturan Sistem</a>
            <ul>
            	<li><a href="<?php echo site_url('pengguna'); ?>">Pengguna</a></li>
                <li><a href="<?php echo site_url('preferensi'); ?>">Preferensi</a></li>
            </ul>
        </li>
    </ul>
</div>
<?php elseif($this->session->userdata('role_id') == 2): ?>
<div class="menu_wrap">
	<ul class="menu">
		<li>
        	<a>Jadwal</a>
            <ul>
            	<li><a href="<?php echo site_url('jadwal/ruangan'); ?>">Penggunaan</a></li>
                <li><a href="<?php echo site_url('jadwal/input'); ?>">Input Penggunaan</a></li>
            </ul>
        </li>
	</ul>
</div>
<?php endif; ?>