<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<table id="grid"></table>
<div id="pager"></div>
<input type="button" class="add-button" value="Tambah" id="addrow" onclick="window.location.href='<?php echo site_url('gedung/add'); ?>'" />
<input type="button" class="button" value="Edit" id="editrow" />
<input type="button" class="del-button" value="Hapus" id="delrow" />
<script type="text/javascript">
jQuery("#grid").jqGrid({
	url:"<?php echo base_url("gedung/listing"); ?>",
	datatype: "json",
	mtype: 'post',
	colNames:['Nama Gedung', 'Luas', 'Jumlah Lantai', 'Photo'],
	colModel:[
		{name:'gd_nama',index:'gd_nama', width:300, editable:true},
		{name:'gd_luas',index:'gd_luas', width:150, align:'right', editable:true},
		{name:'gd_lantai',index:'gd_lantai', width:150, align:'right', editable:true},
		{name:'gd_foto',index:'gd_foto', width:100, align:'center', editable:true}
	],
	rowNum:20,
	autowidth: true,
	rowList:[30, 40, 50, 60, 70],
	pager: '#pager',
	sortname: 'gd_id',
	viewrecords: true,
	hidegrid: false,
	sortorder: "asc",
	rownumbers: true,
	width: 800,
	height: 275,
	multiselect: true,
	editurl: "<?php echo site_url('gedung/mod') ?>",
	caption:"Daftar Gedung",
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
			window.location.href = "<?php echo site_url('gedung/edit'); ?>/"+gr;
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
