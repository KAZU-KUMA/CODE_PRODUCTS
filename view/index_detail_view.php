<!-- ===========================================================
商品詳細画面＊
=========================================================== -->
<!DOCTYPE html>
<html lang="ja">
<head>
<!-- head情報読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>商品詳細</title>
<!-- css読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'index_detail.css'); ?>">
</head>
<body>
<!-- ヘッダー読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined.php';?>
<!-- コンテンツ -->
  <div class="container">
    <h1>商品詳細</h1>
<!-- メッセージ表示 -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
<!-- 商品詳細テーブル表示 -->
    <?php if(empty($items) === false): ?>
      <?php foreach($items as $item): ?>
        <img src="<?php print(IMAGE_PATH . $item['image']);?>" class="item_image float-left col-md-4 mb-3">
        <div class="table-responsive col-md-8">
        <table class="table table-bordered text-center" >
          <tr>
            <td class="bg-light text-nowrap">商品名</td>
            <td class="text-left">
              <p class="mb-0 ml-2"><?php print($item['name']); ?></p>
            </td>
          </tr>
          <tr>
            <td class="bg-light text-nowrap">価格</td>
            <td class="text-left">
              <p class="mb-0 ml-2"><?php print(number_format($item['price'])); ?>円</p>
            </td>
          </tr>
          <tr>
            <td class="bg-light text-nowrap">在庫数</td>
            <td class="text-left">
              <?php if($item['stock'] >= DISPLAY_STOCK_MAX){ ?>
                <p class="text-success mb-0 ml-2">
                  <?php print('在庫多<br>残り'.$item['stock']); ?>個
                </p>
              <?php }else if($item['stock'] < DISPLAY_STOCK_MAX 
              && $item['stock'] > DISPLAY_STOCK_MIN ){ ?>
                <p class="text-danger mb-0 ml-2">
                  <?php print('残りわずか'.$item['stock']); ?>個<br>ご注文はお早めに!!
                </p>
              <?php }else{ ?>
                <p class="text-danger mb-0 ml-2">現在売り切れです</p>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td class="bg-light text-nowrap">商品説明</td>
            <td class="text-left">
              <?php $text = $item['explanation'];?>
              <?php
                $ua=$_SERVER['HTTP_USER_AGENT'];
                $browser = ((strpos($ua,'iPhone')!==false)||(strpos($ua,'Android')!==false));
                  if ($browser === true){
                  $browser = 'sp';
                }
                if($browser === 'sp'){
              ?>
                <!-- //スマホの場合に読み込むソースを記述 -->
                <?php $textwrap = mb_wordwrap($text, 15, "\n", true);?>
              <?php }else{ ?>
                <!-- //タブレット・PCの場合に読み込むソースを記述 -->
                <?php $textwrap = mb_wordwrap($text, 40, "\n", true);?>
              <?php } ?>
              <pre class="mb-0 ml-2"><?php print($textwrap); ?></pre>
            </td>
          </tr>
        </table>
        </div>
      <?php endforeach; ?>
      <?php if($item['stock'] > 0){ ?>
        <form action="index_add_cart.php" method="post" class="mb-3">
          <input type="hidden" name="csrf_token" value="<?php print $token ?>">
          <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
          <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
        </form>
      <?php } ?>
      <form action="index_add_favorite.php" method="post" class="mb-3">
        <input type="hidden" name="csrf_token" value="<?php print $token ?>">
        <input type="submit" value="お気に入りに追加" class="btn btn-primary btn-block">
        <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
      </form>
    <?php else: ?>
      <p>商品はありません。</p>
    <?php endif; ?>
  <!-- トークンのPOST送信(戻る) -->
    <form action="index.php"  method="post">
      <input type="hidden" name="csrf_token" value="<?php print $token ?>">
      <input type="submit" value="戻る" class="btn btn-warning btn-block mt-5">
    </form>  
  </div>
<!-- フッター読み込み -->
  <?php include VIEW_PATH . 'templates/footer.php'; ?>
</body>
</html>
