<!-- ===========================================================
商品一覧画面＊
=========================================================== -->
<!DOCTYPE html>
<html lang="ja">
<head>
<!-- head情報読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>商品一覧</title>
<!-- css読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'index.css'); ?>">
</head>
<body>
<!-- ヘッダー読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined.php';?>
<!-- コンテンツ --> 
  <div class="container">
    <h1>商品一覧</h1>
<!-- 検索フォーム、並び替え -->
    <form action='index_search.php' method='post' class='mb-3'>
      <div class="input-group">
      <input type="text" class="form-control" name="keyword" placeholder="商品名を入力してください">
      <div class="input-group-prepend" >
        <select class="btn-secondary" name="select">
          <option value="display_item">並替え</option>
          <option value="high_price">高い順</option>
          <option value="low_price">安い順</option>
          <option value="rank_item">人気順</option>
          <option value="new_item">新着順</option>
        </select>
      </div>
      <div class="input-group-append" >
      <input type="hidden" name="csrf_token" value="<?php print $token ?>">
      <input type='submit' class="btn btn-warning " name='search' value='検索'>
      </div>
      </div>
    </form>
<!-- メッセージ表示 -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
<!-- 商品一覧テーブル表示 -->
    <?php if(empty($items) === false): ?>
      <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead class="thead-light">
          <tr>
          <?php if($select === "rank_item"){ ?>
            <th class="text-nowrap">順位</th>
          <?php } ?>
            <th class="text-nowrap">商品画像</th>
            <th class="text-nowrap">商品名</th>
            <th class="text-nowrap">価格</th>
            <th class="text-nowrap">在庫数</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1;?>
          <?php foreach($items as $item): ?>
            <?php $rank = $i++;?>
            <tr>
            <?php if($select === "rank_item"){ ?>
              <td>
                <?php print($rank); ?>
              </td>
            <?php } ?>
              <td>
                <img src="<?php print(IMAGE_PATH . $item['image']);?>" class="item_image">
              </td>
              <td class="text-nowrap">
                <a href="index_detail.php?id=<?php print $item['item_id']?>">
                  <?php print($item['name']); ?>
                </a>
              </td>
              <td class="text-nowrap">
                <?php print(number_format($item['price'])); ?>円
              </td>
              <td> 
                <?php if($item['stock'] >= DISPLAY_STOCK_MAX){ ?>
                  <p class="text-success text-nowrap">
                    <?php print('在庫多<br>残り'.$item['stock']); ?>個
                  </p>
                <?php }else if($item['stock'] < DISPLAY_STOCK_MAX 
                && $item['stock'] > DISPLAY_STOCK_MIN ){ ?>
                  <p class="text-danger text-nowrap">
                    <?php print('残りわずか'.$item['stock']); ?>個<br>ご注文はお早めに!!
                  </p>
                <?php }else{ ?>
                  <p class="text-danger text-nowrap">現在売り切れです</p>
                <?php } ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    <?php else: ?>
      <p>商品登録はありません。</p>
    <?php endif; ?>

<!-- ページネーション -->
    <?php if((isset($_POST['search'])) !== TRUE): ?>
    <!-- 前に進む -->
    <?php if($page >= 2){?>
      <p class="float-left"><a href="index.php?page=<?php print($page-1); ?>"><?php print($page-1); ?>ページ目へ</a></p>
    <?php } ?>
    <!-- 後へ進む -->
    <?php $max_page = ceil($count['count_item'] / PAGINATION);
      if($page < $max_page){
    ?>
      <p class="float-right"><a href="index.php?page=<?php print($page+1); ?>"><?php print($page+1); ?>ページ目へ</a></p>
      <?php } ?>
    <?php endif; ?>
  </div>
<!-- 先頭へ -->
<button id="back-to-top" class="btn btn-success top_page">
  <i class="fas fa-chevron-up"></i>
</button>
<!-- js読み込み -->
  <script src="<?php print(JS_PATH . 'main.js'); ?>"></script>
<!-- フッター読み込み -->
  <?php include VIEW_PATH . 'templates/footer.php'; ?>
</body>
</html>