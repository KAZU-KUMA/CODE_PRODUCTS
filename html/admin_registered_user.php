<?php
/*===========================================================
 ユーザー管理表示＊
===========================================================*/
// 外部ファイル読み込み(定数、モデル読み込み)
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';
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
// ログインユーザーが管理人であるか確認[user]
if(is_admin($user) === false){
// login.phpに移動
  redirect_to(LOGIN_URL);
}
// ユーザー一覧の取得[user]
// エスケープ処理[functions]
$result = admin_registered_user($db);
$users = entity_assoc_array($result);

// ビューの読み込み
include_once VIEW_PATH . '/registered_user_view.php';
