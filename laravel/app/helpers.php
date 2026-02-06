<?php
use Carbon\Carbon;
use Carbon\CarbonInterval;

function formatCoret($nilai){
	// $tambahanHarga = $nilai * 50/100;
	$total = $nilai*2;
	if($total==0){
		$total = 2999000;
	}
    return "Rp".number_format($total, 0, ',', '.');    
}
function formatRupiah($nilai){
    return "Rp".number_format($nilai, 0, ',', '.');    
}
function formatRibuan($nilai){
    return number_format($nilai, 0, ',', '.');    
}
function formatRupiahCekGratis($nilai){
    if($nilai==0){
        return "Gratis";
    }else{
        return "Rp".number_format($nilai, 0, ',', '.');    
    }
}
function angkaInteger($nilai){
    return number_format($nilai, 0, ',', '');    
}
function pembulatan($uang)
{
 $uang = ceil($uang); 
 $uang = number_format($uang, 0, ',', '');
 $ratusan = substr($uang, -3);
 if($ratusan==0)
 {
    $akhir = $uang;
 }
 else{
     $akhir = $uang + (1000-$ratusan);
 }
 return $akhir; 
}
function allyear(){
	$allyears = range(Carbon\Carbon::now()->year, 1990);
	return $allyears;
}
function jeniskel($val){
	if ($val=='l') {
		$output = "Laki-laki";
	}elseif($val=='p'){
		$output = "Perempuan";
	}else{
		$output = "";
	}
	return $output;
}
function tglnow(){
	$now = Carbon::now();
	return $now; 
}
function tglIndo($tanggal){
	if ($tanggal) {
    $tanggal = date('Y-m-d', strtotime($tanggal));
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}else{
		return '-';
	}
}
function bulanIndo($tanggal){
    $tanggal = date('Y-m-d', strtotime($tanggal));
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
function tglEuropa($tanggal){
	$tanggal = date('d F Y', strtotime($tanggal));
	return $tanggal;
}
function tglIndoSingkat($tanggal){
    $tanggal = date('Y-m-d', strtotime($tanggal));
	$bulan = array (
		1 =>   'Jan',
		'Feb',
		'Mar',
		'Apr',
		'Mei',
		'Jun',
		'Jul',
		'Agu',
		'Sep',
		'Okt',
		'Nov',
		'Des'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function waktuIndo($tanggal){
    $tanggalfix = date('Y-m-d', strtotime($tanggal));
    $time = date('H:i', strtotime($tanggal));
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggalfix);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0]." ".$time;
}

function waktuIndoSingkat($tanggal){
    $tanggalfix = date('Y-m-d', strtotime($tanggal));
    $time = date('H:i', strtotime($tanggal));
	$bulan = array (
		1 =>   'Jan',
		'Feb',
		'Mar',
		'Apr',
		'Mei',
		'Jun',
		'Jul',
		'Agu',
		'Sep',
		'Okt',
		'Nov',
		'Des'
	);
	$pecahkan = explode('-', $tanggalfix);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0]." ".$time;
}
function semuaBulanParam($awal,$akhir){
	$awal = date('m', strtotime($awal));
	$awal = (int)$awal;

	$akhir = date('m', strtotime($akhir));
	$akhir = (int)$akhir;

	$month = [];
	for ($m=$awal; $m<=$akhir; $m++) {
		$month[] = date('F', mktime(0,0,0,$m, 1, date('Y')));
	}
	return $month;
}
function semuaBulan(){
	$month = [];
	for ($m=1; $m<=12; $m++) {
		$month[] = date('F', mktime(0,0,0,$m, 1, date('Y')));
	}
	return $month;
}
function bulanToIndo($bulan){
	// $year = Carbon\Carbon::now()->format('Y');
	if($bulan=='January'){
		$bulan = 'Januari';
	}elseif($bulan=='February'){
		$bulan = 'Februari';
	}elseif($bulan=='March'){
		$bulan = 'Maret';
	}elseif($bulan=='April'){
		$bulan = 'April';
	}elseif($bulan=='May'){
		$bulan = 'Mei';
	}elseif($bulan=='June'){
		$bulan = 'Juni';
	}elseif($bulan=='July'){
		$bulan = 'Juli';
	}elseif($bulan=='August'){
		$bulan = 'Agustus';
	}elseif($bulan=='September'){
		$bulan = 'September';
	}elseif($bulan=='October'){
		$bulan = 'Oktober';
	}elseif($bulan=='November'){
		$bulan = 'November';
	}elseif($bulan=='December'){
		$bulan = 'Desember';
	}
	return $bulan;
}
function bulanToIndoSingkat($bulan){
	// $year = Carbon\Carbon::now()->format('Y');
	if($bulan=='January'){
		$bulan = 'Jan';
	}elseif($bulan=='February'){
		$bulan = 'Feb';
	}elseif($bulan=='March'){
		$bulan = 'Mar';
	}elseif($bulan=='April'){
		$bulan = 'Apr';
	}elseif($bulan=='May'){
		$bulan = 'Mei';
	}elseif($bulan=='June'){
		$bulan = 'Jun';
	}elseif($bulan=='July'){
		$bulan = 'Jul';
	}elseif($bulan=='August'){
		$bulan = 'Agu';
	}elseif($bulan=='September'){
		$bulan = 'Sep';
	}elseif($bulan=='October'){
		$bulan = 'Okt';
	}elseif($bulan=='November'){
		$bulan = 'Nov';
	}elseif($bulan=='December'){
		$bulan = 'Des';
	}
	return $bulan;
}

function OnlyBulanPeriode($bulan){
	if($bulan=='January'){
		$periode = '-01-01';
	}elseif($bulan=='February'){
		$periode = '-02-01';
	}elseif($bulan=='March'){
		$periode = '-03-01';
	}elseif($bulan=='April'){
		$periode = '-04-01';
	}elseif($bulan=='May'){
		$periode = '-05-01';
	}elseif($bulan=='June'){
		$periode = '-06-01';
	}elseif($bulan=='July'){
		$periode = '-07-01';
	}elseif($bulan=='August'){
		$periode = '-08-01';
	}elseif($bulan=='September'){
		$periode = '-09-01';
	}elseif($bulan=='October'){
		$periode = '-10-01';
	}elseif($bulan=='November'){
		$periode = '-11-01';
	}elseif($bulan=='December'){
		$periode = '-12-01';
	}
	return $periode;
}

function tglEdit($tanggal){
	if ($tanggal) {
		return date('d-m-Y', strtotime($tanggal));
	}else{
		return '';
	}
}

function agama($agama){
	if($agama=='islam'){
		return 'Islam';
	}else if($agama=='protestan'){
		return 'Protestan';
	}else if($agama=='katolik'){
		return 'Katolik';
	}else if($agama=='hindu'){
		return 'Hindu';
	}else if($agama=='buddha'){
		return 'Buddha';
	}else if($agama=='khonghucu'){
		return 'Khonghucu';
	}else{
		return 'Data Not Found';
	}
}
function pendidikan($pend){
	if($pend=='sd'){
		return 'SD Sederajat';
	}else if($pend=='smp'){
		return 'SMP Sederajat';
	}else if($pend=='sma'){
		return 'SMA Sederajat';
	}else if($pend=='d3'){
		return 'D3';
	}else if($pend=='d4'){
		return 'D4';
	}else if($pend=='s1'){
		return 'S1';
	}else if($pend=='s2'){
		return 'S2';
	}else if($pend=='s3'){
		return 'S3';
	}else{
		return 'Data Not Found';
	}
}
function random($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function pilihan(){
	$myarray = array(
		array('a',"A"),
		array('b',"B"),
		array('c',"C"),
		array('d',"D"),
		array('e',"E")
	);
	return $myarray;
}

function datetime($date){
	$date=date_create($date);
	return date_format($date,"d M Y H:i:s");
}
function dateeuro($date){
	$date=date_create($date);
	return date_format($date,"d M Y");
}
function getday($date){
	$date=date_create($date);
	return date_format($date,"j");
}
function timetoHuman($val){
	$value = $val;
	$dt = Carbon::now();
	$days = $dt->diffInDays($dt->copy()->addMinutes($value));
	$hours = $dt->diffInHours($dt->copy()->addMinutes($value)->subDays($days));
	$minutes = $dt->diffInMinutes($dt->copy()->addMinutes($value)->subDays($days)->subHours($hours));
	return CarbonInterval::days($days)->hours($hours)->minutes($minutes)->forHumans();
}
function statuspayment($val1,$val2){
	$myarray = array(
		array(0,"Pending","badge badge-warning"),
		array(1,"Processing","badge badge-info"),
		array(2,"Failed","badge badge-danger"),
		array(3,"Expired","badge badge-danger"),
		array(4,"Complete","badge badge-success")
	);
	return $myarray[$val1][$val2];
}
function statuskirim($val1,$val2){
	$myarray = array(
		array(0,"Belum Dikirim","badge badge-warning"),
		array(1,"Sudah Dikirim","badge badge-success"),
	);
	return $myarray[$val1][$val2];
}
function statuslulus($val1,$val2){
	$myarray = array(
		array(0,"Tidak Lulus","badge badge-danger"),
		array(1,"Lulus","badge badge-success")
	);
	return $myarray[$val1][$val2];
}
function jenissoal($val){
	if($val==1){
		$jenis = "Pilihan Ganda";
	}else{
		$jenis = "Kecermatan";
	}
	return $jenis;
}
function datetimestore($tanggal){
	$tgl = explode(" ",$tanggal);
	$tgldate = Carbon::createFromFormat('d-m-Y',$tgl[0])->isoFormat('YYYY-MM-DD');
	$tgltime = $tgl[1];
	$tglfix = $tgldate." ".$tgltime.":00"; 
	return $tglfix;
}
function datestore($tanggal){
	$tgl = Carbon::createFromFormat('d-m-Y',$tanggal)->isoFormat('YYYY-MM-DD');
	return $tgl;
}
function datetimeedit($tanggal){
	if ($tanggal) {
		return date('d-m-Y H:i', strtotime($tanggal));
	}else{
		return '';
	}
}
function getyear($tanggal){
    $tanggal = date('Y', strtotime($tanggal));
	return $tanggal;
}

function predikat($nilai){
	if($nilai=="A+"){
		$predikat = "Peraih Medali Emas";
	}elseif($nilai=="A"){
		$predikat = "Peraih Medali Perak";
	}elseif($nilai=="B+"){
		$predikat = "Peraih Medali Perunggu";
	}else{
		$predikat ="Peserta";
	}
    
	return $predikat;
}

function channel(){
	$myarray = array(
		[
			'kode'=>'MYBVA',
			'nama'=>'Maybank Virtual Account',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/ZT91lrOEad1582929126.png',
			'biaya'=>'Rp 4.250'
		],
		[
			'kode'=>'PERMATAVA',
			'nama'=>'Permata Virtual Account',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/szezRhAALB1583408731.png',
			'biaya'=>'Rp 4.250'
		],
		[
			'kode'=>'BNIVA',
			'nama'=>'BNI Virtual Account',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/n22Qsh8jMa1583433577.png',
			'biaya'=>'Rp 4.250'
		],
		[
			'kode'=>'BRIVA',
			'nama'=>'BRI Virtual Account',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/8WQ3APST5s1579461828.png',
			'biaya'=>'Rp 4.250'
		],
		[
			'kode'=>'MANDIRIVA',
			'nama'=>'Mandiri Virtual Account',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/T9Z012UE331583531536.png',
			'biaya'=>'Rp 4.250'
		],
		[
			'kode'=>'BCAVA',
			'nama'=>'BCA Virtual Account',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/ytBKvaleGy1605201833.png',
			'biaya'=>'Rp 5.500'
		],
		[
			'kode'=>'SMSVA',
			'nama'=>'Sinarmas Virtual Account',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/KHcqcmqVFQ1607091889.png',
			'biaya'=>'Rp 4.250'
		],
		[
			'kode'=>'MUAMALATVA',
			'nama'=>'Muamalat Virtual Account',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/GGwwcgdYaG1611929720.png',
			'biaya'=>'Rp 4.250'
		],
		[
			'kode'=>'CIMBVA',
			'nama'=>'CIMB Niaga Virtual Account',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/WtEJwfuphn1614003973.png',
			'biaya'=>'Rp 4.250'
		],
		[
			'kode'=>'BSIVA',
			'nama'=>'BSI Virtual Account',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/tEclz5Assb1643375216.png',
			'biaya'=>'Rp 4.250'
		],
		[
			'kode'=>'OCBCVA',
			'nama'=>'OCBC NISP Virtual Account',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/ysiSToLvKl1644244798.png',
			'biaya'=>'Rp 4.250'
		],
		[
			'kode'=>'DANAMONVA',
			'nama'=>'Danamon Virtual Account',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/F3pGzDOLUz1644245546.png',
			'biaya'=>'Rp 4.250'
		],
		[
			'kode'=>'BNCVA',
			'nama'=>'BNC Virtual Account',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/3IXRIbogu11664370160.png',
			'biaya'=>'Rp 4.250'
		],
		[
			'kode'=>'ALFAMART',
			'nama'=>'Alfamart',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/jiGZMKp2RD1583433506.png',
			'biaya'=>'3500'
		],
		[
			'kode'=>'INDOMARET',
			'nama'=>'Indomaret',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/zNzuO5AuLw1583513974.png',
			'biaya'=>'3500'
		],
		[
			'kode'=>'ALFAMIDI',
			'nama'=>'Alfamidi',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/aQTdaUC2GO1593660384.png',
			'biaya'=>'3500'
		],
		[
			'kode'=>'OVO',
			'nama'=>'OVO',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/fH6Y7wDT171586199243.png',
			'biaya'=>'3.00%'
		],
		[
			'kode'=>'SHOPEEPAY',
			'nama'=>'ShopeePay',
			'img'=>'https://assets.tripay.co.id/upload/payment-icon/d204uajhlS1655719774.png',
			'biaya'=>'3.00%'
		],
	);
	return $myarray;
	// if($val1==00 && $val2==00){
	// }else{
	// 	return $myarray[$val1][$val2];
	// }
}

function jenjang($val){
	if($val==1){
		$dataval = "SD/Sederajat";
	}elseif($val==2){
		$dataval = "SMP/Sederajat";
	}elseif($val==3){
		$dataval = "SMA/Sederajat";
	}elseif($val==4){
		$dataval = "Mahasiswa";
	}elseif($val==5){
		$dataval = "Guru";
	}else{
		$dataval ="No Data";
	}
	return $dataval;
}

function referrer($val1=00,$val2=00){
	$myarray = array(
		array(0,"Teman"),
		array(1,"Lainnya"),
		array(2,"Tiktok"),
		array(3,"Instagram"),
	);
	if($val1==00 && $val2==00){
		return $myarray;
	}else{
		return $myarray[$val1][$val2];
	}
}

function fasilitas($val1=00,$val2=00){
	$myarray = array(
		array(0,"Full Akses selama 12 Bulan"),
		array(1,"Kunci Jawaban dan Pembahasan"),
		array(2,"Berlatih Manajemen Waktu"),
		array(3,"Praktis dan Simpel"),
		array(4,"Tampilan Sederhana dan Elegan"),
		array(5,"Latihan Sistem CAT & Realtime"),
		array(6,"Skor dan Grafik Informatif"),
		array(7,"Akses di Smartphone, Laptop atau Komputer"),
		array(8,"Mendukung Beragam Metode Pembayaran (Virtual Account, E-Wallet dan Alfamart)"),
	);
	if($val1==00 && $val2==00){
		return $myarray;
	}else{
		return $myarray[$val1][$val2];
	}
}