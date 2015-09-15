function showClock(){
	var waktu = new Date();
	var jam = waktu.getHours();
	var menit = waktu.getMinutes();
	var detik = waktu.getSeconds();
	var tanggal = waktu.getDate();
	var bulan = waktu.getMonth();
	var tahun = waktu.getFullYear();
	var nama_bulan = new Array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
	menit = ( menit<10 ? "0" : "") + menit;
	detik = ( detik<10 ? ":0" : ":") + detik;
	tanggal = ( tanggal<10 ? "0" : "") + tanggal;
	//var waktu = ( jam<12 ) ? "AM" : "PM";
	//jam = ( jam>12 ) ? jam-12 : jam;
	jam = ( jam<10 ? "0" : "" ) + jam;
	var currentTime = jam+":"+menit;
	//$('#waktu1').html(tanggal);
	//$('#waktu2').html(nama_bulan[bulan]+" - "+tahun);
	//$('#jam').html(currentTime+""+detik+" "+waktu);
	document.getElementById("tanggal").innerHTML = tanggal+" "+nama_bulan[bulan]+" "+tahun;
	document.getElementById("jam").innerHTML = currentTime+""+detik;
}