<?php $i = 0 ?>


<!--flash message-->
<?php $this->load->view('_partial/flash_message') ?>

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
                <div class="body table-responsive">
                        <table id="serverside" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>NO</th>
                                <th>KELAS</th>
                                <th>EDIT</th>
                                <th>DELETE</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    <div class="row">

                        <!--    Button Create-->
                        <div class="col-xs-12">
                            <?= anchor("kelas/create",'Tambah Kelas',['class' => 'btn btn-primary waves-effect','data-toggle' => 'tooltip', 'data-placement' => 'right' ,'title' => 'Tambah Kelas']) ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var get_url = "<?=base_url('kelas');?>"; // get kelas url
    </script>
