<?php
/*===========================================================
 お気に入り追加機能＊
===========================================================*/
// 外部ファイル読み込み(定数、モデル読み込み)
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'favorite.php';

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
//登録回数の取得(重複不可)[favorite]
  $favorite = get_user_favorite($db, $user['user_id'], $item_id);
//整合性確認(非公開、商品削除)[item]
  $item = get_item($db, $item_id);
  if(get_item($db, $item_id) === false){
    set_error('この商品はすでに削除されました。');
  }else if(validate_integrity($item, $favorite) === false){
    set_error('お気に入りの更新に失敗しました。');
  }else{
      if($favorite === false){
          if(add_favorite($db, $user['user_id'], $item_id)){
            set_message('お気に入りに商品を追加しました。');
          }else{
            set_error('お気に入りの更新に失敗しました。');
          }
      }else{
        set_error('登録済みの商品です。');
      }
  }

}else{
  set_error('不正な処理です。');
}
// index_detail.phpに移動
redirect_to(DETAIL_URL."?id={$item_id}");
