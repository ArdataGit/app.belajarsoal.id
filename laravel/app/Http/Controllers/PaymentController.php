<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\PaketMst;
use App\Models\Transaksi;
use App\Models\KodePotongan;
use App\Models\Keranjang;
use App\Models\MasterRekening;
use App\Models\User;
use App\Models\UserAlamat;
use Carbon\Carbon;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use Auth;
use Illuminate\Support\Facades\Response;

class PaymentController extends Controller {
    // private $apiKey;
    // private $merchantId;
    // private $linkcallback;
    // private $sandboxmode;

    public function __construct() {
        $this->apiKey = env('DUITKU_APIKEY');
        $this->merchantId = env('DUITKU_MERCHANTID');
        $this->linkcallback = env('DUITKU_CALLBACK');
        $this->sandboxmode = env('DUITKU_SANDBOX_MODE');

        $this->ipaymu_va = env('IPAYMU_VA');
        $this->ipaymu_apikey = env('IPAYMU_APIKEY');
        $this->ipaymu_isproduction = env('IPAYMU_ISPRODUCTION');
        $this->ipaymu_callback = env('IPAYMU_CALLBACK');

        $this->tripay_privatekey = env('TRIPAY_PRIVATEKEY');
        $this->tripay_apikey = env('TRIPAY_APIKEY');
        $this->tripay_isproduction = env('TRIPAY_ISPRODUCTION');
        $this->tripay_callback = env('TRIPAY_CALLBACK');
        $this->tripay_kodemerchant = env('TRIPAY_KODEMERCHANT');
    }
    // public function createorder(Request $request)
    // {
    //     $mastermemberid = Crypt::decrypt($request->mastermemberid);
    //     $mastermember = MasterMember::find($mastermemberid);
    //     $merchantOrderId    = time();

    //     $responcreate['merchant_order_id'] = $merchantOrderId;
    //     $responcreate['fk_user_id'] = Auth::id();
    //     $responcreate['fk_master_member_id'] = $mastermember->id;
    //     $responcreate['harga'] = $mastermember->harga;
    //     $responcreate['status'] = 0;
    //     $responcreate['expired'] = Carbon::now()->addMinutes(180)->toDateTimeString();
    //     $responcreate['created_by'] = Auth::id();
    //     $responcreate['created_at'] = Carbon::now()->toDateTimeString();
    //     $responcreate['updated_by'] = Auth::id();
    //     $responcreate['updated_at'] = Carbon::now()->toDateTimeString();
    //     $createdata = Transaksi::create($responcreate);
    //     if($createdata){
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Halaman akan diarahakan otomatis. Mohon Tunggu...',
    //             'id' => Crypt::encrypt($createdata->id)
    //         ]);
    //     }else{
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Gagal, mohon coba kembali !'
    //         ]);
    //     }

    // }
    public function createordermanual(Request $request) {
        $idpaket = Crypt::decrypt($request->idpaket);

        if ($request->idpromo) {
            $idpromo = Crypt::decrypt($request->idpromo);
            $cekkode = KodePotongan::find($idpromo);
        } else {
            $cekkode = null;
        }
        $paket = PaketMst::findOrFail($idpaket);
        $total = $paket->harga;
        if ($cekkode) {
            $fkpromo = $cekkode->id;
            if ($cekkode->tipe == 2) {
                $potongan = $paket->harga * $cekkode->jumlah / 100;
            } else {
                $potongan = $cekkode->jumlah;
            }
            $total = $paket->harga - $potongan;
            if ($total < 20000) {
                $total = 20000;
            } else {
                $total = $total;
            }
        } else {
            $fkpromo = null;
        }

        $total += $request->angkaunik;

        $merchantOrderId = 'Manual-' . time() . $request->angkaunik;

        $responcreate['merchant_order_id'] = $merchantOrderId;
        $responcreate['fk_user_id'] = Auth::id();
        $responcreate['fk_promo_id'] = $fkpromo;
        $responcreate['fk_user_alamat'] = Auth::user()->kecamatan_r ? Auth::user()->kecamatan_r->nama : '-';
        $responcreate['fk_paket_mst'] = $paket->id;
        $responcreate['fk_paket_kategori'] = $paket->fk_paket_kategori;
        $responcreate['fk_paket_subkategori'] = $paket->fk_paket_subkategori;
        $responcreate['harga_normal'] = $paket->harga;
        $responcreate['harga'] = $total;
        $responcreate['status'] = 0;
        $responcreate['expired'] = Carbon::now()->addMinutes(1440)->toDateTimeString();
        $responcreate['aktif_sampai'] = Carbon::now()->addMonths(6)->toDateTimeString();
        $responcreate['created_by'] = Auth::id();
        $responcreate['created_at'] = Carbon::now()->toDateTimeString();
        $responcreate['updated_by'] = Auth::id();
        $responcreate['updated_at'] = Carbon::now()->toDateTimeString();

        //     $responcreate['merchant_order_id'] = $merchantOrderId;
        //     $responcreate['fk_user_id'] = Auth::id();
        //     $responcreate['fk_master_member_id'] = $mastermember->id;
        //     $responcreate['harga'] = $mastermember->harga;
        //     $responcreate['status'] = 0;
        //     $responcreate['expired'] = Carbon::now()->addMinutes(180)->toDateTimeString();
        //     $responcreate['created_by'] = Auth::id();
        //     $responcreate['created_at'] = Carbon::now()->toDateTimeString();
        //     $responcreate['updated_by'] = Auth::id();
        //     $responcreate['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = Transaksi::create($responcreate);

        if ($createdata) {
            return response()->json([
                'success' => true,
                'message' => 'Pesanan Berhasil Diproses, Mohon Tunggu...',
                'url' => route('panduanpembayaran', ['id' => $merchantOrderId])
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan Gagal Diproses, Silahkan Coba Lagi...'
            ]);
        }
    }
    public function createorder(Request $request) {
        $idpaket = Crypt::decrypt($request->idpaket);
        // $ceksudahbeli = Transaksi::where('fk_paket_mst',$idpaket)->where('status',1)->where('fk_user_id',Auth::id())->first();
        // if($ceksudahbeli){
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Paket sudah dibeli'
        //     ]);
        //     dd('Error');
        // }
        if ($request->idpromo) {
            $idpromo = Crypt::decrypt($request->idpromo);
            $cekkode = KodePotongan::find($idpromo);
        } else {
            $cekkode = null;
        }
        $paket = PaketMst::findOrFail($idpaket);
        $total = $paket->harga;
        if ($cekkode) {
            $fkpromo = $cekkode->id;
            if ($cekkode->tipe == 2) {
                $potongan = $paket->harga * $cekkode->jumlah / 100;
            } else {
                $potongan = $cekkode->jumlah;
            }
            $total = $paket->harga - $potongan;
            if ($total < 20000) {
                $total = 20000;
            } else {
                $total = $total;
            }
        } else {
            $fkpromo = null;
        }
        // $jumlah = $request->jumlah;
        // $ongkir = $request->ongkir;
        // $id_alamat = $request->id_alamat;
        // $id_paket = $request->id_paket;
        // $id_keranjang = $request->id_keranjang;
        // $data_alamat = UserAlamat::find($id_alamat);


        $user = User::find(Auth::id());



        $duitkuConfig = new \Duitku\Config($this->apiKey, $this->merchantId);
        $duitkuConfig->setSandboxMode($this->sandboxmode);
        $paymentAmount      = $total; // Amount
        $hargaNormal      = $paket->harga; // Amount
        $email              = Auth::user()->email; // your customer email
        $phoneNumber        = Auth::user()->no_wa; // your customer phone number (optional)
        $productDetails     = "Pembelian Paket " . $paket->subkategori_r->judul;
        $merchantOrderId    = time(); // from merchant, unique
        $additionalParam    = ''; // optional
        $merchantUserInfo   = ''; // optional
        $customerVaName     = Auth::user()->name; // display name on bank confirmation display
        $callbackUrl        = $this->linkcallback; // url for callback
        $returnUrl          = url('transaksi'); // url for redirect
        $expiryPeriod       = 180; // set the expired time in minutes

        // Customer Detail
        $firstName          = Auth::user()->name;
        $lastName           = "";

        // Address
        $alamat             = Auth::user()->provinsi_r ? Auth::user()->provinsi_r->nama : '-';
        // $daftarKota = RajaOngkir::kota()->find($data_alamat->fk_kabupaten);
        $city               = Auth::user()->kabupaten_r ? Auth::user()->kabupaten_r->nama : '-';
        $postalCode         = '12345';
        $countryCode        = "ID";

        $address = array(
            'firstName'     => $firstName,
            'lastName'      => $lastName,
            'address'       => $alamat,
            'city'          => $city,
            'postalCode'    => $postalCode,
            'phone'         => $phoneNumber,
            'countryCode'   => $countryCode
        );

        $customerDetail = array(
            'firstName'         => $firstName,
            'lastName'          => $lastName,
            'email'             => $email,
            'phoneNumber'       => $phoneNumber
            // 'billingAddress'    => $address,
            // 'shippingAddress'   => $address
        );



        // Item Details
        $item1 = array(
            'name'      => $paket->judul,
            'price'     => $total,
            'quantity'  => 1
        );

        $itemDetails = array(
            $item1
        );
        // $item2 = array(
        //     'name'      => $productDetails,
        //     'price'     => 400000,
        //     'quantity'  => 1
        // );

        // $itemDetails = array(
        //     $item1,$item2
        // );

        $params = array(
            'paymentAmount'     => $paymentAmount,
            'merchantOrderId'   => $merchantOrderId,
            'productDetails'    => $productDetails,
            'additionalParam'   => $additionalParam,
            'merchantUserInfo'  => $merchantUserInfo,
            'customerVaName'    => $customerVaName,
            'email'             => $email,
            'phoneNumber'       => $phoneNumber,
            'itemDetails'       => $itemDetails,
            'customerDetail'    => $customerDetail,
            'callbackUrl'       => $callbackUrl,
            'returnUrl'         => $returnUrl,
            'expiryPeriod'      => $expiryPeriod
        );

        try {
            // createInvoice Request
            $responseDuitkuPop = \Duitku\Pop::createInvoice($params, $duitkuConfig);
            $datarespon = json_decode($responseDuitkuPop);
            $responcreate['payment_url'] = $datarespon->paymentUrl;
            $responcreate['reference'] = $datarespon->reference;
            $responcreate['merchant_order_id'] = $merchantOrderId;
            $responcreate['fk_user_id'] = Auth::id();
            $responcreate['fk_promo_id'] = $fkpromo;
            $responcreate['fk_user_alamat'] = $alamat;
            $responcreate['fk_paket_mst'] = $paket->id;
            $responcreate['fk_paket_kategori'] = $paket->fk_paket_kategori;
            $responcreate['fk_paket_subkategori'] = $paket->fk_paket_subkategori;
            $responcreate['harga_normal'] = $hargaNormal;
            $responcreate['harga'] = $paymentAmount;
            $responcreate['status'] = 0;
            $responcreate['expired'] = Carbon::now()->addMinutes(180)->toDateTimeString();
            $responcreate['aktif_sampai'] = Carbon::now()->addYears(1)->toDateTimeString();
            $responcreate['created_by'] = Auth::id();
            $responcreate['created_at'] = Carbon::now()->toDateTimeString();
            $responcreate['updated_by'] = Auth::id();
            $responcreate['updated_at'] = Carbon::now()->toDateTimeString();
            $createdata = Transaksi::create($responcreate);

            // foreach($id_keranjang as $updatekeranjang){
            //     $id_kerjng = Crypt::decrypt($updatekeranjang);
            //     $updatedataker['status'] = 1;
            //     Keranjang::find($id_kerjng)->update($updatedataker);
            // }
            header('Content-Type: application/json');
            echo $responseDuitkuPop;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function createorderipaymu(Request $request) {

        $idpaket = Crypt::decrypt($request->idpaket);
        // $ceksudahbeli = Transaksi::where('fk_paket_mst',$idpaket)->where('status',1)->where('fk_user_id',Auth::id())->first();
        // if($ceksudahbeli){
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Paket sudah dibeli'
        //     ]);
        //     dd('Error');
        // }
        if ($request->idpromo) {
            $idpromo = Crypt::decrypt($request->idpromo);
            $cekkode = KodePotongan::find($idpromo);
        } else {
            $cekkode = null;
        }
        $paket = PaketMst::findOrFail($idpaket);
        $total = $paket->harga;
        if ($cekkode) {
            $fkpromo = $cekkode->id;
            if ($cekkode->tipe == 2) {
                $potongan = $paket->harga * $cekkode->jumlah / 100;
            } else {
                $potongan = $cekkode->jumlah;
            }
            $total = $paket->harga - $potongan;
            if ($total < 20000) {
                $total = 20000;
            } else {
                $total = $total;
            }
        } else {
            $fkpromo = null;
        }


        // SAMPLE HIT API iPaymu v2 PHP //

        $va           = $this->ipaymu_va; //get on iPaymu dashboard
        $apiKey       = $this->ipaymu_apikey; //get on iPaymu dashboard
        if ($this->ipaymu_isproduction) {
            $url          = 'https://my.ipaymu.com/api/v2/payment'; // for production mode
        } else {
            $url          = 'https://sandbox.ipaymu.com/api/v2/payment'; // for development mode
        }

        $method       = 'POST'; //method

        //Request Body//
        $body['product']    = array($paket->judul);
        $body['qty']        = array('1');
        $body['price']      = array($total);
        $body['returnUrl']  = url('pembelian');
        $body['cancelUrl']  = url('belipaket');
        $body['notifyUrl']  = $this->ipaymu_callback;
        $body['referenceId'] = 'Ipy-' . time(); //your reference id
        //End Request Body//

        //Generate Signature
        // *Don't change this
        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ':' . $va . ':' . $requestBody . ':' . $apiKey;
        $signature    = hash_hmac('sha256', $stringToSign, $apiKey);
        $timestamp    = Date('YmdHis');
        //End Generate Signature

        $ch = curl_init($url);

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'va: ' . $va,
            'signature: ' . $signature,
            'timestamp: ' . $timestamp
        );

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_POST, count($body));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $err = curl_error($ch);
        $ret = curl_exec($ch);
        curl_close($ch);

        if ($err) {
            echo $err;
        } else {
            //Response
            $ret = json_decode($ret);

            if ($ret->Status == 200) {
                $sessionId  = $ret->Data->SessionID;
                $url        =  $ret->Data->Url;

                $responcreate['payment_url'] = $url;
                $responcreate['reference'] = $sessionId;
                $responcreate['merchant_order_id'] = $body['referenceId'];
                $responcreate['fk_user_id'] = Auth::id();
                $responcreate['fk_promo_id'] = $fkpromo;
                $responcreate['fk_user_alamat'] = Auth::user()->provinsi_r ? Auth::user()->provinsi_r->nama : '-';
                $responcreate['fk_paket_mst'] = $paket->id;
                $responcreate['fk_paket_kategori'] = $paket->fk_paket_kategori;
                $responcreate['fk_paket_subkategori'] = $paket->fk_paket_subkategori;
                $responcreate['harga_normal'] = $paket->harga;
                $responcreate['harga'] = $total;
                $responcreate['status'] = 0;
                $responcreate['expired'] = Carbon::now()->addMinutes(1440)->toDateTimeString();
                $responcreate['aktif_sampai'] = Carbon::now()->addYears(1)->toDateTimeString();
                $responcreate['created_by'] = Auth::id();
                $responcreate['created_at'] = Carbon::now()->toDateTimeString();
                $responcreate['updated_by'] = Auth::id();
                $responcreate['updated_at'] = Carbon::now()->toDateTimeString();
                $createdata = Transaksi::create($responcreate);

                return response()->json([
                    'status' => true,
                    'message' => 'Pesanan Berhasil Diproses, Mohon Tunggu...',
                    'url' => $url
                ]);
            } else {
                // echo $ret;
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal. Mohon coba kembali!'
                ]);
            }
            //End Response
        }
    }

    public function createordertripay(Request $request) {

        $idpaket = Crypt::decrypt($request->idpaket);
        // $ceksudahbeli = Transaksi::where('fk_paket_mst',$idpaket)->where('status',1)->where('fk_user_id',Auth::id())->first();
        // if($ceksudahbeli){
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Paket sudah dibeli'
        //     ]);
        //     dd('Error');
        // }
        if ($request->idpromo) {
            $idpromo = Crypt::decrypt($request->idpromo);
            $cekkode = KodePotongan::find($idpromo);
        } else {
            $cekkode = null;
        }
        $paket = PaketMst::findOrFail($idpaket);
        $total = $paket->harga;
        if ($cekkode) {
            $fkpromo = $cekkode->id;
            if ($cekkode->tipe == 2) {
                $potongan = $paket->harga * $cekkode->jumlah / 100;
            } else {
                $potongan = $cekkode->jumlah;
            }
            $total = $paket->harga - $potongan;
            if ($total < 20000) {
                $total = 20000;
            } else {
                $total = $total;
            }
        } else {
            $fkpromo = null;
        }

        $apiKey       = $this->tripay_apikey;
        $privateKey   = $this->tripay_privatekey;
        $merchantCode = $this->tripay_kodemerchant;
        $tripay_isproduction = $this->tripay_isproduction;
        $merchantRef  = 'Tri-' . time();
        $amount       = $total;
        $channel = $request->channel;

        if ($tripay_isproduction) {
            $linkcreate = "https://tripay.co.id/api/transaction/create";
        } else {
            $linkcreate = "https://tripay.co.id/api-sandbox/transaction/create";
        }

        $data = [
            'method'         => $channel,
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => Auth::user()->name ?: '-',
            'customer_email' => Auth::user()->email ?: '-',
            'customer_phone' => Auth::user()->no_wa ?: '-',
            'order_items'    => [
                [
                    'sku'         => 'PK-' . $paket->id,
                    'name'        => $paket->judul,
                    'price'       => $amount,
                    'quantity'    => 1,
                    'product_url' => $request->urlpaket,
                    'image_url'   => asset($paket->banner),
                ]
            ],
            'return_url'   => url('pembelian'),
            'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
            'signature'    => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => $linkcreate,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            echo $error;
        } else {
            $ret = json_decode($response);

            if ($ret->success) {
                $ref = $ret->data->reference;
                $url_checkout = $ret->data->checkout_url;
                $responcreate['payment_url'] = $url_checkout;
                $responcreate['reference'] = $ref;
                $responcreate['merchant_order_id'] = $merchantRef;
                $responcreate['fk_user_id'] = Auth::id();
                $responcreate['fk_promo_id'] = $fkpromo;
                $responcreate['fk_user_alamat'] = Auth::user()->kecamatan_r ? Auth::user()->kecamatan_r->nama : '-';
                $responcreate['fk_paket_mst'] = $paket->id;
                $responcreate['fk_paket_kategori'] = $paket->fk_paket_kategori;
                $responcreate['fk_paket_subkategori'] = $paket->fk_paket_subkategori;
                $responcreate['harga_normal'] = $paket->harga;
                $responcreate['harga'] = $total;
                $responcreate['channel'] = $channel;
                $responcreate['status'] = 0;
                $responcreate['expired'] = Carbon::now()->addMinutes(1440)->toDateTimeString();
                $responcreate['aktif_sampai'] = Carbon::now()->addMonths(6)->toDateTimeString();
                $responcreate['created_by'] = Auth::id();
                $responcreate['created_at'] = Carbon::now()->toDateTimeString();
                $responcreate['updated_by'] = Auth::id();
                $responcreate['updated_at'] = Carbon::now()->toDateTimeString();
                $createdata = Transaksi::create($responcreate);

                if ($createdata) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Pesanan Berhasil Diproses, Mohon Tunggu...',
                        'url' => $url_checkout
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Pesanan Gagal Diproses, Silahkan Coba Lagi...'
                    ]);
                }
            } else {
                echo $response;
            }
        }

        // dd(json_decode($response));
    }

    public function detailbayar($id) {
        $menu = 'transaksi';
        $submenu = '';
        $rek = MasterRekening::all();
        $id = Crypt::decrypt($id);
        $transaksi = Transaksi::find($id);
        $membermst = PaketMst::find($transaksi->fk_master_member_id);

        $data_param = [
            'menu',
            'submenu',
            'transaksi',
            'membermst',
            'rek'
        ];
        return view('user/detailbayar')->with(compact($data_param));
    }
    public function createorderduitku(Request $request) {
        $mastermemberid = Crypt::decrypt($request->mastermemberid);
        $mastermember = MasterMember::find($mastermemberid);

        if ($mastermember) {
            $duitkuConfig = new \Duitku\Config($this->apiKey, $this->merchantId);
            $duitkuConfig->setSandboxMode($this->sandboxmode);
            $paymentAmount      = $mastermember->harga; // Amount
            $email              = Auth::user()->email; // your customer email
            $phoneNumber        = ""; // your customer phone number (optional)
            $productDetails     = "Member " . $mastermember->judul;
            $merchantOrderId    = time(); // from merchant, unique
            $additionalParam    = ''; // optional
            $merchantUserInfo   = ''; // optional
            $customerVaName     = Auth::user()->name; // display name on bank confirmation display
            $callbackUrl        = $this->linkcallback; // url for callback
            $returnUrl          = url('transaksi'); // url for redirect
            $expiryPeriod       = 180; // set the expired time in minutes

            // Customer Detail
            $firstName          = Auth::user()->name;
            $lastName           = "";

            // Address
            $alamat             = "Jl. Kembangan Raya";
            $city               = "Jakarta";
            $postalCode         = "11530";
            $countryCode        = "ID";

            $address = array(
                'firstName'     => $firstName,
                'lastName'      => $lastName,
                'address'       => $alamat,
                'city'          => $city,
                'postalCode'    => $postalCode,
                'phone'         => $phoneNumber,
                'countryCode'   => $countryCode
            );

            $customerDetail = array(
                'firstName'         => $firstName,
                'lastName'          => $lastName,
                'email'             => $email,
                'phoneNumber'       => $phoneNumber
                // 'billingAddress'    => $address,
                // 'shippingAddress'   => $address
            );

            // Item Details
            $item1 = array(
                'name'      => $productDetails,
                'price'     => $paymentAmount,
                'quantity'  => 1
            );

            $itemDetails = array(
                $item1
            );

            $params = array(
                'paymentAmount'     => $paymentAmount,
                'merchantOrderId'   => $merchantOrderId,
                'productDetails'    => $productDetails,
                'additionalParam'   => $additionalParam,
                'merchantUserInfo'  => $merchantUserInfo,
                'customerVaName'    => $customerVaName,
                'email'             => $email,
                'phoneNumber'       => $phoneNumber,
                'itemDetails'       => $itemDetails,
                'customerDetail'    => $customerDetail,
                'callbackUrl'       => $callbackUrl,
                'returnUrl'         => $returnUrl,
                'expiryPeriod'      => $expiryPeriod
            );

            try {
                // createInvoice Request
                $responseDuitkuPop = \Duitku\Pop::createInvoice($params, $duitkuConfig);
                $datarespon = json_decode($responseDuitkuPop);
                $responcreate['payment_url'] = $datarespon->paymentUrl;
                $responcreate['reference'] = $datarespon->reference;
                $responcreate['merchant_order_id'] = $merchantOrderId;
                $responcreate['fk_user_id'] = Auth::id();
                $responcreate['fk_master_member_id'] = $mastermember->id;
                $responcreate['harga'] = $mastermember->harga;
                $responcreate['status'] = 0;
                $responcreate['expired'] = Carbon::now()->addMinutes(180)->toDateTimeString();
                $responcreate['created_by'] = Auth::id();
                $responcreate['created_at'] = Carbon::now()->toDateTimeString();
                $responcreate['updated_by'] = Auth::id();
                $responcreate['updated_at'] = Carbon::now()->toDateTimeString();
                Transaksi::create($responcreate);

                header('Content-Type: application/json');
                echo $responseDuitkuPop;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public function callbackduitku(Request $request) {
        // $data['nik'] = rand(15,35);
        // $data['name'] = 'fffff';
        // $data['username'] = 'ggggg';
        // $data['email'] = 'hhhh';
        // $data['gender'] = "s";
        // $data['user_level'] = "1";
        // $data['is_active'] = "1";
        // $data['password'] = "2";
        // User::create($data);
        // return 'Berhasil';

        try {
            $duitkuConfig = new \Duitku\Config($this->apiKey, $this->merchantId);
            $duitkuConfig->setSandboxMode($this->sandboxmode);

            $callback = \Duitku\Pop::callback($duitkuConfig);

            header('Content-Type: application/json');
            $notif = json_decode($callback);

            $merchantOrderId = $notif->merchantOrderId;

            if ($notif->resultCode == "00") {
                $data['status'] = 1;
                $data['updated_at'] = Carbon::now()->toDateTimeString();
            } else if ($notif->resultCode == "01") {
                $data['status'] = 2;
                $data['updated_at'] = Carbon::now()->toDateTimeString();
            }
            Transaksi::where('merchant_order_id', $merchantOrderId)->update($data);
        } catch (Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }

    public function callbackipaymu(Request $request) {
        if ($request->status_code == 1) {
            $data['status'] = 1;
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            Transaksi::where('merchant_order_id', $request->reference_id)->update($data);
        } elseif ($request->status_code == -2) {
            $data['status'] = 2;
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            Transaksi::where('merchant_order_id', $request->reference_id)->update($data);
        } elseif ($request->status_code == 0) {
            $data['status'] = 0;
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            Transaksi::where('merchant_order_id', $request->reference_id)->update($data);
        }
    }

    public function callbacktripay(Request $request) {
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $this->tripay_privatekey);

        if ($signature !== (string) $callbackSignature) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid signature',
            ]);
        }

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return Response::json([
                'success' => false,
                'message' => 'Unrecognized callback event, no action was taken',
            ]);
        }

        $data = json_decode($json);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid data sent by tripay',
            ]);
        }

        $invoiceId = $data->merchant_ref;
        $tripayReference = $data->reference;
        $status = strtoupper((string) $data->status);

        if ($data->is_closed_payment === 1) {
            $invoice = Transaksi::where('merchant_order_id', $invoiceId)
                ->where('reference', $tripayReference)
                // ->where('status', '=', 'UNPAID')
                ->first();

            if (! $invoice) {
                return Response::json([
                    'success' => false,
                    'message' => 'No invoice found or already paid: ' . $invoiceId,
                ]);
            }

            switch ($status) {
                case 'PAID':
                    // $invoice->update(['status' => 'PAID']);
                    $invoice->update([
                        'status' => 1,
                        'updated_at' => Carbon::now()->toDateTimeString()
                    ]);
                    break;

                case 'EXPIRED':
                    $invoice->update(['status' => 'EXPIRED']);
                    $invoice->update([
                        'status' => 2,
                        'updated_at' => Carbon::now()->toDateTimeString()
                    ]);
                    break;

                case 'FAILED':
                    // $invoice->update(['status' => 'FAILED']);
                    // $invoice->update([
                    //     'status' => 2,
                    //     'updated_at' => Carbon::now()->toDateTimeString()
                    // ]);
                    break;

                default:
                    return Response::json([
                        'success' => false,
                        'message' => 'Unrecognized payment status',
                    ]);
            }

            return Response::json(['success' => true]);
        }
    }
}
