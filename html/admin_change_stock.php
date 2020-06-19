<?php
/*===========================================================
 商品在庫数更新機能＊
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
  $item_id = get_post('item_id');
  $stock = get_post('stock');
// 商品在庫数更新[item]
  if(update_item_stock($db, $item_id, $stock)){
    set_message('在庫数を変更しました。');
  }else{
    set_error('在庫数の変更に失敗しました。');
  }

}else{
  set_error('不正な処理です。');
}
// admin.phpに移動
redirect_to(ADMIN_URL);