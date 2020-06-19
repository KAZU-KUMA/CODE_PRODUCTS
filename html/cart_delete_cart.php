<?php
/*===========================================================
カート削除機能＊
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
// トークンのPOST送信された値とセッション値を照合[function]
if(is_valid_csrf_token(get_post('csrf_token'))){

// POST送信値の取得[function]
  $item_id = get_post('item_id'); 
// カート削除[cart]
  if(delete_cart($db, $item_id, $user['user_id'])){
    set_message('削除しました。');
  }else{
    set_error('削除に失敗しました。');
  }

}else{
  set_error('不正な処理です。');
}
// cart.phpに移動
redirect_to(CART_URL);