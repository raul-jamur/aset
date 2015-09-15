<?php $this->load->view('header'); ?>
<p class="title"><?=$pagetitle;?></p>
<div id="content" style="width:460px; height:270px; position:relative; float:left;">
    <ul class="dashboard-item" >
        <li>
            <a class="dash-btn" href="<?php echo site_url('gedung/katalog'); ?>">
                <img src="<?php echo base_url(); ?>assets/images/building_icon2.png" />
                <p>Gedung & Ruangan</p>
            </a>
        </li>
        <li>
            <a class="dash-btn" href="<?php echo site_url('jadwal/info'); ?>">
                <img src="<?php echo base_url(); ?>assets/images/jadwal_icon1.png" />
                <p>Informasi Penggunaan</p>
            </a>
        </li>
    </ul>
    
</div>
<div id="scroll-wrapper">
    <div class="vertical_scroller">
	    <div class="scrollingtext">
            <?=$scroller;?>
        </div>
    </div>
    <!--<div class="top-grad"></div>
    <div class="bottom-grad"></div>-->
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.vertical_scroller').SetScroller({ velocity: 30, direction: 'vertical', cursor: 'auto' });
});
</script>
<?php $this->load->view('footer'); ?>