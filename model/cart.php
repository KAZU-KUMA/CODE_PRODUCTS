<?php 
// 外部ファイル読み込み(モデル読み込み)
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';
require_once MODEL_PATH . 'history.php';

/*===========================================================*/
// カート処理
/*===========================================================*/
/*===========================================================
関数名：get_user_carts
機能：ログインユーザーのカート情報取得(表示用、全体、公開のみ)
引数：$db[DB接続情報], $user_id[ログインユーザーID]
戻り値：レコードの取得値
===========================================================*/
function get_user_carts($db, $user_id){
  $sql = "SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM carts
    INNER JOIN items
    ON carts.item_id = items.item_id
    WHERE carts.user_id = ? AND items.status = ?";
  $params=[$user_id, ITEM_STATUS_OPEN]; 
  return fetch_all_query($db, $sql, $params);
}

/*===========================================================
関数名：get_user_cart
機能：ログインユーザーのカート情報取得(カート登録用、登録回数確認、個々)
引数：$db[DB接続情報], $user_id[ログインユーザーID],  $item_id[商品ID]
戻り値：レコードの取得値
===========================================================*/
function get_user_cart($db, $user_id, $item_id){
  $sql = "SELECT * FROM carts WHERE user_id = ? AND item_id = ?";
  $params=[$user_id, $item_id];
  return fetch_query($db, $sql, $params);
}

/*===========================================================
関数名：add_cart
機能：カート登録機能(新規登録、更新)
引数：db[DB接続情報], $user_id[ログインユーザーID], $item_id[商品ID]
戻り値：SQL文の実行(INSERTまたはUPDATE)
===========================================================*/
function add_cart($db, $user_id, $item_id) {
  //各商品のカート数確認(登録回数確認)
  $cart = get_user_cart($db, $user_id, $item_id);
  //カート新規登録または更新
  if($cart === false){
    //1回目
    return insert_cart($db, $user_id, $item_id);
  }else{
    //2回目以降
    return update_cart_amount($db, $cart['item_id'], $cart['amount'] + 1, $user_id);
  }
}

/*===========================================================
関数名：insert_cart
機能：カート新規登録(１回目、詳細画面)
引数：db[DB接続情報], $user_id[ログインユーザーID], 
$item_id[商品ID], $amount[カート数(初期値：1)]
戻り値：SQL文の実行(INSERT)
===========================================================*/
function insert_cart($db, $user_id, $item_id, $amount = 1){
  $sql = "INSERT INTO carts(item_id, user_id, amount)VALUES(?, ?, ?)";
  $params=[$item_id, $user_id, $amount];
  return execute_query($db, $sql, $params);
}

/*===========================================================
関数名：update_cart_amount
機能：カート更新(２回目以降、詳細画面＋カート画面)
引数：db[DB接続情報], $item_id[商品ID], $amount[カート数], $user_id[ログインユーザーID]
戻り値：SQL文の実行(UPDATE)
===========================================================*/
function update_cart_amount($db, $item_id, $amount, $user_id){
// エラーチェック(未入力、数字のみ、個数制限)
  if(is_valid_item_amount($amount) === true){
    $sql = "UPDATE carts SET amount = ? WHERE item_id = ? AND user_id = ? LIMIT 1";
    $params=[$amount, $item_id, $user_id];
    return execute_query($db, $sql, $params);
  }else{
    return false;
  }
}

/*===========================================================
関数名：is_valid_item_amount
機能：カート数のエラー処理(未入力、数字のみ、個数制限)
引数：$amount[購入数]
戻り値：true[エラー数0の場合]
===========================================================*/
function is_valid_item_amount($amount){
  if (is_valid_blank($amount) === false) {
    set_error('購入数を入力してください。');
  }else if(is_positive_integer($amount) === false){
    set_error('購入数は1個以上の整数で入力してください。');
  }else if((($amount >= CART_MIN) &&
   ($amount < CART_MAX)) === false){
    set_error('購入数は'. CART_MIN .'個以上'. CART_MAX .'個以下にしてください。');
  }else{
    return true;
  }
}

/*===========================================================
関数名：delete_cart
機能：カートの指定商品の削除
引数：db[DB接続情報], $cart_id[カートID], $user_id[ログインユーザーID]
戻り値：SQL文の実行(DELETE)
===========================================================*/
function delete_cart($db, $item_id, $user_id){
  $sql = "DELETE FROM carts WHERE item_id = ? AND user_id = ? LIMIT 1";
  $params=[$item_id, $user_id];
  return execute_query($db, $sql, $params);
}

/*===========================================================
関数名：sum_carts
機能：カートの合計金額計算
引数：$carts[ログインユーザーのカート情報]
戻り値：$total_price[合計金額]
===========================================================*/
function sum_carts($carts){
  $total_price = 0;
  if(empty($carts) === false) {
    foreach($carts as $cart){
      $total_price += $cart['price'] * $cart['amount'];
    }
  }
  return $total_price;
}

/*===========================================================*/
// 購入処理
/*===========================================================*/
/*===========================================================
関数名：purchase_carts
機能：購入処理(在庫数更新、購入履歴登録、カート削除、整合性)
引数：db[DB接続情報], $carts[ログインユーザーのカート情報], $user_id[ログインユーザーID]
戻り値：なし
===========================================================*/
function purchase_carts($db, $carts, $user_id){
  $db->beginTransaction();
// 購入履歴登録
  $result = insert_purchase_history($db, $user_id);
  if($result !== false):
// 購入履歴の最後に挿入された行のIDの取得
    $history_id = $db->lastInsertId('history_id');
// エラーチェック(整合性：非公開、売り切れ、購入数制限、購入数＞在庫数)
    if(validate_cart_purchase($carts) === false){
      $result = false;
    }
    if($result !== false){
      foreach($carts as $cart):
// 在庫数更新
        if(update_item_stock($db, $cart['item_id'], $cart['stock'] - $cart['amount']) === false){
          set_error($cart['name'] . 'の購入に失敗しました。');
          $result = false;
          break;
        }else{
// 購入明細登録
          $result = insert_purchase_detail($db, $history_id, $cart['item_id'], $cart['name'], $cart['price'], $cart['amount']);
          if($result === false){
            break;
          }
        }
      endforeach;
    }
  endif;

  if ($result !== false) {
    $db->commit();
    set_message('ご購入ありがとうございました。');
// カート削除
    delete_user_carts($db, $user_id);
  } else {
    $db->rollback();
  }
}

/*===========================================================
関数名：validate_cart_purchase
機能：購入エラー処理(整合性全体、非公開、売り切れ、購入数制限、購入数＞在庫数)
※item_idないため、個々指定不可
引数：$carts[ログインユーザーのカート情報]
戻り値：true[条件を満たす]またはfalse[条件を満たさない]
===========================================================*/
function validate_cart_purchase($carts){
  foreach($carts as $cart){
// ステータス非公開の場合
    if((int)$cart['status'] === ITEM_STATUS_CLOSE){
      set_error($cart['name'] . 'は非公開のため、現在購入できません。');
      return false;
    }
// 商品売り切れ(在庫数0)の場合
    if($cart['stock'] <= 0){
      set_error($cart['name'] . 'は売り切れのため、現在購入できません。');
      return false;
    }
// 購入数0の場合
    if($cart['amount'] <= 0){
      set_error($cart['name'] . 'は購入数' . $cart['amount'] . '個のため、購入できません。');
      return false;
    }
// 在庫数＜購入数の場合
    if($cart['stock'] - $cart['amount'] < 0){
      set_error($cart['name'] . 'は在庫が足りません。購入可能数は' . $cart['stock'] . '個です。');
      return false;
    }
  }
// カートに商品が入っていない場合
  if(count($carts) === 0){
    set_error('カートに商品が入っていません。');
    return false;
  }
  return true;
}

/*===========================================================
関数名：delete_user_carts
機能：カートの全て削除(購入完了)
引数：$db[DB接続情報], $user_id[ログインユーザID]
戻り値：SQL文の実行(DELETE)
===========================================================*/
function delete_user_carts($db, $user_id){
  $sql = "DELETE FROM carts WHERE user_id = ?";
  $params=[$user_id];
  execute_query($db, $sql, $params);
}