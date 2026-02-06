<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piagam</title>
    <style>
        @page { margin: 0px; }
        body { margin: 0px; }
        .content{
            width:100%;z-index:2;margin-top:165px;color:#474747;
        }
        .mp-0{
            margin:0px;
            padding:0px;
        }
        .mp-1{
            margin:7.5px;
        }
        .txt-black{
           color:#272727; 
        }
        .content-isi{
            padding:5px 125px 0px;
            line-height:1.4;
        }
    </style>
</head>
<body>
<section>
    <img width="100%" style="position:absolute" src="{{ public_path('/image/global/piagam.jpg') }}" alt="">
    <div class="content">
    <center>
        <h4 class="txt-black" style="margin-bottom:10px;margin-top:30px">NO:{{$nopiagam}}</h4>
        <h3 class="txt-black mp-0">LEGALITAS : AHU-0057943-AH.01.14 Tahun 2021</h3>
        <h4 class="mp-0" style="margin-top:15px">Piagam ini diberikan kepada :</h4>
        <h2 class="mp-1 txt-black">{{$user->name}}</h2>
        <h4 class="mp-1">sebagai :</h4>
        <h2 class="mp-0 txt-black">PESERTA</h2>
    </center>
    <div class="content-isi">
        <h4>Atas pastisipasinya di ajang "<b class="txt-black">{{$eventmst->judul}}</b>" bidang {{$mapel->judul}} tahun {{getyear($eventmst->mulai)}}, dari tanggal {{tglIndo($eventmst->mulai)}} dengan predikat "<b class="txt-black">{{predikat($nilai)}}</b>".</h4>
    </div>
    <div class="txt-black" style="font-size:16px;bottom:240px;padding-left:125px;position:absolute;width:100%">
        Mengetahui<br>
        Balikpapan, {{tglIndo(tglnow())}}
    </div>
    <img style="bottom:75px;float:right;padding-right:125px;position:absolute;width:10%" src="data:image/png;base64, {!! $qrcode !!}">
    </div>
</section>

</body>
</html>