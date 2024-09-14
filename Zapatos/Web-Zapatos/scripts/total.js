const allPrice = document.querySelectorAll('.c-p');
const priceTotal = document.querySelector('.price-total');
const totalPriceSubmit = document.getElementById('total_price');
const productsIds = document.querySelectorAll('#id_products');

let sumatory = 0;

priceTotal.innerHTML = 'Subtotal: $' + sumatory;

allPrice.forEach((price) => {
    sumatory += getNumberOnly(price);
});

priceTotal.innerHTML = 'Subtotal: $' + sumatory.toFixed(1);

function getNumberOnly(element) {
    const number = element.innerHTML.split('$')[1];

    return Number(number);
}

/* Seteando el precio total que se enviará por post */
totalPriceSubmit.setAttribute('value', getNumberOnly(priceTotal));
