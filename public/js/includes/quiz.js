function playQuiz(limit, vocFromDB, radioDirection){

  "use strict";
  console.log('radioDirection ', radioDirection); 
  let question;
  let answer;
  let fakeAnswers;
  let cardSet;
  //console.log('start fakeVocFromDB ', fakeVocFromDB.length);
        
  const content = document.querySelector('#outputQuiz');
  let flexContainer;
  let outputQuestion;
  let outputAnswers;
  let fakVoc = [];

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  for (let i = 1; i <= vocFromDB.length; i++) {

      $.ajax({
          type:'GET',
          url:"{{ route('quiz.fetch.fake') }}",
          datatype: "json",
          data:{radioDirection:radioDirection},
          success:function(data){

            fakVoc = data.fakeVoc;
            console.log('fakVoc ', fakVoc);

            cardSet = new CardSet(vocFromDB[i-1], fakVoc);

            question = cardSet.getQuestion();
            answer = cardSet.getAnswer();
            fakeAnswers = cardSet.getFakeAnswers();
            console.log('fakeAnswers', fakeAnswers);

            if(i % 4 === 1){
                  content.insertAdjacentHTML('beforeend', '<div id="contId_'+i+'" class="card-flex-container">');
                    flexContainer = document.querySelector('#contId_'+i);
                  }
                  
                  flexContainer.insertAdjacentHTML('beforeend', '<div id="card_' + i + '" class="card bg-turkis" style="width: 18rem;"><div class="card-body">');
                  outputQuestion = document.querySelector('#card_' + i + ' .card-body');
                  outputQuestion.insertAdjacentHTML('beforeend', '<div class="card-title bg-darkgray">' + question + '</div><ul class="list-group list-group-flush">');
                  outputAnswers = document.querySelector('#card_' + i + ' .card-body .list-group');
                      
                  fakeAnswers.forEach(function(value, index) {
                    console.log('value ', value, 'index ', index);
                    outputAnswers.insertAdjacentHTML('beforeend', '<li class="list-group-item">' + value.fvn + '</li>');
                  });

            }



        
        });

    }    
              
}