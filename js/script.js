const saveButton = document.querySelector('.button--primary');
const modal = document.querySelector('.modal');
const modalClose = document.querySelector('.close');

function toggleModal() {
    modal.classList.toggle("show-modal");
}

saveButton.addEventListener('click', toggleModal);
modalClose.addEventListener('click', toggleModal);

