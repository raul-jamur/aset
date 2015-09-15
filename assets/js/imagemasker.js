$(document).ready(function(){
	$("#content img").each(function(){
		var h = $(this).height();
		var w = $(this).width();
		var a = $(this).attr("src");
		var p = $(this).position();
		var i = $("img").index(this);
		//$(this).attr("src","<?php echo base_url("assets/images/blank.png"); ?>");
		//$(this).css({"height":h, "width":w, "background":"url('"+a+"') no-repeat"});
		var newEl = document.createElement("div");
		newEl.id = "mask"+i;
		document.getElementById("content").appendChild(newEl);
		//$("#mask"+i).css({"height":h, "width":w, "background":"url('"+a+"') no-repeat", "position":"absolute","left":p.left,"top":p.top});
		$("#mask"+i).css({"height":h, "width":w, "background":"url('/aset/images/blank.png') no-repeat", "position":"absolute","left":p.left,"top":p.top});
		
	});
});