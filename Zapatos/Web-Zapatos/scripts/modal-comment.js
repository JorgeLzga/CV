const modalsClose = document.querySelectorAll('.modal__button--cancel');
const buttonsActivation = document.querySelectorAll('.bxs-trash');
const buttonsDelete = document.querySelectorAll('.modal__button--success');
const containersModal = document.querySelectorAll('.modal');
const modals = document.querySelectorAll('.card__modal');
const idProduct = document.getElementById('input-hidden-id-product');

let pathId;

for (let index = 0; index < buttonsActivation.length; index++) {
    buttonsActivation[index].addEventListener('click', (e) => {
        containersModal[0].classList.add('modal--active');
        modals[0].classList.add('card__modal--active');

        pathId =
            '../controllers/delete-comment.php?' +
            e.target.getAttribute('id') +
            '&id_product=' +
            idProduct.value;
        buttonsDelete[0].setAttribute('href', pathId);
    });
}

modalsClose[0].addEventListener('click', () => {
    containersModal[0].classList.remove('modal--active');
    modals[0].classList.remove('card__modal--active');
});
