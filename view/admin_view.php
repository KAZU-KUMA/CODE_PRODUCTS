<!-- ===========================================================
商品管理画面＊
=========================================================== -->
<!DOCTYPE html>
<html lang="ja">
<head>
<!-- head情報読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>商品管理</title>
<!-- css読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'admin.css'); ?>">
</head>
<body>
<!-- ヘッダー読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined_admin.php';?>
<!-- コンテンツ -->
  <div class="container">
    <h1>商品管理</h1>
<!-- メッセージ表示 -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
<!-- 新規追加 -->
    <form 
      method="post" 
      action="admin_insert_item.php" 
      enctype="multipart/form-data"
      class="add_item_form col-md-6">
      <div class="form-group">
        <label for="name">名前 </label>
        <input class="form-control" type="text" name="name" id="name">
      </div>
      <div class="form-group">
        <label for="price">価格 </label>
        <input class="form-control" type="number" name="price" id="price">
      </div>
      <div class="form-group">
        <label for="stock">在庫数 </label>
        <input class="form-control" type="number" name="stock" id="stock">
      </div>
      <div class="form-group">
        <label for="image">商品画像 </label>
        <input type="file" name="image" id="image">
      </div>
      <div class="form-group">
        <label for="status">ステータス </label>
        <select class="form-control" name="status" id="status">
          <option value=1>公開</option>
          <option value=0>非公開</option>
        </select>
      </div>
      <div class="form-group">
        <label for="explanation">商品説明(100文字以内)</label>
        <textarea class="form-control" name='explanation' id="explanation" rows='6'></textarea>
      </div>
      <input type="hidden" name="csrf_token" value="<?php print $token ?>">
      <input type="submit" value="■□■□■商品登録■□■□■" class="btn btn-success">
    </form>
<!-- 商品一覧テーブル表示 -->
    <?php if(empty($items) === false): ?>
      <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead class="thead-light">
          <tr>
            <th class="text-nowrap">商品画像</th>
            <th class="text-nowrap">商品名</th>
            <th class="text-nowrap">価格</th>
            <th class="text-nowrap">在庫数</th>
            <th class="text-nowrap">ステータス</th>
            <th class="text-nowrap">操作</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($items as $item): ?>
            <tr class="<?php print(((int)$item['status'] === ITEM_STATUS_OPEN) ? '' : 'close_item'); ?>">
              <td>
                <img src="<?php print(IMAGE_PATH . $item['image']);?>" class="item_image">
              </td>
              <td class="text-nowrap">
                <?php print($item['name']); ?>
              </td>
              <td class="text-nowrap">
                <?php print(number_format($item['price'])); ?>円
              </td>
              <td class="text-nowrap">
                <form method="post" action="admin_change_stock.php">
                  <div class="form-group">
                    <input type="number" name="stock" value="<?php print($item['stock']); ?>">個
                  </div>
                  <input type="hidden" name="csrf_token" value="<?php print $token ?>">
                  <input type="submit" value="変更" class="btn btn-primary">
                  <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                </form>
              </td>
              <td>
                <form method="post" action="admin_change_status.php">
                  <?php if((int)$item['status'] === ITEM_STATUS_OPEN){ ?>
                    <input type="submit" value="公開 → 非公開" class="btn btn-primary">
                    <input type="hidden" name="changes_status" value=0>
                  <?php }else{ ?>
                    <input type="submit" value="非公開 → 公開" class="btn btn-secondary">
                    <input type="hidden" name="changes_status" value=1>
                  <?php } ?>
                  <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                  <input type="hidden" name="csrf_token" value="<?php print $token ?>">
                </form>
              </td>
              <td> 
                <form method="post" action="admin_delete_item.php">
                  <input type="hidden" name="csrf_token" value="<?php print $token ?>">
                  <input type="submit" value="削除" class="btn btn-danger delete">
                  <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
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
  </div>
<!-- 先頭へ -->
  <button id="back-to-top" class="btn btn-success top_page">
    <i class="fas fa-chevron-up"></i>
  </button>
<!-- js読み込み -->
  <script src="<?php print(JS_PATH . 'main.js'); ?>"></script>
</body>
</html>