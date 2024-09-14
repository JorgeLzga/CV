const buttonsEdit = document.querySelectorAll('.bx-edit-alt');
const inputs = document.querySelectorAll('.inputs__hidden');
const inputsValues = document.querySelectorAll('.inputs__input');
const form = document.querySelector('.form-user');
const buttonClose = document.querySelector('.content_modify__header');
const containerModify = document.querySelector('.content__modify');

let array = [];
let productList = [];

for (let index = 0; index < buttonsEdit.length; index++) {
    buttonsEdit[index].addEventListener('click', () => {
        containerModify.classList.add('content__modify--active');
        form.classList.remove('form-user--desactive');
    });
}

buttonClose.addEventListener('click', () => {
    form.classList.add('form-user--desactive');
    containerModify.classList.remove('content__modify--active');
});

/* Inicializo el array con los valores */
for (let index = 0; index < inputs.length; index++) {
    array.push(inputs[index].value);
}

/* Separo el array en valores para cada producto */
for (let index = 0; index <= array.length; index++) {
    productList.push(array.slice(0, 7));

    array.splice(0, 1);
    array.splice(0, 1);
    array.splice(0, 1);
    array.splice(0, 1);
    array.splice(0, 1);
    array.splice(0, 1);
    array.splice(0, 1);
}

for (let index = 0; index < buttonsEdit.length; index++) {
    buttonsEdit[index].addEventListener('click', () => {
        const buttonID = buttonsEdit[index].parentNode.getAttribute('id');
        const idProduct = productList[index][0];
        if (buttonID === idProduct) {
            fitInputs(index + 1);
        }
    });
}

function fitInputs(numberProduct) {
    for (let index = 0; index < numberProduct; index++) {
        for (let j = 0; j < 7; j++) {
            inputsValues[j].value = productList[index][j];
        }
    }
}
