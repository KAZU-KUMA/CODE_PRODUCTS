<?php
// 外部ファイル読み込み(モデル読み込み)
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';
/*===========================================================*/
// 共通
/*===========================================================*/
/*===========================================================
関数名：get_login_user
機能：ログインユーザー情報取得
引数：$db[DB接続情報]
戻り値：ログインユーザー情報
===========================================================*/
function get_login_user($db){
  $login_user_id = get_session('user_id');
  $sql = "SELECT user_id, name, password, type FROM users WHERE user_id = ? LIMIT 1";
  $params=[$login_user_id];
  return fetch_query($db, $sql, $params);
}

/*===========================================================
関数名：is_admin
機能：ログインユーザーが管理人であるか確認
引数：$user[ログインユーザー情報取得]
戻り値：true[管理人]またはfalse[管理人以外]
===========================================================*/
function is_admin($user){
  return $user['type'] === USER_TYPE_ADMIN;
}

/*===========================================================*/
//ログイン処理
/*===========================================================*/
/*===========================================================
関数名：login_user
機能：ログイン照合とエラー処理
引数：$db[DB接続情報], $name[ユーザー名]、$password[パスワード]
戻り値：false[登録済みの場合またはエラー数がある場合]
        またはレコードの取得値
===========================================================*/
function login_user($db, $name, $password) {
// エラーチェック(未入力)
  if(is_valid_login_user($name, $password) === false){
    return false;
  }else{
// ログイン照合(登録済みユーザーと入力値を照合)
    return get_user_login_as($db, $name);
  }
}

/*===========================================================
関数名：get_user_login_as
機能：ユーザー情報の取得(ログイン照合)
引数：$db[DB接続情報], $name[ユーザー名]、$password[パスワード]
戻り値：レコードの取得値(入力値と一致)またはfalse(不一致)
===========================================================*/
function get_user_login_as($db, $name){
  $sql = "SELECT user_id, name, password, type FROM users WHERE name = ? LIMIT 1";
  $params=[$name];
  return fetch_query($db, $sql, $params);
}

/*===========================================================
関数名：is_valid_user
機能：ユーザー名、パスワードのエラー処理
引数：$name[ユーザー名]、$password[パスワード], $password_confirmation[確認用パスワード]
戻り値：true[条件を満たす]またはfalse[条件を満たさない]
===========================================================*/
function is_valid_login_user($name, $password){
  $is_valid_user_name = is_valid_login_user_name($name);
  $is_valid_password = is_valid_login_password($password); 
   if(($is_valid_user_name && $is_valid_password) === true){
    return true;
   }else{
    return false;
   }
}

/*===========================================================
関数名：is_valid_user_name
機能：ユーザー名のエラー処理(未入力)
引数：$name[ユーザー名]
戻り値：true[条件を満たす]
===========================================================*/
function is_valid_login_user_name($name) {
  if(is_valid_blank($name) === false) {
    set_error('ユーザー名を入力してください');
  }else{
    return true;
  }
}

/*===========================================================
関数名：is_valid_user_name
機能：パスワードのエラー処理(未入力)
引数：$password[パスワード], $password_confirmation[確認用パスワード]
戻り値：true[条件を満たす]
===========================================================*/
function is_valid_login_password($password){
  if(is_valid_blank($password) === false) {
    set_error('パスワードを入力してください');
  }else{
    return true;
  }
}

/*===========================================================*/
//サインアップ処理
/*===========================================================*/
/*===========================================================
関数名：regist_user
機能：ユーザー新規登録機能(重複、エラー確認)と登録
引数：$db[DB接続情報], $name[ユーザー名]、$password[パスワード], $password_confirmation[確認用パスワード]
戻り値：false[登録済みの場合]、SQL文の実行(INSERT)
===========================================================*/
function regist_user($db, $name, $password, $password_confirmation) {
  if(is_valid_signup_user($name, $password, $password_confirmation) === false){
    return false;
  }else{
    return insert_user($db, $name, $password);
  }
}

/*===========================================================
関数名：insert_user
機能：新規ユーザーの登録
引数：$db[DB接続情報], $name[ユーザー名]、$password[パスワード]
戻り値：SQL文の実行(INSERT)
===========================================================*/
function insert_user($db, $name, $password){
  $sql = "INSERT INTO users(name, password) VALUES (?, ?)";
  $params=[$name,  password_hash($password, PASSWORD_DEFAULT)];
  return execute_query($db, $sql, $params);
}

/*===========================================================
関数名：registered_user
機能：ユーザー情報の取得(UNIQUE制約)
引数：$db[DB接続情報], $name[ユーザー名]
戻り値：レコードの取得値(登録済み)またはfalse(未登録)
===========================================================*/
function registered_user($db, $name){
  $sql = "SELECT user_id, name, password, type FROM users WHERE name = ? LIMIT 1";
  $params=[$name];
  return fetch_query($db, $sql, $params);
}

/*===========================================================
関数名：is_valid_signup_user
機能：登録ユーザー名、パスワードのエラー処理(未入力、半角英数字、文字数制限)
引数：$name[ユーザー名]、$password[パスワード], $password_confirmation[確認用パスワード]
戻り値：true[条件を満たす]またはfalse[条件を満たさない]
===========================================================*/
function is_valid_signup_user($name, $password, $password_confirmation){
  $is_valid_user_name = is_valid_signup_user_name($name);
  $is_valid_password = is_valid_signup_password($password, $password_confirmation);
  if(($is_valid_user_name && $is_valid_password) === true){
    return true;
   }else{
    return false;
   }
}

/*===========================================================
関数名：is_valid_user_name
機能：登録ユーザー名のエラー処理(未入力、半角英数字、文字数制限)
引数：$name[ユーザー名]
戻り値：true[条件を満たす]
===========================================================*/
function is_valid_signup_user_name($name) {
  $length = mb_strlen($name);
  if(is_valid_blank($name) === false) {
    set_error('ユーザー名を入力してください');
  }else if((( USER_NAME_LENGTH_MIN <= $length) 
  && ($length <= USER_NAME_LENGTH_MAX)) === false){
    set_error('ユーザー名は'. USER_NAME_LENGTH_MIN . '文字以上、' . USER_NAME_LENGTH_MAX . '文字以内にしてください。');
  }else if(is_alphanumeric($name) === false){
    set_error('ユーザー名は半角英数字で入力してください。');
  }else{
    return true;
  }
}

/*===========================================================
関数名：is_valid_user_name
機能：パスワードのエラー処理(未入力、半角英数字、文字数制限、入力間違え)
引数：$password[パスワード], $password_confirmation[確認用パスワード]
戻り値：true[条件を満たす]
===========================================================*/
function is_valid_signup_password($password, $password_confirmation){
  $length = mb_strlen($password);
  if(is_valid_blank($password) === false) {
    set_error('パスワードを入力してください');
  }
  if(is_valid_blank($password_confirmation) === false) {
      set_error('パスワード（確認用）を入力してください');
  }else if((( USER_PASSWORD_LENGTH_MIN <= $length) 
  && ($length <= USER_PASSWORD_LENGTH_MAX)) === false){
    set_error('パスワードは'. USER_PASSWORD_LENGTH_MIN . '文字以上、' . USER_PASSWORD_LENGTH_MAX . '文字以内にしてください。');
  }else if(is_alphanumeric($password) === false){
    set_error('パスワードは半角英数字で入力してください。');
  }else if($password !== $password_confirmation){
    set_error('パスワードがパスワード(確認用)と一致しません。');
  }else{
    return true;
  }
}

/*===========================================================*/
//登録ユーザー表示
/*===========================================================*/
/*===========================================================
関数名：registered_user
機能：管理人以外の登録済みユーザー情報取得
引数：$db[DB接続情報]
戻り値：レコードの取得値
===========================================================*/
function admin_registered_user($db){
  $sql = "SELECT user_id, name, password, type, created FROM users WHERE type = ?";
  $params=[USER_TYPE_NORMAL];
  return fetch_all_query($db, $sql, $params);
}