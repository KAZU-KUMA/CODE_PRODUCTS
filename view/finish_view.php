<!-- ===========================================================
購入完了画面＊
=========================================================== -->
<!DOCTYPE html>
<html lang="ja">
<head>
<!-- head情報読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入完了</title>
<!-- css読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'finish.css'); ?>">
</head>
<body>
<!-- ヘッダー読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
<!-- コンテンツ -->
  <div class="container">
<!-- メッセージ表示 -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
<!-- 購入テーブル表示 -->
    <?php if(empty($carts) === false): ?>
      <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead class="thead-light">
          <tr>
            <th class="text-nowrap">商品画像</th>
            <th class="text-nowrap">商品名</th>
            <th class="text-nowrap">価格</th>
            <th class="text-nowrap">購入数</th>
            <th class="text-nowrap">小計</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($carts as $cart): ?>
            <tr>
              <td>
                <img src="<?php print(IMAGE_PATH . $cart['image']);?>" class="item_image">
              </td>
              <td class="text-nowrap">
                <?php print($cart['name']); ?>
              </td>
              <td class="text-nowrap">
                <?php print(number_format($cart['price'])); ?>円
              </td>
              <td class="text-nowrap">
                <?php print($cart['amount']); ?>個
              </td>
              <td class="text-nowrap">
                <?php print(number_format($cart['price'] * $cart['amount'])); ?>円
              </td>
            </tr>
          <?php endforeach; ?>
          <tr>
           <td class="bg-light">合計金額</td>
           <td colspan="4"><?php print number_format($total_price); ?>円</td>
          </tr>
        </tbody>
      </table>
      </div>
    <?php else: ?>
      <p>購入した商品はありません。</p>
    <?php endif; ?> 
    <form action="index.php"  method="post">
      <input type="hidden" name="csrf_token" value="<?php print $token ?>">
      <input type="submit" value="戻る" class="btn btn-warning btn-block">
    </form>
  </div>
<!-- フッター読み込み -->
<?php include VIEW_PATH . 'templates/footer.php'; ?>
</body>
</html>