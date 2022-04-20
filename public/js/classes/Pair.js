class Pair {
  constructor(card1, card2, id1, id2) {
    // console.log('card1', card1, 'card2', card2, 'id1', id1, 'id2', id2);
    this.card1 = card1[1];
    this.card2 = card2[1];
    this.card1Index = card1[0];
    this.card2Index = card2[0];
    this.id1 = id1;
    this.id2 = id2;
    this.vocabularyIndexes = [];

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

  getVocabularyIndexes(){
    return this.getVocabularyIndexes;
  }
  
  /**
   * compares card1 with card2
   * @params firstLanguageCard, secondLanguageCard
   * 
   * @returns true|false
   */
  compareCards(vocabularyArray, foreignArray) {
    let indexCard1;
    let indexCard2;

    let card1 = this.card1;
    let card2 = this.card2;
    let card1index = this.card1Index;
    let card2index = this.card2Index;

    if (this.id1 !== this.id2) {
      if(card1index === card2index){
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }

  
  }

}