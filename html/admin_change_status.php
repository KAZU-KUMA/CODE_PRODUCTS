<?php
/*===========================================================
 商品ステータス更新機能＊
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
  $change_status = (int)get_post('changes_status');

// 商品ステータス更新[item]
  if($change_status === ITEM_STATUS_OPEN){
    update_item_status($db, $item_id, ITEM_STATUS_OPEN);
    set_message('ステータスを変更しました。');
  }else if($change_status === ITEM_STATUS_CLOSE){
    update_item_status($db, $item_id, ITEM_STATUS_CLOSE);
    set_message('ステータスを変更しました。');
  }else{
    set_error('不正なリクエストです。');
  }

}else{
  set_error('不正な処理です。');
}
// admin.phpに移動
redirect_to(ADMIN_URL);