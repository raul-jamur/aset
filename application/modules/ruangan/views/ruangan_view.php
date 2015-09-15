<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<table id="grid"></table>
<div id="pager"></div>
<input type="button" class="add-button" value="Tambah" id="addrow" onclick="window.location.href='<?php echo site_url('ruangan/add'); ?>'" />
<input type="button" class="button" value="Edit" id="editrow" />
<input type="button" class="del-button" value="Hapus" id="delrow" />
<script type="text/javascript">
jQuery("#grid").jqGrid({
	url:"<?php echo base_url("ruangan/listing"); ?>",
	datatype: "json",
	mtype: 'post',
	colNames:['Nama Ruangan', 'Jenis', 'Luas', 'Lokasi', 'Photo'],
	colModel:[
		{name:'ruang_nama',index:'ruang_nama', width:200, editable:true},
		{name:'jenisruang_nama',index:'jenisruang_nama', width:150, editable:true},
		{name:'ruang_luas',index:'ruang_luas', width:100, align:'right', editable:true},
		{name:'ruang_lokasi',index:'ruang_lokasi', width:200, editable:false},
		{name:'ruang_foto',index:'ruang_foto', width:100, align:'center', editable:true}
	],
	rowNum:20,
	autowidth: true,
	rowList:[30, 40, 50, 60, 70],
	pager: '#pager',
	sortname: 'ruang_id',
	viewrecords: true,
	hidegrid: false,
	sortorder: "asc",
	rownumbers: true,
	width: 800,
	height: 275,
	multiselect: true,
	editurl: "<?php echo site_url('ruangan/mod') ?>",
	caption:"Daftar Ruangan",
	ondblClickRow: function(rowid)
    {
		jQuery("#grid").jqGrid('viewGridRow',rowid);
    }
});
jQuery("#grid").jqGrid('navGrid','#pager',{edit:false,add:false,del:false,search:false});
$(document).ready(function(){
	$("#editrow").click(function(){
		var gr = jQuery("#grid").jqGrid('getGridParam','selrow');
		if( gr != null ){
			window.location.href = "<?php echo site_url('ruangan/edit'); ?>/"+gr;
		}else{
			alert("Silahkan pilih data terlebih dahulu");
		}
	});
	$("#delrow").click(function(){ 
		var gr = jQuery("#grid").jqGrid('getGridParam','selarrrow'); 
		if( gr.length > 0){
			jQuery("#grid").jqGrid('delGridRow',gr,{reloadAfterSubmit:false}); 
		}else{
			alert("Silahkan pilih terlebih dahulu data yang ingin Anda hapus!"); 
		}
	});
});

</script>
<?php $this->load->view('panelfooter'); ?>
