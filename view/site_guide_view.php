<!-- ===========================================================
サイト案内画面＊
=========================================================== -->
<!DOCTYPE html>
<html lang="ja">
<head>
<!-- head情報読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>サイト案内</title>
<!-- css読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'site_guide.css'); ?>">
</head>
<body>
<!-- ヘッダー読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined.php';?>
<!-- コンテンツ-->
  <div class="container">
<!-- <h1>ただいま製作中!!</h1> -->

<p class="mb-0 font-weight-bold">こちらは機械部品を取り扱うオンライン販売システムです。</p>
<p><small>(模倣サイトのため、実際に商品を注文することはできませんので、ご注意ください。)</small></p>
<dl>
  <dt>製作者</dt>
    <dd>熊倉 一樹</dd>
  <dt>テーマ</dt>
    <dd>CODE PRODUCTS(部品の在庫管理およびオンライン販売システム)</dd>
  <dt>制作およびテーマ選定理由</dt>
    <dd>前職では取引先の整備工場や顧客が機械の故障、整備時に部品が必要な際、電話対応のみであり、<br>
    24時間、どこからでも容易に在庫数、価格の確認や購入できるシステムがあれば、良いと思い制作に至りました。
    </dd>
  <dt>作成期間</dt>
    <dd>5/30〜6/10(12日間)</dd>
  <dt>作成言語と環境</dt>
    <dd>
      <ul>
        <li>言語・・・HTML/CSS、PHP、MySQL</li>
        <li>フレームワーク、ライブラリ・・・ Bootsrtap、JQuery</li>       
        <li>ツール・・・GitHub(バージョン管理), Docker(LAMP環境)</li>
        <li>OS・・・Mac</li>
      </ul>
    </dd>
  <p class="font-weight-bold">ソースコード(GitHub)　<a href="https://github.com/KAZU-KUMA/CODE_PRODUCTS">表示</a></p>
  <p class="font-weight-bold">コンセプトシート　<a href="https://docs.google.com/presentation/d/e/2PACX-1vRHZFbUvCaDwx9wNjqnDOhjDXosQs5MxPFbNIf8yLIbBeGkizOBZV3vMD71CurL5IJH3CQYD3V4qWSs/pub?start=false&loop=false&delayms=3000">表示</a></p>
  <p class="font-weight-bold">サイトマップ、ワイヤーフレーム　<a href="https://docs.google.com/presentation/d/e/2PACX-1vTkiNCIhdDyYe9uCzu5IJLGIW5vTGLBjlwJgMW97oFPt9RmYAY9Z63pC_aS0ZaOWAmB4hpA5n21CTgB/pub?start=false&loop=false&delayms=3000">表示</a></p>
  <p class="font-weight-bold">テーブル定義書、テスト仕様書　<a href="https://docs.google.com/spreadsheets/d/e/2PACX-1vRd22QJfTEqvJqLu-G5inUQYFfzQd2p0con8FNSAK9GJbkASp89mtj9-TVlqJfGnhH_p4gNsSajm6gI/pubhtml">表示</a></p>
  <p class="font-weight-bold">スケジュール管理　<a href="https://docs.google.com/spreadsheets/d/e/2PACX-1vSszLlT72kbYCU6cwpjeXH3YTyl0Pi8X3tfpvXMk7HQh23w6jXGLtsLXVTDmjyYbGlUYjQhQxr8lwKk/pubhtml">表示</a></p>
</dl>
<form action="index.php"  method="post">
  <input type="submit" value="戻る" class="btn btn-warning btn-block">
</form>
</div>
<!-- フッター読み込み -->
<?php include VIEW_PATH . 'templates/footer.php'; ?>
</body>
</html>