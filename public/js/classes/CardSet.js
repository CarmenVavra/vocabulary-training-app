class CardSet{
  constructor(vocFromDB, fakVoc, direction){
    this.fakeAnswers = [];

    if('dir1' == direction){
      this.question = vocFromDB.vn;
      this.answer = vocFromDB.fvn;

      for(let fake of fakVoc){
        this.fakeAnswers.push(fake.fvn);
      }  
      
    }else if('dir2' == direction){
      this.question = vocFromDB.fvn;
      this.answer = vocFromDB.vn;

      for(let fake of fakVoc){
        this.fakeAnswers.push(fake.vn);
      }  
      
/* 
      for(let i=0;i<fakVoc.length;i++){
        this.fakeAnswers.push(fakVoc[i].vn);
      } */
    }


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
