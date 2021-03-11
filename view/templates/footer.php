<!-- ===========================================================
フッター＊
=========================================================== -->
<footer class="footer mt-5">
<!-- ナビゲーションメニュー(タブレット[md]以下切替) -->
<nav class="navbar navbar-expand-md navbar_footer">
<!-- コンテンツ -->
  <ul class="navbar-nav mx-auto">
    <li class="nav-item">
      <a class="nav-link text_fotter text-nowrap" href="#<?php //print(SITE_GUIDE_URL);?>">サイトについて </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text_fotter text-nowrap" href="<?php print(CONTACT_URL);?>">お問い合わせ</a></li>
<!-- モーダルウィンドウ(Profile) -->
    <li class="nav-item">
      <a class="nav-link text_fotter text-nowrap" data-toggle="modal" data-target="#modal1" href="#">管理人について</a>
      <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content modal-bg">
            <div class="modal-header">
              <h5 class="modal-title text-center" id="label1">　　PROFILE　〜About Me〜</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body pt-0">
              <img class="img-fluid my-2 border img-thumbnail " src="<?php print(DEFALT_IMAGE_PATH . 'WorkImage.png'); ?>" alt='CodeSHOP'>
              <div class="profile" id="profile">
                  <p>名前 / 熊倉 一樹（Kumakura Kazuki）</p>
                  <p>生年月日 / 1991月06年21日</p>
                  <p>出身地 / 新潟県長岡市</p>
                  <p>血液型 / A型</p>
                  <p>趣味 / ボウリング</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </li>
  </ul>
</nav>
<!-- コピーライト -->
<nav class="navbar navbar-expand-md navbar_footer">
  <p class="navbar-nav mx-auto">
    <small>Copyright &copy; Code Products All Rights Reserved.</small>
  </p>
</nav>
</footer>
