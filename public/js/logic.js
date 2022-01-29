$(document).ready(function(){
  $('#overlay-select-language').show();
  $('#addNewLanguage').hide();
  $('#rowMarker').hide();
  $('#fieldSizeContainer').hide();

  $('#btnSelectLanguagesNew').on('click', function(){
      $('#addNewLanguage').toggle();
  });
 
  $('#profile').on('click', function(e){
    e.preventDefault();
    $('#dropdownUser').hide();
    $('#overlay-profile').show();
  }) 

  $('#btnProfileClose').on('click', function(){
    $('#overlay-profile').hide();
  });

  $('#userEdit').on('click', function(e){
    e.preventDefault();
    $('#dropdownUser').hide();
    $('#overlay-edit').show();
  })

  $('#btnEditUser').on('click', function(e){
    $('#overlay-edit').hide();
  });

  $('#btnApplyHangmanFilter').on('click', function(){
    $('#contHangman').show();
    $('#collapseSelection').hide();
  });

  $('#btnApplyPairsFilter').on('click', function(){
    $('#contTblPairs').show();
    $('#collapseSelection').hide();
  });

   $('#btnApplyLearningFilter').on('click', function(){
    $('#contTblLearning').show();
    $('#collapseSelection').hide();
  }); 

  $('.dropdown-toggle').on('click', function(e){
    $(e.target).siblings().toggle();
  });

  $('#btnFilter').on('click', function(){
    $('#collapseSelection').toggle();
  });

  $('#btnPairs').on('click', function(){
    window.location.href = '/pair';
  });

  $('#btnHangman').on('click', function(){
    window.location.href = '/hangman';
  });

  $('#btnQuiz').on('click', function(){
    window.location.href = '/quiz';
  });

  $('#btnLernen').on('click', function(){
    window.location.href = '/learning';
  });

  $('#newGame').on('click', function(){
    window.location.href = '/hangman';
  });

  $('.navbar-brand').on('click', function(){
    window.location.href = '/welcome';
  });

  $('.nav-link').on('click', function(e){
    if(e.target.id == 'nav_1'){
      window.location.href = '/vocabulary';
    }
    if(e.target.id == 'nav_2'){
      window.location.href = '/training';
    }
    if(e.target.id == 'nav_3'){
      window.location.href = '/dashboard';
    }
  });

  $('#nav_2').on('mouseover', function(e){
    $(this).siblings().toggle();
  });

  $('#navUserSettings').on('click', function(){
    $('#userSettings').toggle();
  });

  $('.row-marker .btn-danger').on('click', function(e){
    $(e.target).closest('tr').toggleClass('red-row');
    $(e.target).closest('tr').removeClass('yellow-row');
    $(e.target).closest('tr').removeClass('green-row');
  });

  $('.row-marker .btn-warning').on('click', function(e){
    $(e.target).closest('tr').toggleClass('yellow-row');
    $(e.target).closest('tr').removeClass('red-row');
    $(e.target).closest('tr').removeClass('green-row');
  });

  $('.row-marker .btn-success').on('click', function(e){
    $(e.target).closest('tr').toggleClass('green-row');
    $(e.target).closest('tr').removeClass('yellow-row');
    $(e.target).closest('tr').removeClass('red-row');
  });

  $('#difficultyLevel').on('click', function(e){
    $(e.target).toggleClass('active');
  });

  $('#selectAll').on('click', function(){
    $('#difficultyLevel').children().removeClass('active');
  });

  $('input[name="dates"]').daterangepicker();

  $('#lblUserLanguage').on('mouseover', function(){
    $('[data-toggle="tooltip"]').tooltip();
  })






});


