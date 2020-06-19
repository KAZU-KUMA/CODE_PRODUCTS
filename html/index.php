<?php
/*===========================================================
 商品一覧表示＊
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

//ページネーション[function](URLパラメータ取得)
  if(get_get('page') !== ""){
    $page = get_get('page');
  }else{
    $page = 1;
  }
// ページ開始位置(0, 5, 10, 15...)
  $start = PAGINATION * ($page - 1);
// ページネーション(商品数取得)[items]
  $count = get_open_items_number($db);

// 商品情報の取得[item](公開のみ)
// エスケープ処理[functions]
  $result = get_open_items($db, $select="", $keyword="", $start);
  $items = entity_assoc_array($result);

// トークンの生成[functions]
$token = get_csrf_token();
// ビューの読み込み
include_once VIEW_PATH . 'index_view.php';
