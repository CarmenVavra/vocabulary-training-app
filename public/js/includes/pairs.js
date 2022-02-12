function playPairs(vocabularies, countCols, jsVariable){

  "use strict";

  let language = [];
  let foreign = [];

  for(let i=0; i<vocabularies.length; i++){
    language.push(vocabularies[i].vn);
    foreign.push(vocabularies[i].fvn);
  }

  let mixedWords = [];
  const languageLen = language.length;
  const foreignLen = foreign.length;
  const mixedLen = languageLen + foreignLen;
  const table = document.querySelector('#tblPairs');
  const btnPairsApply = document.querySelector('#btnApplyPairsFilter');
  const filterSettings = document.querySelector('#collapseSelection');
  let indexCount = 0;
  let countColumns = 0;
  let checkedRadio;


  if(jsVariable == 1){
    countColumns = countCols;
    console.log(countColumns);
    // für die Anzeige --> Vokabel aus beiden Tabellen werden in ein gemeinsames Array gespeichert
    language.forEach(function(value, index) {
      mixedWords[index] = value;
      indexCount++;
    });

    foreign.forEach(function(value, index) {
      mixedWords[indexCount] = value;
      indexCount++;
    });

    let shuffledMixedWords = _.shuffle(mixedWords);

    let tr;
    let td;
    
    shuffledMixedWords.forEach(function(value, index) {
      if (index % countColumns === 0) {
        tr = document.createElement('tr');
        table.appendChild(tr);

      }
      tr.insertAdjacentHTML('beforeend', '<td id="td_' + index + '" class="td-pairs">' + value + '</td>');

    });

    let counterHide = 0;
    let idxCards = 0;
    let cards = [];
    let cardElements = [];
    let pairsModal = new Modal(document.querySelector('#overlay'));
    const tds = document.querySelectorAll('.td-pairs');
    const closeCont = document.querySelector('#overlay-container');
    let outputTime = document.querySelector('#pairsTime span');
    let outputErrors = document.querySelector('#outputPairsErrors span');
    const btnOK = document.querySelector('#overlay button');
    let pairsCounter = 0;
    let errorCount = 0;

    btnOK.onclick = function(){
      pairsModal.closeModal();
      window.location.href = '/pair';
    }

    closeCont.onclick = function(e) {
      if (e.target.id == 'overlay-container' || e.target.id == 'close') {
        pairsModal.closeModal();
        window.location.href = '/pair';
      }
    };

    let interval;
    tds.forEach(function(value, index) {
      
      value.onclick = function(e) {
        
        if (pairsCounter == 0) {
          interval = setInterval(function() {
            pairsCounter++;
          }, 1000);
        }
        e.target.classList.add('card-turkis');
        
        if (idxCards <= 1) {
          cards[idxCards] = e.target.innerHTML;
          cardElements[idxCards] = e.target;

          if (idxCards == 1) {
            let pair = new Pair(cards[0], cards[1]);
            let isPair = pair.compareCards(language, foreign);

            if (isPair == true) {
              cardElements.forEach(function(value, index) {
                value.classList.add('hide-card');
                counterHide++;
                if (counterHide == mixedLen) {
                  
                  clearInterval(interval);            // Daten für highscore
                  outputTime.innerHTML = '<strong>' + pairsCounter + '</strong> Sekunden';
                  outputErrors.innerHTML = '<strong>' + errorCount + '</strong>';
                  setTimeout(function() {
                    pairsModal.openModal();
                  }, 1300);
                }
              });
            } else{
              errorCount++;
            }

            idxCards = -1;
            cardElements.forEach(function(value, index) {
              if (cards.length == 2 && value.classList.contains('card-turkis')) {
                cardElements.forEach(function(value, index) {
                  setTimeout(function() {
                    value.classList.remove('card-turkis');
                  }, 350);
                });
              }
            });
          }
        }
        idxCards++;
      }

    });


  };
}