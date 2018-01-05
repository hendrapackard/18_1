<div class="container-fluid">
    <div class="block-header">
        <h2>DASHBOARD</h2>
    </div>
    <?php
    $is_login = $this->session->userdata('is_login');
    $nama = $this->session->userdata('nama');
    $level = $this->session->userdata('level');
    ?>
    <!-- <?= var_dump($this->session->userdata()); ?> -->
    <?php if ($is_login): ?>

        <?php if ($level === 'admin'): ?>
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL ANGGOTA</div>
                            <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?= $jmlAnggota ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">book</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL BUKU</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?= $jmlBuku ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">label</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL JUDUL BUKU</div>
                            <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"><?= $jmlJudul ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">sync</i>
                        </div>
                        <div class="content">
                            <div class="text">BUKU DIPINJAM</div>
                            <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"><?= $jmlKembali ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="body bg-teal"><p>Halo, <strong><?= ucfirst($nama) ?></strong>!</p>
                            <p>Selamat Bekerja</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 align="center">Grafik Lingkaran</h2>
                        </div>
                        <div class="body">
                            <div id="graf" style="height:250px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 align="center">Grafik Batang</h2>
                        </div>
                        <div class="body">
                            <div id="graf2" style="height:250px"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="body bg-teal"><p>Halo, <strong><?= ucfirst($nama) ?></strong>!</p>
                            <p>Selamat Datang</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 align="center">Grafik Lingkaran</h2>
                        </div>
                        <div class="body">
                            <div id="graf" style="height:250px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 align="center">Grafik Batang</h2>
                        </div>
                        <div class="body">
                            <div id="graf2" style="height:250px"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>

    <?php else: ?>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="body bg-teal"><p>Selamat datang di Perpustakaan SMA Negeri 2 Cileungsi !!!</p>
                        <p>Untuk melihat katalog buku, gunakan menu <strong>"Buku"</strong></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2 align="center">Grafik Lingkaran</h2>
                    </div>
                    <div class="body">
                        <div id="graf" style="height:250px"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2 align="center">Grafik Batang</h2>
                    </div>
                    <div class="body">
                        <div id="graf2" style="height:250px"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>


</div>