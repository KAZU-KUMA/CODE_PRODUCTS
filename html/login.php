<?php
/*===========================================================
ログイン表示＊
===========================================================*/
// 外部ファイル読み込み(定数、モデル読み込み)
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

session_start();
// ログイン有無確認[function]
if(is_logined() === true){
// index.phpに移動
  redirect_to(HOME_URL);
}
// トークンの生成[functions]
$token = get_csrf_token();
// ビューの読み込み
include_once VIEW_PATH . 'login_view.php';