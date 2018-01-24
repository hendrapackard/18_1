<?php
$level = $this->session->userdata('level');
?>

<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>SEMUA BUKU (TOTAL / SEMUA)</h2>
                    </div>

                </div>

            </div>
            <div class="body">
                <div class="body table-responsive">
                    <?php if ($bukus) : ?>
                        <table class="table table-bordered table-striped table-hover tabel-biasa">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Label Buku</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Status</th>
                                <?php if ($level === 'admin'): ?>
                                    <th>Delete</th>
                                <?php endif ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($bukus as $buku): ?>

                                <td><?= ++$i ?></td>
                                <td><?= $buku->label_buku ?></td>
                                <td><?= $buku->judul_buku ?></td>
                                <td><?= $buku->penulis ?></td>
                                <td><?= $buku->penerbit ?></td>
                                <td><?= $buku->is_ada == 'y' ? '<span class="label label-success">ada': '<span class="label label-danger">dipinjam</span>' ?></td>
                                <?php if ($level === 'admin'): ?>

                                    <td>
                                        <?= form_open("buku/delete") ?>
                                        <?= form_hidden('id_buku',$buku->id_buku) ?>
                                        <?= form_button(['type' => 'submit','content' => '<i class="material-icons">delete</i>', 'class' => 'btn btn-danger waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Delete', 'onclick' => "return confirm('Anda yakin akan menghapus buku ini?')"]) ?>
                                        <?= form_close() ?>
                                    </td>
                                <?php endif ?>
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
                            <?= anchor("judul",'<< Kembali',['class' => 'btn btn-primary waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Kembali']) ?>
                        </div>
                    </div>
