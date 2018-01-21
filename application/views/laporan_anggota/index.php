<?php $i = 0 ?>


<!--flash message-->
<?php $this->load->view('_partial/flash_message') ?>

<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>LAPORAN ANGGOTA</h2>
                    </div>

                </div>

            </div>
            <div class="body">
                <div class="body table-responsive">
                    <table id="serverside" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr><th>No</th>
                                <th>Nama</th>
                                <th>No Induk</th>
                                <th>Jenis Kelamin</th>
                                <th>No Handphone</th>
                                <th>Kelas</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>


                        </table>
                    <div class="row">
                        <!--    Button Create-->
                        <div class="col-xs-12">
                            <?= anchor("cetak-laporan-anggota",'Cetak',['class' => 'btn btn-primary waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Cetak','target' => '_blank']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var get_url = "<?=base_url('Laporan_anggota');?>"; // get laporan url
    </script>


