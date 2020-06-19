<header>
  <!-- ===========================================================
 ヘッダー(ログインあり、一般ユーザー画面用)
=========================================================== -->
<!-- ナビゲーションメニュー(タブレット[md]以下切替) -->
<nav class="navbar navbar-expand-md navbar_header">
<!-- ロゴ画像 -->
    <a class="navbar-brand" href="<?php print(ADMIN_URL);?>"><img class='logo' src="<?php print(DEFALT_IMAGE_PATH . 'logo.png'); ?>" alt='CodeSHOP'></a>
<!-- ハンバーガーメニュー -->
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#headerNav" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="ナビゲーションの切替">
      <span class="navbar-toggler-icon"></span>
    </button>
<!-- コンテンツ -->
    <div class="collapse navbar-collapse" id="headerNav">
      <ul class="navbar-nav ml-auto mx-5">
        <li class="nav-item">
          <a class="nav-link text-white text-nowrap" href="<?php print(CART_URL);?>">カート</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white text-nowrap" href="<?php print(FAVORITE_URL);?>">お気に入り</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white text-nowrap" href="<?php print(HISTORY_URL);?>">購入履歴</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white text-nowrap" href="<?php print(LOGOUT_URL);?>">ログアウト</a>
        </li>
      </ul>
    </div>
  </nav>
  <p class="ml-5 mt-2 h4">ようこそ、<span class="text-success"><?php print($user['name']); ?></span>さん</p>
</header>