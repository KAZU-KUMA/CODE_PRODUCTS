<?php
/*===========================================================
 商品追加機能＊
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
// ログインユーザーが管理人であるか確認[user]
if(is_admin($user) === false){
// login.phpに移動
  redirect_to(LOGIN_URL);
}
// トークンのPOST送信された値とセッション値を照合[function]
if(is_valid_csrf_token(get_post('csrf_token'))){
  
// POST送信値の取得[function]
  $name = get_post('name');
  $price = get_post('price');
  $status = (int)get_post('status');
  $stock = get_post('stock');
  $explanation = get_post('explanation');
  $image = get_file('image');
// 商品新規追加[item]
  if(regist_item($db, $name, $price, $stock, $explanation, $status, $image) === true){
    set_message('商品を登録しました。');
  }else{
    set_error('商品の登録に失敗しました。');
  }

}else{
  set_error('不正な処理です。');
}
// admin.phpに移動
redirect_to(ADMIN_URL);