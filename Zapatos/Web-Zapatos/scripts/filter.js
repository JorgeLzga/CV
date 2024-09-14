const searchInput = document.getElementById('search');
const cards = document.querySelectorAll('.container__card');
/* const cardContainer = document.querySelectorAll('.container__card'); */

searchInput.addEventListener('keyup', (e) => {
    cards.forEach((card) => {
        const name = card.dataset.name.toLowerCase();

        if (!name.includes(e.target.value.toLowerCase())) {
            card.classList.add('card__filter');
        } else {
            card.classList.remove('card__filter');
        }
    });
});
