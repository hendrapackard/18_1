<?php
$i = 0;
$is_login = $this->session->userdata('is_login');
?>

<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>BUKU (DIPINJAM)</h2>
                    </div>

                </div>

            </div>
            <div class="body">
                <div class="body table-responsive">
                    <?php if ($bukus) : ?>
                        <table id="tabel_biasa" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Label Buku</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Peminjam</th>
                                <th>Kelas</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($bukus as $buku): ?>

                                <td><?= ++$i ?></td>
                                <td><?= $buku->label_buku ?></td>
                                <td><?= $buku->judul_buku ?></td>
                                <td><?= $buku->penulis ?></td>
                                <td><?= $buku->penerbit ?></td>
                                <td><?= $buku->peminjam ?></td>
                                <td><?= $buku->nama_kelas ?></td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>


                        </table>
                    <?php else: ?>
                        <p>Tidak ada data buku.</p>
                    <?php endif ?>
                    <div class="row">
                        <!--    Button Create-->
                        <div class="col-xs-12">
                            <?= anchor("judul",'<< Kembali',['class' =>'btn btn-primary waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Kembali']) ?>
                        </div>
                    </div>