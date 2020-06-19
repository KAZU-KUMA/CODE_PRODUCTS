<?php
/*===========================================================
購入完了表示＊
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
// 購入情報(カート情報)の取得[cart]
// エスケープ処理[functions]
$result = get_user_carts($db, $user['user_id']);
$carts = entity_assoc_array($result);
// 購入処理[cart]
if(purchase_carts($db, $carts, $user['user_id']) === false){
  set_error('商品が購入できませんでした。');
// cart.phpに移動
  redirect_to(CART_URL);
} 
// 合計金額[cart]
$total_price = sum_carts($carts);
// トークンの生成[functions]
$token = get_csrf_token();
// ビューの読み込み
include_once '../view/finish_view.php';