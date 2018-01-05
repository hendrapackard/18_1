<?php
 $success = $this->session->flashdata('success');
 $error = $this->session->flashdata('error');
 $warning = $this->session->flashdata('warning');

 if ($error) {
     $message_status = 'alert alert-danger';
     $message = $error;
 }

 if ($warning) {
     $message_status = 'alert alert-warning';
     $message = $warning;
 }

 if ($success) {
     $message_status = 'alert alert-success';
     $message = $success;
 }
 ?>

<?php if ($success || $warning || $error): ?>
<div class="box-body">
    <div class="<?= $message_status ?>">
        <?= $message ?>
    </div>
</div>

<?php endif ?>
