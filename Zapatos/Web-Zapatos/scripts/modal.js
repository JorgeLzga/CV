const buttons = document.querySelectorAll('.profile__button');
const containersModal = document.querySelectorAll('.modal');
const modals = document.querySelectorAll('.card__modal');
const modalsClose = document.querySelectorAll('.modal__button--cancel');
const modalsHeaderClose = document.querySelectorAll('.bx-x');
const inputs = document.querySelectorAll('.modal__input');
const submits = document.querySelectorAll('.modal__button');

let count = 0;

for (let index = 0; index < submits.length; index++) {
    if (submits[index].type === 'submit') {
        closeModal(submits[index], containersModal[count], modals[count]);

        count++;
    }
}

for (let index = 0; index < buttons.length; index++) {
    modalReference(
        buttons[index],
        containersModal[index],
        modals[index],
        modalsClose[index],
        modalsHeaderClose[index]
    );
}

function modalReference(
    element,
    container,
    modal,
    modalsClose,
    modalsHeaderClose
) {
    if (element.dataset.modal === container.getAttribute('id')) {
        openModal(element, container, modal);
        closeModal(modalsClose, container, modal);
        closeModal(modalsHeaderClose, container, modal);
    }
}

function openModal(element, container, modal) {
    element.addEventListener('click', () => {
        container.classList.add('modal--active');
        modal.classList.add('card__modal--active');
    });
}

function closeModal(element, container, modal) {
    element.addEventListener('click', () => {
        container.classList.remove('modal--active');
        modal.classList.remove('card__modal--active');
        setTimeout(() => {
            clearInput(inputs);
        }, 300);
    });
}

function clearInput(inputs) {
    inputs.forEach((input) => (input.value = ''));
}
