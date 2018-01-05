<?php $i = 0 ?>


<!--flash message-->
<?php $this->load->view('_partial/flash_message') ?>

<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>PROYEK</h2>
                    </div>

                </div>

            </div>
            <div class="body">
                <div class="body table-responsive">
                    <?php if ($proyeks) : ?>
                        <table class="table-bordered table-striped table-hover tabel-biasa">
                            <thead>
                            <tr>
                                <th>NO</th>
                                <th>TANGGAL</th>
                                <th>PIC</th>
                                <th>PROYEK</th>
                                <th>TASK</th>
                                <th>WAKTU</th>
                                <th>EDIT</th>
                                <th>DELETE</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($proyeks as $proyek): ?>

                                <td><?= ++$i ?></td>
                                <td><?= $proyek->tanggal ?></td>
                                <td><?= $proyek->pic ?></td>
                                <td><?= $proyek->proyek ?></td>
                                <td><?= $proyek->task ?></td>
                                <td><?= $proyek->waktu ?></td>
                                <td><?= anchor("proyek/edit/$proyek->id_proyek",'<i class="material-icons">edit</i>', ['class' => 'btn btn-warning waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Edit']) ?></td>
                                <td>
                                    <?= form_open("proyek/delete/$proyek->id_proyek") ?>
                                    <?= form_hidden('id_proyek',$proyek->id_proyek) ?>
                                    <?= form_button(['type' => 'submit','content' => '<i class="material-icons">delete</i>', 'class' => 'btn btn-danger waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Delete','onclick' => "return confirm('Anda yakin akan menghapus proyek ini?')"]) ?>
                                    <?= form_close() ?>
                                </td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>


                        </table>
                    <?php else: ?>
                        <p>Tidak ada data proyek.</p>
                    <?php endif ?>
                    <div class="row">
                        <!--    Button Create-->
                        <div class="col-xs-12">
                            <?= anchor("proyek/create",'Tambah Proyek',['class' => 'btn btn-primary waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Tambah Proyek']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


