<?php
/*===========================================================
カート追加＊
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
// 整合性確認(非公開、売り切れ、商品削除)[item]
  $item = get_item($db, $item_id);
  if(get_item($db, $item_id) === false){
    set_error('この商品はすでに削除されました。');
  }else if(validate_integrity($item) === false){
    set_error('カートの更新に失敗しました。');
  }else{
// カートを追加[cart](詳細画面)
      if(add_cart($db, $user['user_id'], $item_id)){
        set_message('カートに商品を追加しました。');
      } else {
        set_error('カートの更新に失敗しました。');
      }
  }

}else{
  set_error('不正な処理です。');
}
// index_detail.phpに移動
redirect_to(DETAIL_URL."?id={$item_id}");
