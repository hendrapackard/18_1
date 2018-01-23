<!--flash message-->
<?php $this->load->view('_partial/flash_message') ?>
<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>APPROVE ANGGOTA</h2>
                    </div>

                </div>

            </div>
            <div class="body">
                <div class="body table-responsive">
                    <table id="serverside" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>No Anggota</th>
                                <th>No Induk</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>No Handphone</th>
                                <th>Kelas</th>
                                <th>Approve</th>
                                <th>Reject</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    <script>
                        var get_url = "<?=base_url('approve_anggota');?>"; // get peminjaman url
                    </script>