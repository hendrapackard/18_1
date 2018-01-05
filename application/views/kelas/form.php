<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>KELAS</h2>
                    </div>

                </div>

            </div>
            <div class="body">
                <h2 class="card-inside-title"><?= $heading ?></h2>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                        <?= form_open($form_action) ?>
                            <div class="form-line">
                                <?= isset($input->id_kelas) ? form_hidden('id_kelas', $input->id_kelas) : '' ?>
                                <?= form_label('Nama Kelas','nama_kelas',['class' => 'form-label']) ?>
                                <?= form_input('nama_kelas',$input->nama_kelas, ['class' => 'form-control date', 'required autofocus']) ?>
                            </div>
                        </div>
                        <?= form_error('nama_kelas') ?>

                    </div>
                </div>
                <div class="footer">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-6">
                            <?= form_button(['type' => 'submit','content' => 'Simpan','class' => 'btn btn-primary waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'top' ,'title' => 'Simpan']) ?>
                            &nbsp;
                            <?= anchor("kelas",'Batal', ['class' => 'btn btn-default waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'top' ,'title' => 'Batal']) ?>
                        </div>

                    </div>

                </div>
                <?= form_close() ?>

