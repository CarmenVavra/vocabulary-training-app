class Pair {
  constructor(card1, card2, id1, id2) {
    // console.log('card1', card1, 'card2', card2, 'id1', id1, 'id2', id2);
    this.card1 = card1[1];
    this.card2 = card2[1];
    this.card1Index = card1[0];
    this.card2Index = card2[0];
    this.id1 = id1;
    this.id2 = id2;


  }
  
  /**
   * compares card1 with card2
   * @params firstLanguageCard, secondLanguageCard
   * 
   * @returns true|false
   */
  compareCards(vocabularyArray, foreignArray) {

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