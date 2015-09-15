<?php $this->load->view('panelheader'); ?>
<?php if($this->session->flashdata('success')):?>
<div class="notif"><div class="info" style="margin:2px 5px;"><?php echo $this->session->flashdata('success');?></div></div>
<?php endif;?>
<div id="paneltabs">
	<ul>
	<?php foreach($akses as $a): ?>
		<li><a href="#paneltabs-<?=$a->fitur_id;?>"><?=$a->fitur_nama;?></a></li>
    <?php endforeach; ?>
    </ul>
    <?php foreach($akses as $a): ?>
    <div id="paneltabs-<?=$a->fitur_id;?>">
    	<?php $this->load->view("fitur/".$a->fitur_view_file); ?>
    </div>
    <?php endforeach; ?>
</div>
<script type="text/javascript">
$(function() {
	$("#paneltabs").tabs();
});

$(document).ready(function(){
	var plot1 = <?=$plot1;?>;
	var label1 = <?=$label1;?>;
	
	var plot2 = <?=$plot2;?>;
	var label2 = <?=$label2;?>;
	 
	plot1 = $.jqplot('chart1', [plot1], {
		title:'Ruangan dengan penggunaan terbanyak minggu ini',
		animate: !$.jqplot.use_excanvas,
		seriesDefaults: {
			renderer:$.jqplot.BarRenderer,
			/*rendererOptions: {
				varyBarColor: true
			},*/
			pointLabels: { show: true, formatString: '%d', location: 's' }
		},
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: label1,
				label:' ',
				labelRenderer: $.jqplot.CanvasAxisLabelRenderer
			},
			yaxis:{
			  label:'Kegiatan/Penggunaan',
			  labelRenderer: $.jqplot.CanvasAxisLabelRenderer
			}
		}
	});
	
	plot2 = $.jqplot('chart2', [plot2], {
		title:'Ruangan dengan penggunaan terbanyak bulan ini',
		animate: !$.jqplot.use_excanvas,
		seriesDefaults: {
			renderer:$.jqplot.BarRenderer,
			/*rendererOptions: {
				varyBarColor: true
			},*/
			pointLabels: { show: true, formatString: '%d', location: 's' }
		},
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: label2,
				label:' ',
				labelRenderer: $.jqplot.CanvasAxisLabelRenderer
			},
			yaxis:{
			  label:'Kegiatan/Penggunaan',
			  labelRenderer: $.jqplot.CanvasAxisLabelRenderer
			}
		}
	});
});
</script>
<?php $this->load->view('panelfooter'); ?>