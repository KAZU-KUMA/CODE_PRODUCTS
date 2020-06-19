<?php
/*===========================================================
購入明細表示＊
===========================================================*/
// 外部ファイル読み込み(定数、モデル読み込み)
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'history.php';
session_start();
// ログイン有無確認[functions]
if(is_logined() === false){
// login.phpに移動
  redirect_to(LOGIN_URL);
}
// DB接続情報の取得[db]
$db = get_db_connect();
// ログインユーザー情報の取得[user]
$user = get_login_user($db);
// GET送信値[functions](URLパラメータ取得)
$history_id = get_get('id');
// 購入履歴取得[history]
// エスケープ処理[functions]
$result = get_purchase_history($db, $user['user_id'], $history_id);
$historys = entity_assoc_array($result);
// 購入明細取得[history]
// エスケープ処理[functions]
$result = get_purchase_detail($db, $user['user_id'], $history_id);
$details = entity_assoc_array($result);
// ビューの読み込み
include_once VIEW_PATH . 'purchase_detail_view.php';
?>