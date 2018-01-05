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

<!--    Konfigurasi serverside-->
    <?php echo server_side() ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#serverside').DataTable({
                "processing" : true,
                "serverSide" : true,
                "language": {
                    "url": "adminbsb/plugins/jquery-datatable/Indonesian.json"
                },
                "lengthMenu": [ [5, 10, 25, -1], [5, 10, 25, "All"] ],"pageLength": 5,
                "order" : [],
                "ajax": {
                    "url" : "<?= site_url('kelas/ajax_list'); ?>",
                    "type" : "POST"
                },
                "columnDefs" : [
                    {
                        "targets" : [0],
                        "orderable":false,
                    },
                ],
            });
        });
    </script>

