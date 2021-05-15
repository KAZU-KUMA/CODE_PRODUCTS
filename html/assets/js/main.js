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

// フォーム処理
$(function () {
    $('#form').submit(function (event) {
      var formData = $('#form').serialize();
      $.ajax({
        url: "https://docs.google.com/forms/u/0/d/e/1FAIpQLSeQoGjWmqASxd6zpgdLrIj445VyyXM-J0a7ZDuh4-4U2iUPxA/formResponse",
        data: formData,
        type: "POST",
        dataType: "xml",
        statusCode: {
          0: function () {
            $('#form')[0].reset();
            $(".end-message").slideDown();
            //window.location.href = "thanks.html";
          },
          200: function () {
            $(".false-message").slideDown();
          }
        }
      });
      event.preventDefault();
    });
});