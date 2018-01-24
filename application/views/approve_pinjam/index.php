<!--flash message-->
<?php $this->load->view('_partial/flash_message') ?>
<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>APPROVE PEMINJAMAN</h2>
                    </div>

                </div>

            </div>
            <div class="body">
                <div class="body table-responsive">
                    <table id="serverside" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kode Peminjaman</th>
                                <th>No Induk</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Label Buku</th>
                                <th>Judul</th>
                                <th>Approve</th>
                                <th>Reject</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    <script>
                        var get_url = "<?=base_url('approve_pinjam');?>"; // get peminjaman url
                    </script>