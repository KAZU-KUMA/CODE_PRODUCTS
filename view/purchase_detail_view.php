<!-- ===========================================================
購入明細画面＊
=========================================================== -->
<!DOCTYPE html>
<html lang="ja">
<head>
<!-- head情報読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入明細</title>
<!-- css読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'purchase_detail.css'); ?>">
</head>
<body>
<!-- ヘッダー読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
<!-- コンテンツ -->
  <div class="container">
  <h1>購入明細</h1>
<!-- メッセージ表示 -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
<!-- 購入明細テーブル表示 -->
    <?php if(empty($details) === false): ?>
<!-- 購入履歴 -->
      <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead class="thead-light">
          <tr>
            <th class="text-nowrap">注文番号</th>
            <th class="text-nowrap">購入日時</th>
            <th class="text-nowrap">合計金額</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($historys as $history): ?>
            <tr>
              <td><?php print($history['history_id']); ?></td>
              <td><?php print($history['created']); ?></td>
              <td><?php print(number_format($history['total_price'])); ?>円</td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
<!-- 購入明細 -->
      <table class="table table-bordered text-center">
        <thead class="thead-light">
          <tr>
           <th class="text-nowrap">商品名</th>
           <th class="text-nowrap">価格</th>
           <th class="text-nowrap">購入数</th>
           <th class="text-nowrap">小計</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($details as $detail): ?>
            <tr>
              <td class="text-nowrap">
                <a href="index_detail.php?id=<?php print $detail['item_id']?>">
                <?php print($detail['purchase_name']); ?>
                </a>
              </td>
              <td class="text-nowrap">
                <?php print($detail['purchase_price']); ?>
              </td>
              <td class="text-nowrap">
                <?php print($detail['purchase_number']); ?>
              </td>
              <td class="text-nowrap">
                <?php print(number_format($detail['purchase_price'] * $detail['purchase_number'])); ?>円
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    <?php else: ?>
      <p>購入履歴はありません。</p>
    <?php endif; ?> 
    <form action="purchase_history.php"  method="post">
      <input type="hidden" name="csrf_token" value="<?php print $token ?>">
      <input type="submit" value="戻る" class="btn btn-warning btn-block">
    </form>
  </div>
<!-- フッター読み込み -->
  <?php include VIEW_PATH . 'templates/footer.php'; ?>
</body>
</html>