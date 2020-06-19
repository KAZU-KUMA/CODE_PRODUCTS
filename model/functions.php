<?php
/*===========================================================
関数名：dd(dump die)
機能：デバック用関数
引数：$var[配列、変数]
戻り値：なし
===========================================================*/
function dd($var){
  print"<pre>";
  var_dump($var);
  print"</pre>";
  exit();
}

/*===========================================================
関数名：redirect_to
機能：ページ遷移
引数：$url[指定URL]
戻り値：なし
dirname：ファイルやディレクトリのパス名からファイル名やディレクトリ名を除いたディレクトリを取得
===========================================================*/
function redirect_to($url){
  $url_root = dirname($_SERVER['REQUEST_URI']);
  header('Location: '.(empty($_SERVER["HTTPS"]) ? "http://" : "https://"). $_SERVER['HTTP_HOST'] . $url_root . $url);
  exit;
}

/*===========================================================
関数名：is_logined
機能：ログイン有無確認
引数：なし
戻り値：true(ログイン有り) false(ログイン無し)
===========================================================*/
function is_logined(){
  return get_session('user_id') !== '';
}

/*===========================================================
関数名：get_get
機能：GET送信値の取得
引数：$name[リクエストパラメータ名(フォーム名)]
戻り値：$_GET[$name](GET送信値)または空('')
===========================================================*/
function get_get($name){
  if(isset($_GET[$name]) === true){
    return $_GET[$name];
  };
  return '';
}

/*===========================================================
関数名：get_post
機能：POST送信値の取得
引数：$name[リクエストパラメータ名(フォーム名)]
戻り値：$_POST[$name](POST送信値)または空('')
===========================================================*/
function get_post($name){
  if(isset($_POST[$name]) === true){
    return $_POST[$name];
  };
  return '';
}

/*===========================================================
関数名：get_file
機能：アップロードファイル名を取得
引数：$name[リクエストパラメータ名(フォーム名)]
戻り値：$_FILES[$name](アップロードファイル名)または空配列array()
===========================================================*/
function get_file($name){
  if(isset($_FILES[$name]) === true){
    return $_FILES[$name];
  };
  return array();
}

/*===========================================================
関数名：get_session
機能：セッションの取得
引数：$name[セッション名]
戻り値：$_SESSION[$name](セッション値)または空('')
===========================================================*/
function get_session($name){
  if(isset($_SESSION[$name]) === true){
    return $_SESSION[$name];
  };
  return '';
}

/*===========================================================
関数名：set_session
機能：セッションの保存
引数：$name[セッション名(キー)]、$value[値]
戻り値：なし
===========================================================*/
function set_session($name, $value){
  $_SESSION[$name] = $value;
}

/*===========================================================
関数名：set_error(多次元配列)
機能：セッションの保存(失敗メッセージ用)
引数：$error[失敗メッセージ]
戻り値：なし
===========================================================*/
function set_error($error){
  $_SESSION['errors'][] = $error;
}

/*===========================================================
関数名：set_message(多次元配列)
機能：セッションの保存(成功メッセージ用)
引数：$message[成功メッセージ]
戻り値：なし
===========================================================*/
function set_message($message){
  $_SESSION['messages'][] = $message;
}

/*===========================================================
関数名：get_errors
機能：セッションの取得(失敗メッセージ用)
引数：なし
戻り値：$errors[失敗メッセージ]または空配列array()
===========================================================*/
function get_errors(){
  $errors = get_session('errors');
  if($errors === ''){
    return array();
  }
  set_session('errors', array());
  return $errors;
}

/*===========================================================
関数名：get_messages
機能：セッションの取得(成功メッセージ用)
引数：なし
戻り値：$errors[成功メッセージ]または空配列array()
===========================================================*/
function get_messages(){
  $messages = get_session('messages');
  if($messages === ''){
    return array();
  }
  set_session('messages', array());
  return $messages;
}

/*===========================================================
関数名：entity_assoc_array(多次元配列)
機能：特殊文字をエスケープ処理する(XSS対策)
引数：$assoc_array[エスケープ処理前のデータ]
戻り値：$entity_assoc_array[エスケープ処理後のデータ]
===========================================================*/
function entity_assoc_array($assoc_array) {
  //レコード分割
  foreach ($assoc_array as $key => $value) {
  //カラム分割
    foreach ($value as $keys => $values) {
      $entity_assoc_array[$key][$keys] = htmlspecialchars($values, ENT_QUOTES, 'UTF-8');
    }
  }
  return $entity_assoc_array;
}

/*===========================================================
関数名：get_csrf_token
機能：トークンの生成とセッション保存(CSRF対策)
引数：無し
戻り値：$token[30桁のランダムな文字列]
===========================================================*/
function get_csrf_token(){
  $token = get_random_string(30);
  set_session('csrf_token', $token);
  return $token;
}

/*===========================================================
関数名：get_random_string(トークン、新しいファイル名で使用)
機能：指定した桁数のランダムな文字列生成
引数：$length[文字数(初期値：20)]
戻り値：指定した桁数のランダムな文字列
===========================================================*/
function get_random_string($length = 20){
  return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}

/*===========================================================
関数名：is_valid_csrf_token
機能：トークンのチェック(各フォームからpostで送信された値とセッションに保存した値照合、CSRF対策)
引数：$token[30桁のランダムな文字列]
戻り値：false(不一致)またはtrue(一致)
===========================================================*/
function is_valid_csrf_token($token){
  if($token === '') {
    return false;
  }
  return $token === get_session('csrf_token');
}

/*===========================================================
関数名：is_valid_blank
機能：未入力(半角、全角空白[スペース]除去)確認
引数：$value[送信された値]
戻り値：false(未入力の場合)
===========================================================*/
function is_valid_blank($value){
  if (trim(mb_convert_kana($value, "s", 'UTF-8')) === ''){
    return false;
  }
}

/*===========================================================
関数名：is_alphanumeric
機能：正規表現(半角英数字)
引数：$string[ユーザー名、パスワード]
戻り値：true[パターンを満たす]またはfalse[パターンを満たさない]
===========================================================*/
function is_alphanumeric($string){
  return is_valid_format($string, REGEXP_ALPHANUMERIC);
}

/*===========================================================
関数名：is_positive_integer
機能：正規表現(半角数字)
引数：$string[価格、数量]
戻り値：true[パターンを満たす]またはfalse[パターンを満たさない]
===========================================================*/
function is_positive_integer($string){
  return is_valid_format($string, REGEXP_POSITIVE_INTEGER);
}

/*===========================================================
関数名：is_valid_format
機能：正規表現(パターン確認)
引数：$string(文字列、数値)、$format(指定パターン)
戻り値：true[パターンを満たす]またはfalse[パターンを満たさない]
===========================================================*/
function is_valid_format($string, $format){
  return preg_match($format, $string) === 1;
}

/*===========================================================
関数名：validate_integrity
機能：カート、お気に入りエラー処理(整合性個々、非公開、売り切れ確認)
引数：$item[指定した商品情報], $favorite[ログインユーザーのお気に入り情報(初期値：空(""))]
戻り値：true[条件を満たす]
===========================================================*/
function validate_integrity($item, $favorite=""){
// ステータス非公開の場合(カート＋お気に入り)
  if((int)$item['status'] === ITEM_STATUS_CLOSE){
    set_error($item['name'] . 'は非公開のため、現在登録または更新できません。');
    return false;
  }
// 商品売り切れ(在庫数0)の場合(カートのみ)
  if((($item['stock']) <= 0 && ($favorite==="")) !== false){
    set_error($item['name'] . 'は売り切れのため、現在登録または更新できません。');
    return false;
  }
}