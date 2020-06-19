<?php
/*===========================================================
サインアップ処理機能＊
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
// DB接続情報の取得[db]
$db = get_db_connect();

// トークンのPOST送信された値とセッション値を照合[function]
if(is_valid_csrf_token(get_post('csrf_token'))){

// POST送信値の取得[function]
  $name = get_post('name');
  $password = get_post('password');
  $password_confirmation = get_post('password_confirmation');

//登録済みユーザー情報の取得(照合)[user]
    $user = registered_user($db, $name);
    if ($user !== false){
      $result = false;
      set_error('同じユーザー名が既に登録されています。');
    }else{
//ユーザー登録、エラー処理(未入力、半角英数字、文字数制限)[user]
      $result = regist_user($db, $name, $password, $password_confirmation);
     }

     if($result === false){ 
        set_error('ユーザー登録に失敗しました。');
    // login.phpに移動
        redirect_to(SIGNUP_URL);
      }else{
        set_message('ユーザー登録が完了しました。');
    // login.phpに移動
        redirect_to(LOGIN_URL);
      }

}else{
  set_error('不正な処理です。');
}

