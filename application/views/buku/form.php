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
                <h2 class="card-inside-title">Anda akan menambahkan buku :</h2>
                <div class="row clearfix">
                    <div class="col-sm-10">
                        <div class="col-sm-2">
                            ISBN
                        </div>
                        <div class="col-sm-10">
                            : <?= $judul->isbn ?>
                        </div>

                        <div class="col-sm-2">
                            Judul
                        </div>
                        <div class="col-sm-10">
                            : <?= $judul->judul_buku ?>
                        </div>
                        <div class="col-sm-2">
                            Penulis
                        </div>
                        <div class="col-sm-10">
                            : <?= $judul->penulis ?>
                        </div>
                        <div class="col-sm-2">
                            Penerbit
                        </div>
                        <div class="col-sm-10">
                            : <?= $judul->penerbit ?>
                        </div>
                        <div class="col-sm-2">
                            Letak
                        </div>
                        <div class="col-sm-10">
                            : <?= $judul->letak ?>
                        </div>
                        <div class="col-sm-2">
                            Klasifikasi
                        </div>
                        <div class="col-sm-10">
                            : <?= $judul->klasifikasi == '000' ? 'Komputer, informasi dan referensi umum' : ($judul->klasifikasi == '100' ? 'Filsafat dan psikologi': ($judul->klasifikasi == '200' ? 'Agama':  ($judul->klasifikasi == '300' ? 'Ilmu Sosial':($judul->klasifikasi == '400' ? 'Bahasa':($judul->klasifikasi == '500' ? 'Sains dan matematika':($judul->klasifikasi == '600' ? 'Teknologi':($judul->klasifikasi == '700' ? 'Kesenian dan rekreasi':($judul->klasifikasi == '800' ? 'Sastra':  'Sejarah dan geografi')))))))) ?>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <?php if (!empty($judul->cover)): ?>
                            <img src="<?= site_url("cover/$judul->cover") ?>" alt="<?= $judul->judul_buku ?>">
                        <?php else: ?>
                            <img src="<?= site_url("cover/no_cover.jpg") ?>" alt="<?= $judul->judul_buku ?>">
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="footer">

                <?= form_open($form_action) ?>

                <?= isset($input->id_judul) ? form_hidden('id_judul',$input->id_judul) : ''?>
                <div class="row clearfix">
                    <div class="col-sm-10">
                        <div class="col-sm-6">
                            <div class="form-group form-float">
                            <div class="form-line">
                                <?= form_label('Jumlah Buku','jumlah_buku',['class' => 'form-label']) ?>
                                <?= form_input('jumlah_buku', isset($input->jumlah_buku) ? $input->jumlah_buku : '', ['class' => 'form-control key', 'required autofocus']) ?>
                                </div>
                            </div>
                            <?= form_error('jumlah_buku') ?>
                        </div>
                        <?= form_button(['type' => 'submit','content' => 'Simpan','class' => 'btn btn-primary waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'top' ,'title' => 'Simpan']) ?>
                        &nbsp;
                        <?= anchor("judul",'Batal', ['class' => 'btn btn-default waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'top' ,'title' => 'Batal']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

