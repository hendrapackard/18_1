<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>USER</h2>
                    </div>

                </div>

            </div>
            <div class="body">
                <h2 class="card-inside-title"><?= $heading ?></h2>
                <div class="row clearfix">
                    <?= form_open_multipart($form_action) ?>
                    <?= isset($input->id_user) ? form_hidden('id_user', $input->id_user) : '' ?>
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                        <div class="form-line">
                                <?= form_label('No Anggota','no_anggota',['class' => 'form-label']) ?>
                                <?= form_input('no_anggota',isset($input->no_anggota) ? $input->no_anggota : $data['autonumber'], ['class' => 'form-control', 'required autofocus','readonly'=>'true']) ?>
                            </div>
                        </div>
                        <?= form_error('no_anggota') ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                        <div class="form-line">
                            <?= form_label('No Induk','no_induk',['class' => 'form-label']) ?>
                            <?= form_input('no_induk',$input->no_induk, ['class' => 'form-control', 'required autofocus']) ?>
                            </div>
                        </div>
                        <?= form_error('no_induk') ?>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                        <div class="form-line">
                            <?= form_label('Password','password',['class' => 'form-label']) ?>
                            <?= form_password('password',$input->password, ['class' => 'form-control', 'required autofocus']) ?>
                            </div>
                        </div>
                        <?= form_error('password') ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                        <div class="form-line">
                                <?= form_radio('level','admin',
                                    isset($input->level) && ($input->level == 'admin') ? true : false,['id' => 'admin','class'=>'with-gap'])
                                ?>
                                <?= form_label('Administrator','admin') ?>

                                <?= form_radio('level','anggota',
                                    isset($input->level) && ($input->level == 'anggota') ? true : false,['id' => 'anggota','class'=>'with-gap'])
                                ?>
                                <?= form_label('Anggota','anggota') ?>

                            </div>
                        </div>
                        <?= form_error('level') ?>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                        <div class="form-line">
                                <?= form_radio('is_verified','y',
                                    isset($input->is_verified) && ($input->is_verified == 'y') ? true : false,['id' => 'y','class'=>'with-gap'])
                                ?>
                                <?= form_label('Terverifikasi','y') ?>

                                <?= form_radio('is_verified','n',
                                    isset($input->is_verified) && ($input->is_verified == 'n') ? true : false,['id' => 'n','class'=>'with-gap'])
                                ?>
                                <?= form_label('Tidak Terverifikasi','n') ?>

                            </div>
                        </div>
                        <?= form_error('is_verified') ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <?= form_label('Nama','nama',['class' => 'form-label']) ?>
                                <?= form_input('nama',$input->nama, ['class' => 'form-control', 'required autofocus']) ?>
                            </div>
                        </div>
                        <?= form_error('nama') ?>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <?= form_radio('jenis_kelamin','l',isset($input->jenis_kelamin) && ($input->jenis_kelamin == 'l') ? true : false,['id' => 'l','class' => 'with-gap']) ?>
                                <?= form_label('Laki - Laki','l') ?>
                                <?= form_radio('jenis_kelamin','p',isset($input->jenis_kelamin) && ($input->jenis_kelamin == 'p') ? true : false,['id' => 'p','class' => 'with-gap']) ?>
                                <?= form_label('Perempuan','p') ?>
                            </div>
                        </div>
                        <?= form_error('jenis_kelamin') ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <?= form_label('No Handphone','no_hp',['class' => 'form-label']) ?>
                                <?= form_input('no_hp',$input->no_hp, ['class' => 'form-control', 'required autofocus']) ?>
                            </div>
                        </div>
                        <?= form_error('no_hp') ?>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                        <div class="form-line">
                            <?= form_dropdown('id_kelas', getDropdownList('kelas',['id_kelas','nama_kelas'],'Kelas'),$input->id_kelas, ['class' => 'form-control','id' => 'kelas']) ?>
                            </div>
                        </div>
                        <?= form_error('id_kelas') ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                        <div class="form-line">
                                <?= form_upload('foto') ?>
                            </div>
                        </div>
                        <?= fileFormError('foto','<p class="form-error">', '</p>'); ?>
                    </div>
                </div>
                <div class="row clearfix">
                    <?php if (!empty($input->foto)): ?>
                        <div class="col-sm-6 right">
                            <div class="form-group form-float">
                            <div class="form-line">
                                <img src="<?= site_url("/foto/$input->foto") ?>" alt="<?= $input->no_induk ?>" class="img-responsive">
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
                            <?= anchor("user",'Batal', ['class' => 'btn btn-default waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'top' ,'title' => 'Batal']) ?>
                        </div>

                    </div>

                </div>

                <?= form_close() ?>
