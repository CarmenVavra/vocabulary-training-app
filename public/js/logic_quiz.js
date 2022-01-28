$(document).ready(function(){
  /* $('#outputQuiz').hide(); */

  $('#btnApplyQuizFilter').on('click', function(){
    $('#outputQuiz').show();
    $('#collapseSelection').hide();
  });

  $('.list-group').on('click', function(e){
    e.preventDefault();
    $(e.target).toggleClass('active');
    $(e.target).siblings().removeClass('active');
  });
  

});