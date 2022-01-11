class Modal{
  constructor(modal){
    this.modal = modal;
  }

  /**
   * open modal-box
   */
  openModal(modalType='default'){
    this.modal.style.display = 'block';
    const content = document.querySelector('#overlay-container .alert');
    const deleteContent = document.querySelector('#overlay-delete-container .alert');
    switch(modalType){
      case 'new':content.classList.remove('turkis-bg');
                      content.classList.remove('red-bg');
                      content.classList.add('green-bg');
                      break;
      case 'edit':    content.classList.remove('green-bg');
                      content.classList.remove('red-bg');
                      content.classList.add('turkis-bg');
                      break;
      case "delete":  deleteContent.classList.remove('green-bg');
                      deleteContent.classList.remove('turkis-bg');
                      deleteContent.classList.add('red-bg');
                      break;
      default: break;
    }
  }

  /**
   * close the opened modal-box
   */
  closeModal(){
    this.modal.style.display = 'none';
  }

  /**
   * set the content to modal-box
   * @param aTag 
   * @returns img
   */
  setContent(aTag){
/*     const img = document.querySelector('#overlay-container img');
    img.setAttribute('src', aTag.getAttribute('href'));
    return img; */
  }

}