<!-- ===========================================================
お問い合わせ画面(Googleフォーム)＊
=========================================================== -->
<!DOCTYPE html>
<html lang="ja">
<head>
<!-- head情報読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>お問い合わせ</title>
<!-- css読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'contact.css'); ?>">
</head>
<body>
<!-- ヘッダー読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
<!-- コンテンツ-->
  <div class="container">
    <h1>お問い合わせ</h1>
    <p>お問い合わせ内容をご入力の上、「送信」ボタンをクリックしてください。</p>
<!-- メッセージ表示 -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <form method="post" action="https://docs.google.com/forms/u/0/d/e/1FAIpQLSeQoGjWmqASxd6zpgdLrIj445VyyXM-J0a7ZDuh4-4U2iUPxA/formResponse" class="contact_form mx-auto mt-3">
      <div class="form-group">
        <label for="name">名前 </label>
        <input type="text" name="entry.2005620554"name="name" id="name" class="form-control" placeholder="Your Name">
      </div>
      <div class="form-group">
        <label for="email">メールアドレス </label>
        <input type="email" name="entry.1045781291" id="email" class="form-control" placeholder="Your Email">
      </div>
      <div class="form-group">
        <label for="subject">件名 </label>
        <input type="text" name="entry.1166974658" id="subject" class="form-control" placeholder="Subject">
      </div>
      <div class="form-group">
        <label for="contact">お問い合わせ内容</label>
        <textarea class="form-control" name="entry.839337160" placeholder="messages..." id="contact" rows='6'></textarea>
      </div>
      <input type="submit" value="送信" class="btn btn-primary btn-block">
      <input type="reset" value="リセット" class="btn btn-warning btn-block">
    </form>
    <form action="index.php"  method="post">
      <input type="hidden" name="csrf_token" value="<?php print $token ?>">
      <input type="submit" value="戻る" class="btn btn-warning btn-block my-5">
    </form>  
  </div>
<!-- フッター読み込み -->
<?php include VIEW_PATH . 'templates/footer.php'; ?>
</body>
</html>