class Pair {
  constructor(card1, card2, id1, id2) {
    console.log('card1', card1, 'card2', card2);
    this.card1 = card1;
    this.card2 = card2;
    this.id1 = id1;
    this.id2 = id2;

  }

  /**
   * returns the first selected card
   * 
   * @returns card1
   */
  getCard1() {
    return this.card1;
  }

  /**
   * returns the second selected card
   * 
   * @returns card2
   */
  getCard2() {
    return this.card2;
  }
  
  /**
   * compares card1 with card2
   * @params firstLanguageCard, secondLanguageCard
   * 
   * @returns true|false
   */
  compareCards(vocabualaryArray, foreignArray) {
    let indexCard1;
    let indexCard2;

    console.log('vocabualaryArray', vocabualaryArray, 'foreignArray', foreignArray);
    if(vocabualaryArray.includes(this.card1)){
      indexCard1 = vocabualaryArray.indexOf(this.card1);
    }

    if(foreignArray.includes(this.card2)){
      indexCard2 = foreignArray.indexOf(this.card2);
    }

    console.log('indexCard1', indexCard1, 'indexCard2', indexCard2);



    // OLD VERSION

    if (this.id1 !== this.id2) {
      /* console.log('this.card1', this.card1, 'this.card2', this.card2); */

      if (vocabualaryArray.includes(this.card1)) {
        indexCard1 = vocabualaryArray.indexOf(this.card1);
      } else if (foreignArray.includes(this.card1)) {
        indexCard1 = foreignArray.indexOf(this.card1);
      }

      if (vocabualaryArray.includes(this.card2)) {
        indexCard2 = vocabualaryArray.indexOf(this.card2);
      } else if (foreignArray.includes(this.card2)) {
        indexCard2 = foreignArray.indexOf(this.card2);
      }

      if (indexCard1 == indexCard2) {
        return true;
      } else {
        return false;
      }

    }
  }

}