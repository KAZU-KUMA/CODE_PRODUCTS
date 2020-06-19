/* ===========================================================
JavaScript(JQuery)＊
=========================================================== */
$(function () {
// 削除確認
  $('.delete').on('click', () => confirm('本当に削除しますか？'));

// 先頭へ
  /*下へスクロールすると表示され、上へスクロールすると非表示になる(スクロール量1000px)*/
  $(window).scroll(function(){
      if($(this).scrollTop() > 1000){
          $('#back-to-top').fadeIn();
      }else{
          $('#back-to-top').fadeOut();
      }
  });
  /*クリック時にTOPへ(0.5秒)*/
  $('#back-to-top').click(function(){
      $('html,body').animate({
          scrollTop:0
      },500)
  });
});