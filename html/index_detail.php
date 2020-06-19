<?php
/*===========================================================
 商品詳細表示＊
===========================================================*/
// 外部ファイル読み込み(定数、モデル読み込み)
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

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

// GET送信値の取得[functions](URLパラメータ取得)
$item_id = get_get('id');
// 商品詳細の取得[item](公開のみ)
// エスケープ処理[functions]
$result = get_detail_items($db, $item_id);
$items = entity_assoc_array($result);
// トークンの生成[functions]
$token = get_csrf_token();
// ビューの読み込み
include_once VIEW_PATH . 'index_detail_view.php';