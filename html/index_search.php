<?php
/*===========================================================
 商品一覧表示(検索＆並び替え)＊
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
// トークンのPOST送信された値とセッション値を照合
if(is_valid_csrf_token(get_post('csrf_token'))){

// POST送信値の取得[function](検索ワード、並び替え)
  if(isset($_POST['search']) === TRUE){
    $select = get_post('select'); 
    $keyword = get_post('keyword'); 
  }

// 商品情報の取得[item](公開のみ)
// エスケープ処理[functions]
  $result = get_open_items($db, $select, $keyword);
  $items = entity_assoc_array($result);

}else{
  set_error('不正な処理です。');
}
// トークンの生成[functions]
$token = get_csrf_token();
// ビューの読み込み
include_once VIEW_PATH . 'index_view.php';
