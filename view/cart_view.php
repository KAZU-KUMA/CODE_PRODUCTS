<!-- ===========================================================
カート画面＊
=========================================================== -->
<!DOCTYPE html>
<html lang="ja">
<head>
<!-- head情報読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>カート</title>
<!-- css読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'cart.css'); ?>">
</head>
<body>
<!-- ヘッダー読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
<!-- コンテンツ -->
  <div class="container">
  <h1>カート</h1>
<!-- メッセージ表示 -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
<!-- カートテーブル表示 -->
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
            <th class="text-nowrap">操作</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($carts as $cart): ?>
            <tr>
              <td>
                <img src="<?php print(IMAGE_PATH . $cart['image']);?>" class="item_image">
              </td>
              <td class="text-nowrap">
                <a href="index_detail.php?id=<?php print $cart['item_id']?>">
                  <?php print($cart['name']); ?>
                </a>
              </td>
              <td class="text-nowrap">
                <?php print(number_format($cart['price'])); ?>円
              </td>
              <td class="text-nowrap">
                <form method="post" action="cart_change_amount.php">
                  <input type="number" name="amount" value="<?php print($cart['amount']); ?>">個
                  <input type="hidden" name="csrf_token" value="<?php print $token ?>">
                  <input type="submit" value="変更" class="btn btn-primary">
                  <input type="hidden" name="item_id" value="<?php print($cart['item_id']); ?>">
                </form>
              </td>
              <td class="text-nowrap">
                <?php print(number_format($cart['price'] * $cart['amount'])); ?>円
              </td>
              <td>
                <form method="post" action="cart_delete_cart.php">
                  <input type="hidden" name="csrf_token" value="<?php print $token ?>">
                  <input type="submit" value="削除" class="btn btn-danger delete">
                  <input type="hidden" name="item_id" value="<?php print($cart['item_id']); ?>">
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          <tr>
            <td class="bg-light">合計金額</td>
            <td colspan="5"><?php print number_format($total_price); ?>円</td>
          </tr>
        </tbody>
      </table>
      </div>
      <form method="post" action="finish.php" class="mb-3">
        <input type="hidden" name="csrf_token" value="<?php print $token ?>">
        <input class="btn btn-block btn-primary" type="submit" value="購入する">
      </form>
    <?php else: ?>
      <p>カートに商品はありません。</p>
    <?php endif; ?> 
    <form action="index.php" method="post">
      <input type="hidden" name="csrf_token" value="<?php print $token ?>">
      <input type="submit" value="戻る" class="btn btn-warning btn-block">
    </form>
  </div>
<!-- js読み込み -->
  <script src="<?php print(JS_PATH . 'main.js'); ?>"></script>
<!-- フッター読み込み -->
<?php include VIEW_PATH . 'templates/footer.php'; ?>
</body>
</html>