<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>PEMINJAMAN</h2>
                    </div>

                </div>

            </div>
            <div class="body">
                <h2 class="card-inside-title">Tambah Peminjaman</h2>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                            <?= form_open($form_action,['id' => 'form-peminjaman','autocomplete' => 'off']) ?>
                            <div class="form-line">
                                <?= form_label('Kode Peminjaman' ,'kode_pinjam',['class' => 'form-label']) ?>
                                <?= form_input('kode_pinjam',date('YmdHis'), ['class' => 'form-control', 'required autofocus', 'readonly'=>'true']) ?>
                            </div>
                        </div>
                        <?= form_error('kode_pinjam') ?>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <?= form_label('Tanggal Pinjam' ,'tanggal_pinjam',['class' => 'form-label']) ?>
                                <?= form_input('tanggal_pinjam',date('Y-m-d'), ['class' => 'form-control', 'required autofocus','readonly'=>'true','id'=>'tanggal_pinjam']) ?>                            </div>
                        </div>
                        <?= form_error('tanggal_pinjam') ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <?= form_label('Jadwal Kembali' ,'jadwal_kembali',['class' => 'form-label']) ?>
                                <?= form_input('jadwal_kembali',cariTanggalKembali(date('Y-m-d')), ['class' => 'form-control', 'required autofocus','readonly'=>'true','id'=>'jadwal_kembali']) ?>
                            </div>
                        </div>
                        <?= form_error('jadwal_kembali') ?>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <?= form_label('Nama' ,'search_user',['class' => 'form-label']) ?>
                                <?= form_input('search_user',$input->search_user,['class' => 'form-control', 'onkeyup' => 'userAutoComplete()','required autofocus','id' => 'search_user']) ?>
                                <ul id="user_list" class="live-search-list"></ul>
                            </div>
                        </div>
                        <?= form_error('search_user') ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <?= form_label('Judul Buku Pertama' ,'search_buku',['class' => 'form-label']) ?>
                                <?= form_input('search_buku',$input->search_buku,['class' => 'form-control', 'onkeyup' => 'bukuAutoComplete()','required autofocus','id' => 'search_buku']) ?>
                                <?= form_hidden('status','2') ?>
                                <ul id="buku_list" class="live-search-list"></ul>
                            </div>
                            <br>
                        <?= form_error('search_buku') ?>
                            <div class="input-group">
                            <span class="input-group-addon align-right">
                                <button type="button" class="btn btn-success waves-effect" id="input2" data-toggle="tooltip" data-placement="top" title="Tambah Input Buku"><i class="material-icons" style="color: white">add</i></button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-offset-6 col-sm-6">
                        <div class="form-group form-float" id="input-buku2" style="display: none">
                            <div class="form-line">
                                <?= form_label('Judul Buku Kedua' ,'search_buku2',['class' => 'form-label']) ?>
                                <?= form_input('search_buku2',$input->search_buku2,['class' => 'form-control', 'onkeyup' => 'bukuAutoComplete2()','required autofocus','id' => 'search_buku2']) ?>
                                <ul id="buku_list2" class="live-search-list"></ul>
                            </div>
                        </div>
                        <?= form_error('search_buku2') ?>
                    </div>
                </div>
                <div class="footer">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-6">
                            <?= form_button(['type' => 'submit','content' => 'Simpan','class' => 'btn btn-primary waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'top' ,'title' => 'Simpan']) ?>
                            &nbsp;
                            <?= anchor("peminjaman",'Batal', ['class' => 'btn btn-default waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'top' ,'title' => 'Batal']) ?>
                        </div>

                    </div>

                </div>

                <!-- Real input for id_siswa and id_buku -->
                <?= isset($input->id_user) ? form_input(['type' => 'hidden', 'name' => 'id_user', 'id' => 'id-user', 'value' => $input->id_user]) : '' ?>
                <?= isset($input->id_buku1) ? form_input(['type' => 'hidden', 'name' => 'id_buku1', 'id' => 'id-buku1', 'value' => $input->id_buku1]) : '' ?>
                <?= isset($input->id_buku2) ? form_input(['type' => 'hidden', 'name' => 'id_buku2', 'id' => 'id-buku2', 'value' => $input->id_buku2]) : '' ?>

                <?= form_close() ?>

                <script>
                    //konfigurasi untuk app.js
                    var get_url_user = "<?=base_url('/peminjaman/user_auto_complete');?>"; // get url user
                    var get_url_buku = "<?=base_url('/peminjaman/buku_auto_complete');?>"; // get url buku
                    var get_url_buku2 = "<?=base_url('/peminjaman/buku_auto_complete2');?>"; // get url buku2
                </script>