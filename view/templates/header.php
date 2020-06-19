<header>
<!-- ===========================================================
 ヘッダー(ログインなし)＊
=========================================================== -->
<!-- ナビゲーションメニュー(タブレット[md]以下切替) -->
  <nav class="navbar navbar-expand-md navbar_header">
<!-- ロゴ画像 -->
    <a class="navbar-brand" href="<?php print(LOGIN_URL);?>"><img class='logo' src="<?php print(DEFALT_IMAGE_PATH . 'logo.png'); ?>" alt='CodeSHOP'></a>
<!-- ハンバーガーメニュー -->
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#headerNav" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="ナビゲーションの切替">
      <span class="navbar-toggler-icon"></span>
    </button>
<!-- コンテンツ -->
    <div class="collapse navbar-collapse" id="headerNav">
      <ul class="navbar-nav ml-auto mx-5">
        <li class="nav-item">
          <a class="nav-link text-white text-nowrap" href="<?php print(SIGNUP_URL);?>">サインアップ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white text-nowrap" href="<?php print(LOGIN_URL);?>">ログイン</a>
        </li>
      </ul>
    </div>
  </nav>
</header>