document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.getElementById("image-carousel");
    const prevBtn = document.getElementById("prev-btn");
    const nextBtn = document.getElementById("next-btn");
    const imageWidth = document.querySelector("#image-carousel img").clientWidth;
    const numImages = document.querySelectorAll("#image-carousel img").length;

    let currentIndex = 0;

    function updateCarousel() {
        carousel.style.transform = `translateX(${-currentIndex * imageWidth}px)`;
    }

    function nextImage() {
        if (currentIndex < numImages - 1) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateCarousel();
    }

    function prevImage() {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = numImages - 1;
        }
        updateCarousel();
    }

    nextBtn.addEventListener("click", nextImage);
    prevBtn.addEventListener("click", prevImage);

    // Auto slide every 3 seconds
    setInterval(nextImage, 3000);
}


);
