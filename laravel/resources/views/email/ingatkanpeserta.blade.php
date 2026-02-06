<style>
    .tombol{
        background: #028618;
        padding: 5px 15px;
        text-decoration: none;
        color: white;
        border-radius: 4px;
    }
    .footer{
        text-align:center;padding:25px;background:lightgray;
    }
</style>
<h3>Hi, {{ $peserta->name }} !</h3>
<p>Jangan lupa {{ $peserta->name }}, tanggal {{tglIndo($event->mulai)}} - {{tglIndo($event->selesai)}} kamu memiliki jadwal ujian. Jangan lupa yaa...!</p>
<br>
<p>Terima Kasih</p>
<p>Divya Prestasi</p>

<div class="footer">
    <p>Email ini adalah layanan yang disediakan oleh Divya Prestasi</p>
    <p>© 2023 Divya Prestasi - cbt.divyacahayaprestasi.id</p>
</div>