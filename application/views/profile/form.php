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
                <h2 class="card-inside-title">Ubah Profile</h2>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                            <?= form_open_multipart($form_action) ?>
                            <?= isset($input->id_user) ? form_hidden('id_user', $input->id_user) : '' ?>
                            <div class="form-line">
                                <?= form_label('No Induk','no_induk',['class' => 'form-label']) ?>
                                <?= form_input('no_induk',$input->no_induk, ['class' => 'form-control', 'required autofocus']) ?>
                            </div>
                        </div>
                        <?= form_error('no_induk') ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <?= form_label('Password','password',['class' => 'form-label']) ?>
                                <?= form_password('password',$input->password, ['class' => 'form-control', 'required autofocus']) ?>
                            </div>
                        </div>
                        <?= form_error('password') ?>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <?= form_label('Konfirmasi Password','passConf',['class' => 'form-label']) ?>
                                <?= form_password('passConf',$input->password, ['class' => 'form-control', 'required autofocus']) ?>
                            </div>
                        </div>
                        <?= form_error('passConf') ?>
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
                                <?= form_label('No Handphone','no_hp',['class' => 'form-label']) ?>
                                <?= form_input('no_hp',$input->no_hp, ['class' => 'form-control', 'required autofocus']) ?>
                            </div>
                        </div>
                        <?= form_error('no_hp') ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                                    <span class="input-group-addon">
                                     <i class="material-icons">file_upload</i>
                                     </span>
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
                            <div class="input-group">
                                <span class="input-group-addon">
                                 <i class="material-icons"></i>
                                 </span>
                                <div class="form-line">
                                    <img src="<?= site_url("/foto/$input->foto") ?>" alt="<?= $input->no_induk ?>" class="img-responsive cover_border">
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
                            <?= anchor("profile",'Batal', ['class' => 'btn btn-default waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'top' ,'title' => 'Batal']) ?>
                        </div>

                    </div>

                </div>

                <?= form_close() ?>
