<?php
$level = $this->session->userdata('level');
$i = 0;
?>

<!--flash message-->
<?php $this->load->view('_partial/flash_message') ?>
<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>BUKU</h2>
                    </div>

                </div>

            </div>
            <div class="body">
                <div class="body table-responsive">
                    <?php if ($juduls) : ?>
                        <table class="table table-bordered table-striped table-hover tabel-biasa-2">
                            <thead>
                            <tr><th>No</th>
                                <th>ISBN</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Jumlah Copy</th>
                                <th>Cover</th>
                                <th>Letak</th>
                                <?php if ($level === 'admin'): ?>
                                    <th>Add</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                <?php endif ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($juduls as $judul): ?>
                                <tr>
                                <td><?= ++$i ?></td>
                                <td><?= $judul->isbn ?></td>
                                <td><?= $judul->judul_buku ?></td>
                                <td><?= $judul->penulis ?></td>
                                <td><?= $judul->penerbit ?></td>
                                <td>Total: <?=  $judul->jumlah_total != 0 ? anchor("buku/total/$judul->id_judul",$judul->jumlah_total) : $judul->jumlah_total ?>
                                    <br>
                                    Ada : <?= $judul->jumlah_ada != 0 ? anchor("buku/ada/$judul->id_judul",$judul->jumlah_ada) : $judul->jumlah_ada ?>
                                    <br>
                                    Dipinjam : <?= $judul->jumlah_dipinjam != 0 ? anchor("buku/dipinjam/$judul->id_judul",$judul->jumlah_dipinjam) : $judul->jumlah_dipinjam ?> </td>
                                <td>
                                    <?php if (!empty($judul->cover)): ?>
                                        <img src="<?= site_url("cover/$judul->cover") ?>" alt="<?= $judul->judul_buku ?>">
                                    <?php else: ?>
                                        <img src="<?= site_url("cover/no_cover.jpg") ?>" alt="<?= $judul->judul_buku ?>">
                                    <?php endif?>
                                </td>
                                <td><?= $judul->letak ?></td>
                                <?php if ($level === 'admin'): ?>
                                    <td>
                                        <?= form_open("buku/create") ?>
                                        <?= form_hidden('id_judul',$judul->id_judul) ?>
                                        <?= form_hidden('first_load',true) ?>
                                        <?= form_button(['type' => 'submit','content' => '<i class="material-icons">add</i>', 'class' => 'btn btn-success waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Tambah Copy Buku']) ?>
                                        <?= form_close() ?></td>
                                    <td>
                                        <?= anchor("judul/edit/$judul->id_judul", '<i class="material-icons">edit</i>', ['class' => 'btn btn-warning waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Edit','target' => '_blank']) ?>
                                    </td>
                                    <td>
                                        <?= form_open("judul/delete/$judul->id_judul") ?>
                                        <?= form_hidden('id_judul',$judul->id_judul) ?>
                                        <?= form_button(['type' => 'submit', 'content' => '<i class="material-icons">delete</i>', 'class' => 'btn btn-danger waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Delete','onclick' => "return confirm('Anda yakin akan menghapus judul ini?')"]) ?>
                                        <?= form_close() ?>
                                    </td>
                                    </tr>
                                <?php endif ?>
                            <?php endforeach ?>
                            </tbody>


                        </table>
                    <?php else: ?>
                        <p>Tidak ada data Buku</p>
                    <?php endif ?>
                    <div class="row">
                        <!--    Button Create-->
                        <div class="col-xs-12">
                            <?php if ($level === 'admin'): ?>
                                <?= anchor("judul/create",'Tambah Judul',['class' => 'btn btn-primary waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Tambah Judul']) ?>
                            <?php else: ?>
                                &nbsp;
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
