<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Aplikasi Perpustakaan | SMA Negeri 2 Cileungsi</title>
    <!-- Favicon-->
    <link rel="icon" href="<?= base_url();?>/adminbsb/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="<?= base_url();?>adminbsb/googlefont/css.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url();?>adminbsb/googlefont/icon.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?= base_url();?>adminbsb/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?= base_url();?>adminbsb/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?= base_url();?>adminbsb/css/style.css" rel="stylesheet">
    <link href="<?= base_url();?>adminbsb/css/app.css" rel="stylesheet">
</head>

<body class="signup-page">
<div class="signup-box">
    <div class="logo">
        <a href="<?= base_url() ?>">Aplikasi <b>Perpustakaan</b></a>
        <img src="<?= base_url();?>adminbsb/images/logo.jpg" class="img-circle center-block" height="110px">
    </div>
    <div class="card">
        <div class="body">

            <div class="msg">Register a new membership</div>
            <?= form_open_multipart('register/create') ?>
            <div class="form-group form-float">
                <div class="form-line">
                    <?= form_label('No Anggota','no_anggota',['class' => 'form-label']) ?>
                    <?= form_input('no_anggota',$input->no_anggota, ['class' => 'form-control', 'required autofocus','readonly'=>'true']) ?>
                </div>
                <?= form_error('no_anggota') ?>
            </div>
            <div class="form-group form-float">
                <div class="form-line">
                    <?= form_label('No Induk','no_induk',['class' => 'form-label']) ?>
                    <?= form_input('no_induk',$input->no_induk, ['class' => 'form-control', 'required autofocus']) ?>
                </div>
                <?= form_error('no_induk') ?>
            </div>
            <div class="form-group form-float">
                <div class="form-line">
                    <?= form_label('Password','password',['class' => 'form-label']) ?>
                    <?= form_password('password',$input->password, ['class' => 'form-control', 'required autofocus']) ?>
                </div>
                <?= form_error('password') ?>
            </div>
            <?= form_hidden('level','anggota', ['class' => 'form-control','placeholder' => 'Level', 'required autofocus']) ?>
            <div class="form-group form-float">
                <div class="form-line">
                    <?= form_label('Nama','nama',['class' => 'form-label']) ?>
                    <?= form_input('nama',$input->nama, ['class' => 'form-control', 'required autofocus']) ?>
                </div>
                <?= form_error('nama') ?>
            </div>
            <div class="form-group form-float">
                <div class="form-line">
                    <?= form_radio('jenis_kelamin','l',isset($input->jenis_kelamin) && ($input->jenis_kelamin == 'l') ? true : false,['id' => 'l','class' => 'with-gap']) ?>
                    <?= form_label('Laki - Laki','l') ?>
                    <?= form_radio('jenis_kelamin','p',isset($input->jenis_kelamin) && ($input->jenis_kelamin == 'p') ? true : false,['id' => 'p','class' => 'with-gap']) ?>
                    <?= form_label('Perempuan','p') ?>
                </div>
                <?= form_error('jenis_kelamin') ?>
            </div>
            <div class="form-group form-float">
                <div class="form-line">
                    <?= form_label('No Handphone','no_hp',['class' => 'form-label']) ?>
                    <?= form_input('no_hp',$input->no_hp, ['class' => 'form-control', 'required autofocus']) ?>
                </div>
                <?= form_error('no_hp') ?>
            </div>
            <div class="form-group form-float">
                <div class="form-line">
                    <?= form_dropdown('id_kelas', getDropdownList('kelas',['id_kelas','nama_kelas'],'Kelas'),$input->id_kelas, ['class' => 'form-control','id' => 'kelas']) ?>
                </div>
                <?= form_error('id_kelas') ?>
            </div>
            <div class="form-group form-float">
                <div class="form-line">
                    <?= form_upload('foto') ?>
                </div>
            <?= fileFormError('foto','<p class="form-error">', '</p>'); ?>
            </div>
        </div>
        <?php if (!empty($input->foto)): ?>

            <div class="form-group form-float">
                <div class="form-line">
                    <img src="<?= site_url("/foto/$input->foto") ?>" alt="<?= $input->no_induk ?>" class="img-responsive cover_border center-block">
                </div>
            </div>
        <?php endif ?>

        <div style="padding: 0px 10px 0px 10px; ">
            <?= form_button(['type' => 'submit','content' => 'Register','class' => 'btn btn-block btn-lg bg-pink waves-effect']) ?>
        </div>
        <?= form_close() ?>

        <div class="m-t-30 m-b--5 align-center">
            <a href="<?= base_url();?>login">You already have a membership?</a>
        </div>
    </div>
</div>

<!-- Jquery Core Js -->
<script src="<?= base_url();?>adminbsb/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap Core Js -->
<script src="<?= base_url();?>adminbsb/plugins/bootstrap/js/bootstrap.js"></script>

<!-- Waves Effect Plugin Js -->
<script src="<?= base_url();?>adminbsb/plugins/node-waves/waves.js"></script>

<!-- Custom Js -->
<script src="<?= base_url();?>adminbsb/js/admin.js"></script>
<script src="<?= base_url();?>adminbsb/js/app.js"></script>

</body>

</html>