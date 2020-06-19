<?php
// ===========================================================
// 定数＊
// ===========================================================
//DB接続情報
define('DB_HOST', 'mysql');
define('DB_NAME', 'sample');
define('DB_USER', 'testuser');
define('DB_PASS', 'password');
define('DB_CHARSET', 'utf8');

//ドキュメントルート取得
define('MODEL_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../model/');
define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../view/');
//CSS外部ファイル読み込み
define('STYLESHEET_PATH', '/assets/css/');
//JavaScript読み込み
define('JS_PATH', '/assets/js/');

//アップロードした画像ファイルの保存ディレクトリ(書込先)
define('IMAGE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/assets/images/' );
//アップロードした画像ファイルのパス(読込先)
define('IMAGE_PATH', '/assets/images/');
//デフォルトファイル
define('DEFALT_IMAGE_PATH', '/assets/defalt_images/');

//各ページのURL
define('SIGNUP_URL', '/signup.php');
define('LOGIN_URL', '/login.php');
define('LOGOUT_URL', '/logout.php');
define('HOME_URL', '/index.php');
define('CART_URL', '/cart.php');
define('FINISH_URL', '/finish.php');
define('ADMIN_URL', '/admin.php');
define('DETAIL_URL', '/index_detail.php');
define('HISTORY_URL', '/purchase_history.php');
define('FAVORITE_URL', '/favorite.php');
define('USER_URL', '/admin_registered_user.php');
define('CONTACT_URL', '/contact.php');
define('SITE_GUIDE_URL', '/site_guide.php');

//正規表現(半角英数字と半角数字)
define('REGEXP_ALPHANUMERIC', '/\A[0-9a-zA-Z]+\z/');
define('REGEXP_POSITIVE_INTEGER', '/\A\d+\z/');

//文字数制限(ログイン)
define('USER_NAME_LENGTH_MIN', 6);
define('USER_NAME_LENGTH_MAX', 20);
define('USER_PASSWORD_LENGTH_MIN', 6);
define('USER_PASSWORD_LENGTH_MAX', 20);
//ユーザータイプ(管理人と一般ユーザー)
define('USER_TYPE_ADMIN', 1);
define('USER_TYPE_NORMAL', 2);
//文字数制限(商品名)
define('ITEM_NAME_LENGTH_MIN', 1);
define('ITEM_NAME_LENGTH_MAX', 20);
//文字数制限(商品説明)
define('ITEM_EXPLANATION_LENGTH_MIN', 1);
define('ITEM_EXPLANATION_LENGTH_MAX', 100);
//価格制限(商品値段)
// define('PRICE_MIN', 1);
define('PRICE_MAX', 100000);
//数量制限(在庫数)
// define('STOCK_MIN', 0);
define('STOCK_MAX', 1000);
//数量制限(在庫数[表示用])
define('DISPLAY_STOCK_MIN', 0);
define('DISPLAY_STOCK_MAX', 10);
//数量制限(購入数)
define('CART_MIN', 1);
define('CART_MAX', 1000);
//ページネーション
define('PAGINATION', 5);
//ランキング
define('RANKING', 3);
//商品ステータス
define('ITEM_STATUS_OPEN', 1);
define('ITEM_STATUS_CLOSE', 0);
//ファイルの拡張子(exif_imagetype関数)
define('PERMITTED_IMAGE_TYPES', array(
  IMAGETYPE_JPEG => 'jpg',
  IMAGETYPE_PNG => 'png',
));