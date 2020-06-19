<!-- ===========================================================
ログイン画面＊
=========================================================== -->
<!DOCTYPE html>
<html lang="ja">
<head>
<!-- head情報読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>ログイン</title>
<!-- css読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'login.css'); ?>">
</head>
<body>
<!-- ヘッダー読み込み -->
  <?php include VIEW_PATH . 'templates/header.php'; ?>
<!-- コンテンツ-->
  <div class="container">
<!-- メッセージ表示 -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <form method="post" action="login_process.php" class="login_form mx-auto mt-5">
      <div class="form-group">
        <label for="name">ユーザー名 </label>
        <input type="text" name="name" id="name" class="form-control">
      </div>
      <div class="form-group">
        <label for="password">パスワード </label>
        <input type="password" name="password" id="password" class="form-control">
      </div>
      <input type="hidden" name="csrf_token" value="<?php print $token ?>">
      <input type="submit" value="ログイン" class="btn btn-warning">
    </form>
  </div>
</body>
</html>