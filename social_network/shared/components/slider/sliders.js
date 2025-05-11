document.addEventListener("DOMContentLoaded", function () {
    const posts = document.querySelectorAll(".post");

    posts.forEach((post) => {
        const slider = post.querySelector(".post__slider");
        if (!slider) return;

        const slides = post.querySelectorAll(".post__slide");
        const prevBtn = post.querySelector(".post__slider-arrow--prev");
        const nextBtn = post.querySelector(".post__slider-arrow--next");
        const counter = post.querySelector(".post__slider-current");

        if (slides.length <= 1) return;

        let currentSlide = 0;

        function updateSlider() {
            slides.forEach((slide, index) => {
                slide.classList.toggle(
                    "post__slide--active",
                    index === currentSlide
                );
            });

            if (counter) {
                counter.textContent = currentSlide + 1;
            }

            // Обновление состояния кнопок
            if (prevBtn) {
                prevBtn.classList.toggle(
                    "post__slider-arrow--active",
                    currentSlide > 0
                );
            }
            if (nextBtn) {
                nextBtn.classList.toggle(
                    "post__slider-arrow--active",
                    currentSlide < slides.length - 1
                );
            }
        }

        if (prevBtn) {
            prevBtn.addEventListener("click", () => {
                if (currentSlide > 0) {
                    currentSlide--;
                    updateSlider();
                }
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener("click", () => {
                if (currentSlide < slides.length - 1) {
                    currentSlide++;
                    updateSlider();
                }
            });
        }

        updateSlider();
    });
});
