<!-- ===========================================================
 メッセージ表示＊
=========================================================== -->
<!-- 失敗メッセージ -->
<?php foreach(get_errors() as $error){ ?>
  <p class="alert alert-danger mt-3"><span><?php print $error; ?></span></p>
<?php } ?>
<!-- 成功メッセージ -->
<?php foreach(get_messages() as $message){ ?>
  <p class="alert alert-success mt-3"><span><?php print $message; ?></span></p>
<?php } ?>