class CardSet{
  constructor(){
    this.question = "la hija";
    this.answer = 'die Tochter';
    this.fakeAnswers = ['der Freund', 'der Mond', 'schlafen'];
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
