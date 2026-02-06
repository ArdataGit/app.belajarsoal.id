@extends('layouts.Skydash')

@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card card-border" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
        <div class="card-body">
          <h4 class="card-title">FAQ</h4>
          <div class="accordion" id="faqAccordion">

            <!-- Pertanyaan 1 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button question" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  <strong>Bagaimana Cara Akses Tryout Gratis?</strong>
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body answer">
                  Tryout gratis bisa kamu akses dengan cara:
                  <ol>
                    <li>Daftar ke website andalancpns.id</li>
                    <li>Login ke apps.andalancpns.id</li>
                    <li>Klik "Paket saya" pada bagian menu di sebelah kiri</li>
                    <li>Klik "Paket Gratis"</li>
                    <li>Klik "Mulai Belajar"</li>
                    <li>Klik "Latihan"</li>
                    <li>Mulai Tryout!</li>
                  </ol>
                </div>
              </div>
            </div>

            <!-- Pertanyaan 2 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  <strong>Paket apa saja yang tersedia di andalancpns.id?</strong>
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body answer">
                  Untuk melihat Paket, silahkan login ke website apps.andalancpns.id, kemudian klik "Paket Tersedia" atau,
                  <ol>
                    <li>Klik tombol tanda garis tiga (☰) pada bagian atas apps, kemudian Pilih "TRYOUT CPNS 2024"</li>
                    <li>Pilih paket</li>
                    <li>Klik "Lihat Paket" untuk melihat detail benefit yang kamu dapatkan untuk setiap paketnya!</li>
                  </ol>
                </div>
              </div>
            </div>

            <!-- Pertanyaan 3 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  <strong>Bagaimana cara melakukan pembayaran paket?</strong>
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body answer">
                  <ol>
                    <li>Pilih Paket yang akan kamu beli</li>
                    <li>Klik "Lihat Paket"</li>
                    <li>Klik "Beli Paket"</li>
                    <li>Klik "Pembayaran"</li>
                    <li>Pilih Metode Pembayaran yang akan kamu gunakan</li>
                  </ol>
                </div>
              </div>
            </div>

            <!-- Pertanyaan 4 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  <strong>Metode pembayaran apa saja yang bisa diterima untuk transaksi paket tryout?</strong>
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                <div class="accordion-body answer">
                  Kami menyediakan pembayaran dengan pilihan:
                  <ul>
                    <li>[BEBAS ADMIN] E-Wallet (Ovo, Dana, Shopee Pay, LinkAja) dan QRIS (Nobu, Shopeepay)</li>
                    <li>Transfer via VA Account Bank (Dengan biaya admin)</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- Pertanyaan 5 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFive">
                <button class="accordion-button question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                  <strong>Apakah Tryout bisa dikerjakan ulang?</strong>
                </button>
              </h2>
              <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                <div class="accordion-body answer">
                  Bisa banget, kamu bisa mengerjakan ulang semua Tryout yang sudah kamu beli dari Platform ini! Selain itu, kamu bisa akses history skor Tryout kamu, jadi bisa banget buat lihat perkembangan kesiapan kamu dari tryout pertama hingga tryout terakhir!
                </div>
              </div>
            </div>

            <!-- Pertanyaan 6 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingSix">
                <button class="accordion-button question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                  <strong>Kalau saya sudah beli Paket 3 Tryout apakah bisa upgrade ke Paket 12 Tryout?</strong>
                </button>
              </h2>
              <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                <div class="accordion-body answer">
                  Jika sudah membeli paket 3 Tryout, untuk mengakses Paket 12 Tryout, kamu harus melakukan pembelian ulang paket Tryoutnya.
                </div>
              </div>
            </div>

            <!-- Pertanyaan 7 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingSeven">
                <button class="accordion-button question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                  <strong>Bagaimana jika saya menemukan kendala di apps?</strong>
                </button>
              </h2>
              <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                <div class="accordion-body answer">
                  Kamu bisa kontak admin, cukup klik button Whatsapp pada apps atau landing page, kamu bisa segera hubungi "Admin" tim Andalan!
                </div>
              </div>
            </div>

            <!-- Pertanyaan 8 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingEight">
                <button class="accordion-button question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                  <strong>Apakah akun bisa digunakan bersama?</strong>
                </button>
              </h2>
              <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                <div class="accordion-body answer">
                  Kami melarang keras akun untuk digunakan bersama, setiap account diperuntukkan untuk 1 orang saja. Jika ada pelanggaran, maka kami akan melakukan penutupan akun (banned), tanpa biaya pengganti (refund)!
                </div>
              </div>
            </div>

            <!-- Pertanyaan 9 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingNine">
                <button class="accordion-button question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                  <strong>Apakah appnya bisa diakses melalui smartphone atau tablet?</strong>
                </button>
              </h2>
              <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#faqAccordion">
                <div class="accordion-body answer">
                  Bisa Dong! Selama gadget kamu mempunyai browser dan terkoneksi dengan internet, kamu bisa akses Tryout di platform andalancpns.id di mana saja!
                </div>
              </div>
            </div>

            <!-- Pertanyaan 10 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTen">
                <button class="accordion-button question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                  <strong>Berapa lama saya bisa mengakses app andalan?</strong>
                </button>
              </h2>
              <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#faqAccordion">
                <div class="accordion-body answer">
                  Untuk Paket Premium akses akan diberikan hingga 1 Tahun! Untuk paket trial saja, akun hanya akan aktif hingga 2 minggu.
                </div>
              </div>
            </div>

            <!-- Pertanyaan 11 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingEleven">
                <button class="accordion-button question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                  <strong>Saya sudah bayar, tapi paket premium belum aktif, apa yang harus saya lakukan?</strong>
                </button>
              </h2>
              <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven" data-bs-parent="#faqAccordion">
                <div class="accordion-body answer">
                  <ol>
                    <li>Coba login ulang ke apps.andalancpns.id dan cek ulang paket mu di menu "Paket Saya"</li>
                    <li>Jika paketmu belum muncul, kamu bisa kontak admin CPNS via WA, sertakan nama di akun kamu, email, & bukti pembayaran paketnya ya!</li>
                  </ol>
                </div>
              </div>
            </div>

            <!-- Tambahkan lebih banyak pertanyaan dan jawaban sesuai kebutuhan -->

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('styles')
<style>
  .question {
    background-color: #007bff; /* Warna background untuk pertanyaan */
    color: white; /* Warna teks untuk pertanyaan */
  }
  .answer {
    background-color: #f8f9fa; /* Warna background untuk jawaban */
  }
  .accordion-button:not(.collapsed) {
    color: white;
    background-color: #0062cc; /* Warna background untuk pertanyaan ketika accordion dibuka */
    box-shadow: inset 0 -1px 0 rgba(0,0,0,.125);
  }
</style>
@endsection