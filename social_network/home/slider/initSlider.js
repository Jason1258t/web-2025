export function initSlider(
    slider,
    startIndex = 0,
    extendedCounter = undefined
) {
    const slides = slider.querySelectorAll(".slider__slide");
    const [prevBtn, nextBtn] = [
        slider.querySelector(".slider__arrow--prev"),
        slider.querySelector(".slider__arrow--next"),
    ];

    const counter = slider.querySelector(".slider__current");

    let currentSlide = startIndex;

    if (prevBtn && nextBtn) {
        const prevHandler = () => step(-1);
        const nextHandler = () => step(1);

        prevBtn.removeEventListener("click", prevHandler);
        nextBtn.removeEventListener("click", nextHandler);

        prevBtn.addEventListener("click", prevHandler);
        nextBtn.addEventListener("click", nextHandler);
    }

    update();

    function step(dir) {
        currentSlide = (currentSlide + dir + slides.length) % slides.length;
        update();
    }

    function update() {
        slides.forEach((slide, index) => {
            slide.classList.toggle(
                "slider__slide--active",
                index === currentSlide
            );
        });
        if (counter) counter.textContent = currentSlide + 1;
        if (extendedCounter)
            extendedCounter.textContent = `${currentSlide + 1} из ${slides.length}`;
    }
}
