<!--flash message-->
<?php $this->load->view('_partial/flash_message') ?>

<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>PROFILE</h2>
                    </div>

                </div>

            </div>
            <div class="body">
                <div class="body table-responsive">
                    <?php if ($profiles) : ?>
                </div>
                <div class="col-sm-3">
                    <?php if (!empty($profiles->foto)): ?>
                        <img src="<?= site_url("foto/$profiles->foto") ?>" alt="<?= $profiles->no_induk ?>" class="cover_border">
                    <?php else: ?>
                        <img src="<?= site_url("foto/no_cover.jpg") ?>" alt="<?= $profiles->no_induk ?>" class="cover_border">
                    <?php endif?>
                </div>
                <div class="col-sm-4">
                    <table class="table table-bordered table-responsive">
                        <tr>
                            <th>No Anggota</th>
                            <td><?= $profiles->no_anggota ?></td>
                        </tr>
                        <tr>
                            <th>No Induk</th>
                            <td><?= $profiles->no_induk ?></td>
                        </tr>

                        <tr>
                            <th>Level</th>
                            <td><?= $profiles->level ?></td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td><?= $profiles->nama ?></td>
                        </tr>
                        <tr>
                            <th>No Handphone</th>
                            <td><?= $profiles->no_hp ?></td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td><?= $profiles->nama_kelas ?></td>
                        </tr>
                    </table>

                </div>
                <?php endif; ?>
                <div class="row">
                    <!--    Button Create-->
                    <div class="col-xs-12">
                        <?= anchor("profile/edit",'Ubah Profile',['class' => 'btn btn-primary waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Ubah Profile']) ?>
                    </div>
                </div>
            </div>
        </div>

