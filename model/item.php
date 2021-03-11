<?php
// 外部ファイル読み込み(モデル読み込み)
require_once MODEL_PATH . "functions.php";
require_once MODEL_PATH . "db.php";

/*===========================================================*/
//商品取得
/*===========================================================*/
/*===========================================================
関数名：get_all_items
機能：登録商品情報の取得(管理画面、全体)
引数：$db[DB接続情報]
戻り値：レコードの取得値
===========================================================*/
function get_all_items($db){
  $sql = "SELECT * FROM items ";
  return fetch_all_query($db, $sql);
}

/*===========================================================
関数名：get_open_items
機能：登録商品情報の取得(商品一覧画面、公開のみ、検索、並び替え)
引数：$db[DB接続情報]
戻り値：レコードの取得値
===========================================================*/
function get_open_items($db, $select="", $keyword="", $start=""){
  if (isset($_POST['search']) === TRUE) {
    if($select === "display_item"){
      $sql = "SELECT * FROM items WHERE status = ? AND name like ?";
      $params=[ITEM_STATUS_OPEN, '%'.$keyword.'%'];
      // set_message('キーワードのみ');
    }else if($select === "high_price"){
      $sql = "SELECT * FROM items WHERE status = ? AND name like ? ORDER BY price DESC";
      set_message('高い順');
      $params=[ITEM_STATUS_OPEN, '%'.$keyword.'%'];
    }else if($select === "low_price"){
      $sql = "SELECT * FROM items WHERE status = ? AND name like ? ORDER BY price ASC";
      $params=[ITEM_STATUS_OPEN, '%'.$keyword.'%'];
      set_message('安い順');
    }else if($select === "rank_item"){
      $sql = "SELECT 
      items.item_id,
      items.name,
      items.stock,
      items.price,
      items.image,
      items.status,
      SUM(purchase_details.purchase_number) AS sum_amount 
      FROM
      items
      INNER JOIN purchase_details
      ON items.item_id = purchase_details.item_id
      WHERE status = ? AND name like ?
      GROUP BY items.item_id
      ORDER BY sum_amount DESC
      LIMIT 0, ?";
      $params=[ITEM_STATUS_OPEN, '%'.$keyword.'%', RANKING];
      set_message('人気順');
    }else if($select === "new_item"){
      $sql = "SELECT * FROM items WHERE status = ? 
      AND name like ? ORDER BY item_id DESC";
      $params=[ITEM_STATUS_OPEN, '%'.$keyword.'%'];
      set_message('新着順');
    }else{
      set_error('不正な処理です');
    }
  }else{
    $sql = "SELECT * FROM items WHERE status = 1 LIMIT ?, ?";
    $params=[$start, PAGINATION];
    // set_message('読込のみ');
  }
    return fetch_all_query($db, $sql, $params);
}

/*===========================================================
関数名：get_detail_items
機能：登録商品詳細の取得(商品詳細画面、公開のみ)
引数：$db[DB接続情報]、$item_id[URLパラメータ]
戻り値：レコードの取得値
===========================================================*/
function get_detail_items($db, $item_id){
  $sql = "SELECT * FROM items WHERE item_id = ? AND status = ?";
  $params=[$item_id, ITEM_STATUS_OPEN];
  return fetch_all_query($db, $sql, $params);
}   

/*===========================================================
関数名：get_item
機能：登録商品情報の取得(商品有無確認、整合性[削除]、SELECT以外)
引数：$db[DB接続情報], $item_id[登録された商品ID]
戻り値：レコードの取得値
===========================================================*/
function get_item($db, $item_id){
  $sql = "SELECT * FROM items WHERE item_id = ?";
  $params=[$item_id];
  return fetch_query($db, $sql, $params);
}

/*===========================================================*/
//商品登録
/*===========================================================*/
/*===========================================================
関数名：regist_item
機能：商品の新規登録
引数：$db, $name, $price, $stock, $status, $image
戻り値：false(エラーありの場合)またはSQL文の実行(INSERT)
===========================================================*/
function regist_item($db, $name, $price, $stock, $explanation, $status, $image){
//保存する新しいファイル名の生成
  $filename = get_upload_filename($image);
//エラーチェック(未入力、文字数制限、数量制限、数字のみなど)
  if(is_validate_item($name, $price, $stock, $explanation, $filename, $status) === false){
    return false;
  }else{
    $db->beginTransaction();
//新規商品登録
    if(insert_item($db, $name, $price, $stock, $explanation, $filename, $status) && save_image($image, $filename) !== false){
      $db->commit();
      return true;
    }else{
      $db->rollback();
      return false;
    }
  }
}

/*===========================================================
関数名：insert_item
機能：商品の新規登録
引数：$db, $name, $price, $stock, $filename, $status
戻り値：SQL文の実行(INSERT)
===========================================================*/
function insert_item($db, $name, $price, $stock, $explanation, $filename, $status){
  $sql = "INSERT INTO items(name, price, stock, explanation, image, status)VALUES(?, ?, ?, ?, ?, ?);";
  $params=[$name, $price, $stock, $explanation, $filename, $status];
  return execute_query($db, $sql, $params);
}

/*===========================================================
関数名：validate_item
機能：エラー処理(全体)
引数：$name, $price, $stock, $filename, $status
戻り値：true[エラー数0の場合]またはfalse[エラーありの場合]
===========================================================*/
function is_validate_item($name, $price, $stock, $explanation, $filename, $status){
  $is_valid_item_name = is_valid_item_name($name);
  $is_valid_item_price = is_valid_item_price($price);
  $is_valid_item_stock = is_valid_item_stock($stock);
  $is_valid_item_explanation = is_valid_item_explanation($explanation);
  $is_valid_item_image = is_valid_item_filename($filename);
  $is_valid_item_status = is_valid_item_status($status);

  if(($is_valid_item_name &&
  $is_valid_item_price && 
  $is_valid_item_stock && 
  $is_valid_item_explanation && 
  $is_valid_item_image && 
  $is_valid_item_status) === true){
   return true;
  }else{
   return false;
  }
}

/*===========================================================
関数名：is_valid_item_name
機能：名前のエラー処理(未入力、文字数制限)
引数：$name
戻り値：true[エラー数0の場合]
===========================================================*/
function is_valid_item_name($name){
  $length = mb_strlen($name);
  if(is_valid_blank($name) === false) {
    set_error('商品名を入力してください。');
  }else if(((ITEM_NAME_LENGTH_MIN <= $length) && ($length <= ITEM_NAME_LENGTH_MAX)) === false){
    set_error('商品名は'. ITEM_NAME_LENGTH_MIN . '文字以上、' . ITEM_NAME_LENGTH_MAX . '文字以内にしてください。');
  }else{
    return true;
  }
}

/*===========================================================
関数名：is_valid_item_price
機能：価格のエラー処理(未入力、数字のみ、価格制限)
引数：$price
戻り値：true[エラー数0の場合]
===========================================================*/
function is_valid_item_price($price){
  if(is_valid_blank($price) === false) {
    set_error('価格を入力してください。');
  }else if(is_positive_integer($price) === false){
    set_error('価格は0円以上の整数で入力してください。');
  }else if($price > PRICE_MAX) {
    set_error('価格は'. (PRICE_MAX/10000) .'万円以下にしてください。');
  }else{
    return true;
  }
}

/*===========================================================
関数名：is_valid_item_stock
機能：在庫数のエラー処理(未入力、数字のみ、数量制限)
引数：$stock
戻り値：true[エラー数0の場合]
===========================================================*/
function is_valid_item_stock($stock){
  if(is_valid_blank($stock) === false) {
    set_error('在庫数を入力してください。');
  }else if(is_positive_integer($stock) === false){
    set_error('在庫数は0個以上の整数で入力してください。');
  }else if($stock > STOCK_MAX) {
    set_error('在庫数は'. STOCK_MAX .'個以下にしてください。');
  }else{
    return true;
  }
}

/*===========================================================
関数名：is_valid_item_explanation
機能：商品説明のエラー処理(未入力、文字数制限)
引数：$explanation
戻り値：true[エラー数0の場合]
===========================================================*/
function is_valid_item_explanation($explanation){
  $length = mb_strlen($explanation);
  if(is_valid_blank($explanation) === false) {
    set_error('商品説明を入力してください。');
  }else if(((ITEM_EXPLANATION_LENGTH_MIN <= $length) && ($length <= ITEM_EXPLANATION_LENGTH_MAX)) === false){
    set_error('商品説明は'. ITEM_EXPLANATION_LENGTH_MIN . '文字以上、' . ITEM_EXPLANATION_LENGTH_MAX . '文字以内にしてください。');
  }else{
    return true;
  }
}

/*===========================================================
関数名：is_valid_item_status
機能：ステータスのエラー処理(公開と非公開のみ)
引数：$status
戻り値：true[エラー数0の場合]
===========================================================*/
function is_valid_item_status($status){
  if(($status === ITEM_STATUS_OPEN || $status === ITEM_STATUS_CLOSE) === false){
    set_error('不正な処理です。');
  }else{
    return true;
  }
}

/*===========================================================
関数名：is_valid_item_filename
機能：ファイルアップロードの有無確認?
引数：$filename
戻り値：true[エラー数0の場合]
===========================================================*/
function is_valid_item_filename($filename){
  if(empty($filename) === false){
    return true;
  }
}

/*===========================================================
関数名：get_upload_filename
機能：保存する新しいファイル名の生成とエラー処理
引数：$image[アップロードファイルの情報]
戻り値：保存する新しいファイル名またはfalse[エラーありの場合]
===========================================================*/
function get_upload_filename($image){
// exif_imagetype関数
// ファイルがアップロードされたかどうかチェック
// 画像ファイルかどうかを確認（画像形式でなければfalseを返す）。
  if(is_uploaded_file($image['tmp_name']) !== false){
    $mimetype = exif_imagetype($image['tmp_name']);
  }else{
    set_error('画像ファイルを指定してください。');
    return false;
  }
// 拡張子の取得(jpgかpng)
  $extension = PERMITTED_IMAGE_TYPES[$mimetype];
// 指定の拡張子であるかどうかチェック
// implode(連結文字, 連結したい文字列[配列])
  if(isset($extension) === false ){
    set_error('ファイル形式は' . implode('、', PERMITTED_IMAGE_TYPES) . 'のみ利用可能です。');
    return false;
  }else{
//保存する新しいファイル名の生成(DB登録するファイル名)
//ランダムな文字列(20)＋拡張子
    $filename = get_random_string() . '.' . $extension;
    return $filename ;
  }
}

/*===========================================================
関数名：save_image＊
機能：アップロードされたファイルを指定ディレクトリに移動して保存
引数：$image[アップロードファイルの情報], $filename[保存する新しいファイル名]
戻り値：アップロードされたファイルを保存またはfalse[保存失敗]
===========================================================*/
function save_image($image, $filename){
  $save_image = move_uploaded_file($image['tmp_name'], IMAGE_DIR . $filename);
  if(($save_image) === false){
    set_error('ファイルアップロードに失敗しました。');
    return false;
  }else{
    return $save_image;
  }
}

/*===========================================================*/
//商品削除
/*===========================================================*/
/*===========================================================
関数名：destroy_item
機能：指定商品の削除(アイテム[DB]＋ファイル)
引数：$db, $item_id
戻り値：true[条件を満たす]またはfalse[条件を満たさない]
===========================================================*/
function destroy_item($db, $item_id){
  $item = get_item($db, $item_id);
  $db->beginTransaction();
  if((delete_item($db, $item_id) && delete_image($item['image'])) !== false){
    $db->commit();
    return true;
  }else{
    $db->rollback();
    return false;
  }
}

/*===========================================================
関数名：delete_item
機能：指定商品の削除(アイテム[DB])
引数：$db, $item_id
戻り値：SQL文の実行(DELETE)
===========================================================*/
function delete_item($db, $item_id){
  $sql = "DELETE FROM items WHERE item_id = ? LIMIT 1";
  $params=[$item_id]; 
  return execute_query($db, $sql, $params);
}

/*===========================================================
関数名：delete_image
機能：指定商品の削除(ファイル)
引数：$filename[ファイル名]
戻り値：true[条件を満たす]またはfalse[条件を満たさない]
===========================================================*/
function delete_image($filename){
// ファイルの有無確認
// unlink関数：指定したパスのファイルを削除する
  if(file_exists(IMAGE_DIR . $filename) === true){
    unlink(IMAGE_DIR . $filename);
    return true;
  }else{
   return false;
  }
}

/*===========================================================*/
//商品更新
/*===========================================================*/
/*===========================================================
関数名：update_item_status
機能：ステータスの更新
引数：$db, $item_id, $status
戻り値：SQL文の実行(UPDATE)
===========================================================*/
function update_item_status($db, $item_id, $status){
//エラーチェック(公開と非公開のみ)
  if(is_valid_item_status($status) === true){
    //ステータス更新
    $sql = "UPDATE items SET status = ? WHERE item_id = ? LIMIT 1";
    $params=[$status, $item_id];
    return execute_query($db, $sql, $params); 
  }else{
    return false;
  }
}

/*===========================================================
関数名：update_item_stock
機能：在庫数の更新
引数：$db, $item_id, $stock
戻り値：SQL文の実行(UPDATE)
===========================================================*/
function update_item_stock($db, $item_id, $stock){
//エラーチェック(未入力、数量制限、数字のみなど)
  if(is_valid_item_stock($stock) === true){
    $sql = "UPDATE items SET stock = ? WHERE item_id = ? LIMIT 1";
    $params=[$stock, $item_id];
    return execute_query($db, $sql, $params);
  }else{
    return false;
  }
}

/*===========================================================*/
//ページネーション 
/*===========================================================*/
/*===========================================================
関数名：get_open_items_number
機能：商品数取得(公開のみ)
引数：$db
戻り値：レコードの取得
===========================================================*/
function get_open_items_number($db){
  $sql = "SELECT COUNT(item_id) as count_item FROM items WHERE status = ?";
  $params=[ITEM_STATUS_OPEN];
  return fetch_query($db, $sql, $params);
}