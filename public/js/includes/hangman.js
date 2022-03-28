function playHangman(origArray){
  "use strict";

  let canvas = new Canvas(document.querySelector('#hangman'));
  const output = document.querySelector('#output');

  let origString = origArray[0].fvn;
  console.log('origArray ', origArray);
  console.log('origString ', origString);
  let searchString = origString.toLowerCase();
  let lenSearchString = searchString.length;
  let inputLetters = [];
  let outputArray = [];
  let errors = [];


  let searchStringArray = searchString.split("");
  const keyboardRow1 = ['q', 'w', 'e', 'r', 't', 'z', 'u', 'i', 'o', 'p', 'ü'];
  const keyboardRow2 = ['a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'ö', 'ä'];
  const keyboardRow3 = ['y', 'x', 'c', 'v', 'b', 'n', 'm'];
  const outputKBRow1 = document.querySelector('#row1');
  const outputKBRow2 = document.querySelector('#row2');
  const outputKBRow3 = document.querySelector('#row3');
  const outputKBRows = document.querySelectorAll('.keyboard-row');
  let row1Keys = '';
  let row2Keys = '';
  let row3Keys = '';
  keyboardRow1.forEach(function(value) {
    row1Keys += '<button class="btn-turkis btn-keyboard">' + value + '</button>';
  });
  outputKBRow1.insertAdjacentHTML('beforeend', row1Keys);

  keyboardRow2.forEach(function(value) {
    row2Keys += '<button class="btn-turkis btn-keyboard">' + value + '</button>';
  });
  outputKBRow2.insertAdjacentHTML('beforeend', row2Keys);

  keyboardRow3.forEach(function(value) {
    row3Keys += '<button class="btn-turkis btn-keyboard">' + value + '</button>';
  });
  outputKBRow3.insertAdjacentHTML('beforeend', row3Keys);

  let splitArray = origString.split('');
  let pattern = ['-', ' ', '!', '?', '\'', '`', ','];

  for (let i = 0; i < lenSearchString; i++) {
    //console.log('splitArray[i] ', pattern.includes(splitArray[i]));
    //console.log('lenStringSearch ', lenSearchString);
    if(pattern.includes(splitArray[i])){
      if(splitArray[i] == ' '){
        outputArray[i] = '&nbsp;';
      }else{
        outputArray[i] = splitArray[i];
      }
    }else{
      outputArray[i] = ' _ ';
    }

  }
  output.innerHTML = outputArray.join("");

  let i = 0;
  let x = 0;
  let hangModal = new Modal(document.querySelector('#overlay-hangman'));
  const closeCont = document.querySelector('#overlay-hangman-container');
  let outputCardTitle = document.querySelector('#overlay-hangman .card-title');
  let outputUserCount = document.querySelector('#hangmanUser span');
  let outputCompCount = document.querySelector('#hangmanComp span');
  let btnOK = document.querySelector('#overlay-hangman button');
  let user = 0;
  let computer = 0;


  outputKBRows.forEach(function(el) {

    el.onclick = function(e) {
      e.target.setAttribute('disabled', "");

      let contains = searchString.indexOf(e.target.textContent);
      if (contains === -1) {
        console.log('Der Buchstabe ist nicht enthalten');
        errors[i] = 1;
        switch (errors.length) {
          case 1: canvas.drawBaseTriangle(); break;
          case 2: canvas.drawPoleLine(); break;
          case 3: canvas.drawLatteLine(); break;
          case 4: canvas.drawSlopeLine(); break;
          case 5: canvas.drawRopeLine(); break;
          case 6: canvas.drawHeadCircle(); break;
          case 7: canvas.drawBodyLine(); break;
          case 8: canvas.drawRightArmLine(); break;
          case 9: canvas.drawLeftArmLine(); break;
          case 10: canvas.drawRightLegLine(); break;
          case 11: canvas.drawLeftLegLine();
                    computer++;
                    outputCardTitle.innerHTML = 'Du hast verloren! Das gesuchte Wort lautet: ' + origString;
                    outputUserCount.innerHTML = user;
                    outputCompCount.innerHTML = computer;
                    hangModal.openModal();
                    break;
          default: return;
        }
        i++;
      } else {

        let letter = searchString.charAt(contains);
        let upperString;
        searchStringArray.forEach(function(value, index) {
          if (value == e.target.textContent) {
            outputArray[index] = value;
            searchStringArray[index] = "";
            searchString = searchStringArray.join("");
           
            upperString = outputArray.join("").toUpperCase();
           
            while(upperString.includes('&NBSP;')){
              upperString = upperString.replace('&NBSP;', '&nbsp;');
            }
            
            output.innerHTML = upperString;

            for(let i=0; i<pattern.length; i++){
              while(searchString.includes(pattern[i])){
                searchString = searchString.replace(pattern[i], '');
              }

            }

            if (searchString == '') {
              user++;
              outputCardTitle.innerHTML = 'Gratulation!! Du hast gewonnen!';
              outputUserCount.innerHTML = user;
              outputCompCount.innerHTML = computer;
              hangModal.openModal();
            }
          }
        });
      }

      if (errors.length != 0) {
        console.log('Fehler: ', errors);
      }
    }
  });

  btnOK.onclick = function(){
      hangModal.closeModal();
      window.location.href = '/hangman';
  };

  closeCont.onclick = function(e) {
    if (e.target.id == 'overlay-hangman-container' || e.target.id == 'close') {
      window.location.href = '/hangman';
      hangModal.closeModal();
    }
  };
}