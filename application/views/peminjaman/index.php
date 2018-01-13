<?php
//Login?
$is_login = $this->session->userdata('is_login');
?>

<!--flash message-->
<?php $this->load->view('_partial/flash_message') ?>
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
                <div class="body table-responsive">
                    <table id="serverside" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jadwal Kembali</th>
                                <th>Kode Peminjaman</th>
                                <th>No Induk</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Label Buku</th>
                                <th>Judul</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>


                        </table>
                    <div class="row">
                        <!--    Button Create-->
                        <div class="col-xs-12">
                            <?= anchor("peminjaman/create",'Tambah',['class' => 'btn btn-primary']) ?>
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
                                    "url": "adminbsb/plugins/jquery-datatable/Indonesian.json",
                                    searchPlaceholder: "Kode Peminjaman, No Induk, Nama"
                                },
                                "lengthMenu": [ [5, 10, 25, -1], [5, 10, 25, "All"] ],"pageLength": 5,
                                "order" : [],
                                "ajax": {
                                    "url" : "<?= site_url('peminjaman/ajax_list'); ?>",
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