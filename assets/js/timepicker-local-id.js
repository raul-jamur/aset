$.datepicker.regional['id'] = {
	closeText: 'Tutup',
	prevText: 'Sebelumnya',
	nextText: 'Selanjutnya',
	currentText: 'Sekarang',
	monthNames: ['Januari','Februari','Maret','April','Mei','Juni',
	'Juli','Agustus','September','Oktober','November','Desember'],
	monthNamesShort: ['Jam','Fen','Маr','Аpr','Мei','Jun',
	'Jul','Аgt','Sep','Оkt','Nov','Des'],
	dayNames: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
	dayNamesShort: ['Mgg','Snn','Sls','Rbu','Kms','Jmt','Sbt'],
	dayNamesMin: ['Mg','Sn','Sl','Rb','Km','Jm','Sb'],
	weekHeader: 'Mg',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['id']);


$.timepicker.regional['id'] = {
	timeOnlyTitle: 'Jam',
	timeText: 'Waktu',
	hourText: 'Jam',
	minuteText: 'Menit',
	secondText: 'Detik',
	millisecText: 'Mili Detik',
	timezoneText: 'Zona Waktu',
	currentText: 'Sekarang',
	closeText: 'Tutup',
	isRTL: false
};
$.timepicker.setDefaults($.timepicker.regional['id']);