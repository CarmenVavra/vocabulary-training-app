$(document).ready(function(){
  /* $('#outputQuiz').hide(); */

  $('#btnApplyQuizFilter').on('click', function(){
    $('#outputQuiz').show();
    $('#collapseSelection').hide();
  });

  $('#outputQuiz').on('click', function(e){
    if($(e.target).hasClass('list-group-item')){
      $(e.target).toggleClass('active');
      $(e.target).siblings().removeClass('active');
    }
  });

/*   $('#checkQuizAnswers').on('click', function(){
    $('')

    //$('[id^=card_]')')
    $("div[id^='editDialog']");
  }); */



});