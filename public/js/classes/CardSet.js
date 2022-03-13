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

  /**
   * returns the question
   * 
   * @returns question
   */
  getQuestion(){
    return this.question;
  }

  /**
   * returns the right answer
   * 
   * @returns answer 
   */
  getAnswer(){
    return this.answer;
  }

  /**
   * returns fake answers and right answer
   * 
   * @returns fakeAnswers 
   */
  getFakeAnswers(){
    
    this.fakeAnswers.push(this.answer);
    
    this.fakeAnswers = _.shuffle(this.fakeAnswers);

    return this.fakeAnswers;
  }

}
