class CardSet{
  constructor(vocFromDB, fakVoc){
    console.log('fakVoc constructor ', fakVoc);
    console.log('vocFromDB ', vocFromDB);
    this.fakeAnswers = [];
    this.question = vocFromDB.vn;
    this.answer = vocFromDB;
    this.fakeAnswers = fakVoc;

    //console.log(this.fakeAnswers);
/*    
    let vocElem = fakeVocFromDB;

    vocElem.splice(0,3);
    this.fakeAnswers = this.answer;
    console.log('fakeAnswers: ', this.fakeAnswers)
     this.fakeAnswers.push(this.answer);
    this.fakeAnswers = _.shuffle(this.fakeAnswers);
    console.log('fakeAnswers: ', this.fakeAnswers); */


  }

  getQuestion(){
    return this.question;
  }

  getAnswer(){
    return this.answer;
  }

  getFakeAnswers(){
    
    this.fakeAnswers.push(this.answer);
    
    this.fakeAnswers = _.shuffle(this.fakeAnswers);

    return this.fakeAnswers;
  }

}
