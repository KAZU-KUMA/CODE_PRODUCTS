<?php 
// 外部ファイル読み込み(モデル読み込み)
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

/*===========================================================*/
// お気に入り処理
/*===========================================================*/
/*===========================================================
関数名：get_user_favorites
機能：ログインユーザーのお気に入り情報取得(表示用、全体、公開のみ)
引数：$db[DB接続情報], $user_id[ログインユーザーID]
戻り値：レコードの取得値
===========================================================*/
function get_user_favorites($db, $user_id){
  $sql = "SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      favorites.favorite_id,
      favorites.user_id
    FROM favorites
    INNER JOIN items
    ON favorites.item_id = items.item_id
    WHERE favorites.user_id = ? AND items.status = ?";
  $params=[$user_id, ITEM_STATUS_OPEN];
  return fetch_all_query($db, $sql, $params);
}

/*===========================================================
関数名：get_user_favorite
機能：ログインユーザーのお気に入り情報取得(お気に入り登録用、登録回数確認、個々)
引数：$db[DB接続情報], $user_id[ログインユーザーID],  $item_id[商品ID]
戻り値：レコードの取得値
===========================================================*/
function get_user_favorite($db, $user_id, $item_id){
  $sql = "SELECT * FROM favorites WHERE user_id = ? AND item_id = ?";
  $params=[$user_id, $item_id];
  return fetch_query($db, $sql, $params);
}

/*===========================================================
関数名：insert_favorite
機能：お気に入り新規登録
引数：db[DB接続情報], $user_id[ログインユーザーID], $item_id[商品ID]
戻り値：SQL文の実行(INSERT)
===========================================================*/
function add_favorite($db, $user_id, $item_id){
  $sql = "INSERT INTO favorites(item_id, user_id)VALUES(?, ?)";
  $params=[$item_id, $user_id];
  return execute_query($db, $sql, $params); 
}

/*===========================================================
関数名：delete_favorite
機能：お気に入りの指定商品の削除
引数：db[DB接続情報], $favorite_id[お気に入りID]
戻り値：SQL文の実行(DELETE)
===========================================================*/
function delete_favorite($db, $item_id, $user_id){
  $sql = "DELETE FROM favorites WHERE item_id = ? AND user_id = ? LIMIT 1";
  $params=[$item_id, $user_id];
  return execute_query($db, $sql, $params);
}