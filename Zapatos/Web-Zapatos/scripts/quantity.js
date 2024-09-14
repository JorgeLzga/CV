const selectContainer = document.querySelector('.select');
const buttonsForm = document.querySelectorAll('.form__button');
const optionContainer = document.querySelector('.option');
const priceText = document.querySelector('.number__price');
const firsItem = document.getElementById('first-number');
const routeCart = document.getElementById('route_cart');

firsItem.innerText = 0;

if (optionContainer.children.length !== 0) {
    firsItem.innerText = optionContainer.children[0].innerText;
}

/* Inputs de carrito */

const values = document.querySelectorAll('.inputs-hidden-cart');
values[2].value = firsItem.innerText;
values[3].value = priceText.innerHTML;

setRouteCart(firsItem.innerText, priceText.innerHTML);

/* Inputs form */

const inputsHidden = document.querySelectorAll('.input-hidden-id');

inputsHidden[0].value = priceText.innerHTML;
inputsHidden[1].value = firsItem.innerHTML;

if (firsItem.innerText === '0') {
    selectContainer.classList.add('select--desactive');
    buttonsForm[0].classList.remove('form__button--primary');
    buttonsForm[0].classList.add('form__button--desactive');
    buttonsForm[1].classList.remove('form__button--secondary');
    buttonsForm[1].classList.add('form__button--desactive');
}

selectContainer.addEventListener('click', () => {
    optionContainer.classList.toggle('option--active');
    selectContainer.classList.toggle('select--active');
});

let priceNumber = priceText.innerHTML;
const options = optionContainer.children;

for (let index = 0; index < options.length; index++) {
    options[index].addEventListener('click', () => {
        selectContainer.firstElementChild.innerHTML = options[index].innerText;
        optionContainer.classList.remove('option--active');
        selectContainer.classList.remove('select--active');

        let newPrice = Number(priceNumber) * Number(options[index].innerText);

        if (!Number.isSafeInteger(newPrice)) {
            newPrice = newPrice.toFixed(1);
        }

        priceText.innerText = newPrice;

        inputsHidden[0].value = priceText.innerHTML;
        inputsHidden[1].value = selectContainer.firstElementChild.innerHTML;

        let cartQuantity = (values[2].value =
            selectContainer.firstElementChild.innerHTML);
        let cartPrice = (values[3].value = priceText.innerHTML);

        setRouteCart(cartQuantity, cartPrice);
    });
}

/* Comentarios */

const buttonComments = document.getElementById('btn_comments');
const btnBack = document.getElementById('btn-back');
const secondContainer = document.querySelector('.second-part__comments');

buttonComments.addEventListener('click', () => {
    secondContainer.classList.add('second-part__comments--active');
});

btnBack.addEventListener('click', () => {
    secondContainer.classList.remove('second-part__comments--active');
});

/* Carrito */

function setRouteCart(quantity, currentPrice) {
    let pathCart = `../controllers/cart.php?idUser=${values[0].value}&idProduct=${values[1].value}&quantity=${quantity}&subtotal=${currentPrice}`;

    routeCart.setAttribute('href', pathCart);
}
