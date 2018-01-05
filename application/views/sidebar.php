<?php
$is_login = $this->session->userdata('is_login');
$level = $this->session->userdata('level');
$nama = $this->session->userdata('nama');
$foto = $this->session->userdata('foto');
?>

<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <?php if ($is_login) : ?>
            <?php if (!empty($foto)): ?>
                <img src="<?= site_url("foto/$foto") ?>" alt="<?= $nama ?>" width="48" height="48" alt="User">
            <?php else: ?>
                <img src="<?= base_url();?>adminbsb/images/user.png" width="48" height="48" alt="User"">
            <?php endif?>
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= ucfirst($nama) ?></div>
            <div class="email"><?= ucfirst($level) ?></div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="<?= base_url('profile') ?>"><i class="material-icons">person</i>Profile</a></li>
                    <li><a href="<?= base_url('logout') ?>"><i class="material-icons">input</i>Logout</a></li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- #User Info -->

    <!-- Menu jika login admin-->
    <div class="menu">
        <?php if ($is_login) : ?>
            <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">menu</i>
                    <span>Menu</span>
                </a>
                <ul class="ml-menu">
                    <li class="active">
                        <?= anchor(base_url(),'Home',['class' => 'klik']) ?>
                    </li>
                    <li>
                        <?= anchor('logout','Logout',['class' => 'klik']) ?>
                    </li>

                </ul>
            </li>
            <?php if ($level === 'admin'): ?>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">layers</i>
                        <span>Master</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <?= anchor('pic','PIC',['class' => 'klik']) ?>
                        </li>
                        <li>
                            <?= anchor('proyek','Proyek',['class' => 'klik']) ?>
                        </li>
                    </ul>
                </li>
            <li>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">shopping_cart</i>
                <span>Transaksi</span>
            </a>
            <ul class="ml-menu">
                <li>
                    <?= anchor('kegiatan','Kegiatan',['class' => 'klik']) ?>
                </li>
            </ul>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">work</i>
                        <span>Laporan</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <?= anchor('laporan-kegiatan','kegiatan',['class' => 'klik']) ?>
                        </li>

                    </ul>
                </li>
                </ul>
            <?php endif ?>
            </li>
    </div>
        <?php else: ?>
    <!-- #Menu jika login admin-->

    <!-- Menu tanpa login -->
    <div class="menu">

        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">menu</i>
                    <span>Menu</span>
                </a>
                <ul class="ml-menu">
                    <li class="active">
                        <?= anchor(base_url(),'Home',['class' => 'klik']) ?>
                    </li>
                </ul>
            </li>
            <li>
                <a class=" waves-effect waves-block" href="<?= base_url('login') ?>">
                    <i class="material-icons">input</i>
                    <span>Login</span>
                </a>
            </li>
            <?php endif ?>

        </ul>
    </div>
    <!-- #Menu tanpa login -->

    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2017 <a href="javascript:void(0);">Aplikasi</a>
        </div>
        <div class="version">
            <b>Designed by</b> <a href="http://hendrandroid10@gmail.com"> Hendra</a>.
        </div>
    </div>
    <!-- #Footer -->
</aside>
