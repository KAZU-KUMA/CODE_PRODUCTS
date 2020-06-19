<!-- ===========================================================
ユーザー管理画面＊
=========================================================== -->
<!DOCTYPE html>
<html lang="ja">
<head>
<!-- head情報読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>ユーザー管理</title>
<!-- css読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'registered_user.css'); ?>">
</head>
<body>
<!-- ヘッダー読み込み -->
<?php include VIEW_PATH . 'templates/header_logined_admin.php';?>
<!-- コンテンツ -->
  <div class="container">
  <h1>ユーザー管理</h1>
<!-- ユーザー管理テーブル表示 -->
    <?php if(empty($users) === false): ?>
      <div class="table-responsive">
        <table class="table table-bordered text-center">
          <thead class="thead-light">
            <tr>
              <th class="text-nowrap">会員番号</th>
              <th class="text-nowrap">ユーザー名</th>
              <th class="text-nowrap">登録日</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($users as $user): ?>
              <tr>
                <td class="text-nowrap">
                  <?php print($user['user_id']); ?>
                </td>
                <td class="text-nowrap">
                  <?php print($user['name']); ?>
                </td>
                <td class="text-nowrap">
                  <?php print($user['created']); ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p>ユーザー登録はありません。</p>
    <?php endif; ?> 
    <form action="admin.php"  method="post">
      <input type="hidden" name="csrf_token" value="<?php print $token ?>">
      <input type="submit" value="戻る" class="btn btn-warning btn-block">
    </form>
  </div>
</body>
</html>
