<?php
// 外部ファイル読み込み(モデル読み込み)
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';
require_once MODEL_PATH . 'user.php';

/*===========================================================*/
// 購入履歴処理
/*===========================================================*/
/*===========================================================
関数名：insert_purchase_history
機能：購入履歴登録
引数：$db[DB接続情報], $user_id[ログインユーザーID]
戻り値：SQL文の実行(INSERT)
===========================================================*/
function insert_purchase_history($db, $user_id){
  $sql = "INSERT INTO purchase_historys(user_id) VALUES(?)";
  $params=[$user_id];
  return execute_query($db, $sql, $params);
}

/*===========================================================
関数名：get_purchase_history
機能：購入履歴取得
引数：$db[DB接続情報], $user_id[ログインユーザーID], $history_id[履歴ID(初期値：空)]
戻り値：レコードの取得値
===========================================================*/
function get_purchase_history($db, $user_id, $history_id = ""){
  // 購入履歴画面(URLパラメータによる判別)
    if(empty($history_id) === true){
        $sql = "SELECT 
          purchase_historys.history_id, 
          purchase_historys.user_id, 
          purchase_historys.created,
          SUM(purchase_price * purchase_number) AS total_price
        FROM purchase_historys 
        INNER JOIN purchase_details
        ON purchase_historys.history_id = purchase_details.history_id 
        WHERE purchase_historys.user_id = ?
        GROUP BY purchase_historys.history_id
        ORDER BY purchase_historys.history_id DESC"; 
        $params=[$user_id]; 
    }else{
  // 購入明細画面
      $sql = "SELECT 
        purchase_historys.history_id, 
        purchase_historys.user_id, 
        purchase_historys.created,
        SUM(purchase_price * purchase_number) AS total_price
      FROM purchase_historys 
      INNER JOIN purchase_details
      ON purchase_historys.history_id = purchase_details.history_id 
      WHERE purchase_historys.history_id = ?
      GROUP BY purchase_historys.history_id";
      $params=[$history_id];
    }
    return fetch_all_query($db, $sql, $params);
  }

/*===========================================================*/
// 購入明細処理
/*===========================================================*/
/*===========================================================
関数名：insert_purchase_detail
機能：購入明細登録
引数：$db$db[DB接続情報], $history_id[履歴ID], $item_id[商品ID], 
$purchase_name[購入商品名(削除対策)], $purchase_price[購入価格(値段変動)], $purchase_number[購入数]
戻り値：SQL文の実行(INSERT)
===========================================================*/
function insert_purchase_detail($db, $history_id, $item_id, $purchase_name, $purchase_price, $purchase_number){
  $sql = "INSERT INTO purchase_details(history_id, item_id, purchase_name, purchase_price, purchase_number) VALUES(?, ?, ?, ?, ?)";
  $params=[$history_id, $item_id, $purchase_name, $purchase_price, $purchase_number];
  return execute_query($db, $sql, $params);
}

/*===========================================================
関数名：get_purchase_detail
機能：購入明細取得
引数：$db[DB接続情報], $user_id[ログインユーザーID], $history_id[履歴ID]
戻り値：レコードの取得値
===========================================================*/
function get_purchase_detail($db, $user_id, $history_id){
  $sql = "SELECT history_id, item_id, purchase_price, purchase_number, purchase_name FROM purchase_details WHERE history_id = ?";
  $params=[$history_id];
  return fetch_all_query($db, $sql, $params);
}
?>