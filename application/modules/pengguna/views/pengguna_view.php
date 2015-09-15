<?php $this->load->view('panelheader'); ?>
<p class="title"><?=$pagetitle; ?></p>
<table id="grid"></table>
<div id="pager"></div>
<input type="button" class="add-button" value="Tambah" id="addrow" onclick="window.location.href='<?php echo site_url('pengguna/add'); ?>'" />
<input type="button" class="button" value="Edit" id="editrow" />
<input type="button" class="del-button" value="Hapus" id="delrow" />
<!--<br/><button id="addrow" onclick="window.location.href='<?php echo site_url('pengguna/add'); ?>'" >Add</button>
<button id="editrow" >Edit</button>
<button id="delrow" >Delete</button>-->
<form name="edform" id="edform" method="post" action="<?php echo site_url('pengguna/edit'); ?>">
<input type="hidden" name="uid" id="uid" value="" />
</form>
<script type="text/javascript">
jQuery("#grid").jqGrid({
	url:"<?php echo base_url("pengguna/listing"); ?>",
	datatype: "json",
	mtype: 'post',
	colNames:['Username', 'Nama', 'Email', 'Kontak', 'Role', 'Login Terakhir', 'IP Terakhir'],
	colModel:[
		{name:'username',index:'username', width:100, editable:false},
		{name:'nama',index:'nama', width:100, editable:true},
		{name:'email',index:'email', width:100, editable:true},
		{name:'kontak',index:'kontak', width:75, editable:true},
		{name:'role_nama',index:'role_nama', width:100, editable: true,edittype:"select",editoptions:{value:"1:Administrator;2:Staff"}},
		{name:'login_terakhir',index:'login_terakhir', width:125,align:'center'},
		{name:'ip_terakhir',index:'ip_terakhir', width:100},
	],
	rowNum:20,
	autowidth: true,
	rowList:[30, 40, 50, 60, 70],
	pager: '#pager',
	sortname: 'user_id',
	viewrecords: true,
	hidegrid: false,
	sortorder: "asc",
	rownumbers: true,
	width: 800,
	height: 275,
	multiselect: true,
	editurl: "<?php echo site_url('pengguna/mod') ?>",
	caption:"Daftar Pengguna",
	ondblClickRow: function(rowid)
    {
		jQuery("#grid").jqGrid('viewGridRow',rowid);
    }
});
jQuery("#grid").jqGrid('navGrid','#pager',{edit:false,add:false,del:false,search:false});
$(document).ready(function(){
	/*
	$("#addrow").button({ icons: { primary: "ui-icon-circle-plus"}});
	$("#editrow").button({ icons: { primary: "ui-icon-pencil"}});
	$("#delrow").button({ icons: { primary: "ui-icon-trash"}});
	*/
	$("#editrow").click(function(){
		var gr = jQuery("#grid").jqGrid('getGridParam','selrow');
		//if( gr != null ) jQuery("#grid").jqGrid('editGridRow',gr,{reloadAfterSubmit:false});
		if( gr != null ){
			//$('#uid').attr('value', gr);
			//$("#edform").submit();
			window.location.href = "<?php echo site_url('pengguna/edit'); ?>/"+gr;
		}else{
			alert("Silahkan pilih data terlebih dahulu");
		}
	});
	$("#delrow").click(function(){ 
		var gr = jQuery("#grid").jqGrid('getGridParam','selarrrow'); 
		if( gr.length > 0){
			//for(var row=0;row<gr.length;row++){
				jQuery("#grid").jqGrid('delGridRow',gr,{reloadAfterSubmit:false}); 
			//}
		}else{
			alert("Silahkan pilih terlebih dahulu data yang ingin Anda hapus!"); 
		}
	});
});

</script>
<?php $this->load->view('panelfooter'); ?>