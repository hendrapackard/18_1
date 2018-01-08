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
                <h2 class="card-inside-title"><?= $heading ?></h2>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                        <?= form_open_multipart($form_action) ?>
                            <?= isset($input->id_judul) ? form_hidden('id_judul', $input->id_judul) : '' ?>
                            <div class="form-line">
                                <?= form_label('ISBN','isbn',['class' => 'form-label']) ?>
                                <?= form_input('isbn',$input->isbn, ['class' => 'form-control', 'required autofocus']) ?>
                            </div>
                        </div>
                        <?= form_error('isbn') ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                        <div class="form-line">
                                <?= form_label('Judul Buku','judul_buku',['class' => 'form-label']) ?>
                                <?= form_input('judul_buku',$input->judul_buku, ['class' => 'form-control', 'required autofocus']) ?>
                            </div>
                        </div>
                        <?= form_error('judul_buku') ?>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                        <div class="form-line">
                                <?= form_label('Penulis','penulis',['class' => 'form-label']) ?>
                                <?= form_input('penulis',$input->penulis, ['class' => 'form-control', 'required autofocus']) ?>
                            </div>
                        </div>
                        <?= form_error('penulis') ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                        <div class="form-line">
                                <?= form_label('Penerbit','penerbit',['class' => 'form-label']) ?>
                                <?= form_input('penerbit',$input->penerbit, ['class' => 'form-control', 'required autofocus']) ?>
                            </div>
                        </div>
                        <?= form_error('penerbit') ?>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="input-group">
                            <div class="form-line">
                                <?= form_dropdown('klasifikasi',  ['' => '-- Pilih Klasifikasi --','000' => 'Komputer, informasi dan referensi umum','100' => 'Filsafat dan psikologi','200' => 'Agama','300' => 'Ilmu Sosial','400' => 'Bahasa','500' => 'Sains dan matematika','600' => 'Teknologi','700' => 'Kesenian dan rekreasi','800' => 'Sastra','900' => 'Sejarah dan geografi'],$input->klasifikasi , ['class' => 'form-control', 'required autofocus']) ?>
                            </div>
                        </div>
                        <?= form_error('klasifikasi') ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                        <div class="form-line">
                            <?= form_dropdown('letak',  ['' => '-- Pilih Letak --','A' => 'A','B' => 'B','C' => 'C','D' => 'D','E' => 'E','F' => 'F','G' => 'G','H' => 'H'],$input->letak , ['class' => 'form-control', 'required autofocus']) ?>
                        </div>
                        </div>
                        <?= form_error('letak') ?>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6 right">
                        <div class="form-group form-float">
                        <div class="form-line">
                                <?= form_upload('cover') ?>
                            </div>
                        </div>
                        <?= fileFormError('cover','<p class="form-error">', '</p>'); ?>
                    </div>
                    <?php if (!empty($input->cover)): ?>
                        <div class="col-sm-6 right">
                            <div class="input-group">
                                <span class="input-group-addon">
                                 <i class="material-icons"></i>
                                 </span>
                                <div class="form-line">
                                    <img src="<?= site_url("/cover/$input->cover") ?>" alt="<?= $input->judul_buku ?>">
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
                <div class="footer">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-6">
                            <?= form_button(['type' => 'submit','content' => 'Simpan','class' => 'btn btn-primary waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'top' ,'title' => 'Simpan']) ?>
                            &nbsp;
                            <?= anchor("judul",'Batal', ['class' => 'btn btn-default waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'top' ,'title' => 'Batal']) ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= form_close() ?>
