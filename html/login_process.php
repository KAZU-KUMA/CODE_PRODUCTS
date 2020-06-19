<?php
/*===========================================================
ログイン処理＊
===========================================================*/
// 外部ファイル読み込み(定数、モデル読み込み)
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start();
// ログイン有無確認[function]
if(is_logined() === true){
// index.phpに移動
  redirect_to(HOME_URL);
}
// トークンのPOST送信された値とセッション値を照合[function]
if(is_valid_csrf_token(get_post('csrf_token'))){

// POST送信値の取得[function]
  $name = get_post('name');
  $password = get_post('password');
// DB接続情報の取得[db]
  $db = get_db_connect();

// ログイン照合[user]
  $user = login_user($db, $name, $password);
  if($user === false || password_verify($password, $user['password']) === false){
    set_error('ログインに失敗しました。');
// login.phpに移動
    redirect_to(LOGIN_URL);
  }else{
// set_session(キー, 値)保存[function]
    set_session('user_id', $user['user_id']);
    set_message('ログインしました。');

// ログインユーザーが管理人か一般ユーザーか確認[user]
    if ($user['type'] === USER_TYPE_ADMIN){
// admin.phpに移動
      redirect_to(ADMIN_URL);
    }else{
// index.phpに移動
      redirect_to(HOME_URL);
    }
  }

}else{
  set_error('不正な処理です。');
}

