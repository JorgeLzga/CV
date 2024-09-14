const modalsClose = document.querySelectorAll('.modal__button--cancel');
const buttonsActivation = document.querySelectorAll('.bx-x');
const buttonsDelete = document.querySelectorAll('.modal__button--success');
const containersModal = document.querySelectorAll('.modal');
const modals = document.querySelectorAll('.card__modal');

let pathId;

for (let index = 0; index < buttonsActivation.length; index++) {
    buttonsActivation[index].addEventListener('click', (e) => {
        containersModal[0].classList.add('modal--active');
        modals[0].classList.add('card__modal--active');

        pathId =
            '../controllers/delete-product.php?' + e.target.getAttribute('id');
        buttonsDelete[0].setAttribute('href', pathId);
    });
}

modalsClose[0].addEventListener('click', () => {
    containersModal[0].classList.remove('modal--active');
    modals[0].classList.remove('card__modal--active');
});
