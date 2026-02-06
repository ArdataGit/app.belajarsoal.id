<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal Latihan dan Kunci Jawaban</title>
    <style>
        /* Tambahan CSS untuk footer */
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            position: relative;
            margin-bottom: 40px;
            /* memberi ruang untuk footer */
        }

        .text-justify {
            text-align: justify;
            /* Mengatur teks agar rata kiri dan kanan */
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 14px;
            padding: 10px 0;
            border-top: 1px solid #000;
            background-color: #f8f8f8;
        }

        /* Menambahkan nomor halaman otomatis */
        .footer::after {
            content: "Page " counter(page);
            position: absolute;
            right: 20px;
            font-size: 14px;
        }

        /* Gaya untuk tagline */
        .tagline-text {
            display: inline-block;
            font-style: bold;
            font-size: 14px;
        }

        /* CSS lainnya tetap */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            top: 0;
        }

        .header-table td {
            vertical-align: middle;
            text-align: center;
        }

        .header-table .logo {
            margin-right: 0;
            width: 25%;
        }

        .header-table .header-text {
            width: 75%;
            align-items: center;
        }

        .header-table h2,
        .header-table h4,
        .header-table h5,
        .header-table h6 {
            margin: 0;
            padding: 0;
        }

        .header-table .header-text h1 {
            font-size: 30px;
            margin-bottom: 10px;
            margin-top: 0px;
        }

        .header-table .header-text h6 {
            font-size: 16px;
            margin-top: 10px;
        }

        .header-table .header-text h5 {
            font-size: 18px;
        }

        .garis1 {
            border: 1px solid black;
            margin-top: 10px;
        }

        .table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .table tr td {
            text-align: center;
            border: 1px solid black;
            padding: 10px;
        }

        .nomor {
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        p {
            margin-top: 0px;
            margin-bottom: 0px;
        }

        .radiopilgan {
            display: flex;
            align-items: center;
        }

        .soal {
            font-weight: bold;
        }

        h2.center-title {
            margin-top: 0;
            margin-bottom: 0;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 50px;
            font-weight: bold;
            color: rgba(0, 0, 0, 0.1);
            z-index: -1;
            white-space: nowrap;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <table class="header-table">
            <tr>
                <td class="logo">
                    <img id="logo" src="https://belajarsoal.id/wp-content/uploads/2025/01/Frame-1261157844.webp"
                        alt="Logo" width="120px" />
                </td>
                <td class="header-text">
                    <h1><strong>BELAJARSOAL.ID</strong></h1>
                    {{-- <p>Ruko Trace, Jalan Ciptomangun Kusumo, Jl. Yudhistira Blk. B 17 No.27, Simpangan, Kec.
                        Cikarang
                        Utara, Kabupaten Bekasi</p>
                    <p>Jawa Barat - 17550</p> --}}
                </td>
            </tr>
        </table>
        <hr class="garis1" />
    </header>

    <!-- Main Content -->
    <div>

        <center>
            <h2 class="center-title">Kunci Jawaban<br>{{ $paketsoalmst->judul }}</h2>
        </center>
        <div style="margin-bottom:15px">
            <b>Jumlah Soal : {{ count($paketsoaldtl) }} Soal</b>
            <br>
            <b>Pembahasan : bisa dilihat langsung di apps.belajarsoal.id</b>
        </div>
        <hr>
    </div>

    @php
        $no = 1;

        function clean($text)
        {
            return preg_replace('/<p[^>]*>(.*?)<\/p>/i', '$1', $text);
        }
    @endphp

    @if (count($paketsoalktg) > 0)
        <center>
            <h3 class="center-title">Soal Pilihan Ganda</h3>
        </center>
    @endif

    @foreach ($paketsoalktg as $key)
        <div class="watermark">BELAJARSOAL.ID</div>

        <div style="margin-bottom:10px;">
            <div style="float:left;">
                <h4>Kategori : {{ $key->kategori_soal_r->judul }}</h4>
            </div>
            <div style="float:right;">
                <h4>Waktu Pengerjaan : {{ $paketsoalmst->waktu ?? 'Waktu Tidak Tersedia' }} Menit</h4>
            </div>

            <div style="clear:both;"></div>
        </div>

        <br>
        @php
            if ($paketsoalmst->is_acak == 1) {
                $cekdata = App\Models\PaketSoalDtl::where('fk_paket_soal_ktg', '=', $key->id)->inRandomOrder()->get();
            } else {
                $cekdata = App\Models\PaketSoalDtl::where('fk_paket_soal_ktg', '=', $key->id)->get();
            }
        @endphp

        @foreach ($cekdata as $datadtl)
            <table>

                <tr class="soal">

                    <td class="nomor">{{ $no }}.</td>

                    <td>{!! $datadtl->master_soal_r->soal !!}</td>

                </tr>
                @if ($datadtl->master_soal_r->a)
                    <tr>
                        <td> </td>
                        <td colspan="2">
                            <div>a. {!! clean($datadtl->master_soal_r->a) !!}</div>
                        </td>
                    </tr>
                @endif

                @if ($datadtl->master_soal_r->b)
                    <tr>
                        <td> </td>
                        <td colspan="2">
                            <div>b. {!! clean($datadtl->master_soal_r->b) !!}</div>
                        </td>
                    </tr>
                @endif

                @if ($datadtl->master_soal_r->c)
                    <tr>
                        <td> </td>
                        <td colspan="2">
                            <div>c. {!! clean($datadtl->master_soal_r->c) !!}</div>
                        </td>
                    </tr>
                @endif

                @if ($datadtl->master_soal_r->d)
                    <tr>
                        <td> </td>
                        <td colspan="2">
                            <div>d. {!! clean($datadtl->master_soal_r->d) !!}</div>
                        </td>
                    </tr>
                @endif

                @if ($datadtl->master_soal_r->e)
                    <tr>
                        <td> </td>
                        <td colspan="2">
                            <div>e. {!! clean($datadtl->master_soal_r->e) !!}</div>
                        </td>
                    </tr>
                @endif
                @if ($datadtl->master_soal_r->jawaban)
                    <tr>
                        <td colspan="2">
                            <div><b>Jawaban :</b> {!! clean($datadtl->master_soal_r->jawaban) !!}</div>
                        </td>
                    </tr>
                @endif

                {{-- @if ($datadtl->master_soal_r->pembahasan)
                <tr>
                    <td colspan="2">
                        <div><b>Pembahasan :</b>
                            {!! clean($datadtl->master_soal_r->pembahasan) !!}
                        </div>
                    </td>
                </tr>
                @endif --}}
                <br>
            </table>
            @php
                $no++;
            @endphp
        @endforeach
    @endforeach

    <!-- Footer -->
    <div class="footer">
        <span class="tagline-text">SENYAP • TANGGUH • DISIPLIN</span>
    </div>
</body>

</html>