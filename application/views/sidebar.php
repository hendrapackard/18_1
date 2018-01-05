<?php
$is_login = $this->session->userdata('is_login');
$level = $this->session->userdata('level');
$nama = $this->session->userdata('nama');
$jenis_kelamin = $this->session->userdata('jenis_kelamin');
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
    <!-- Menu -->
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
                            <!--                        <a href="--><?//= base_url('kelas') ?><!--" class="klik">Kelas</a>-->
                            <?= anchor('kelas','Kelas',['class' => 'klik']) ?>
                        </li>
                        <li>
                            <?= anchor('user','User',['class' => 'klik']) ?>
                        </li>
                        <li>
                            <?= anchor('judul','Buku',['class' => 'klik']) ?>
                        </li>
                    </ul>
                </li>
            <?php endif ?>
            <?php if ($level === 'anggota'): ?>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">layers</i>
                        <span>Master</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <?= anchor('judul','Buku',['class' => 'klik']) ?>
                        </li>
                    </ul>
                </li>
            <?php endif ?>
            <li>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">shopping_cart</i>
                <span>Transaksi</span>
            </a>
            <ul class="ml-menu">
            <?php if ($level === 'anggota'): ?>
                <li>
                    <?= anchor('peminjaman-user','Peminjaman',['class' => 'klik']) ?>
                </li>
            <?php endif ?>
            <?php if ($level === 'admin'): ?>
                <li>
                    <?= anchor('peminjaman','Peminjaman',['class' => 'klik']) ?>
                </li>

            <?php endif ?>

            <?php if ($level === 'anggota'): ?>
                <li>
                    <?= anchor('pengembalian-user','Pengembalian',['class' => 'klik']) ?>
                </li>
            <?php endif ?>

            <?php if ($level === 'admin'): ?>
                <li>
                    <?= anchor('pengembalian','Pengembalian',['class' => 'klik']) ?>
                </li>
                </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">done</i>
                        <span>Approve</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <?= anchor('approve-anggota','Approve Anggota',['class' => 'klik']) ?>
                        </li>
                        <li>
                            <?= anchor('approve-pinjam','Approve Pinjam',['class' => 'klik']) ?>
                        </li>
                        <li>
                            <?= anchor('approve-kembali','Approve Kembali',['class' => 'klik']) ?>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">work</i>
                        <span>Laporan</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <?= anchor('laporan-buku','Buku',['class' => 'klik']) ?>
                        </li>
                        <li>
                            <?= anchor('laporan-anggota','Anggota',['class' => 'klik']) ?>
                        </li>
                        <li>
                            <?= anchor('laporan-peminjaman','Peminjaman',['class' => 'klik']) ?>
                        </li>
                        <li>
                            <?= anchor('laporan-pengembalian','Pengembalian',['class' => 'klik']) ?>
                        </li>
                        <li>
                            <?= anchor('laporan-denda','Denda',['class' => 'klik']) ?>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class=" waves-effect waves-block" href="<?= base_url();?>petunjuk.pdf">
                        <i class="material-icons">help</i>
                        <span>Petunjuk</span>
                    </a>
                </li>
                </ul>
            <?php endif ?>

        <?php else: ?>
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
                        <?= anchor('judul','Buku',['class' => 'klik']) ?>
                    </li>

                </ul>
            </li>
            <li>
                <a class=" waves-effect waves-block" href="<?= base_url('login') ?>">
                    <i class="material-icons">input</i>
                    <span>Login</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">info</i>
                    <span>About</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <?= anchor('cara-pinjam','Peminjaman Buku',['class' => 'klik']) ?>
                    </li>
                    <li>
                        <?= anchor('about','Struktur Organisasi',['class' => 'klik']) ?>
                    </li>
                    <li>
                        <?= anchor('visi','Visi dan Misi',['class' => 'klik']) ?>
                    </li>
                    <li>
                        <?= anchor('tata','Tata Tertib',['class' => 'klik']) ?>
                    </li>
                </ul>
            </li>

            <?php endif ?>
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2018 <a href="javascript:void(0);">SMAN 2 Cileungsi</a>
        </div>
        <div class="version">
            <b>Designed by</b> <a href="http://hendrandroid10@gmail.com"> Hendra</a>. ({elapsed_time} seconds)
        </div>
    </div>
    <!-- #Footer -->
</aside>
