<?php
/*===========================================================
カート表示＊
===========================================================*/
// 外部ファイル読み込み(定数、モデル読み込み)
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

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
// カート情報の取得[cart]
// エスケープ処理[functions]
$result = get_user_carts($db, $user['user_id']);
$carts = entity_assoc_array($result);
// 合計金額の取得[cart]
$total_price = sum_carts($carts);
// トークンの生成[functions]
$token = get_csrf_token();
// ビューの読み込み
include_once VIEW_PATH . 'cart_view.php';