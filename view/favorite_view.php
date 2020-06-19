<!-- ===========================================================
お気に入り画面＊
=========================================================== -->
<!DOCTYPE html>
<html lang="ja">
<head>
<!-- head情報読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>お気に入り</title>
<!-- css読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'favorite.css'); ?>">
</head>
<body>
<!-- ヘッダー読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined.php';?>
<!-- コンテンツ -->
  <div class="container">
    <h1>お気に入り</h1>
<!-- メッセージ表示 -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
<!-- お気に入りテーブル表示 -->
    <?php if(empty($favorites) === false): ?>
      <div class="table-responsive">
      <table class="table table-bordered text-center">
      <thead class="thead-light">
        <tr>
          <th class="text-nowrap">商品画像</th>
          <th class="text-nowrap">商品名</th>
          <th class="text-nowrap">価格</th>
          <th class="text-nowrap">在庫数</th>
          <th class="text-nowrap">操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($favorites as $favorite): ?>
          <tr>
            <td>
              <img src="<?php print(IMAGE_PATH . $favorite['image']);?>" class="item_image">
            </td>
            <td class="text-nowrap">
              <a href="index_detail.php?id=<?php print $favorite['item_id']?>">
              <?php print($favorite['name']); ?>
              </a>
            </td>
            <td class="text-nowrap">
              <?php print(number_format($favorite['price'])); ?>円
            </td>
            <td>
              <?php if($favorite['stock'] >= DISPLAY_STOCK_MAX){ ?>
                <p class="text-success text-nowrap">
                  <?php print('在庫多<br>残り'.$favorite['stock']); ?>個
                </p>
              <?php }else if($favorite['stock'] < DISPLAY_STOCK_MAX 
              && $favorite['stock'] > DISPLAY_STOCK_MIN ){ ?>
                <p class="text-danger text-nowrap">
                  <?php print('残りわずか'.$favorite['stock']); ?>個<br>ご注文はお早めに!!
                </p>
              <?php }else{ ?>
                <p class="text-danger text-nowrap">現在売り切れです</p>
              <?php } ?>
            </td>
            <td>
            <form method="post" action="favorite_delete_favorite.php">
              <input type="hidden" name="csrf_token" value="<?php print $token ?>">
              <input type="submit" value="削除" class="btn btn-danger delete">
              <input type="hidden" name="item_id" value="<?php print($favorite['item_id']); ?>">
            </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    <?php else: ?>
    <p>商品登録はありません。</p>
    <?php endif; ?>
    <form action="index.php"  method="post">
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