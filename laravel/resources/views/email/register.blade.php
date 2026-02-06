<style>
    .tombol {
        background: #028618;
        padding: 5px 15px;
        text-decoration: none;
        color: white;
        border-radius: 4px;
    }

    .footer {
        text-align: center;
        padding: 25px;
        background: lightgray;
    }
</style>
 <h3>Selamat Datang, {{ $nama }}</h3>
  <p>Selamat bergabung di <strong>{{ $_SERVER['SERVER_NAME'] }}</strong></p>

  <p>Berikut ini adalah email dan password yang anda daftarkan:</p>
  <ul>
    <li><strong>Email:</strong> {{ $email }}</li>
    <li><strong>Password:</strong> {{ $password }}</li>
  </ul>

  <p>Silahkan login ke dashboard Anda melalui link berikut:</p>
  <p>
    <a href="https://{{ $_SERVER['SERVER_NAME'] }}/login" target="_blank">
      https://{{ $_SERVER['SERVER_NAME'] }}/login
    </a>
  </p>

  <hr>

  <p><strong>{{ $_SERVER['SERVER_NAME'] }}</strong></p>
  <ul>
    <li>Download modul-modul materi gratis, dan ribuan soal-soal latihan CPNS, PPPK, dan BUMN terbaru</li>
    <li>Setiap paket soal bisa dikerjakan dengan Mode Tryout ATAU bisa juga dengan Mode Belajar (bisa langsung lihat pembahasan tiap soal).</li>
    <li>Akses mudah, bisa belajar dan latihan kapan saja dan dimana saja.</li>
    <li>Soal dan pembahasan baru ditambahkan setiap hari.</li>
  </ul>

  <p>Jika ada pertanyaan, silahkan hubungi WA kami di <strong>085766908058</strong></p>

  <p><strong>Yuk langsung Belajar Soal!</strong></p>

  <p>Terima Kasih</p>
  <p><strong>{{ $_SERVER['SERVER_NAME'] }}</strong></p>
</div>