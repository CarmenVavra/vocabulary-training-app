class Canvas{
  constructor(canvas){
    if (canvas.getContext) {
      this.canvas = canvas.getContext('2d');
      this.canvas.strokeStyle = '#fff';
    }    
  }

  /**
   * draw triangle on the bottom of canvas
   * 
   * @returns canvas
   */
  drawBaseTriangle(){
      // 1. Schritt ==> drawSockel() -> Dreieck unten 
      this.canvas.beginPath();
      this.canvas.moveTo(100, 300);
      this.canvas.lineTo(150, 350);
      this.canvas.lineTo(50, 350);
      this.canvas.closePath();
      this.canvas.stroke();
      return this.canvas;
  }

  /**
   * draw vertical line
   * 
   * @returns canvas
   */
  drawPoleLine(){
      // 2. Schritt ==> drawStange() -> Strich senkreckt hinauf von der Dreiecks-Spitze ausgehend
      this.canvas.beginPath();
      this.canvas.moveTo(100, 300);
      this.canvas.lineTo(100, 70);
      this.canvas.stroke();
      return this.canvas;
  }

  /**
   * draw horizontal line
   * 
   * @returns canvas
   */
  drawLatteLine(){
      // 3. Schritt ==> drawLatte() -> Strich 90° nach rechts
      this.canvas.beginPath();
      this.canvas.moveTo(100, 70);
      this.canvas.lineTo(200, 70);
      this.canvas.stroke();
      return this.canvas;
  }
  
  /**
   * draw slope line
   * 
   * @returns canvas
   */
  drawSlopeLine(){
      // 4. Schritt ==> drawSchraege() -> Schräge von Strich 1 zu Strich 2
      this.canvas.beginPath();
      this.canvas.moveTo(100, 130);
      this.canvas.lineTo(150, 70);
      this.canvas.stroke();
      return this.canvas;
  }
  
  /**
   * draw rope line
   * 
   * @returns canvas
   */
  drawRopeLine(){
      // 5. Schritt ==> drawSeil() -> Seil (Gerade rechter Winkel) vom Ende von Strich 2 senkrecht hinunter
      this.canvas.beginPath();
      this.canvas.moveTo(200, 70);
      this.canvas.lineTo(200, 120);
      this.canvas.stroke();
      return this.canvas;
  }
  
  /**
   * draw head circle
   * 
   * @returns canvas
   */
  drawHeadCircle(){
      // 6. Schritt ==> drawKopf() -> Kopf (Kreis) beginnt am Ende des Seils
      this.canvas.beginPath();
      this.canvas.arc(200, 140, 20, 0, Math.PI * 2, true);
      this.canvas.stroke();
      return this.canvas;
  }

  /**
   * draw body line
   * 
   * @returns canvas
   */
  drawBodyLine(){
      // 7. Schritt ==> drawKoerper() -> Körper -> von der unteren Kopfmitte senkrecht hinunter
      this.canvas.beginPath();
      this.canvas.moveTo(200, 160);
      this.canvas.lineTo(200, 240);
      this.canvas.stroke();
      return this.canvas;
  }

    /**
   * draw right arm line
   * 
   * @returns canvas
   */
  drawRightArmLine(){
      // 8. Schritt ==> drawRightArm() -> !. Arm -> von der Mitte des Körpers schräg nach rechts hinauf
      this.canvas.beginPath();
      this.canvas.moveTo(200, 200);
      this.canvas.lineTo(250, 140);
      this.canvas.stroke();
      return this.canvas;
  }

  /**
   * draw left arm line
   * 
   * @returns canvas
   */
  drawLeftArmLine(){
      // 9. Schritt ==> drawLeftArm() -> 2. Arm -> von der Mitte des Körpers schräg nach links hinauf
      this.canvas.beginPath();
      this.canvas.moveTo(200, 200);
      this.canvas.lineTo(150, 140);
      this.canvas.stroke();
      return this.canvas;
  }

  /**
   * draw right leg line
   * 
   * @returns canvas
   */
  drawRightLegLine(){
      // 10. Schritt ==> drawRightLeg() -> 1. Bein -> vom Ende des Körpers schräg nach rechts hinunter
      this.canvas.beginPath();
      this.canvas.moveTo(200, 240);
      this.canvas.lineTo(250, 300);
      this.canvas.stroke();
      return this.canvas;
  }

  /**
   * draw left leg line
   * 
   * @returns canvas
   */
  drawLeftLegLine(){
      // 11. Schritt ==> drawLeftLeg() -> 2. Bein -> vom Ende des Körpers schräg nach links hinunter
      this.canvas.beginPath();
      this.canvas.moveTo(200, 240);
      this.canvas.lineTo(150, 300);
      this.canvas.stroke();
      return this.canvas;
  }

  /**
   * returns the canvas
   * 
   * @returns canvas
   */
  getCanvas(){
    return this.canvas;
  }











}