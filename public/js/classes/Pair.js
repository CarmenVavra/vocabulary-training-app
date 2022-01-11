class Pair {
  constructor(card1, card2) {
    this.card1 = card1;
    this.card2 = card2;

  }

  getCard1() {
    return this.card1;
  }

  getCard2() {
    return this.card2;
  }

  compareCards(germanArray, spainArray) {
    let indexCard1;
    let indexCard2;

    if (this.card1 !== this.card2) {

      if (germanArray.includes(this.card1)) {
        indexCard1 = germanArray.indexOf(this.card1);
      } else if (spainArray.includes(this.card1)) {
        indexCard1 = spainArray.indexOf(this.card1);
      }

      if (germanArray.includes(this.card2)) {
        indexCard2 = germanArray.indexOf(this.card2);
      } else if (spainArray.includes(this.card2)) {
        indexCard2 = spainArray.indexOf(this.card2);
      }

      if (indexCard1 == indexCard2) {
        return true;
      } else {
        return false;
      }

    }
  }

}