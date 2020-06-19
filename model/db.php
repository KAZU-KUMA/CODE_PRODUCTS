<?php
/*===========================================================
関数名：get_db_connec
機能：DB接続
引数：なし
戻り値：$dbh[DB接続情報]
===========================================================*/
function get_db_connect(){
// MySQL用のDSN文字列
  $dsn = 'mysql:dbname='. DB_NAME .';host='. DB_HOST .';charset='.DB_CHARSET;
  try {
// データベースに接続
    $dbh = new PDO($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    exit('接続できませんでした。理由：'.$e->getMessage() );
  }
  return $dbh;
}

/*===========================================================
関数名：fetch_query
機能：レコードの取得(SELECT文)
引数：$db[DB接続情報$dbh], $sql[SQL文], 
      $params[パラメータにバインドする値、(初期値：空配列)]
戻り値：レコードの取得値(１行)またはfalse(処理失敗)
===========================================================*/
function fetch_query($db, $sql, $params = array()){
  try{
    $statement = $db->prepare($sql);
    $statement->execute($params);
    return $statement->fetch();
  }catch(PDOException $e){
    set_error('データ取得に失敗しました。');
  }
  return false;
}

/*===========================================================
関数名：fetch_all_query
機能：レコードの取得(SELECT文)
引数：$db[DB接続情報$dbh], $sql[SQL文], 
      $params[パラメータにバインドする値、(初期値：空配列)]
戻り値：レコードの取得値(複数行)またはfalse(処理失敗)
===========================================================*/
function fetch_all_query($db, $sql, $params = array()){
  try{
    $statement = $db->prepare($sql);
    $statement->execute($params);
    return $statement->fetchAll();
  }catch(PDOException $e){
    set_error('データ取得に失敗しました。');
  }
  return false;
}

/*===========================================================
関数名：execute_query
機能：レコードの登録、更新、削除(INSERT文、UPDATE文、DELETE文)
引数：$db[DB接続情報$dbh], $sql[SQL文], 
      $params[パラメータにバインドする値、(初期値：空配列)]
戻り値：SQL文の実行またはfalse(処理失敗)
===========================================================*/
function execute_query($db, $sql, $params = array()){
  try{
    $statement = $db->prepare($sql);
    return $statement->execute($params);
  }catch(PDOException $e){
    set_error('更新に失敗しました。');
  }
  return false;
}