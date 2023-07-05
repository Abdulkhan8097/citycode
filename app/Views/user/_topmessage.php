<?php
$session = \Config\Services::session();
 $message = $session->getFlashdata('message') ? $session->getflashdata('message') : '';
 $errmessage = $session->getFlashdata('errmessage') ? $session->getFlashdata('errmessage') : '';
if ($message) {
?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $message; ?>
</div><br>
<?php } else if($errmessage){
 ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<?php echo $errmessage; ?><br>
</div>
<?php } ?>