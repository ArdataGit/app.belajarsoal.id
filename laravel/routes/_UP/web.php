<?php



use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PDFController;

use App\Http\Middleware\IsAdmin;

use App\Http\Middleware\IsAdminOrAff;

use App\Http\Middleware\IsUser;

use App\Http\Middleware\IsUserUmum;

use App\Http\Middleware\IsAff;

/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/



// Route::get('login')->uses('App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');



Route::get('/', [App\Http\Controllers\CampurController::class, 'index']);



Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');



Route::get('auth/google', [App\Http\Controllers\GoogleController::class, 'index']);

Route::get('auth/google/callback', [App\Http\Controllers\GoogleController::class, 'callback']);



Route::post('userauth', [App\Http\Controllers\Auth\LoginController::class, 'login']);

Route::get('buatakun', [App\Http\Controllers\Auth\RegisterController::class, 'index']);

Route::get('lupapassword', [App\Http\Controllers\CampurController::class, 'lupapassword']);

// Route::post('storeregister', [App\Http\Controllers\Auth\RegisterController::class, 'storeregister']);

Route::post('storeregister', [App\Http\Controllers\CampurController::class, 'storeregister']);

Route::post('resetpassword', [App\Http\Controllers\CampurController::class, 'resetpassword']);

Route::get('aktivasi/{id}', [App\Http\Controllers\CampurController::class, 'aktivasi']);



Route::get('/home', [App\Http\Controllers\ProfilController::class, 'index'])->name('home');



Route::get('rankingtryout/{id}', [App\Http\Controllers\UserController::class, 'rankingtryout']);

Route::get('rankingpaket/{id}', [App\Http\Controllers\UserController::class, 'rankingpaket']);

Route::get('rankingpaketkec/{id}', [App\Http\Controllers\UserController::class, 'rankingpaketkec']);



Route::get('detailhasil/{id}', [App\Http\Controllers\UserController::class, 'detailhasil']);

Route::get('detailhasilkecermatan/{id}', [App\Http\Controllers\UserController::class, 'detailhasilkecermatan']);



Route::get('sertifikat/{idmapel}/{iduser}', [App\Http\Controllers\PDFController::class, 'sertifikat']);

Route::get('piagam/{idmapel}/{iduser}', [App\Http\Controllers\PDFController::class, 'piagam']);



Route::post('/updateUserAkun', [App\Http\Controllers\ProfilController::class, 'updateakun']);

Route::post('/updateUserProfil', [App\Http\Controllers\ProfilController::class, 'updateprofil']);

Route::post('/updateUserPassword', [App\Http\Controllers\ProfilController::class, 'updatepassword']);



Route::middleware([IsAff::class])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\ProfilController::class, 'dashboard'])->name('dashboard');

});



Route::get('/userjson', [App\Http\Controllers\UserListController::class, 'indexjson']);



Route::middleware([IsAdminOrAff::class])->group(function () {



    Route::get('paketuser/{id}', [App\Http\Controllers\PaketUserController::class, 'index']);

    Route::post('storepaketuser', [App\Http\Controllers\PaketUserController::class, 'store']);

    Route::post('/hapuspaketuser/{id}', [App\Http\Controllers\PaketUserController::class, 'destroy']);

    Route::post('getPaketSoalUser', [App\Http\Controllers\PaketUserController::class, 'getPaketSoalUser']);



    Route::get('memberuser/{id}', [App\Http\Controllers\MemberUserController::class, 'index']);

    Route::post('storememberuser', [App\Http\Controllers\MemberUserController::class, 'store']);

    Route::post('/hapusmemberuser/{id}', [App\Http\Controllers\MemberUserController::class, 'destroy']);

    Route::post('getPaketSoalUser', [App\Http\Controllers\MemberUserController::class, 'getPaketSoalUser']);



    Route::get('/profil', [App\Http\Controllers\ProfilController::class, 'profil']);



    Route::get('/affiliate', [App\Http\Controllers\UserListController::class, 'affiliate']);

    Route::get('/affiliatedtl/{id}', [App\Http\Controllers\UserListController::class, 'affiliatedtl']);

    Route::get('/user', [App\Http\Controllers\UserListController::class, 'index']);

    Route::post('/storeuserlist', [App\Http\Controllers\UserListController::class, 'store']);

    Route::post('/updateuserlist/{id}', [App\Http\Controllers\UserListController::class, 'update']);

    Route::post('/hapususerlist/{id}', [App\Http\Controllers\UserListController::class, 'destroy']);

    Route::post('/resetuserpass', [App\Http\Controllers\UserListController::class, 'reset']);



    Route::get('/lihathasilujian/{id}', [App\Http\Controllers\UserListController::class, 'lihathasilujian']);

    // Route::get('lihatdetailhasil/{id}', [App\Http\Controllers\UserListController::class, 'lihatdetailhasil']);

    // Route::get('lihatdetailhasilkecermatan/{id}', [App\Http\Controllers\UserListController::class, 'lihatdetailhasilkecermatan']);



    // PDF

    Route::get('/exportsoal/{jns}/{id}', [App\Http\Controllers\PDFController::class, 'exportsoal']);

});

Route::middleware([IsAdmin::class])->group(function () {

    // Kategori Soal

    Route::get('kategorisoal', [App\Http\Controllers\KategoriSoalController::class, 'index']);

    Route::post('storekategorisoal', [App\Http\Controllers\KategoriSoalController::class, 'store']);

    Route::post('/updatekategorisoal/{id}', [App\Http\Controllers\KategoriSoalController::class, 'update']);

    Route::post('/hapuskategorisoal/{id}', [App\Http\Controllers\KategoriSoalController::class, 'destroy']);



    // Paket Kategori

    Route::get('paketkategori', [App\Http\Controllers\PaketKategoriController::class, 'index']);

    Route::post('storepaketkategori', [App\Http\Controllers\PaketKategoriController::class, 'store']);

    Route::post('/updatepaketkategori/{id}', [App\Http\Controllers\PaketKategoriController::class, 'update']);

    Route::post('/hapuspaketkategori/{id}', [App\Http\Controllers\PaketKategoriController::class, 'destroy']);



    // Paket Kategori

    Route::get('paketsubkategori/{id}', [App\Http\Controllers\PaketSubkategoriController::class, 'index']);

    Route::post('storepaketsubkategori', [App\Http\Controllers\PaketSubkategoriController::class, 'store']);

    Route::post('/updatepaketsubkategori/{id}', [App\Http\Controllers\PaketSubkategoriController::class, 'update']);

    Route::post('/hapuspaketsubkategori/{id}', [App\Http\Controllers\PaketSubkategoriController::class, 'destroy']);



    // Kategori Soal Kecermatan

    Route::get('kategorisoalkecermatan', [App\Http\Controllers\KategoriSoalKecermatanController::class, 'index']);

    Route::post('storekategorisoalkecermatan', [App\Http\Controllers\KategoriSoalKecermatanController::class, 'store']);

    Route::post('/updatekategorisoalkecermatan/{id}', [App\Http\Controllers\KategoriSoalKecermatanController::class, 'update']);

    Route::post('/hapuskategorisoalkecermatan/{id}', [App\Http\Controllers\KategoriSoalKecermatanController::class, 'destroy']);

    // Kategori Soal

    Route::get('masterrekening', [App\Http\Controllers\MasterRekeningController::class, 'index']);

    Route::post('storemasterrekening', [App\Http\Controllers\MasterRekeningController::class, 'store']);

    Route::post('/updatemasterrekening/{id}', [App\Http\Controllers\MasterRekeningController::class, 'update']);

    Route::post('/hapusmasterrekening/{id}', [App\Http\Controllers\MasterRekeningController::class, 'destroy']);

    // Master Soal

    Route::get('mastersoal/{idkategori}', [App\Http\Controllers\MasterSoalController::class, 'index']);

    Route::post('storemastersoal', [App\Http\Controllers\MasterSoalController::class, 'store']);

    Route::get('editmastersoal/{idkategori}/{id}', [App\Http\Controllers\MasterSoalController::class, 'edit']);

    Route::post('/updatemastersoal/{id}', [App\Http\Controllers\MasterSoalController::class, 'update']);

    Route::post('/hapusmastersoal/{id}', [App\Http\Controllers\MasterSoalController::class, 'destroy']);

    Route::post('/hapusmastersoalall', [App\Http\Controllers\MasterSoalController::class, 'destroyall']);

    Route::post('importsoal', [App\Http\Controllers\MasterSoalController::class, 'importsoal']);

    // Master Soal Kecermatan

    Route::get('mastersoalkecermatan/{idkategori}', [App\Http\Controllers\MasterSoalKecermatanController::class, 'index']);

    Route::post('storemastersoalkecermatan', [App\Http\Controllers\MasterSoalKecermatanController::class, 'store']);

    Route::post('/updatemastersoalkecermatan/{id}', [App\Http\Controllers\MasterSoalKecermatanController::class, 'update']);

    Route::post('/hapusmastersoalkecermatan/{id}', [App\Http\Controllers\MasterSoalKecermatanController::class, 'destroy']);

    // Dtl Soal Kecermatan

    Route::get('dtlsoalkecermatan/{idmaster}', [App\Http\Controllers\DtlSoalKecermatanController::class, 'index']);

    Route::post('storedtlsoalkecermatan', [App\Http\Controllers\DtlSoalKecermatanController::class, 'store']);

    Route::post('/updatedtlsoalkecermatan/{id}', [App\Http\Controllers\DtlSoalKecermatanController::class, 'update']);

    Route::post('/hapusdtlsoalkecermatan/{id}', [App\Http\Controllers\DtlSoalKecermatanController::class, 'destroy']);

    // Paket Soal Pilihan Ganda

    Route::get('paketsoalmst', [App\Http\Controllers\PaketSoalMstController::class, 'index']);

    Route::post('storepaketsoalmst', [App\Http\Controllers\PaketSoalMstController::class, 'store']);

    Route::post('/updatepaketsoalmst/{id}', [App\Http\Controllers\PaketSoalMstController::class, 'update']);

    Route::post('/hapuspaketsoalmst/{id}', [App\Http\Controllers\PaketSoalMstController::class, 'destroy']);

    Route::get('rankingpeserta/{id}', [App\Http\Controllers\PaketSoalMstController::class, 'rankingpeserta']);

    Route::post('/updateranking/{id}', [App\Http\Controllers\PaketSoalMstController::class, 'updateranking']);



    Route::get('pakethadiah/{id}', [App\Http\Controllers\PaketSoalMstController::class, 'pakethadiah']);

    Route::post('storepakethadiah', [App\Http\Controllers\PaketSoalMstController::class, 'storehadiah']);

    Route::post('updatepakethadiah', [App\Http\Controllers\PaketSoalMstController::class, 'updatehadiah']);

    Route::post('hapuspakethadiah', [App\Http\Controllers\PaketSoalMstController::class, 'destroyhadiah']);



    // Paket Soal Kecermatan

    Route::get('paketsoalkecermatan', [App\Http\Controllers\PaketSoalKecermatanController::class, 'index']);

    Route::post('storepaketsoalkecermatan', [App\Http\Controllers\PaketSoalKecermatanController::class, 'store']);

    Route::post('/updatepaketsoalkecermatan/{id}', [App\Http\Controllers\PaketSoalKecermatanController::class, 'update']);

    Route::post('/hapuspaketsoalkecermatan/{id}', [App\Http\Controllers\PaketSoalKecermatanController::class, 'destroy']);



    Route::get('paketsoalktg/{id}', [App\Http\Controllers\PaketSoalMstController::class, 'indexktg']);

    Route::post('storepaketsoalktg', [App\Http\Controllers\PaketSoalMstController::class, 'storektg']);

    Route::post('/updatepaketsoalktg/{id}', [App\Http\Controllers\PaketSoalMstController::class, 'updatektg']);

    Route::post('/hapuspaketsoalktg/{id}', [App\Http\Controllers\PaketSoalMstController::class, 'destroyktg']);



    Route::get('paketsoaldtl/{id}', [App\Http\Controllers\PaketSoalMstController::class, 'indexdtl']);

    Route::post('storepaketsoaldtl/{idmst}/{idktg}', [App\Http\Controllers\PaketSoalMstController::class, 'storedtl']);

    Route::post('/updatepaketsoaldtl/{id}', [App\Http\Controllers\PaketSoalMstController::class, 'updatedtl']);

    Route::post('/hapuspaketsoaldtl/{id}', [App\Http\Controllers\PaketSoalMstController::class, 'destroydtl']);



    Route::get('paketsoalkecermatandtl/{id}', [App\Http\Controllers\PaketSoalKecermatanController::class, 'indexdtl']);

    Route::post('storepaketsoalkecermatandtl/{idmst}', [App\Http\Controllers\PaketSoalKecermatanController::class, 'storedtl']);

    Route::post('/updatepaketsoalkecermatandtl/{id}', [App\Http\Controllers\PaketSoalKecermatanController::class, 'updatedtl']);

    Route::post('/hapuspaketsoalkecermatandtl/{id}', [App\Http\Controllers\PaketSoalKecermatanController::class, 'destroydtl']);



    // Event Mst

    Route::get('paketmst', [App\Http\Controllers\PaketMstController::class, 'index']);

    Route::post('storeeventmst', [App\Http\Controllers\PaketMstController::class, 'store']);

    Route::post('/updateeventmst/{id}', [App\Http\Controllers\PaketMstController::class, 'update']);

    Route::post('/hapuseventmst/{id}', [App\Http\Controllers\PaketMstController::class, 'destroy']);



    // Kode Potongan

    Route::get('kodepotongan', [App\Http\Controllers\KodePotonganController::class, 'index']);

    Route::post('storekodepotongan', [App\Http\Controllers\KodePotonganController::class, 'store']);

    Route::post('/updatekodepotongan', [App\Http\Controllers\KodePotonganController::class, 'update']);

    Route::post('/hapuskodepotongan', [App\Http\Controllers\KodePotonganController::class, 'destroy']);



    // Informasi

    Route::get('informasi', [App\Http\Controllers\InformasiController::class, 'index']);

    Route::post('storeinformasi', [App\Http\Controllers\InformasiController::class, 'store']);

    Route::post('/updateinformasi', [App\Http\Controllers\InformasiController::class, 'update']);

    Route::post('/hapusinformasi', [App\Http\Controllers\InformasiController::class, 'destroy']);



    Route::get('pesertaevent/{id}', [App\Http\Controllers\PaketMstController::class, 'pesertaevent']);

    Route::post('ingatkanpeserta', [App\Http\Controllers\PaketMstController::class, 'ingatkanpeserta']);



    // Event Dtl

    Route::get('paketdtl/{idpaket}', [App\Http\Controllers\PaketMstController::class, 'indexdtl']);

    Route::post('storeeventdtl', [App\Http\Controllers\PaketMstController::class, 'storedtl']);

    Route::post('/updateeventdtl/{id}', [App\Http\Controllers\PaketMstController::class, 'updatedtl']);

    Route::post('/hapuseventdtl/{id}', [App\Http\Controllers\PaketMstController::class, 'destroydtl']);

    // Route::post('getPaketSoal/{idevent}', [App\Http\Controllers\PaketMstController::class, 'getPaketSoal']);



    // Event Syarat

    Route::get('paketfitur/{idpaket}', [App\Http\Controllers\PaketMstController::class, 'indexfitur']);

    Route::post('storepaketfitur', [App\Http\Controllers\PaketMstController::class, 'storefitur']);

    Route::post('/updatepaketfitur/{id}', [App\Http\Controllers\PaketMstController::class, 'updatefitur']);

    Route::post('/hapuspaketfitur/{id}', [App\Http\Controllers\PaketMstController::class, 'destroyfitur']);



    // Paket Video

    Route::get('paketmateri/{idpaket}', [App\Http\Controllers\PaketMateriController::class, 'index']);

    Route::post('storepaketmateri', [App\Http\Controllers\PaketMateriController::class, 'store']);

    Route::post('/updatepaketmateri/{id}', [App\Http\Controllers\PaketMateriController::class, 'update']);

    Route::post('/hapuspaketmateri/{id}', [App\Http\Controllers\PaketMateriController::class, 'destroy']);



    // Paket Zoom

    Route::get('paketzoom/{idpaket}', [App\Http\Controllers\PaketZoomController::class, 'index']);

    Route::post('storepaketzoom', [App\Http\Controllers\PaketZoomController::class, 'store']);

    Route::post('/updatepaketzoom/{id}', [App\Http\Controllers\PaketZoomController::class, 'update']);

    Route::post('/hapuspaketzoom/{id}', [App\Http\Controllers\PaketZoomController::class, 'destroy']);



    Route::get('lihattransaksi/{id}', [App\Http\Controllers\UserListController::class, 'lihattransaksi']);

    Route::get('lihatsyarat/{userid}/{id}', [App\Http\Controllers\UserListController::class, 'lihatsyarat']);

    Route::post('/updatestatuspembayaran/{id}', [App\Http\Controllers\UserListController::class, 'updatestatuspembayaran']);

    Route::post('/updatestatushadiah/{id}', [App\Http\Controllers\UserListController::class, 'updatestatushadiah']);



    Route::get('listtransaksi/{jenis}', [App\Http\Controllers\UserListController::class, 'listtransaksi']);

    Route::post('/hapustransaksi/{jenis}/{id}', [App\Http\Controllers\UserListController::class, 'hapustransaksi']);



    Route::get('template', [App\Http\Controllers\AdminController::class, 'tmp']);

    Route::post('/updatetemplate/{id}', [App\Http\Controllers\AdminController::class, 'updatetmp']);



});



Route::middleware([IsUser::class])->group(function () {

    // User

    Route::get('tambahalamat', [App\Http\Controllers\UserController::class, 'tambahalamat']);

    Route::post('getalamat', [App\Http\Controllers\CampurController::class, 'getalamat']);

    Route::get('ubahalamat/{id}', [App\Http\Controllers\UserController::class, 'ubahalamat']);

    Route::get('listalamat', [App\Http\Controllers\UserController::class, 'listalamat']);

    Route::post('simpanalamat', [App\Http\Controllers\UserController::class, 'simpanalamat']);

    Route::post('updatealamat', [App\Http\Controllers\UserController::class, 'updatealamat']);

    Route::post('hapusalamat', [App\Http\Controllers\UserController::class, 'hapusalamat']);

    Route::post('getprovinsiro', [App\Http\Controllers\CampurController::class, 'getprovinsiro']);

    Route::post('daftar/{id}', [App\Http\Controllers\UserController::class, 'daftar']);

    Route::post('cekongkir', [App\Http\Controllers\UserController::class, 'cekongkir']);

    Route::get('paketdetail/{id}', [App\Http\Controllers\UserController::class, 'index']);

    Route::get('checkout/{id}', [App\Http\Controllers\UserController::class, 'checkout']);

    Route::get('paketsayadetail/{id}', [App\Http\Controllers\UserController::class, 'paketsayadtl']);

    Route::post('cekkode', [App\Http\Controllers\UserController::class, 'cekkode']);

    Route::get('tryout', [App\Http\Controllers\UserController::class, 'tryout']);

    Route::get('profileuser', [App\Http\Controllers\UserController::class, 'profileuser']);

    Route::post('updateBuktiBayar', [App\Http\Controllers\UserController::class, 'updatebuktibayar']);

    Route::post('createorder', [App\Http\Controllers\PaymentController::class, 'createorder']);

    Route::post('createorderipaymu', [App\Http\Controllers\PaymentController::class, 'createorderipaymu']);

    Route::post('createordertripay', [App\Http\Controllers\PaymentController::class, 'createordertripay']);

    // Route::post('createorderhadiah', [App\Http\Controllers\PaymentController::class, 'createorderhadiah']);

    Route::get('detailbayar/{id}', [App\Http\Controllers\PaymentController::class, 'detailbayar']);

    Route::get('pembelian', [App\Http\Controllers\UserController::class, 'pembelian']);

    Route::get('jadwal', [App\Http\Controllers\UserController::class, 'jadwal']);

    Route::get('belipaketktg', [App\Http\Controllers\UserController::class, 'belipaketktg']);

    Route::get('paketsayaktg', [App\Http\Controllers\UserController::class, 'paketsayaktg']);

    Route::get('belipaketsubktg/{id}', [App\Http\Controllers\UserController::class, 'belipaketsubktg']);

    Route::post('caripaketsubktg', [App\Http\Controllers\UserController::class, 'caripaketsubktg']);

    Route::get('paketsayasubktg/{id}', [App\Http\Controllers\UserController::class, 'paketsayasubktg']);

    Route::get('belipaket/{id}', [App\Http\Controllers\UserController::class, 'belipaket']);

    Route::get('informasidtl/{id}', [App\Http\Controllers\UserController::class, 'informasidtl']);

    Route::get('voucherdtl/{id}', [App\Http\Controllers\UserController::class, 'voucherdtl']);

    Route::get('paketsaya/{id}', [App\Http\Controllers\UserController::class, 'paketsaya']);
    
    Route::get('paketgratis', [App\Http\Controllers\UserController::class, 'paketgratis']);

    Route::post('cekujian', [App\Http\Controllers\UserController::class, 'cekujian']);

    Route::post('/mulaiujian/{id}', [App\Http\Controllers\UserController::class, 'mulaiujian']);

    Route::get('/klaimhadiah/{id}', [App\Http\Controllers\UserController::class, 'klaimhadiah']);

    Route::post('batalkanpesanan', [App\Http\Controllers\UserController::class, 'batalkanpesanan']);

    Route::post('hapuskeranjang', [App\Http\Controllers\UserController::class, 'hapuskeranjang']);

    Route::get('keranjangku', [App\Http\Controllers\UserController::class, 'keranjangku']);

    Route::post('/mulaiujiankecermatan/{id}', [App\Http\Controllers\UserController::class, 'mulaiujiankecermatan']);

    Route::get('ujian/{id}', [App\Http\Controllers\UserController::class, 'ujian']);

    // Route::get('ujiankecermatan/{id}', [App\Http\Controllers\UserController::class, 'ujiankecermatan']);

    Route::post('updatejawaban', [App\Http\Controllers\UserController::class, 'updatejawaban']);

    Route::post('updatejawabankecermatan', [App\Http\Controllers\UserController::class, 'updatejawabankecermatan']);

    Route::get('hasilujian', [App\Http\Controllers\UserController::class, 'hasilujian']);

    Route::post('selesaiujian', [App\Http\Controllers\UserController::class, 'selesaiujian']);

    Route::post('selesaiujiankecermatan', [App\Http\Controllers\UserController::class, 'selesaiujiankecermatan']);

    Route::post('selesaiujiankecermatanfix', [App\Http\Controllers\UserController::class, 'selesaiujiankecermatanfix']);





});





// User List

// Route::get('/userlist', [App\Http\Controllers\UserListController::class, 'index']);

// Route::post('/storeuserlist', [App\Http\Controllers\UserListController::class, 'store']);

// Route::post('/updateuserlist/{id}', [App\Http\Controllers\UserListController::class, 'update']);

// Route::post('/hapususerlist/{id}', [App\Http\Controllers\UserListController::class, 'destroy']);

// Route::post('/resetuserpass', [App\Http\Controllers\UserListController::class, 'reset']);



// User Role

// Route::get('/userrole', [App\Http\Controllers\UserRoleController::class, 'index']);

// Route::post('/storeuserrole', [App\Http\Controllers\UserRoleController::class, 'store']);

// Route::post('/updateuserrole/{id}', [App\Http\Controllers\UserRoleController::class, 'update']);

// Route::post('/hapususerrole/{id}', [App\Http\Controllers\UserRoleController::class, 'destroy']);

Route::post('getkabupatenro', [App\Http\Controllers\CampurController::class, 'getkabupatenro']);

Route::post('getKabupaten', [App\Http\Controllers\CampurController::class, 'getKabupaten']);

Route::post('getKecamatan', [App\Http\Controllers\CampurController::class, 'getKecamatan']);

Route::post('getsubkategori', [App\Http\Controllers\CampurController::class, 'getsubkategori']);

// Auth::routes(); 

// Auth::routes(['login' => false]);       

Auth::routes(['register' => false]);       



// Route::group(['middleware' => 'IsAdmin'], function () {

    

// });







