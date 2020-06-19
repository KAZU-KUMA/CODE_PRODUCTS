<?php
/*===========================================================
ログアウト処理＊
===========================================================*/
// 外部ファイル読み込み(定数、モデル読み込み)
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

session_start();
// セッション変数を全て削除
$_SESSION = array();
// セッションクッキーのパラメータを取得
$params = session_get_cookie_params();

// sessionに利用しているクッキーの有効期限を過去に設定することで無効化
setcookie(session_name(), '', time() - 42000,
  $params["path"], 
  $params["domain"],
  $params["secure"], 
  $params["httponly"]
);
// セッションIDを無効化
session_destroy();
// login.phpに移動
redirect_to(LOGIN_URL);

