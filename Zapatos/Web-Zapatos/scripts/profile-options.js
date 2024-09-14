const buttonProfile = document.querySelector('.bx-chevron-down');
const menuProfile = document.querySelector('.profile__custom__menu');

buttonProfile.addEventListener('click', () => {
    menuProfile.classList.toggle('profile__custom__menu--active');
});
