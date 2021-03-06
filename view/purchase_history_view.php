<!-- ===========================================================
購入履歴画面＊
=========================================================== -->
<!DOCTYPE html>
<html lang="ja">
<head>
<!-- head情報読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入履歴</title>
<!-- css読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'purchase_history.css'); ?>">
</head>
<body>
<!-- ヘッダー読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
<!-- コンテンツ -->
  <div class="container">
  <h1>購入履歴</h1>
<!-- メッセージ表示 -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
<!-- 購入履歴テーブル表示 -->
    <?php if(empty($historys) === false): ?>
      <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead class="thead-light">
          <tr>
            <th class="text-nowrap">注文番号</th>
            <th class="text-nowrap">購入日時</th>
            <th class="text-nowrap">合計金額</th>
            <th class="text-nowrap">購入明細</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($historys as $history): ?>
            <tr>
              <td class="text-nowrap">
                <?php print($history['history_id']); ?>
              </td>
              <td class="text-nowrap">
                <?php print($history['created']); ?>
              </td>
              <td class="text-nowrap">
                <?php print(number_format($history['total_price'])); ?>円
              </td>
              <td class="text-nowrap">
                <a href="purchase_detail.php?id=<?php print $history['history_id']?>">表示</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    <?php else: ?>
      <p>購入履歴はありません。</p>
    <?php endif; ?> 
    <form action="index.php" method="post">
      <input type="hidden" name="csrf_token" value="<?php print $token ?>">
      <input type="submit" value="戻る" class="btn btn-warning btn-block">
    </form>
  </div>
<!-- フッター読み込み -->
  <?php include VIEW_PATH . 'templates/footer.php'; ?>
</body>
</html>