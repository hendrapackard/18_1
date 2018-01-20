<html>
<head>

    //print berdasarkan area
    <script>
        function printContent(el){
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>

    <link href="<?= base_url();?>adminbsb/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
        #a6{
            height:14.8cm ;
            width: 10.5cm;
        }

        #depan{
            height: 48%;
            width: 99%;
            margin-bottom: .3cm;
            border-radius:25px 25px 25px 25px;
            position: relative;

        }
        #belakang{
            height: 48%;
            width: 99%;
            border-radius:25px 25px 25px 25px;
            position: relative;
        }

        .face-front {
            background: #fff;
        }

        /* an image that fills the whole of the front face */
        .face-front img {
            position: absolute;
            z-index: 1;
            opacity: 0.7;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
            border-radius:25px 25px 25px 25px;
            box-shadow: 7px 7px 10px;
        }

        hr {
            position: relative;
            z-index: 2;
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 2px;
        }

        td{
            padding-bottom: 10px;
        }
    </style>
</head>
<body id="a6">
<div class="face face-front" id="depan"><img src="<?= base_url(); ?>/adminbsb/images/kartu.jpg" alt="kartu.jpg">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><img style="height: 50px;width: 50px;border-radius: 0px; box-shadow: none;margin: 10px 0px 4px 10px" src='<?= base_url();?>/adminbsb/images/logo.png' /></div>
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="z-index: 2;padding: 0px 30px 0px 0px ">
        <h5 style="font-family: 'Times New Roman'" align="center">KARTU PERPUSTAKAAN</h5>
        <h4 align="center" style="font-family: 'Times New Roman'; line-height: 1px; color: #0D47A1">SMA NEGERI 2 CILEUNGSI</h4>
        <h6 align="center" style="font-family: 'Times New Roman'; font-size: 10px;">Komp. Metland Transyogi Jl. Gandaria Utara No.2 Cileungsi 16820</h6>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <hr>
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><?php if (!empty($users->foto)): ?>
            <img src="<?= site_url("foto/$users->foto") ?>" alt="<?= $users->no_induk ?>" style="width: 100px;height: 125px;border-radius: 0px; box-shadow: none;margin: 10px 0px 4px 10px;z-index: 1;position: absolute;opacity: 1;border-style: ridge;border-width: 2px;border-radius: 2px 2px 2px 2px">
        <?php else: ?>
            <img src="<?= site_url("foto/no_cover.jpg") ?>" alt="<?= $users->no_induk ?>" style="width: 100px;height: 125px;border-radius: 0px; box-shadow: none;margin: 10px 0px 4px 10px;z-index: 1;position: absolute;opacity: 1;border-style: outset;border-width: 2px">
        <?php endif?>
    </div>
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <br>
        <table border="0" align="left" style="font-family: 'Times New Roman'; position: relative; z-index: 2;opacity: 1; margin-left: 50px;font-size: 15px; margin-bottom: 20px">
            <tr><td>No Anggota</td><td>:</td><td>&nbsp;<?= $users->no_anggota ?></td></tr>
            <tr><td>Nama</td><td>:</td><td>&nbsp;<?= ucfirst($users->nama) ?></td></tr>
            <tr><td>NIS</td><td>:</td><td>&nbsp;<?= $users->no_induk ?></td></tr>
            <tr><td>No Handphone&nbsp;</td><td>:</td><td>&nbsp;<?= $users->no_hp ?></td></tr>
        </table>
    </div>
    <br>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h6 align="right" style="font-family: 'Times New Roman';font-size: 10px; position: relative;z-index: 2;opacity: 1; margin-left: 50px">Berlaku Hingga : <?= date('d-m-Y', strtotime('+3 year', strtotime(date('d-m-Y')))) ?></h6>
    </div>
</div>
<div class="face face-front" id="belakang"><img src="<?= base_url(); ?>/adminbsb/images/kartu.jpg" alt="kartu.jpg">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="z-index: 2;padding: 0px 4px 0px 0px ">
        <h4 align="center" style="font-family: 'Times New Roman'; padding-top: 20px; padding-bottom: 10px; line-height: 1px; color: #0D47A1">TATA TERTIB</h4>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 5px">
        <hr>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-left: 0px; padding-top: 0px">
        <ul>
            <li align="left" style="font-family: 'Times New Roman'; position: relative; z-index: 2;opacity: 1;  font-size:12px;">Maksimal lama peminjaman buku selama 3 hari </li>
            <li align="left" style="font-family: 'Times New Roman'; position: relative; z-index: 2;opacity: 1;  font-size:12px;">Maksimal peminjaman buku sebanyak 2 buku </li>
            <li align="left" style="font-family: 'Times New Roman'; position: relative; z-index: 2;opacity: 1;  font-size:12px;">Sangsi keterlambatan pengembalian buku pinjaman sebesar Lima Ratus Rupiah</li>
            <li align="left" style="font-family: 'Times New Roman'; position: relative; z-index: 2;opacity: 1;  font-size:12px;">Buku-buku yang hilang harus diganti sesuai dengan judul buku yang hilang atau
                diganti dengan uang yang sesuai dengan harga buku pada saat itu</li>
        </ul>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 10px">
        <hr style="border-width: 25px; border-radius: 5px 5px 5px 5px">
    </div>
    <br>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="right">

        <button onClick="printContent('a6');" type="button" class="btn btn-info"><span class="glyphicon glyphicon-print"></span> Cetak</button>
    </div>
</div>
<script src="<?= base_url();?>adminbsb/plugins/bootstrap/js/bootstrap.js"></script>
</body>
</html>